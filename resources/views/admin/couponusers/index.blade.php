@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-semibold mb-4">クーポン配布管理</h2>

    <!-- クーポン配布フォーム -->
    <form action="{{ route('admin.couponusers.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="user_id" class="block text-sm font-medium text-gray-700">ユーザー</label>
            <select name="user_id" id="user_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
                <option value="">選択してください</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="coupon_id" class="block text-sm font-medium text-gray-700">クーポン</label>
            <select name="coupon_id" id="coupon_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
                <option value="">選択してください</option>
                @foreach($coupons as $coupon)
                    <option value="{{ $coupon->id }}">{{ $coupon->title }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">配布</button>
    </form>

    <h3 class="mt-8 text-xl">配布されたクーポン一覧</h3>

    <table class="table-auto w-full border">
    <thead>
        <tr>
            <th>ユーザー</th>
            <th>クーポン</th>
            <th>取得日</th>
            <th>使用日</th>
            <th>状態</th>
            <th>操作</th>
        </tr>
    </thead>

    <tbody>
        @foreach($couponUsers as $cu)
            <tr>
                <td>{{ $cu->user->name }}</td>
                <td>{{ $cu->coupon->title }}</td>
                <td>{{ $cu->acquired_at }}</td>
                <td>{{ $cu->used_at ?? '-' }}</td>
                <td>
                    @if($cu->used_at)
                        <span style="color:red;">使用済</span>
                    @else
                        <span style="color:green;">未使用</span>
                    @endif
                </td>
                <td>
                    <form method="POST"
                          action="{{ route('admin.couponusers.destroy', $cu) }}">
                        @csrf
                        @method('DELETE')
                        <button>削除</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $couponUsers->links() }}

    <!-- ページネーションリンク -->
    <div class="mt-4">
        {{ $couponUsers->links() }}
    </div>
@endsection
