<?php

namespace App\Constants;

class OrderStatus
{
    public const STATUSES = [
        'pending' => [
            'label' => 'Chờ duyệt',
            'badge' => 'bg-label-secondary'
        ],
        'paid' => [
            'label' => 'Đã thanh toán',
            'badge' => 'bg-label-primary'
        ],
        'processing' => [
            'label' => 'Đang xử lý',
            'badge' => 'bg-label-waring'
        ],
        'shipped' => [
            'label' => 'Đang vận chuyển',
            'badge' => 'bg-label-info'
        ],
        'delivered' => [
            'label' => 'Đã giao',
            'badge' => 'bg-label-success'
        ],
        // 'cancelled' => ,
        'refunded'
    ];
}
