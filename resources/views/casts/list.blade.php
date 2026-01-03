<x-app-layout>
<x-slot name="header">
    <!-- 上部ステータスバー -->
    <div class="relative bg-white border-b border-[#e6c98b]">
        <div class="max-w-7xl mx-auto px-4 py-2 flex items-center justify-between">

            <!-- 左：ロゴ -->
            <div class="text-[#e6c98b] font-serif italic text-xl">
                club Olympia
            </div>

            <!-- 中央：ID / pt -->
            <div class="flex items-center gap-6 text-gray-700 font-semibold">
                <div>
                    <span class="text-sm text-gray-400">ID</span>
                    <span class="ml-1 text-lg">{{ $user->id ?? '123456' }}</span>
                </div>
                <div>
                    <span class="text-sm text-gray-400">pt</span>
                    <span class="ml-1 text-lg text-[#e6c98b]">{{ $user->point ?? 1000 }}</span>
                </div>
            </div>

            <!-- 右：MENU -->
            <button class="flex flex-col items-center text-gray-600">
                <span class="w-6 h-0.5 bg-gray-400 mb-1"></span>
                <span class="w-6 h-0.5 bg-gray-400 mb-1"></span>
                <span class="w-6 h-0.5 bg-gray-400"></span>
                <span class="text-xs mt-1">MENU</span>
            </button>

        </div>
    </div>

    <!-- CAST LIST 見出し（金色帯） -->
    <div class="bg-[#e6c98b]">
        <h2 class="text-center text-white text-2xl font-serif tracking-widest py-3">
            CAST LIST
        </h2>
    </div>
</x-slot>


    <div>
        @if($user->is_cast)
            <p class="text-green-600">あなたはキャストとして登録されています。</p>
            <div class="text-right mb-4">
                <a href="/mycast/edit" class="bg-blue-500 text-white px-4 py-2 rounded">自分のデータを編集</a>
            </div>
        @endif
    </div>
    
    <div class="w-full">
        <div class="grid grid-cols-4 gap-1">
            @foreach ($casts as $cast)
                <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col items-stretch">
                    <div class="relative w-full" style="aspect-ratio:1/1;">
                        <a href="{{ route('casts.show', $cast) }}" class="absolute inset-0">
                        @if($cast->image_path)
                            <img src="{{ asset('storage/' . $cast->image_path) }}"
                                 alt="キャスト画像"
                                 class="object-cover w-full h-full">
                        @else
                            <div class="w-full h-full bg-gray-300"></div>
                        @endif
                        <div class="absolute bottom-0 left-0 w-full bg-white/40 text-black text-center text-base font-bold py-2">
                            {{ $cast->name }}
                        </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
