<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Status;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    // Hiển thị danh sách đơn hàng
    public function index()
    {
        $orders = Order::with(['user', 'status', 'payment'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    // Hiển thị chi tiết đơn hàng
    public function show($id)
    {
        $order = Order::with([
            'user',
            'address',
            'status',
            'payment',
            'orderDetails.product',
            'orderDetails.product.variants.variantValues'
        ])->findOrFail($id);

        // Lấy trạng thái theo thứ tự ID ASC
        $statuses = Status::orderBy('id', 'asc')->get();

        return view('admin.orders.show', compact('order', 'statuses'));
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_id' => 'required|exists:statuses,id',
        ]);

        $order = Order::findOrFail($id);
        $newStatusId = (int) $request->status_id;
        $currentStatusId = $order->status_id;

        // Danh sách trạng thái hợp lệ theo thứ tự
        $statusOrder = [1, 2, 3, 4, 5, 6, 7, 9]; // Hoàn hàng = 9
        $cancelStatusId = 8; // Hủy đơn hàng

        // Không cho quay lại trạng thái trước
        if ($newStatusId < $currentStatusId) {
            return redirect()->back()->with('error', '❌ Không thể quay lại trạng thái trước đó!');
        }

        // Không cho hủy nếu đã lấy hàng thành công hoặc hơn
        if ($currentStatusId >= 4 && $newStatusId == $cancelStatusId) {
            return redirect()->back()->with('error', '❌ Không thể hủy đơn hàng sau khi đã lấy hàng thành công!');
        }

        // Kiểm tra đúng thứ tự (trừ khi hủy)
        if ($newStatusId != $cancelStatusId) {
            $currentIndex = array_search($currentStatusId, $statusOrder);
            $nextIndex = $currentIndex + 1;

            if (!isset($statusOrder[$nextIndex]) || $statusOrder[$nextIndex] != $newStatusId) {
                return redirect()->back()->with('error', '❌ Bạn phải cập nhật theo đúng thứ tự trạng thái!');
            }
        }

        // Cập nhật trạng thái
        $order->status_id = $newStatusId;
        $order->save();

        return redirect()->route('orders.show', $order->id)
            ->with('success', '✅ Cập nhật trạng thái thành công!');
    }
    public function updateProductStatus(Request $request, $orderId, $detailId)
    {
        try {
            $detail = OrderDetail::where('order_id', $orderId)
                ->where('id', $detailId)
                ->firstOrFail();

            $currentStatus = $detail->status_id ?? 1;
            $newStatus = $request->status_id;

            if($currentStatus == 8 || $currentStatus == 9){
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể thay đổi trạng thái khi đang hủy hoặc hoàn!'
                ], 422);
            }

            // Admin không thể hủy đơn hoặc hoàn hàng khi đã xác nhận
            if (($newStatus == 8 || $newStatus == 9) && $currentStatus >= 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể hủy đơn hoặc hoàn hàng khi đã xác nhận!'
                ], 422);
            }

            // Chỉ cho phép chuyển sang trạng thái kế tiếp
            if ($newStatus != $currentStatus + 1 && $newStatus != $currentStatus) {
                // Ngoại lệ: có thể hủy khi chưa xác nhận
                if (!($newStatus == 8 && $currentStatus == 1)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Chỉ được chuyển sang trạng thái kế tiếp!'
                    ], 422);
                }
            }

            // Cập nhật trạng thái
            $detail->status_id = $newStatus;
            $detail->save();

            // Cập nhật trạng thái tổng của đơn hàng
            $this->updateOrderStatus($orderId);

            // Lấy thông tin trạng thái mới
            $status = Status::find($newStatus);

            // Lấy danh sách trạng thái có thể chuyển tiếp
            $nextStatuses = $this->getAvailableStatuses($newStatus);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái sản phẩm thành công!',
                'status_name' => $status->name ?? 'N/A',
                'status_id' => $newStatus,
                'next_statuses' => $nextStatuses
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    private function updateOrderStatus($orderId)
    {
        $order = Order::find($orderId);
        if (!$order) {
            return;
        }

        // Kiểm tra xem có sản phẩm nào đang ở trạng thái 1-6 không
        $hasProcessingItems = OrderDetail::where('order_id', $orderId)
            ->whereIn('status_id', [1, 2, 3, 4, 5, 6])
            ->exists();

        // Cập nhật status: 0 = chưa hoàn thành, 1 = hoàn thành
        $order->status = $hasProcessingItems ? 0 : 1;

        if ($hasProcessingItems) {
            $order->status_payment = '1';
        }

        $order->save();
    }

    private function getAvailableStatuses($currentStatusId)
    {
        $statuses = Status::all();
        $availableStatuses = [];

        foreach ($statuses as $status) {
            $canSelect = false;

            // Trạng thái hiện tại
            if ($currentStatusId == $status->id) {
                $canSelect = true;
            }
            // Trạng thái kế tiếp (không cho phép chuyển sang hoàn hàng)
            elseif ($currentStatusId + 1 == $status->id && $status->id != 9) {
                $canSelect = true;
            }
            // Chỉ có thể hủy khi ở trạng thái chờ xác nhận
            elseif ($status->id == 8 && $currentStatusId == 1) {
                $canSelect = true;
            }

            if ($canSelect) {
                $availableStatuses[] = [
                    'id' => $status->id,
                    'name' => $status->name,
                    'is_cancel' => $status->id == 8
                ];
            }
        }

        return $availableStatuses;
    }
}
