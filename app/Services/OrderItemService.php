<?php

namespace App\Services;

use App\Repositories\OrderItemRepository;

class OrderItemService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected OrderItemRepository $orderItemRepository,
        protected CartItemService $cartItemService
    ) {}

    public function create($order_id, $cartItems)
    {
        $data = $cartItems->map(function ($item) use ($order_id) {
            return [
                'order_id'  => $order_id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'product_image' => $item->product->thumbnail->path,
                'quantity'  => $item->quantity,
                'unit_price'     => $item->product->price,
            ];
        })->toArray();

        foreach ($data as $item) {
            $this->orderItemRepository->create($item);
        }

        $this->cartItemService->deleteBySessionOrUser();

        return true;
    }

    public function checkImagePath($imagePath) {
        return $this->orderItemRepository->checkByImagePath($imagePath);
    }
}
