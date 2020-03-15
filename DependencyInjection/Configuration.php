<?php

namespace Insidestyles\SwooleBridgeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Insidestyles\SwooleBridgeBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('swoole_bridge');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('server')
                    ->children()
                        ->scalarNode('host')
                            ->example('127.0.0.1')
                            ->cannotBeEmpty()
                            ->isRequired()
                        ->end()
                        ->scalarNode('port')
                            ->example(8080)
                            ->cannotBeEmpty()
                            ->isRequired()
                        ->end()
                        ->booleanNode('origin_check')
                            ->defaultValue(false)
                            ->example(true)
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
