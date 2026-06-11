<?php

namespace App\Console\Commands;

use App\Repositories\CartItemRepository;
use Illuminate\Console\Command;

class ClearGuestCart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-guest-cart';
    protected $description = 'Xóa giỏ hàng quá 1 ngày.';

    public function __construct(
        protected CartItemRepository $cartItemRepository
    )
    {
        return parent::__construct();
    }

    public function handle()
    {
        $this->cartItemRepository->deleteGuest();
        $this->info('Đã xóa giỏ hàng quá hạn.');
    }
}
