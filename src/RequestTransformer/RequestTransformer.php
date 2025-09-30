<?php

namespace MaxBeckers\AmazonAlexaBundle\RequestTransformer;

use MaxBeckers\AmazonAlexa\Exception\MissingRequestDataException;
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
    public function __construct(
        private readonly RequestHandlerRegistry $requestHandlerRegistry,
        private readonly RequestValidator $requestValidator,
        private readonly RequestStack $requestStack
    ) {
    }

    public function transformRequest(Request $request, ?string $signatureCertChainUrl = null, ?string $signature = null): Response
    {
        if (!$request->getContent()) {
            throw new MissingRequestDataException();
        }

        $alexaRequest = AlexaRequest::fromAmazonRequest(
            $request->getContent(),
            $signatureCertChainUrl ?? $request->server->get('HTTP_SIGNATURECERTCHAINURL', ''),
            $signature ?? $request->server->get('HTTP_SIGNATURE', '')
        );

        if (!$alexaRequest) {
            throw new MissingRequestDataException();
        }

        $this->requestValidator->validate($alexaRequest);
        $handler = $this->requestHandlerRegistry->getSupportingHandler($alexaRequest);

        return $handler->handleRequest($alexaRequest);
    }

    public function transform(): Response
    {
        $request = $this->requestStack->getCurrentRequest();

        return $this->transformRequest($request);
    }
}
