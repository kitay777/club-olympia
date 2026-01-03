<x-app-layout>

<div class="min-h-screen w-full  text-black px-4 py-10 
            bg-[url('/assets/imgs/bg_pattern.png')] bg-cover">

    <!-- タイトル -->
    <h2 class="text-center text-2xl font-bold text-yellow-500 tracking-wide">
        マイページ
    </h2>
    <div class="border-t border-yellow-500 mt-2 mb-10 w-full"></div>

    <!-- 中央パネル -->
    <div class="max-w-3xl mx-auto bg-white/80 border border-yellow-600 
                rounded-2xl p-6 sm:p-10 shadow-xl">

        <!-- ===================== ユーザー情報 ===================== -->
        <div class="mb-10">
            <div class="text-xl font-bold text-yellow-400 mb-4">
                {{ $user->name }} 様
            </div>

            <div class="flex items-center gap-3">
                <span class="text-lg text-yellow-500">保有ポイント：</span>
                <span class="text-3xl font-mono text-black tracking-wide">
                    {{ $user->point ?? 0 }} <span class="text-yellow-400">pt</span>
                </span>
            </div>

            <form method="GET" action="{{ route('mypage.use_point_form') }}">
                <button 
                    type="submit"
                    class="mt-6 px-6 py-3 border border-yellow-500 text-black 
                           rounded hover:bg-yellow-500 hover:text-black transition">
                    ポイントを使用する
                </button>
            </form>
        </div>


        <!-- ===================== クーポン一覧 ===================== -->
        <h3 class="text-xl font-bold text-yellow-400 mb-3">保有クーポン</h3>
        <div class="border-t border-yellow-600 opacity-50 mb-6"></div>

        <div class="space-y-5">

@foreach($coupons as $coupon)
<div
    x-data="{ open: false }"
    class="bg-white/50 border border-yellow-700 rounded-xl p-4 flex gap-4
           cursor-pointer hover:opacity-80 transition"
    @click="open = true"
>

    <!-- 画像 -->
    @if($coupon->image_path)
        <img src="{{ asset('storage/'.$coupon->image_path) }}"
             class="w-20 h-20 object-cover rounded border border-yellow-600">
    @endif

    <!-- 情報 -->
    <div class="flex-1">
        <div class="font-bold text-lg text-yellow-400">
            {{ $coupon->title }}
        </div>

        <div class="text-sm mb-1">
            {{ $coupon->description }}
        </div>

        @if($coupon->pivot->acquired_at)
            <div class="text-xs text-yellow-300">
                取得日: {{ $coupon->pivot->acquired_at }}
            </div>
        @endif
    </div>

    <!-- ===================== 確認モーダル ===================== -->
    <div
        x-show="open"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60"
    >
        <div
            class="bg-white w-[90%] max-w-md rounded-xl p-6 text-gray-700"
            @click.stop
        >
            <h3 class="text-xl font-bold mb-4 text-center">
                クーポン利用確認
            </h3>

            <p class="mb-6 text-center">
                <span class="font-bold">{{ $coupon->title }}</span><br>
                このクーポンを利用しますか？
            </p>

            <div class="flex justify-center gap-6">
                <!-- キャンセル -->
                <button
                    type="button"
                    @click="open = false"
                    class="px-6 py-2 border border-gray-400 rounded
                           hover:bg-gray-100"
                >
                    キャンセル
                </button>

                <!-- 利用する -->
                <form method="POST"
                      action="{{ route('mypage.coupons.use', $coupon) }}">
                    @csrf
                    <button
                        type="submit"
                        class="px-6 py-2 bg-[#595959] text-white
                               border border-[#c8a86a]
                               rounded hover:opacity-80"
                    >
                        利用する
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endforeach


        </div>


        <!-- ===================== ポイント履歴 ===================== -->
        <h3 class="text-xl font-bold text-yellow-400 mt-12 mb-3">ポイント履歴</h3>
        <div class="border-t border-yellow-600 opacity-50 mb-6"></div>

        <table class="w-full text-sm border-collapse">
            <thead>
                <tr class="bg-black border border-yellow-700 text-yellow-400">
                    <th class="p-3">日時</th>
                    <th class="p-3">内容</th>
                    <th class="p-3">増減</th>
                    <th class="p-3">残高</th>
                </tr>
            </thead>

            <tbody>
                @foreach($pointHistories as $history)
                    <tr class="border border-yellow-800 text-black-200">
                        <td class="p-3">{{ $history->created_at }}</td>
                        <td class="p-3">{{ $history->reason }}</td>
                        <td class="p-3 {{ $history->change > 0 ? 'text-green-400' : 'text-red-400' }}">
                            {{ $history->change > 0 ? '+' : '' }}{{ $history->change }}
                        </td>
                        <td class="p-3">{{ $history->balance }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

</x-app-layout>
