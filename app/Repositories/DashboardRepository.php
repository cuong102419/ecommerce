<?php

namespace App\Repositories;

use App\Models\Order;

class DashboardRepository
{
    public function totalProfit()
    {
        return Order::where('status', 'delivered')->selectRaw('SUM(total_amount - 50000) as profit')->value('profit');
    }

    public function totalRevalue()
    {
        return Order::where('status', 'delivered')->sum('total_amount');
    }

    public function totalPayment()
    {
        return Order::where('status', 'delivered')->where('payment_method', '!=', 'cod')->sum('total_amount');
    }

    public function totalTransaction()
    {
        return Order::where('status', 'delivered')->where('payment_method', 'cod')->sum('total_amount');
    }

    public function revenues()
    {
        return Order::selectRaw(
            'MONTH(created_at) as month,
            SUM(total_amount) as total'
        )
            ->where('status', 'delivered')
            ->whereYear('created_at', now()->year)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month');
    }

    // public function 

}
