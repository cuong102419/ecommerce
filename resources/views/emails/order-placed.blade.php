{{-- resources/views/emails/order-placed.blade.php --}}
<x-mail::message>

    # Đặt hàng thành công!

    Xin chào **{{ $order->shipping_name }}**,

    Đơn hàng **#{{ $order->id }}** của bạn đã được đặt thành công.

    ---

    ## Thông tin giao hàng

    **Họ tên:** {{ $order->shipping_name }}<br>
    **Số điện thoại:** {{ $order->shipping_phone }}<br>
    **Email:** {{ $order->email }}<br>
    **Địa chỉ:** {{ $order->shipping_address }}

    ---

    ## Chi tiết đơn hàng

    <x-mail::table>
        | Sản phẩm | Số lượng | Thành tiền |
        |:---------|:--------:|-----------:|
        @foreach ($order->orderItems as $item)
            | {{ $item->product_name }} | {{ $item->quantity }} |
            {{ number_format($item->unit_price * $item->quantity, 0, '.', '.') }}đ |
        @endforeach
        | **Phí giao hàng** | | 50.000đ |
        | **Tổng tiền** | | **{{ number_format($order->total_amount, 0, '.', '.') }}đ** |
    </x-mail::table>

    ---

    **Phương thức thanh toán:**
    {{ match ($order->payment_method) {
        'cod' => 'Thanh toán khi nhận hàng (COD)',
        'momo' => 'Ví MoMo',
        'vnpay' => 'Cổng thanh toán VNPay',
    } }}

    Cảm ơn bạn đã mua hàng tại **{{ config('app.name') }}**!

    Trân trọng,<br>
    {{ config('app.name') }}

</x-mail::message>
