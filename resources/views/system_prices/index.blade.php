<x-app-layout>

    <!-- SYSTEM 金帯 -->
    <div class="w-full bg-[#e6c98b]">
        <h2 class="text-center text-white text-2xl font-serif tracking-widest py-3">
            SYSTEM
        </h2>
    </div>

    <!-- ===== SET料金 ===== -->
    <div class="bg-[#e5dccb] py-4 text-center font-bold text-lg">
        1st set 40min
    </div>

    <div class="max-w-xl mx-auto py-4 space-y-2">
        @foreach($setPrices as $item)
            <div class="flex justify-between px-6 text-gray-700">
                <span>{{ $item->title }}</span>
                <span>{{ $item->value }}</span>
            </div>
        @endforeach
    </div>

    <!-- ===== 同伴料金 ===== -->
    <div class="bg-[#e5dccb] py-4 text-center font-bold text-lg mt-6">
        同伴料金 60min
    </div>

    <div class="max-w-xl mx-auto py-4 space-y-2">
        <div class="flex justify-between px-6 text-gray-700">
            <span>20:00〜</span>
            <span>¥12,000〜</span>
        </div>
    </div>

    <!-- ===== 延長料金 ===== -->
    <div class="bg-[#e5dccb] py-4 text-center font-bold text-lg mt-6">
        延長料金
    </div>

    <div class="max-w-xl mx-auto py-4 space-y-2">
        <div class="flex justify-between px-6 text-gray-700">
            <span>30min</span>
            <span>¥3,600</span>
        </div>
        <div class="flex justify-between px-6 text-gray-700">
            <span>60min</span>
            <span>¥6,600</span>
        </div>
    </div>

    <!-- ===== 指名料金 ===== -->
    <div class="bg-[#e5dccb] py-4 text-center font-bold text-lg mt-6">
        指名料金
    </div>

    <div class="max-w-xl mx-auto py-4 space-y-2">
        @foreach($nominatePrices as $item)
            <div class="flex justify-between px-6 text-gray-700">
                <span>{{ $item->title }}</span>
                <span>{{ $item->value }}</span>
            </div>
        @endforeach
    </div>

    <!-- ===== クレジットカード ===== -->
    <div class="bg-[#e5dccb] py-6 text-center font-bold mt-8">
        各種カードがご利用頂けます。
        <div class="flex justify-center gap-4 mt-4">
            <img src="/assets/imgs/card.png" class="h-8">
        </div>
    </div>

    <!-- ===== 店舗情報 ===== -->
    <div class="max-w-xl mx-auto py-8 space-y-2 text-gray-700">
        @foreach($infos as $item)
            <div class="flex">
                <div class="w-24 font-semibold">{{ $item->title }}</div>
                <div>{{ $item->value }}</div>
            </div>
        @endforeach
    </div>

    <!-- ===== ACCESS 金帯 ===== -->
    <div class="w-full bg-[#e6c98b] mt-8">
        <h2 class="text-center text-white text-2xl font-serif tracking-widest py-3">
            ACCESS
        </h2>
    </div>

    <!-- 住所 + Google map -->
    <div class="bg-[#e5dccb] px-6 py-4 flex justify-between items-center">
        <span class="text-gray-700">
                        @foreach($infos as $item)
                <tr>
                    <td class="font-semibold">{{ $item->title }}</td>
                    <td>{{ $item->value }}</td>
                </tr>
            @endforeach
        </span>

        <a href="https://www.google.com/maps?q={{ urlencode($infos['住所']->value ?? '') }}"
           target="_blank"
           class="bg-gray-600 text-white px-4 py-1 rounded">
            Google map
        </a>
    </div>

    <!-- 地図 -->
        <div class="mt-6">
            <h4 class="font-bold mb-2">Googleマップ</h4>
            <iframe src="https://www.google.com/maps?q=35.6895,139.6917&z=15&output=embed"
                width="100%" height="280" style="border:0; border-radius: 12px;" allowfullscreen loading="lazy"></iframe>
        </div>

</x-app-layout>
