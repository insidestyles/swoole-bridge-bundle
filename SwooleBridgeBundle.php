<?php

namespace Insidestyles\SwooleBridgeBundle;

use Insidestyles\SwooleBridgeBundle\DependencyInjection\Compiler\AddProcessorsPass;
use Insidestyles\SwooleBridgeBundle\DependencyInjection\SwooleBridgeExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class SwooleBridgeBundle
 * @package Insidestyles\SwooleBridgeBundle
 */
class SwooleBridgeBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new AddProcessorsPass());
    }

    /**
     * {@inheritdoc}
     */
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new SwooleBridgeExtension();
    }
}
