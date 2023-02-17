<?php

namespace App\Controller;

use App\DTO\AddToCartRequest;
use App\DTO\DeleteFromCartRequest;
use App\Entity\ProductModel;
use App\Service\ApiResponse;
use App\Service\ErrorResponse;
use App\Service\ProductService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/add', name: 'app_product_add_to_cart', methods: ['POST'])]
    public function addToCart(
        Request $request,
        AddToCartRequest $addToCartRequest,
        ApiResponse $response,
        ErrorResponse $errorResponse,
        ProductService $productService
    ): JsonResponse|ErrorResponse {
        try {
            $cartId = $request->getSession()->get('cartId');
            $productService->addToCart($addToCartRequest->getId(), $cartId);

            return new JsonResponse($response->getContent(), $response->getStatus());
        } catch (Exception $e) {
            return $errorResponse->response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/delete', name: 'app_product_delete_from_cart', methods: ['POST'])]
    public function deleteFromCart(
        Request $request,
        DeleteFromCartRequest $deleteFromCartRequest,
        ApiResponse $response,
        ErrorResponse $errorResponse,
        ProductService $productService
    ): JsonResponse|ErrorResponse {
        try {
            $cartId = $request->getSession()->get('cartId');
            $productService->deleteFromCart($deleteFromCartRequest->getId(), $cartId);

            return new JsonResponse($response->getContent(), $response->getStatus());
        } catch (Exception $e) {
            return $errorResponse->response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    #[Route('/list-by-model/{id}', name: 'app_product_list_by_model', methods: ['GET'])]
    public function listByModel(
        ApiResponse $response,
        ErrorResponse $errorResponse,
        ProductModel $productModel,
        ProductService $productService
    ): JsonResponse|ErrorResponse {
        try {
            $data = $productService->listByModel($productModel);
            $response->setData($data);
            $response->setTotal(count($data));

            return new JsonResponse($response->getContent(), $response->getStatus());
        } catch (Exception $e) {
            return $errorResponse->response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

