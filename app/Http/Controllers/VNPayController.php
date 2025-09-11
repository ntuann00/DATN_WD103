<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VNPayController extends Controller
{

    public function create(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập');
        }
        $orderId = $request->input('order_id');
        // dd($orderId);
        $order = Order::find($orderId);
        // dd($order);
        // if (!$order) {
        //     return redirect()->route('cart.view')->with('error', 'Không tìm thấy đơn hàng!');
        // }

        $grandTotal = $request->total;

        $orderInfo =
            $user->id . '-' . $grandTotal . '-' . $order->id;

        // Bắt đầu xử lý redirect qua VNPAY
        $vnp_TmnCode = env('VNPAY_TMN_CODE');
        $vnp_HashSecret = env('VNPAY_HASH_SECRET');
        $vnp_Url = env('VNPAY_URL');
        $vnp_Returnurl = env('VNPAY_RETURN_URL');

        $vnp_TxnRef = 'ORDER' . time();
        $vnp_Amount = $grandTotal * 100;
        $vnp_OrderInfo = $orderInfo;
        $vnp_OrderType = 'billpayment';
        $vnp_Locale = 'vn';
        $vnp_BankCode = '';
        $vnp_IpAddr = request()->ip();

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        ];

        // Sắp xếp mảng dữ liệu input theo thứ tự bảng chữ cái của key
        ksort($inputData);

        $query = ""; // Biến lưu trữ chuỗi truy vấn (query string)
        $i = 0; // Biến đếm để kiểm tra lần đầu tiên
        $hashdata = ""; // Biến lưu trữ dữ liệu để tạo mã băm (hash data)

        // Duyệt qua từng phần tử trong mảng dữ liệu input
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                // Nếu không phải lần đầu tiên, thêm ký tự '&' trước mỗi cặp key=value
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                // Nếu là lần đầu tiên, không thêm ký tự '&'
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1; // Đánh dấu đã qua lần đầu tiên
            }
            // Xây dựng chuỗi truy vấn
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        // Gán chuỗi truy vấn vào URL của VNPay
        $vnp_Url = $vnp_Url . "?" . $query;

        // Kiểm tra nếu chuỗi bí mật hash secret đã được thiết lập
        if (isset($vnp_HashSecret)) {
            // Tạo mã băm bảo mật (Secure Hash) bằng cách sử dụng thuật toán SHA-512 với hash secret
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            // Thêm mã băm bảo mật vào URL để đảm bảo tính toàn vẹn của dữ liệu
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect($vnp_Url);
    }

    public function vnpayReturn(Request $request)
    {
        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        $vnp_TransactionStatus = $request->input('vnp_TransactionStatus');

        // Nếu thanh toán thất bại
        if ($vnp_ResponseCode != '00') {
            $orderInfo = $request->input('vnp_OrderInfo');
            if ($orderInfo) {
                $orderParts = explode('-', $orderInfo);
                $orderId = $orderParts[2] ?? null;

                if ($orderId) {
                    // Xoá đơn hàng chưa thanh toán
                    Order::where('id', $orderId)->delete();
                }
            }

            return redirect()->route('order.fail')->with('error', 'Thanh toán không thành công');
        }

        $vnp_HashSecret = env('VNPAY_HASH_SECRET');
        $vnp_SecureHash = $request->input('vnp_SecureHash');

        // $vnp_SecureHash = $request->vnp_SecureHash;
        $inputData = $request->all();

        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        $hashData = rtrim($hashData, '&');

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash !== $vnp_SecureHash) {
            return redirect()->route('order.fail')->with('error', 'Thanh toán không thành công');
        }

        if ($inputData['vnp_ResponseCode'] != '00') {
            return redirect()->route('order.fail')->with('error', 'Thanh toán không thành công');
        }

        try {
            DB::beginTransaction();

            if (!isset($inputData['vnp_OrderInfo'])) {
                return redirect()->route('order.fail')->with('error', 'Thanh toán không thành công');
            }

            $orderParts = explode('-', $inputData['vnp_OrderInfo']);

            if (count($orderParts) <= 1) {
                return redirect()->route('order.fail')->with('error', 'Thanh toán không thành công');
            }

            $userId = filter_var(trim($orderParts[0], '"'), FILTER_VALIDATE_INT);

            $user = User::query()->find($userId);

            if (!$user) {
                return redirect()->route('order.fail')->with('error', 'Thanh toán không thành công');
            }

            $grandTotal = trim($orderParts[1], '"');
            $order_id = $orderParts[2] == 0 ? '' : trim($orderParts[2], '"');
            $cart = Cart::where('user_id', $userId)->first();

            if (!$cart) {
                return redirect()->route('order.fail')->with('error', 'Thanh toán không thành công');
            }

            if (!$order_id) {
                return redirect()->route('order.fail')->with('error', 'Thanh toán không thành công');
            } else {
                $order = Order::where('id', $order_id)->where('user_id', $userId)->first();
                if (!$order) {
                    return redirect()->route('order.fail')->with('error', 'Thanh toán không thành công');
                }
            }

            $order->status_id = 1;
            $order->status_payment = 1;
            $order->save();

            $selectedIds = session('selected_items', []);

            if (!empty($selectedIds)) {
                $cart->cartDetails()->whereIn('id', $selectedIds)->delete();
            }

            DB::commit();

            return redirect()->route('order.success')->with('success', 'Thanh toán thanh cong!');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->route('order.fail')->with('error', 'Thanh toán không thành công');
        }
    }
}
