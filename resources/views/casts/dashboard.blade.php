<x-app-layout>
    <div class="w-full">
        @if ($tickers->count())
            <div x-data='tickerComponent({!! json_encode($tickers) !!})' x-init="start()"
                class="w-full bg-black border-y border-yellow-500 overflow-hidden py-2 relative" x-ref="container">
                <div class="absolute top-0 left-0 h-full flex items-center whitespace-nowrap" x-ref="ticker"
                    :style="{ transform: `translateX(${x}px)` }">
                    <template x-for="(text, i) in displayItems" :key="i">
                        <span class="text-white text-lg mx-6" x-text="text"></span>
                    </template>
                </div>
            </div>
        @endif



        <script>
            document.addEventListener('alpine:init', () => {

                Alpine.data('tickerComponent', (items) => ({
                    baseItems: items,
                    displayItems: [],
                    x: 0,

                    start() {
                        this.$nextTick(() => {

                            const containerWidth = this.$refs.container.offsetWidth;

                            this.displayItems = [...this.baseItems];

                            while (this.calcWidth() < containerWidth * 2) {
                                this.displayItems = this.displayItems.concat(this.baseItems);
                                if (this.displayItems.length > 50) break;
                            }

                            this.animate();
                        });
                    },

                    animate() {
                        const ticker = this.$refs.ticker;

                        const loop = () => {
                            this.x -= 1;

                            if (this.x <= -(ticker.scrollWidth / 2)) {
                                this.x = 0;
                            }

                            requestAnimationFrame(loop);
                        };

                        loop();
                    },

                    calcWidth() {
                        const span = document.createElement('span');
                        span.style.visibility = 'hidden';
                        span.style.whiteSpace = 'nowrap';
                        span.innerText = this.displayItems.join('　　');

                        document.body.appendChild(span);
                        const w = span.offsetWidth;
                        document.body.removeChild(span);

                        return w;
                    }
                }));

            });
        </script>


        @if ($topImages->count())
            <div x-data="carousel" x-init="start()" class="relative w-full overflow-hidden"
                style="aspect-ratio: 16 / 9;">


                <!-- 画像 -->
                <template x-for="(item, index) in items" :key="index">
                    <div x-show="current === index" class="absolute inset-0 transition-opacity duration-700"
                        x-transition.opacity>
                        <img :src="item" class="w-full h-auto object-cover">
                    </div>
                </template>

                <!-- 左右ボタン -->
                <button @click="prev"
                    class="absolute left-3 top-1/2 -translate-y-1/2 
                   text-white bg-black/40 p-2 rounded-full">‹</button>

                <button @click="next"
                    class="absolute right-3 top-1/2 -translate-y-1/2 
                   text-white bg-black/40 p-2 rounded-full">›</button>

                <!-- ドット -->
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                    <template x-for="(item, index) in items" :key="'dot-' + index">
                        <button @click="go(index)" class="w-3 h-3 rounded-full"
                            :class="current === index ? 'bg-white' : 'bg-gray-400'">
                        </button>
                    </template>
                </div>

            </div>

            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.data('carousel', () => ({
                        current: 0,
                        timer: null,
                        items: @json($topImages->map(fn($img) => asset('storage/' . $img->image_path))),

                        start() {
                            // 自動スライド
                            this.timer = setInterval(() => this.next(), 4000);

                            // スワイプ
                            let startX = 0;
                            this.$el.addEventListener('touchstart', e => {
                                startX = e.touches[0].clientX;
                            });
                            this.$el.addEventListener('touchend', e => {
                                let endX = e.changedTouches[0].clientX;
                                if (endX < startX - 50) this.next();
                                if (endX > startX + 50) this.prev();
                            });
                        },

                        next() {
                            this.current = (this.current + 1) % this.items.length;
                        },

                        prev() {
                            this.current = (this.current - 1 + this.items.length) % this.items.length;
                        },

                        go(i) {
                            this.current = i;
                        }
                    }))
                })
            </script>
        @endif
@auth
    <div class="w-full flex justify-center mt-1">

        @if(($canPlayBoxGame ?? false))
            {{-- ▶ プレイ可能 --}}
            <a href="{{ route('game.box') }}"
               class="relative group">

                {{-- 光る演出 --}}
                <div class="absolute -inset-1 bg-yellow-400 blur opacity-60
                            group-hover:opacity-90 transition"></div>

                <div class="relative
                            bg-black border-2 border-yellow-500
                            px-10 py-4 rounded-full
                            text-yellow-400 text-xl font-bold
                            hover:bg-yellow-500 hover:text-black transition">

                    🎁 BOX GAME START
                    <span class="block text-sm font-normal tracking-wide mt-1">
                        1〜5等が当たる！（一人一回限り）
                    </span>
                </div>
            </a>
        @else
            {{-- ❌ すでにプレイ済み --}}
            </div>
        @endif

    </div>
@endauth


        <div class="mt-1">

<!-- CAST LIST タイトル -->
<div class="w-full bg-[#e6c98b]">
    <div class="flex justify-between items-center px-4 py-3">
        <h2 class="text-white text-xl font-serif italic tracking-widest">
            CAST LIST
        </h2>

        <a href="{{ route('casts.index') }}"
           class="text-white text-sm hover:underline">
            もっと見る
        </a>
    </div>
</div>


            <!-- 金ライン -->
            <div class="border-t border-yellow-500 my-2"></div>

            <!-- 横スクロールコンテナ -->
<div class="bg-[#e5dccb] py-6 px-4 overflow-x-auto whitespace-nowrap">
    @foreach ($casts as $cast)
        <a href="{{ route('casts.show', $cast) }}"
           class="inline-block mr-4 align-top">

            <div class="bg-[#d8cdbb] p-2">
                <div class="bg-white aspect-square w-[160px] relative">
                    @if ($cast->image_path)
                        <img src="{{ asset('storage/' . $cast->image_path) }}"
                             class="absolute inset-0 w-full h-full object-cover">
                    @else
                        <div class="absolute inset-0 bg-gray-400"></div>
                    @endif
                </div>

                <div class="mt-2 text-center text-gray-700 font-semibold">
                    {{ $cast->name }}
                </div>
            </div>

        </a>
    @endforeach
</div>

            <!-- リクルートバナー -->
<!-- RECRUIT -->
<div class="bg-[#e5dccb] py-10 text-center">
    <div class="text-gray-600 mb-3">
        ーフロアレディ、スタッフ募集中ー
    </div>

    <a href="/recruit" class="inline-block">
        <div class="bg-gradient-to-r from-[#c8a77a] to-[#a8895e] px-10 py-3">
            <span class="text-white text-2xl font-serif tracking-widest">
                RECRUIT
            </span>
        </div>
    </a>
</div>



        </div>
        <!-- ↓↓↓ ここから下にバナー・アドレス・Google Map ↓↓↓ -->
        @if ($tickers->count())
<!-- テロップ -->
<div class="bg-white border-t border-b border-[#e6c98b] overflow-hidden py-3">
    <div x-data="{ x: 0 }"
         x-init="
            setInterval(() => {
                x = (x <= -1000) ? 0 : x - 1
            }, 16)
         "
         class="whitespace-nowrap"
         :style="`transform: translateX(${x}px)`">

        <span class="mx-8 text-gray-700">テロップ</span>
        <span class="mx-8 text-gray-700">テロップ</span>
        <span class="mx-8 text-gray-700">テロップ</span>
        <span class="mx-8 text-gray-700">テロップ</span>
        <span class="mx-8 text-gray-700">テロップ</span>
    </div>
</div>

        @endif
        <!-- NEWS -->
        <div class="mt-10">

<!-- NEWS タイトル -->
<div class="w-full bg-gradient-to-r from-[#ecd9a3] via-[#e6c98b] to-[#ecd9a3] mt-10">
    <div class="flex justify-between items-center px-4 py-3">
        <h2 class="text-white text-xl font-serif tracking-widest">
            NEWS
        </h2>

        <a href="{{ route('news.index') }}"
           class="text-white text-sm hover:underline">
            もっと見る
        </a>
    </div>
</div>


            <!-- 金ライン -->
            <div class="border-t border-yellow-500 my-2"></div>

            <div class="bg-[#e5dccb]">

                @foreach ($latestNews as $n)
                    @php
                        $isNew = $n->published_at >= now()->subDays(3);
                    @endphp

                    <div x-data="{ open: false }" class="border-b border-gray-700">
                        <button @click="open = !open"
                            class="w-full flex items-center px-3 py-3 hover:bg-gray-800 transition">
                            <!-- アイコン -->
                            <span class="mr-3 text-lg">▶</span>

                            <!-- New -->
                            @if ($isNew)
                                <span class="text-red-500 font-bold mr-3">New</span>
                            @endif

                            <!-- 日付 -->
                            <span class="font-bold text-lg mr-3">
                                {{ $n->published_at->format('Y/m/d') }}
                            </span>

                            <!-- タイトル -->
                            <span class="truncate">
                                {{ $n->title }}
                            </span>
                        </button>

                        <!-- 本文（開閉エリア） -->
                        <div x-show="open" x-collapse class="px-4 py-3 bg-gray-900 text-sm text-gray-200">
                            {!! nl2br(e($n->body)) !!}

                            @if ($n->image_path)
                                <div class="mt-3">
                                    <img src="{{ asset('storage/' . $n->image_path) }}" class="w-full rounded">
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
        <!-- BLOG -->
        <div class="mt-10">

<!-- BLOG タイトル -->
<div class="w-full bg-gradient-to-r from-[#ecd9a3] via-[#e6c98b] to-[#ecd9a3] mt-12">
    <div class="flex justify-between items-center px-4 py-3">
        <h2 class="text-white text-xl font-serif tracking-widest">
            BLOG
        </h2>

        <a href="{{ route('blogs.index') }}"
           class="text-white text-sm hover:underline">
            もっと見る
        </a>
    </div>
</div>


            <!-- 金ライン -->
            <div class="border-t border-yellow-500 my-2"></div>

            <!-- カード一覧（横3 or ページいっぱい） -->
            <div class="grid grid-cols-3 gap-4 px-2">

                @foreach ($latestBlogs as $blog)
                    <div class="bg-white rounded shadow overflow-hidden">

                        <!-- 上段：キャスト名 -->
                        <div class="px-3 py-1 font-bold text-gray-700">
                            {{ $blog->cast->name ?? 'Name' }}
                        </div>

                        <!-- サムネイル -->
                        <div class="w-full" style="aspect-ratio: 1/1;">
                            @if ($blog->image_path)
                                <img src="{{ asset('storage/' . $blog->image_path) }}"
                                    class="object-cover w-full h-full" />
                            @else
                                <div class="bg-blue-200 w-full h-full"></div>
                            @endif
                        </div>

                        <!-- 下段：題名 + 日付 -->
                        <div class="flex justify-between items-center px-3 py-2 text-sm font-bold text-gray-800">
                            <span>{{ $blog->title }}</span>
                            <span>{{ $blog->published_at->format('Y/m/d') }}</span>
                        </div>

                        <!-- 本文冒頭 -->
                        <div class="px-3 pb-3 text-gray-600 text-sm">
                            {{ \Illuminate\Support\Str::limit(strip_tags($blog->body), 20, '…') }}
                        </div>

                    </div>
                @endforeach

            </div>

        </div>


        <!-- ACCESS -->
        <div class="mt-12 text-white py-6 px-4">

            <!-- タイトル -->
<!-- ACCESS タイトル -->
<div class="w-full bg-gradient-to-r from-[#ecd9a3] via-[#e6c98b] to-[#ecd9a3] mt-12">
    <div class="px-4 py-3">
        <h2 class="text-white text-xl font-serif tracking-widest">
            ACCESS
        </h2>
    </div>
</div>

            <div class="border-t border-yellow-500 my-2"></div>
            <!-- 上段：住所 ＋ Google Map ボタン -->
<!-- 住所 & Google map -->
<div class="w-full bg-[#e5dccb] px-4 py-3 flex justify-between items-center">
    <div class="text-gray-600 font-semibold">
        {{ $shopInfo->address }}
    </div>

    <a href="https://www.google.com/maps?q={{ urlencode($shopInfo->address) }}"
       target="_blank"
       class="bg-[#4a4a4a] text-white px-6 py-1 rounded font-bold shadow hover:bg-[#333] transition">
        Google map
    </a>
</div>

            <!-- 地図領域（添付画像風の枠） -->
            <div class="w-full rounded-lg overflow-hidden border border-yellow-500">

                {{-- カスタム地図画像を使う場合 --}}
                {{-- <img src="/assets/imgs/custom_map.png" class="w-full h-auto" /> --}}

                {{-- Google Maps iframe（埋め込み） --}}
                <iframe src="https://www.google.com/maps?q={{ urlencode($shopInfo->address) }}&z=17&output=embed"
                    class="w-full" height="350" style="border:0;" allowfullscreen loading="lazy">
                </iframe>
            </div>

        </div>

                    <!-- タイトル -->
<!-- OFFICIAL SNS タイトル -->
<div class="w-full bg-gradient-to-r from-[#ecd9a3] via-[#e6c98b] to-[#ecd9a3] mt-12">
    <div class="px-4 py-3">
        <h2 class="text-white text-2xl font-serif tracking-widest">
            OFFICIAL SNS
        </h2>
    </div>
</div>

        <div class="border-t border-yellow-500 my-2"></div>
        <div class="w-full py-8 flex justify-center items-center gap-12 bg-blacks mt-10">
            <a href="https://facebook.com/yourpage" target="_blank" class="hover:scale-110 transition">
                <img src="/images/facebook.svg" alt="Facebook" class="w-10 h-10" />
            </a>
            <a href="https://instagram.com/yourpage" target="_blank" class="hover:scale-110 transition">
                <img src="/images/instagram.svg" alt="Instagram" class="w-10 h-10" />
            </a>
            <a href="https://www.tiktok.com/@yourpage" target="_blank" class="hover:scale-110 transition">
                <img src="/images/tiktok.svg" alt="TikTok" class="w-10 h-10" />
            </a>
        </div>
    </div>
</x-app-layout>
