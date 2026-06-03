<?php

namespace App\Repositories;

use App\Models\CartItem;

class CartItemRepository
{
    public function getBySession($sessionId)
    {
        return CartItem::where('session_id', $sessionId)->get();
    }

    public function getByUser($userId)
    {
        return CartItem::where('user_id', $userId)->get();
    }

    public function findById($id){
        return CartItem::where('id', $id)->first();
    }

    public function finByProductId($cartId, $productId)
    {
        return CartItem::where('cart_id', $cartId)->where('product_id', $productId)->first();
    }

    public function incrementQuantity($id, $quantity)
    {
        return CartItem::where('id', $id)->increment('quantity', $quantity);
    }

    public function decrementQuantity($id, $quantity) {
        return CartItem::where('id', $id)->decrement('quantity', $quantity);
    }

    public function findByUserAndProduct($userId, $productId)
    {
        return CartItem::where('user_id', $userId)->where('product_id', $productId)->first();
    }

    public function findBySessionAndProduct($sessionId, $productId)
    {
        return CartItem::where('session_id', $sessionId)->where('product_id', $productId)->first();
    }

    public function create(array $data)
    {
        return CartItem::create($data);
    }

    public function deleteItem($id)
    {
        return CartItem::destroy($id);
    }
    public function deleteBySession($sessionId)
    {
        return CartItem::where('session_id', $sessionId)->delete();
    }

    public function deleteByUser($userId) {
        return CartItem::where('user_id', $userId)->delete();
    }

    public function updateQuantity($id, $quantity)
    {
        return CartItem::where('id', $id)->update(['quantity' => $quantity]);
    }
}
