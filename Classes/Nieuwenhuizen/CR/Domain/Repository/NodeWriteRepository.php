<?php
namespace Nieuwenhuizen\CR\Domain\Repository;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Exception;
use TYPO3\TYPO3CR\Domain\Model\Node;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;
use TYPO3\TYPO3CR\Utility as NodeUtility;

/**
 * @Flow\Scope("singleton")
 */
class NodeWriteRepository extends AbstractNodeRepository {

	/**
	 * @param string $idealNodeName
	 * @param NodeInterface $referenceNode
	 * @return string
	 */
	public function getFreeNodeName($idealNodeName, NodeInterface $referenceNode) {
		$idealNodeName = NodeUtility::renderValidNodeName($idealNodeName);
		$possibleNodeName = $idealNodeName;
		$counter = 1;
		while ($referenceNode->getNode($possibleNodeName) !== NULL) {
			$possibleNodeName = $idealNodeName . '-' . $counter;
			$counter++;
		}
		return $possibleNodeName;
	}

	/**
	 * @param NodeInterface $referenceNode
	 * @param string $idealNodeName
	 * @param string $nodeTypeName
	 * @param array $properties
	 * @throws Exception
	 * @return Node
	 */
	public function createChildNode(NodeInterface $referenceNode, $idealNodeName, $nodeTypeName, array $properties = array()) {
		$nodeType = $this->nodeTypeManager->getNodeType($nodeTypeName);
		$node = $referenceNode->createNode(
			$this->getFreeNodeName($idealNodeName, $referenceNode),
			$nodeType
		);

		$nodeTypeProperties = $nodeType->getProperties();

		foreach ($properties as $propertyName => $propertyValue) {
			if (!isset($nodeTypeProperties[$propertyName])) {
				throw new Exception(sprintf('NodeType %s has no property named "%s"', $nodeTypeName, $propertyName));
			}
			$node->setProperty($propertyName, $propertyValue);
		}

		if ($node->getNodeType()->isOfType('TYPO3.Neos:Document')) {
			$node->setProperty('uriPathSegment', $node->getName());
		}

		$this->emitNewNodePublished($node);

		return $node;
	}

	/**
	 * @param NodeInterface $referenceNode
	 * @return boolean
	 */
	public function removeNode(NodeInterface $referenceNode) {
		$referenceNode->remove();
		return $referenceNode->isRemoved();
	}

	/**
	 * @param NodeInterface $referenceNode
	 * @param array $newPropertyValues
	 * @return void
	 */
	public function updateNode(NodeInterface $referenceNode, array $newPropertyValues) {
		foreach ($newPropertyValues as $property => $value) {
			$referenceNode->setProperty($property, $value);
		}
	}

	/**
	 * @Flow\Signal
	 * @param NodeInterface $node
	 * @return void
	 */
	protected function emitNodePublished(NodeInterface $node){
	}

	/**
	 * @Flow\Signal
	 * @param NodeInterface $node
	 * @return void
	 */
	protected function emitNewNodePublished(NodeInterface $node){
	}

}