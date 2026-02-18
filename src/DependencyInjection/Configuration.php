<?php

namespace Spatie\SymfonyIgnitionBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
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
                    ->info('By default, Ignition uses a nice white based theme. If this is too bright for your eyes, you can use dark mode.')
                    ->end()
                ->booleanNode('should_display_exception')
                    ->defaultValue('%kernel.debug%')
                    ->info('Avoid rendering Ignition, for example in production environments.')
                    ->end()
                ->booleanNode('force_html_response')
                    ->defaultFalse()
                    ->info('When true, Ignition always renders HTML errors regardless of request format. When false, non-HTML requests (e.g. JSON) are handled by Symfony.')
                    ->end()
                ->scalarNode('openai_key')
                    ->defaultValue('')
                    ->info('if you want AI solutions to your app\'s errors.')
                    ->end()
            ->end();

        return $treeBuilder;
    }
}
