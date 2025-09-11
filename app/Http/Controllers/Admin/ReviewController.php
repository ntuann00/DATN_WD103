<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    // Xem danh sách bình luận
    public function index()
    {
        $reviews = Review::with('user', 'product')->latest()->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }
}
