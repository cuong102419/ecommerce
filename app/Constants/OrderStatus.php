<?php

namespace App\Constants;

class OrderStatus
{
    public const STATUSES = [
        'pending' => [
            'label' => 'Chờ duyệt',
            'color' => 'secondary'
        ],
        'paid' => [
            'label' => 'Đã thanh toán',
            'color' => 'primary'
        ],
        'processing' => [
            'label' => 'Đang xử lý',
            'color' => 'warning'
        ],
        'shipped' => [
            'label' => 'Đang vận chuyển',
            'color' => 'info'
        ],
        'delivered' => [
            'label' => 'Đã giao',
            'color' => 'success'
        ],
        'cancelled' => [
            'label' => 'Hủy đơn',
            'color' => 'danger'
        ],
        'refunded' => [
            'label' => 'Hoàn tiền',
            'color' => 'warning'
        ]
    ];
}
