<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Coupon;  
use Carbon\Carbon;

class MypageController extends Controller
{
    

public function useCoupon(Request $request, Coupon $coupon)
{
    $user = Auth::user();

    $pivot = $user->coupons()
        ->where('coupon_id', $coupon->id)
        ->firstOrFail()
        ->pivot;

    if ($pivot->used_at) {
        return back()->with('error', 'このクーポンは既に使用されています');
    }

    $user->coupons()->updateExistingPivot(
        $coupon->id,
        ['used_at' => now()]
    );

    // 履歴（管理者・監査用）
    $user->pointHistories()->create([
        'change' => 0,
        'reason' => "クーポン使用：{$coupon->title}",
        'balance' => $user->point,
    ]);

    return redirect()->route('mypage')->with('success', 'クーポンを使用しました');
}

    public function index()
    {
        $user = Auth::user();

        // 保有クーポン
        //$coupons = $user->coupons()->withPivot('acquired_at', 'used_at')->get();
$coupons = $user->coupons()
    ->wherePivotNull('used_at')
    ->withPivot('acquired_at', 'used_at')
    ->get();

        // ポイント履歴（新しい順）
        $pointHistories = $user->pointHistories()->orderByDesc('id')->get();

        return view('mypage.index', compact('user', 'coupons', 'pointHistories'));
    }

    public function usePointForm()
    {
        $user = Auth::user();
        return view('mypage.use-point', ['user' => $user]);
    }

    // 実際のポイント消費
    public function usePoint(Request $request)
    {
        $user = Auth::user();
        $usePoint = $request->input('point');

        // 残高チェック
        if ($usePoint > $user->point) {
            return back()->with('error', 'ポイントが足りません');
        }

        // ポイント減算＆履歴登録
        $user->point -= $usePoint;
        $user->save();

        $user->pointHistories()->create([
            'change' => -$usePoint,
            'reason' => 'ポイント使用',
            'balance' => $user->point,
        ]);

        return redirect()->route('mypage')->with('success', "{$usePoint}pt 使用しました");
    }
}
