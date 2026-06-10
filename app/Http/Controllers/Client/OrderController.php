<?php

namespace App\Http\Controllers\Client;

use App\Constants\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Repositories\OrderRepository;
use App\Services\CartItemService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct(
        protected CartItemService $cartItemService,
        protected OrderService $orderService,
        protected OrderRepository $orderRepository
    ) {}

    public function index()
    {
        $cartItems = $this->cartItemService->getCartItems();
        $totalPrice = $this->cartItemService->getTotalPrice($cartItems);

        return view('client.orders.index', compact('cartItems', 'totalPrice'));
    }

    public function store(StoreOrderRequest $request)
    {
        try {
            $data = $request->validated();
            $order = $this->orderService->create($data);

            if ($order->payment_method === 'momo') {
                return redirect()->route('payment', $order->id);
            }

            alert('Thành công', 'Đặt hàng thành công.', 'success');
            if (Auth::check()) {
                return redirect()->route('orders.detail', $order->id);
            }

            return redirect()->route('home');
        } catch (\Throwable $th) {
            alert('Lỗi', $th->getMessage(), 'error');

            return redirect()->back();
        }
    }

    public function list()
    {
        $orders = $this->orderRepository->getByUserId(Auth::id());
        $statuses = OrderStatus::STATUSES;

        return view('client.orders.list', compact('orders', 'statuses'));
    }

    public function detail($orderId)
    {
        $order = $this->orderRepository->findByIdAndUserId($orderId, Auth::id());
        $statuses = OrderStatus::STATUSES;

        return view('client.orders.detail', compact('order', 'statuses'));
    }
}
