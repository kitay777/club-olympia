<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponUser extends Model
{
    use HasFactory;

    protected $table = 'coupon_user';

    protected $fillable = [
        'user_id',
        'coupon_id',
        'acquired_at', // 取得日時
        'used_at',     // 使用日時（NULL = 未使用）
    ];

    protected $casts = [
        'acquired_at' => 'datetime',
        'used_at'     => 'datetime',
    ];

    /**
     * ユーザー
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * クーポン
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
