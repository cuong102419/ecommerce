<?php

namespace App\Console\Commands;

use App\Services\OrderService;
use Illuminate\Console\Command;

class DeleteExpiredOrders extends Command
{
    protected $signature = 'app:delete-expired-orders';
    protected $description = 'Command description';

    public function __construct(
        protected OrderService $orderService
    ) {
        return parent::__construct();
    }

    public function handle()
    {
        $count = $this->orderService->deleteExpired();
        $this->info("Đã hủy {$count} đơn hàng hết hạn.");
    }
}
