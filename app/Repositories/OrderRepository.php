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
        return Order::find($id);
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
        $order = Order::find($id);

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
        return Order::where('status', 'pending')->where('payment_method', 'momo')->get();
    }
}
