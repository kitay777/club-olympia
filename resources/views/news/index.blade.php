<x-app-layout>

    <!-- 上部：NEWS 金帯 -->
    <div class="w-full bg-[#e6c98b]">
        <h2 class="text-center text-white text-2xl font-serif tracking-widest py-3">
            NEWS
        </h2>
    </div>

    <!-- NEWS 全体枠 -->
    <div class="bg-[#e5dccb] py-10">
        <div class="max-w-3xl mx-auto space-y-12">

            @foreach ($news as $n)
                @php
                    $isNew = $n->published_at >= now()->subDays(3);
                @endphp

                <!-- 1件 -->
                <div>

                    <!-- サムネ枠 -->
                    <div class="bg-white w-full mb-4" style="aspect-ratio:16/9;">
                        @if ($n->image_path)
                            <img src="{{ asset('storage/' . $n->image_path) }}"
                                 class="w-full h-full object-cover">
                        @endif
                    </div>

                    <!-- タイトル行 -->
                    <div class="flex justify-between items-center px-1 mb-2">

                        <div class="flex items-center gap-3 text-lg font-bold">
                            @if ($isNew)
                                <span class="text-red-600">New</span>
                            @else
                                <span class="text-black">▶</span>
                            @endif

                            <span>{{ $n->title }}</span>
                        </div>

                        <span class="text-sm text-gray-700">
                            {{ $n->published_at->format('Y/m/d') }}
                        </span>
                    </div>

                    <!-- 内容 -->
                    <div class="text-center text-gray-600 mb-6">
                        {{ \Illuminate\Support\Str::limit($n->body, 80, '…') }}
                    </div>

                    <!-- 区切り線 -->
                    <div class="border-t border-black"></div>

                </div>
            @endforeach

        </div>
    </div>

</x-app-layout>
