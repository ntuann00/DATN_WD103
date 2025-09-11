<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // Bảng tương ứng
    protected $table = 'reviews';

    // Các cột có thể gán giá trị hàng loạt
    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
    ];

    // Quan hệ: 1 review thuộc về 1 user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ: 1 review thuộc về 1 product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getCleanCommentAttribute()
{
    $badWords = ['đm', 'vl', 'cmm', 'ngu']; // danh sách từ cấm
    $comment = $this->comment;

    foreach ($badWords as $word) {
        $comment = str_ireplace($word, '***', $comment);
    }

    return $comment;
}

}
