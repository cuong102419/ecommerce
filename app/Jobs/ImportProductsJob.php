<?php

namespace App\Jobs;

use App\Imports\ProductsImport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Maatwebsite\Excel\Facades\Excel;

class ImportProductsJob implements ShouldQueue
{
    use Queueable;


    public function __construct(
        protected string $path
    ) {}

    public function handle()
    {
        Excel::import(app(ProductsImport::class), $this->path, 'local');
    }
}
