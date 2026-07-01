<?php

namespace App\Services;

use App\Jobs\SendMailJob;
use App\Mail\OrderDeliveredMail;
use App\Mail\OrderPlacedEmail;
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

            SendMailJob::dispatch($order->email, new OrderPlacedEmail($order))->afterCommit();

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

    public function restoreStock($orderId)
    {
        $orderItems = $this->orderItemRepository->getByOrderId($orderId);

        foreach ($orderItems as $item) {
            if ($item->product_id == null) {
                continue;
            }

            $this->productRepository->incrementStock($item->product_id, $item->quantity);
        }
    }

    public function updateStatus($id, $data)
    {
        if ($data['action'] == 'cancelled' || $data['action'] == 'refunded') {
            $this->restoreStock($id);
        }

        if ($data['action'] == 'delivered') {
            $order = $this->findById($id);
            SendMailJob::dispatch($order->email, new OrderDeliveredMail($order))->afterCommit();
        }

        return $this->orderRepository->toggleStatus($id, $data['action']);
    }

    public function deleteOrders(array $orderIds)
    {
        foreach ($orderIds as $id) {
            $order = $this->findById($id);
            if ($order->status  === 'pending' || $order->status === 'cancelled') {
                if (!in_array($order->status, ['pending', 'cancelled'])) continue;
                $this->restoreStock($id);
                $this->orderRepository->deleteOrder($order->id);
            }
        }
    }

    public function deleteExpired() {
        $orders = $this->orderRepository->getExpiredPending();

        foreach ($orders as $order) {
            $this->restoreStock($order->id);
            $this->orderRepository->deleteOrder($order->id);
        }

        return $orders->count();
    }

    public function updateStatusAll($data)
    {
        try {
            $orderIds = $data['id'];
            if ($data['action'] === 'remove') {
                $this->deleteOrders($data['id']);
                return ['success' => true];
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

    public function updateShippingInfo($id, $data) {
        return $this->orderRepository->updateShippingInfo($id, $data);
    }
}
