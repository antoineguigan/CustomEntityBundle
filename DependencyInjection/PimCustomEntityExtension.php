<?php

namespace Pim\Bundle\CustomEntityBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class PimCustomEntityExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('formatters.yml');
        $loader->load('serializer.yml');
        $loader->load('data_sources.yml');
        $loader->load('event_listeners.yml');
        $loader->load('actions.yml');
        $loader->load('mass_actions.yml');
        $loader->load('managers.yml');
        $loader->load('attribute_types.yml');
        $loader->load('form.yml');
        $loader->load('update_guessers.yml');
    }
}
