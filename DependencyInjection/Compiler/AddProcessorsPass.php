<?php

namespace Insidestyles\SwooleBridgeBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Class AddProcessorsPass
 * @package Insidestyles\SwooleBridgeBundle\DependencyInjection\Compiler
 */
class AddProcessorsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('swoole_bridge.handler')) {
            return;
        }
    }
}
