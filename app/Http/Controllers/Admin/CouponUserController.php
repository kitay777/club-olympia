<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\User;
use App\Models\CouponUser;  // coupon_user のモデル
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Shop; // Shopモデルをインポート

class CouponUserController extends Controller
{
public function index(Request $request)
{
    $users = User::all();
    $coupons = Coupon::all();

    $query = CouponUser::with('user', 'coupon');

    // 利用状況で絞り込み
    if ($request->get('status') === 'used') {
        $query->whereNotNull('used_at');
    } elseif ($request->get('status') === 'unused') {
        $query->whereNull('used_at');
    }

    $couponUsers = $query
        ->orderByDesc('used_at')
        ->paginate(10);

    return view(
        'admin.couponusers.index',
        compact('users', 'coupons', 'couponUsers')
    );
}


    public function store(Request $request)
    {
        // ユーザーにクーポンを配布
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',  // ユーザーID
            'coupon_id' => 'required|exists:coupons,id',  // クーポンID
        ]);

        // クーポンユーザー情報を保存
        CouponUser::create([
            'user_id' => $validated['user_id'],
            'coupon_id' => $validated['coupon_id'],
        ]);

        return redirect()->route('admin.couponusers.index')->with('success', 'クーポンがユーザーに配布されました');
    }
    public function destroy(CouponUser $couponUser)
    {
        // 削除処理
        $couponUser->delete();

        // 成功メッセージと共に一覧ページにリダイレクト
        return redirect()->route('admin.couponusers.index')->with('success', 'クーポン配布ユーザーが削除されました');
    }

}

