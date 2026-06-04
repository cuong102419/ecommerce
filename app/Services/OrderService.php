<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected  OrderRepository $orderRepository,
        protected CartItemService $cartItemService,
        protected OrderItemService $orderItemService
    ) {}

    public function create(array $data)
    {
        if (Auth::user()) {
            $data['user_id'] = Auth::id();
        }

        $cartItems = $this->cartItemService->getCartItems();
        $data['total_amount'] = $this->cartItemService->getTotalPrice($cartItems) + 50000;
        if ($cartItems->isEmpty()) {
            throw new \RuntimeException('Giỏ hàng trống');
        }

        return DB::transaction(function () use ($data, $cartItems) {
            $order = $this->orderRepository->create($data);

            $this->orderItemService->create($order->id, $cartItems);

            return $order->refresh();
        });
    }

    public function findById($id)
    {
        return $this->orderRepository->findById($id);
    }

    public function get()
    {
        return $this->orderRepository->get();
    }

    public function toggleStatus($id, $status)
    {
        return $this->orderRepository->toggleStatus($id, $status);
    }
}
