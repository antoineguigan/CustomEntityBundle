<?php

namespace Pim\Bundle\CustomEntityBundle\Action;

use Pim\Bundle\CustomEntityBundle\Configuration\Registry;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Action factory
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ActionFactory
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Registry
     */
    protected $configRegistry;

    /**
     * @var ActionInterface[][]
     */
    private $actions = [];

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     * @param Registry           $configRegistry
     */
    public function __construct(ContainerInterface $container, Registry $configRegistry)
    {
        $this->container = $container;
        $this->configRegistry = $configRegistry;
    }

    /**
     * Returns an action
     *
     * @param string $customEntityName
     * @param string $actionType
     *
     * @return ActionInterface
     */
    public function getAction($customEntityName, $actionType)
    {
        if (isset($this->actions[$customEntityName][$actionType])) {
            return $this->actions[$customEntityName][$actionType];
        }

        if (!$this->configRegistry->has($customEntityName)) {
            return null;
        }

        $configuration = $this->configRegistry->get($customEntityName);

        if (!$configuration->hasAction($actionType)) {
            return null;
        }

        if (!isset($this->actions[$customEntityName])) {
            $this->actions[$customEntityName] = [];
        }

        $action = $this->container->get($configuration->getAction($actionType));
        $this->actions[$customEntityName][$actionType] = $action;
        $action->setConfiguration($configuration);

        return $action;
    }
}
