<?php

namespace App\Services;

use App\Repositories\DashboardRepository;

class DashboardService
{
    public function __construct(
        protected DashboardRepository $dashboardRepository
    ) {}

    public function totalProfit() {
        return $this->dashboardRepository->totalProfit();
    }

    public function totalRevalue() {
        return $this->dashboardRepository->totalRevalue();
    }

    public function totalPayment() {
        return $this->dashboardRepository->totalPayment();
    }

    public function totalTransaction() {
        return $this->dashboardRepository->totalTransaction();
    }

    public function revenues() {
        $revenues = $this->dashboardRepository->revenues();
        $data = [];

        for($i = 1; $i <= 12; $i++) {
            $data[] = (float) ($revenues[$i] ?? 0);
        }

        return $data;
    }
}
