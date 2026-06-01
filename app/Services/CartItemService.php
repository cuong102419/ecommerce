<?php

namespace App\Services;

use App\Repositories\CartItemRepository;
use Illuminate\Support\Facades\Auth;

class CartItemService
{
    public function __construct(
        protected CartItemRepository $cartItemRepository
    ) {}

    public function getCartItems()
    {
        if (Auth::check()) {
            return $this->cartItemRepository->getByUser(Auth::user()->id);
        }

        return $this->cartItemRepository->getBySession(session()->getId());
    }

    public function getTotalPrice($cartItems)
    {
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item->product->price * $item->quantity;
        }
        return $totalPrice;
    }

    public function create(array $data)
    {
        if (Auth::user()) {
            $data['user_id'] = Auth::id();
            $existingItem = $this->cartItemRepository->findByUserAndProduct(Auth::id(), $data['product_id']);
        } else {
            $data['session_id'] = session()->getId();
            $existingItem = $this->cartItemRepository->findBySessionAndProduct(session()->getId(), $data['product_id']);
        }

        if ($existingItem) {
            return $this->cartItemRepository->incrementQuantity($existingItem->id, $data['quantity']);
        }

        return $this->cartItemRepository->create($data);
    }

    public function delete($id)
    {
        $this->cartItemRepository->deleteItem($id);
    }
    public function mergeCart($sessionId)
    {
        $sessionItems = $this->cartItemRepository->getBySession($sessionId);

        if ($sessionItems->isEmpty()) return;

        foreach ($sessionItems as $item) {
            $existingItem = $this->cartItemRepository->findByUserAndProduct(
                Auth::id(),
                $item->product_id
            );

            if ($existingItem) {
                $this->cartItemRepository->incrementQuantity($existingItem->id, $item->quantity);
            } else {
                $this->cartItemRepository->create([
                    'user_id'    => Auth::id(),
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                ]);
            }
        }

        $this->cartItemRepository->deleteBySession($sessionId);
    }

    public function update(array $data) {
        foreach($data['quantities'] as $id => $quantity) {
            $this->cartItemRepository->updateQuantity($id, $quantity);
        }
    }
}
