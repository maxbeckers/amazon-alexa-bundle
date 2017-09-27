<?php

namespace MaxBeckers\AmazonAlexaBundle;

use MaxBeckers\AmazonAlexaBundle\DependencyInjection\CompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Maximilian Beckers <beckers.maximilian@gmail.com>
 */
class AmazonAlexaBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        // add all request handlers tagged by "maxbeckers_amazon_alexa.request_handler" to registry.
        $container->addCompilerPass(new CompilerPass\RequestHandlerResolverPass());
    }
}
