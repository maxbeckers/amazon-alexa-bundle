<?php

namespace MaxBeckers\AmazonAlexaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Maximilian Beckers <beckers.maximilian@gmail.com>
 */
class AmazonAlexaController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function amazonRequestAction(Request $request): JsonResponse
    {
        return new JsonResponse(
            $this->get('maxbeckers_amazon_alexa.request_transformer')->transformRequest(
                $request,
                $request->headers->get('SIGNATURECERTCHAINURL'),
                $request->headers->get('SIGNATURE')
            )
        );
    }
}
