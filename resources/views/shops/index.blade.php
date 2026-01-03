<x-app-layout>

    <!-- 上部：金帯タイトル -->
    <div class="w-full bg-[#e6c98b]">
        <h2 class="text-center text-white text-2xl font-serif tracking-widest py-3">
            紹介店舗
        </h2>
    </div>

    <!-- 一覧 -->
    <div class="max-w-3xl mx-auto mt-12 px-6 space-y-12">

        @foreach($shops as $shop)
            <a href="{{ route('shops.show', $shop) }}" class="block group">

                <!-- 行全体 -->
                <div class="flex items-center gap-6">

                    <!-- 左：L字ゴールド装飾 -->
                    <div class="flex flex-col items-start">
                        <div class="w-4 h-4 border-l-2 border-t-2 border-[#c8a86a]"></div>
                        <div class="w-6 border-t-2 border-[#c8a86a]"></div>
                    </div>

                    <!-- 中央：店舗名 -->
                    <div class="text-lg tracking-wide text-gray-600">
                        店舗　
                        <span class="text-gray-800 font-semibold text-xl">
                            {{ $shop->name }}
                        </span>
                    </div>

                    <!-- 右：長い金ライン -->
                    <div class="flex-1 border-t border-[#c8a86a]"></div>

                </div>

            </a>
        @endforeach

    </div>

</x-app-layout>
