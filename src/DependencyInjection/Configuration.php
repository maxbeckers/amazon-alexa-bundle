<?php

namespace MaxBeckers\AmazonAlexaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Maximilian Beckers <beckers.maximilian@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('maxbeckers_amazon_alexa');
        $rootNode    = $treeBuilder->getRootNode();

        return $treeBuilder;
    }
}
