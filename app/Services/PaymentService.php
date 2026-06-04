<?php

namespace App\Services;

use App\Repositories\PaymentRepository;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected PaymentRepository $paymentRepository,
        protected OrderService $orderService,
        protected CartItemService $cartItemService
    ) {}

    public function momoPayment($order)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $serectKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderId = $order->id . '_' . time(); // Mã đơn hàng
        $orderInfo = 'Thanh toán qua MoMo';
        $amount = (int) $order->total_amount;
        $ipnUrl = route('payment.store');
        $redirectUrl = route('payment.store');
        $extraData = '';

        $requestId = time() . "";
        $requestType = "payWithMethod";
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl="
            . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl="
            . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $serectKey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',

            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );

        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);

        return redirect()->to($jsonResult['payUrl']);
    }

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    public function create($request)
    {
        $data = [
            'order_id' => explode('_', $request['orderId'])[0],
            'provider' => 'momo',
            'transaction_ref' => $request['transId'],
            'status' => $request['message'],
            'amount' => $request['amount']
        ];

        return DB::transaction(function () use ($data){
            $this->orderService->toggleStatus($data['order_id'], 'paid');
            $this->cartItemService->deleteBySessionOrUser();

            return $this->paymentRepository->create($data);
        });
    }
}
