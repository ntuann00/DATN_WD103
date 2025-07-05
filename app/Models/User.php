<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

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

    protected $hidden = ['password'];

    protected $casts = [
        'birthday' => 'date',
        'status' => 'boolean',
        'role_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function getImgUrlAttribute()
    {
        return $this->img ? asset('storage/' . $this->img) : asset('images/default-avatar.png');
    }

    public function getGenderLabelAttribute()
    {
        return ucfirst($this->gender);
    }

    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }
}
