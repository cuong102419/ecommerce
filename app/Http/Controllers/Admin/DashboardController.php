<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    public function index()
    {
        $totalProfit = $this->dashboardService->totalProfit();
        $totalRevalue = $this->dashboardService->totalRevalue();
        $totalPayment = $this->dashboardService->totalPayment();
        $totalTransaction = $this->dashboardService->totalTransaction();
        $monthlyRevenue  = $this->dashboardService->revenues();

        return view("admin.dashboard.index", compact(
            'totalProfit',
            'totalRevalue',
            'totalPayment',
            'totalTransaction',
            'monthlyRevenue'
        ));
    }
}
