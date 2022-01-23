<?php

namespace Spatie\SymfonyIgnitionBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('ignition');
        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
                ->scalarNode('application_path')
                    ->defaultValue('')
                    ->info('When setting the application path, Ignition will trim the given value from all paths. This will make the error page look cleaner.')
                    ->end()
                ->booleanNode('dark_mode')
                    ->defaultFalse()
                    ->info('By default, Ignition uses a nice white based them. If this is too bright for your eyes, you can use dark mode.')
                    ->end()
                ->booleanNode('should_display_exception')
                    ->defaultValue('%kernel.debug%')
                    ->info('Avoid rendering Ignition, for example in production environments.')
                    ->end()
            ->end();

        return $treeBuilder;
    }
}
