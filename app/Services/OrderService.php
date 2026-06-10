<?php

namespace App\Services;

use App\Jobs\SendOrderMailJob;
use App\Repositories\OrderItemRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
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
        protected OrderItemService $orderItemService,
        protected OrderItemRepository $orderItemRepository,
        protected ProductRepository $productRepository
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

            SendOrderMailJob::dispatch($order->refresh()->load('orderItems'))->afterCommit();

            return $order->refresh();
        });
    }

    public function findById($id)
    {
        return $this->orderRepository->findById($id);
    }

    public function get($data)
    {
        return $this->orderRepository->get($data);
    }

    public function updateStatus($id, $data)
    {
        if ($data['action'] == 'cancelled' || $data['action'] == 'refunded') {
            $orderItems = $this->orderItemRepository->getByOrderId($id);

            foreach ($orderItems as $item) {
                $this->productRepository->incrementStock($item->product_id, $item->quantity);
            }
        }

        return $this->orderRepository->toggleStatus($id, $data['action']);
    }

    public function updateStatusAll($data)
    {
        try {
            $orderIds = $data['id'];
            if ($data['action'] === 'remove') {
                $skipped = 0;
                $deleted = 0;
                foreach ($orderIds as $id) {
                    $order = $this->findById($id);
                    if ($order->status  === 'pending' || $order->status === 'cancelled') {
                        $orderItems = $this->orderItemRepository->getByOrderId($id);

                        foreach ($orderItems as $item) {
                            if ($item->product_id == null) {
                                continue;
                            }

                            $this->productRepository->incrementStock($item->product_id, $item->quantity);
                        }

                        $this->orderRepository->deleteOrder($order->id);
                    }
                }

                return [
                    'success' => true,
                    'deleted' => $deleted,
                    'skipped' => $skipped,
                ];
            }

            foreach ($orderIds as $id) {
                $order = $this->findById($id);
                if ($order->status !== 'pending' || $order->status === $data['action']) {
                    continue;
                }

                $this->updateStatus($id, $data);
            }

            return [
                'success' => true
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false
            ];
        }
    }
}
