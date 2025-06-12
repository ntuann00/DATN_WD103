<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Users extends Authenticatable
{
    use Notifiable;

    // Nếu tên bảng không phải là 'users', cần khai báo:
    protected $table = 'users';

    // Các trường được phép gán giá trị hàng loạt (mass assignable)
    protected $fillable = [
        'name',
        'phone',
        'email',
        'img',
        'birthday',
        'password',
        'gender',
        'role_id',
        'status',
    ];

    // Ẩn các trường khi xuất ra JSON
    protected $hidden = [
        'password',
    ];

    // Kiểu dữ liệu cần ép kiểu
    protected $casts = [
        'birthday' => 'date',
        'status' => 'boolean',
        'role_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Mối quan hệ (nếu bạn có bảng roles)
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Trả về ảnh đầy đủ URL
    public function getImgUrlAttribute()
    {
        return $this->img ? asset('storage/' . $this->img) : asset('images/default-avatar.png');
    }

    // Gán giới tính viết hoa chữ đầu
    public function getGenderLabelAttribute()
    {
        return ucfirst($this->gender);
    }

    // Tự động hash mật khẩu nếu gán mới
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }
}
