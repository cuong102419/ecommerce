<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\ReviewRepository;
use Illuminate\Support\Facades\Auth;

class ReviewService
{
    public function __construct(
        protected ReviewRepository $reviewRepository,
        protected OrderRepository $orderRepository
    ) {}

    public function create($data, $productId) {
        $hasBought = $this->orderRepository->hasBought(Auth::id(), $productId);
        if(!$hasBought) {
            return false;
        }

        $hasReviewed = $this->reviewRepository->hasReviewed(Auth::id(), $productId);
        if ($hasReviewed) {
            return false;
        }

        $data['user_id'] = Auth::id();
        $data['product_id'] = $productId;
        
        return $this->reviewRepository->create($data);
    }
}
