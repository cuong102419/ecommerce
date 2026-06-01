<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartItem\StoreCartItemRequest;
use App\Http\Requests\CartItem\UpdateCartItemRequest;
use App\Services\CartItemService;

class CartItemController extends Controller
{
    public function __construct(
        protected CartItemService $cartItemService
    ) {}

    public function index() {
        $cartItems = $this->cartItemService->getCartItems();
        $totalPrice = $this->cartItemService->getTotalPrice($cartItems);
        return view('client.cart.index', compact('cartItems', 'totalPrice'));
    }

    public function store(StoreCartItemRequest $request) {
        $this->cartItemService->create($request->validated());
        return redirect()->route('cart');
    }

    public function delete($id) {
        $this->cartItemService->delete($id);
        return redirect()->route('cart');
    }

    public function update(UpdateCartItemRequest $request) {
        $this->cartItemService->update($request->validated());

        return redirect()->route('cart');
    }
}
