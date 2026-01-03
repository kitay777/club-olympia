<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen
             bg-[url('/assets/imgs/bg_pattern.png')]
             bg-repeat
             font-sans text-gray-700">

    <!-- 画面全体の中央寄せラッパー -->
    <div class="min-h-screen flex flex-col items-center" style="background:url('/assets/imgs/back.png') repeat top center;">

        <!-- ページ固有コンテンツ -->
        <div class="w-full">
            {{ $slot }}
        </div>

    </div>

</body>
</html>
