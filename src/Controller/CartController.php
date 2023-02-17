<?php

namespace App\Controller;

use App\Service\ApiResponse;
use App\Service\CartService;
use App\Service\ErrorResponse;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart')]
class CartController extends AbstractController
{
    #[Route('', name: 'app_cart_info', methods: ['GET'])]
    public function getCartInfo(
        Request $request,
        ApiResponse $response,
        ErrorResponse $errorResponse,
        CartService $cartService,
    ): JsonResponse|ErrorResponse {
        try {
            $cartId = $request->getSession()->get('cartId');
            $data = $cartService->getCartInfo($cartId);
            $response->setData($data);

            return new JsonResponse($response->getContent(), $response->getStatus());
        } catch (Exception $e) {
            return $errorResponse->response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

