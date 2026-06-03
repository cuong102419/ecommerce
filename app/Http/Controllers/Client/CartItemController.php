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

    public function index()
    {
        $cartItems = $this->cartItemService->getCartItems();
        $totalPrice = $this->cartItemService->getTotalPrice($cartItems);
        return view('client.cart.index', compact('cartItems', 'totalPrice'));
    }

    public function store(StoreCartItemRequest $request)
    {
        $result = $this->cartItemService->create($request->validated());

        if ($result == false) {
            alert('Lỗi', 'Số lượng không đủ.', 'error');
            return redirect()->back();
        }

        alert('Thành công', 'Thêm vào giỏ hàng thành công', 'success');
        return redirect()->route('cart');
    }

    public function delete($id)
    {
        $this->cartItemService->delete($id);

        return redirect()->route('cart');
    }

    public function update(UpdateCartItemRequest $request)
    {
        $result = $this->cartItemService->update($request->validated());

        if ($result) {
            alert('Thành công', 'Cập nhật giỏ hàng thành công', 'success');
            return redirect()->route('cart');
        } else {
            alert('Lỗi', 'Số lượng không đủ.', 'error');
            return redirect()->route('cart');
        }
    }
}
