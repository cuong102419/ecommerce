<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {}

    public function index() {
        $orders = $this->orderService->get();
        
        return view('admin.orders.index', compact('orders'));
    }

    public function detail($id) {
        return view('admin.orders.detail');
    }
}
