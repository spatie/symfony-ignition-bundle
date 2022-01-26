<?php

namespace Spatie\SymfonyIgnitionBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class IgnitionExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $config = $this->processConfiguration(
            $this->getConfiguration($configs, $container),
            $configs
        );

        $definition = $container->getDefinition('spatie_ignition.ignition');

        if (true == $config['dark_mode']) {
            $definition->addMethodCall('useDarkMode');
        }

        $definition->addMethodCall('applicationPath', [$config['application_path']]);
        $definition->addMethodCall('shouldDisplayException', [$config['should_display_exception']]);
    }
}
