<?php

namespace MediaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('media', 'array');

        $rootNode
                ->children()
                # db_driver
                ->scalarNode('db_driver')
                ->validate()->ifNotInArray(['orm'])->thenInvalid('db_driver must be set to one of "orm".')->end()
                ->defaultValue('orm')
                ->cannotBeOverwritten()
                ->end()
                # upload_path
                ->scalarNode('upload_path')
                ->defaultValue('../web/uploads')
                ->end()
                # media_formats
                ->arrayNode('media_formats')
                ->useAttributeAsKey('id')
                ->prototype('array')
                ->children()
                ->end()
                ->end();

        return $treeBuilder;
    }

}
