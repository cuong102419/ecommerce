<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\CartItemService;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $orderId = explode('_', $request['orderId'])[0];
        $this->paymentService->create($request->all());
        $this->cartItemService->deleteBySessionOrUser();

        alert('Thành công.', 'Thanh toán thành công.', 'success');
        if(Auth::check()) {
            return redirect()->route('orders.detail', $orderId);
        }
        return redirect()->route('home');
    }

    public function vnpay($orderId)
    {
        $order = $this->orderService->findById($orderId);
        return $this->paymentService->vnPay($order);
    }

    public function vnpayConfirm(Request $request)
    {
        if ($request['vnp_TransactionStatus'] != '00') {
            alert('Lỗi.', 'Thanh toán không thành công.', 'error');
            return redirect()->back();
        }

        $this->paymentService->vnPayCreate($request);
        $this->cartItemService->deleteBySessionOrUser();

        alert('Thành công.', 'Thanh toán thành công.', 'success');
        if(Auth::check()) {
            return redirect()->route('orders.detail', $request['vnp_TxnRef']);
        }
        return redirect()->route('home');
    }
}
