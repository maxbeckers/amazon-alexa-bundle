<?php

namespace MaxBeckers\AmazonAlexaBundle\DependencyInjection;

use MaxBeckers\AmazonAlexa\Request\Request as AlexaRequest;
use MaxBeckers\AmazonAlexa\RequestHandler\RequestHandlerRegistry;
use MaxBeckers\AmazonAlexa\Response\Response;
use MaxBeckers\AmazonAlexa\Validation\RequestValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Maximilian Beckers <beckers.maximilian@gmail.com>
 */
class RequestTransformer
{
    /**
     * @var RequestHandlerRegistry
     */
    private $requestHandlerRegistry;

    /**
     * @var RequestValidator
     */
    private $requestValidator;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param RequestHandlerRegistry $requestHandlerRegistry
     * @param RequestValidator       $requestValidator
     * @param RequestStack           $requestStack
     */
    public function __construct(RequestHandlerRegistry $requestHandlerRegistry, RequestValidator $requestValidator, RequestStack $requestStack)
    {
        $this->requestHandlerRegistry = $requestHandlerRegistry;
        $this->requestValidator       = $requestValidator;
        $this->requestStack           = $requestStack;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function transformRequest(Request $request): Response
    {
        $alexaRequest = AlexaRequest::fromAmazonRequest(
            $request->getContent(),
            $request->headers->get('HTTP_SIGNATURECERTCHAINURL'),
            $request->headers->get('HTTP_SIGNATURE')
        );

        $this->requestValidator->validate($alexaRequest);
        $handler = $this->requestHandlerRegistry->getSupportingHandler($alexaRequest);

        return $handler->handleRequest($alexaRequest);
    }

    /**
     * @return Response
     */
    public function transform(): Response
    {
        $request = $this->requestStack->getCurrentRequest();

        return $this->transformRequest($request);
    }
}
