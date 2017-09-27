<?php

namespace MaxBeckers\AmazonAlexaBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Maximilian Beckers <beckers.maximilian@gmail.com>
 */
class RequestHandlerResolverPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $definition     = $container->findDefinition('maxbeckers_amazon_alexa.request_handler_registry');
        $taggedServices = $container->findTaggedServiceIds('maxbeckers_amazon_alexa.request_handler');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addHandler', [new Reference($id)]);
        }
    }
}
