<?php

namespace App\Services;

use App\Repositories\OrderItemRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;

class OrderItemService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected OrderItemRepository $orderItemRepository,
        protected CartItemService $cartItemService,
        protected ProductRepository $productRepository,
        protected OrderRepository $orderRepository
    ) {}

    public function create($orderId, $cartItems)
    {
        $data = $cartItems->map(function ($item) use ($orderId) {
            return [
                'order_id'  => $orderId,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'product_image' => $item->product->thumbnail->path,
                'quantity'  => $item->quantity,
                'unit_price'     => $item->product->price,
            ];
        })->toArray();

        foreach ($data as $item) {
            $product = $this->productRepository->getById($item['product_id']);
            if ($product->stock < $item['quantity']) {
                throw new \RuntimeException("Sản phẩm không đủ số lượng.");
            }

            $this->orderItemRepository->create($item);
            $this->productRepository->decrementStock($product->id, $item['quantity']);
        }

        $order = $this->orderRepository->findById($orderId);

        if ($order->payment_method == 'cod') {
            $this->cartItemService->deleteBySessionOrUser();
        }

        return true;
    }

    public function checkImagePath($imagePath)
    {
        return $this->orderItemRepository->checkByImagePath($imagePath);
    }
}
