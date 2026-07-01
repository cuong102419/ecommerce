<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\StoreReviewRequest;
use App\Services\ReviewService;

class ReviewController extends Controller
{
    public function __construct(
        protected ReviewService $reviewService
    ) {}

    public function store(StoreReviewRequest $request, $productId)
    {
        $data = $request->validated();
        $result = $this->reviewService->create($data, $productId);

        if (!$result) {
            alert('Lỗi', 'Xảy ra lỗi khi đánh giá.', 'error');
            return redirect()->back();
        }

        alert('Thành công', 'Gửi đánh giá thành công.', 'success');
        return redirect()->back();
    }
}
