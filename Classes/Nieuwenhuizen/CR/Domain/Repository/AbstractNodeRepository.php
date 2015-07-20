<?php
namespace Nieuwenhuizen\CR\Domain\Repository;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\TYPO3CR\Domain\Service\NodeTypeManager;
use TYPO3\TYPO3CR\Domain\Service\ContextFactoryInterface;
use TYPO3\TYPO3CR\Domain\Service\Context;

/**
 * @Flow\Scope("singleton")
 */
abstract class AbstractNodeRepository {

	/**
	 * @Flow\Inject
	 * @var ContextFactoryInterface
	 */
	protected $contextFactory;

	/**
	 * @Flow\Inject
	 * @var NodeTypeManager
	 */
	protected $nodeTypeManager;

	/**
	 * @param array $contextProperties
	 * @return Context
	 */
	protected function createContentContext($contextProperties = array()) {
		return $this->contextFactory->create($contextProperties);
	}

}