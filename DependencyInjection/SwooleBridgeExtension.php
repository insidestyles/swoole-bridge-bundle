<?php

namespace Insidestyles\SwooleBridgeBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class SwooleBridgeExtension
 * @package Insidestyles\SwooleBridgeBundle\DependencyInjection
 */
class SwooleBridgeExtension extends Extension
{
    const ALIAS = 'swoole_bridge';

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $configs = $this->processConfiguration($configuration, $configs);
        if (isset($configs['server'])) {
            $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
            $loader->load('swoole-bridge.yaml');

            $container->setParameter('swoole_bridge.server.host', $configs['server']['host']);
            $container->setParameter('swoole_bridge.server.port', $configs['server']['port']);

            if (!empty($configs['server']['origins'])) {
                //@todo add origin check
            }
        }
    }

    /**
     * Register handler instance
     *
     * @param string $handlerKey
     * @param array $handlerInfo
     * @param ContainerBuilder $container
     *
     * @return string The handler service id
     */
    private function registerHandler($handlerKey, array $handlerInfo, ContainerBuilder $container)
    {
        $handlerId = 'swoole_bridge.handler.' . $handlerKey;

        return $handlerId;
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {
        return self::ALIAS;
    }
}
