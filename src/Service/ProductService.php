<?php

namespace App\Service;

use App\Entity\ProductModel;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;

readonly class ProductService
{
    private const PRODUCT_NOT_FOUND = 'Product not find';
    private const CART_NOT_FOUND = 'Cart not find';
    public function __construct(
        private ProductRepository $productRepository,
        private CartRepository $cartRepository,
    ) {
    }


    public function addToCart(int $productId, int $cartId): void
    {
        $cart = $this->cartRepository->find($cartId);
        if ($cart === null) {
            throw new \RuntimeException(self::CART_NOT_FOUND);
        }
        $product = $this->productRepository->find($productId);
        if ($product === null) {
            throw new \RuntimeException(self::PRODUCT_NOT_FOUND);
        }

        $cart->addProduct($product);
        $this->cartRepository->save($cart, true);
    }

    public function deleteFromCart(int $productId, int $cartId): void
    {
        $cart = $this->cartRepository->find($cartId);
        if ($cart === null) {
            throw new \RuntimeException(self::CART_NOT_FOUND);
        }
        $product = $this->productRepository->find($productId);
        if ($product === null) {
            throw new \RuntimeException(self::PRODUCT_NOT_FOUND);
        }

        $cart->removeProduct($product);
        $this->cartRepository->save($cart, true);
    }

    public function listByModel(ProductModel $productModel):array{
        $products = $this->productRepository->findBy(['model' => $productModel]);
        $data = [];
        foreach ($products as $product) {
            $data[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
            ];
        }
        return $data;
    }
}
