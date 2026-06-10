<?php

namespace App\Http\Controllers\Admin;

use App\Constants\OrderStatus;
use App\Http\Controllers\Controller;
use App\Repositories\OrderItemRepository;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService,
        protected OrderItemRepository $orderItemRepository
    ) {}

    public function index(Request $request)
    {
        $orders = $this->orderService->get($request);
        $statuses = OrderStatus::STATUSES;
        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    public function detail($id)
    {
        $order = $this->orderService->findById($id);
        $orderItem = $this->orderItemRepository->getByOrderId($id);
        $statuses = OrderStatus::STATUSES;

        return view('admin.orders.detail', compact('order', 'orderItem', 'statuses'));
    }

    public function updateStatus(Request $request, $id)
    {
        $this->orderService->updateStatus($id, $request);

        alert('Thành công', 'Cập nhật trạng thái đơn thành công.', 'success');
        return redirect()->back();
    }

    public function updateAll(Request $request)
    {
        $result = $this->orderService->updateStatusAll($request);

        if (!$result['success']) {
            alert('Lỗi.', 'Cập nhật đơn hàng không thành công.', 'error');
            return redirect()->back();
        }

        if ($result['skipped'] > 0 && $result['deleted'] === 0) {

            alert('Cảnh báo.', "Không thể xóa {$result['skipped']} đơn vì không hợp lệ.", 'warning');
            return redirect()->back();
        }

        if ($result['skipped'] > 0) {
            
            alert('Thành công.', "Đã xóa {$result['deleted']} đơn. {$result['skipped']} đơn không hợp lệ bị bỏ qua.", 'warning');
            return redirect()->back();
        }

        alert('Thành công.', "Đã xóa {$result['deleted']} đơn hàng.", 'success');
        return redirect()->back();
    }
}
