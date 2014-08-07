<?php

namespace Pim\Bundle\CustomEntityBundle\Datasource;

use Doctrine\Common\Persistence\ObjectManager;
use Oro\Bundle\DataGridBundle\Datagrid\DatagridInterface;
use Pim\Bundle\CatalogBundle\Helper\LocaleHelper;
use Pim\Bundle\CustomEntityBundle\Entity\Repository\DatagridAwareRepositoryInterface;
use Pim\Bundle\CustomEntityBundle\Entity\Repository\LocaleAwareRepositoryInterface;
use Pim\Bundle\DataGridBundle\Datasource\Datasource;
use Pim\Bundle\DataGridBundle\Datasource\ResultRecord\HydratorInterface;

/**
 * Datasource for custom entity datagrids
 *
 * @author    Antoine Guigan <antoine@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class CustomEntityDatasource extends Datasource
{
    /**
     * @var string
     */
    const TYPE = 'pim_custom_entity';

    /**
     * @var LocaleHelper
     */
    protected $localeHelper;

    /**
     * Constructor
     *
     * @param ObjectManager     $om
     * @param HydratorInterface $hydrator
     * @param LocaleHelper      $localeHelper
     */
    public function __construct(
        ObjectManager $om,
        HydratorInterface $hydrator,
        LocaleHelper $localeHelper = null
    ) {
        parent::__construct($om, $hydrator);

        $this->localeHelper = $localeHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function process(DatagridInterface $grid, array $config)
    {
        $this->configuration = $config;

        $repository = $this->getRepository();

        if (!isset($config['repository_method']) && $repository instanceof DatagridAwareRepositoryInterface) {
            $config['repository_method'] = 'createDatagridQueryBuilder';
        }

        parent::process($grid, $config);

        if ($repository instanceof LocaleAwareRepositoryInterface) {
            $repository->setLocale($this->localeHelper->getCurrentLocale()->getCode());
        }

    }
}
