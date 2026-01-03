<x-app-layout>

    <!-- 背景（白＋ダイヤ柄） -->
    <div class="min-h-screen w-full
                bg-[url('/assets/imgs/bg_pattern.png')] bg-repeat
                px-4 py-8 text-gray-700">

        <!-- 金帯タイトル -->
        <div class="w-full bg-[#e6c98b] mb-12">
            <h2 class="text-center text-white text-2xl font-serif tracking-widest py-3">
                紹介店舗
            </h2>
        </div>

        <div class="max-w-3xl mx-auto">

            <!-- ================= 写真枠（多重ゴールド） ================= -->
            <div class="relative mb-12">

                <!-- 外枠 -->
                <div class="border-2 border-[#c8a86a] p-2">
                    <div class="border border-[#c8a86a] p-2">
                        <div class="bg-white" style="aspect-ratio: 16 / 9;">
                            @if ($shop->image_path)
                                <img src="{{ asset('storage/' . $shop->image_path) }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-xl text-gray-500">
                                    写真
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            <!-- ================= 情報行 ================= -->

            @php
                $rows = [
                    '店名' => $shop->name,
                    '住所' => $shop->address ?? '',
                    'TEL' => $shop->tel ?? '',
                    '紹介文' => $shop->description ?? '',
                ];
            @endphp

            @foreach ($rows as $label => $value)
                <div class="mb-8">
                    <div class="text-lg tracking-wide text-gray-500">
                        {{ $label }}
                    </div>
                    <div class="border-t border-[#c8a86a] mt-1"></div>
                    <div class="mt-2 text-gray-700">
                        {!! nl2br(e($value)) !!}
                    </div>
                </div>
            @endforeach

            <!-- ================= クーポン（ボタン型） ================= -->
            @if ($shop->coupons->count())
                <div class="flex justify-center gap-10 mt-14">

                    @foreach ($shop->coupons->take(2) as $coupon)
                    <div class="mb-6 p-4 border border-yellow-600 rounded-xl bg-black/50">
                        @if ($coupon->image_path)
                            <img src="{{ asset('storage/' . $coupon->image_path) }}"
                                 class="w-full h-40 object-cover rounded mb-3">
                        @endif

                        <div class="text-lg font-bold">{{ $coupon->title }}</div>
                        <div class="text-gray-300 text-sm mb-2">
                            {!! nl2br(e($coupon->description)) !!}
                        </div>
                        <div class="text-yellow-400 text-sm">
                            有効期限：{{ $coupon->valid_until }}
                        </div>
                    </div>
                    @endforeach


                </div>
            @endif

        </div>
    </div>

</x-app-layout>
