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

    public function get()
    {
        return Order::latest()->paginate(10);
    }

    public function toggleStatus($id, $status)
    {
        $order = Order::find($id);
        return $order->update(['status' => $status]);
    }

    public function deleteOrder($id) {
        return Order::delete($id);
    }
}
