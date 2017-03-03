<?php
namespace Nieuwenhuizen\CR\Domain\Repository;

use Neos\Flow\Annotations as Flow;
use Neos\ContentRepository\Domain\Service\NodeTypeManager;
use Neos\ContentRepository\Domain\Service\ContextFactoryInterface;
use Neos\ContentRepository\Domain\Service\Context;

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