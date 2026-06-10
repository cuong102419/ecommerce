<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\CartItemService;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService,
        protected OrderService $orderService,
        protected CartItemService $cartItemService
    ) {}

    public function index($orderId)
    {
        $order = $this->orderService->findById($orderId);
        return $this->paymentService->momoPayment($order);
    }

    public function store(Request $request)
    {
        if ($request['resultCode'] != 0) {
            alert('Lỗi.', 'Thanh toán không thành công.', 'error');
            return redirect()->back();
        }

        $this->paymentService->create($request->all());
        $this->cartItemService->deleteBySessionOrUser();

        alert('Thành công.', 'Thanh toán thành công.', 'success');
        return redirect()->route('home');
    }
}
