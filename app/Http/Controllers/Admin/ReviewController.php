<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Hiển thị danh sách tất cả bình luận trong admin
     */
    public function index()
    {
        $reviews = Review::with(['user', 'product'])->latest()->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Lọc và hiển thị bình luận sạch từ client theo sản phẩm
     */
    public function showProductReviews($productId)
    {
        $bannedWords = ['đm', 'vãi', 'ngu', 'lồn', 'chết', 'quảng cáo', 'xxx'];

        $reviews = Review::with(['user'])
            ->where('product_id', $productId)
            ->get()
            ->filter(function ($review) use ($bannedWords) {
                foreach ($bannedWords as $word) {
                    if (stripos($review->comment, $word) !== false) {
                        return false;
                    }
                }
                return true;
            });

        return view('user.products.reviews', compact('reviews'));
    }

    /**
     * Tạo mới bình luận từ phía người dùng
     */
    public function store(Request $request, $productId)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $bannedWords = ['đm', 'vãi', 'ngu', 'lồn', 'chết', 'quảng cáo', 'xxx'];
        $comment = strtolower($request->comment);

        foreach ($bannedWords as $word) {
            if (str_contains($comment, $word)) {
                return back()->withInput()->withErrors([
                    'comment' => 'Bình luận chứa từ ngữ không phù hợp.',
                ]);
            }
        }

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $productId,
            'rating' => $request->rating ?? 5,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Bình luận của bạn đã được gửi.');
    }
}
