<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository
{
    public function create(array $data)
    {
        return Order::create($data);
    }

    public function findById($id)
    {
        return Order::findOrFail($id);
    }

    public function get($data)
    {
        return Order::query()
            ->when($data['id'], function ($query, $id) {
                $query->where('id', $id);
            })
            ->when($data['status'], function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($data['payment-method'], function ($query, $paymentMethod) {
                $query->where('payment_method', $paymentMethod);
            })
        ->latest()->paginate(10)->withQueryString();
    }

    public function toggleStatus($id, $status)
    {
        $order = $this->findById($id);

        if($order->status != $status) {
            return $order->update(['status' => $status]);
        }
    }

    public function deleteOrder($id) {
        return Order::destroy($id);
    }

    public function getByUserId($userId) {
        return Order::where('user_id', $userId)->latest()->paginate(6);
    }

    public function findByIdAndUserId($id, $userId) {
        return Order::with('orderItems')->where('user_id', $userId)->findOrFail($id);
    }

    public function getExpiredPending() {
        return Order::where('status', 'pending')->where('created_at', '<', now()->subMinute(15))->get();
    }

    public function updateShippingInfo($id, $data) {
        return Order::findOrFail($id)->update($data);
    }

    public function hasBought($userId, $productId) {
        return Order::where('user_id', $userId)
        ->where('status', 'delivered')
        ->whereHas('orderItems', fn($q) => $q->where('product_id', $productId))
        ->exists();
    }
}
