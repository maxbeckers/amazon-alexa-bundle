<?php

namespace MaxBeckers\AmazonAlexaBundle\Controller;

use MaxBeckers\AmazonAlexaBundle\RequestTransformer\RequestTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Maximilian Beckers <beckers.maximilian@gmail.com>
 */
class AmazonAlexaController extends AbstractController
{
    public function __construct(
        private readonly RequestTransformer $requestTransformer
    ) {
    }

    public function amazonRequestAction(Request $request): JsonResponse
    {
        return new JsonResponse(
            $this->requestTransformer->transformRequest(
                $request,
                $request->headers->get('SIGNATURECERTCHAINURL'),
                $request->headers->get('SIGNATURE')
            )
        );
    }
}
