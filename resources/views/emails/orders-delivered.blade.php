<x-mail::message>
# Đơn hàng đã giao thành công 🎉

Xin chào **{{ $order->shipping_name ?: ($order->user->name ?? 'khách hàng') }}**,

Đơn hàng **#{{ $order->id }}** của bạn đã được giao thành công.

<x-mail::table>
| Sản phẩm | Số lượng | Giá |
| :------- | :------: | --: |
@foreach($order->orderItems as $item)
| {{ $item->product_name }} | {{ $item->quantity }} | {{ number_format($item->unit_price) }}đ |
@endforeach
</x-mail::table>

Bạn hãy dành chút thời gian đánh giá sản phẩm để giúp chúng tôi cải thiện chất lượng dịch vụ nhé!


Cảm ơn bạn đã tin tưởng và mua hàng tại {{ config('app.name') }}!

Trân trọng,<br>
{{ config('app.name') }}
</x-mail::message>