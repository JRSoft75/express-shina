<?php

namespace App\Service;

use App\Repository\CartRepository;

readonly class CartService
{
    private const CART_NOT_FOUND = 'Cart not find';

    public function __construct(
        private CartRepository $cartRepository,
    ) {
    }

    public function getCartInfo(int $cartId): array
    {
        $cart = $this->cartRepository->find($cartId);
        if ($cart === null) {
            throw new \RuntimeException(self::CART_NOT_FOUND);
        }
        $products = $cart->getProducts();
        $data = [
            'items' => [],
        ];
        $totalPrice = 0;
        foreach ($products as $product) {
            $data['items'][] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
            ];
            $totalPrice += $product->getPrice();
        }
        $data['totalPrice'] = $totalPrice;

        return $data;
    }
}
