<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        return view("client.products.list");
    }

    public function detail() {
        return view("client.products.detail");
    }
}
