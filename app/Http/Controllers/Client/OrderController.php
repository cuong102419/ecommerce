<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Services\CartItemService;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(
        protected CartItemService $cartItemService,
        protected OrderService $orderService
    ) {}

    public function index()
    {
        die('xxxxxx');
        $cartItems = $this->cartItemService->getCartItems();
        $totalPrice = $this->cartItemService->getTotalPrice($cartItems);

        return view('client.orders.index', compact('cartItems', 'totalPrice'));
    }

    public function store(StoreOrderRequest $request)
    {
        dd($request);
        try {
            $data = $request->validated();
            $order = $this->orderService->create($data);

            if ($order->payment_method === 'momo') {
                return redirect()->route('payment', $order->id);
            }
            alert('Thành công', 'Đặt hàng thành công.', 'success');
            return redirect()->route('home');
        } catch (\Throwable $th) {
            alert('Lỗi', $th->getMessage(), 'error');

            return redirect()->back();
        }
    }
}
