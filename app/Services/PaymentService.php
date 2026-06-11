<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\PaymentRepository;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected PaymentRepository $paymentRepository,
        protected OrderRepository $orderRepository,
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

        return DB::transaction(function () use ($data) {
            $this->orderRepository->toggleStatus($data['order_id'], 'paid');
            $this->cartItemService->deleteBySessionOrUser();

            return $this->paymentRepository->create($data);
        });
    }

    public function vnPay($order)
    {
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('payment.vnpay.confirm');
        $vnp_TmnCode = "CAKIXXYP";
        $vnp_HashSecret = "RR16VDH4FTKXEZRJXM9WEIQJ1ZH9PE1T";

        $vnp_TxnRef = $order->id;
        $vnp_OrderInfo = 'Thanh toán';
        $vnp_OrderType = 'Cake';
        $vnp_Amount = $order->total_amount * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00',
            'message' => 'success',
            'data' => $vnp_Url
        );

        return redirect()->away($vnp_Url);
    }

    public function vnPayCreate($request)
    {
        $data = [
            'order_id' => $request['vnp_TxnRef'],
            'provider' => 'vnpay',
            'transaction_ref' => $request['vnp_TransactionNo'],
            'status' => 'Successful',
            'amount' => $request['vnp_Amount']
        ];

        return DB::transaction(function () use ($data) {
            $this->orderRepository->toggleStatus($data['order_id'], 'paid');
            $this->cartItemService->deleteBySessionOrUser();

            return $this->paymentRepository->create($data);
        });
    }
}
