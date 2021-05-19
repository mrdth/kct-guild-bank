<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Karazhan Chess Team Guild Bank</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script>const whTooltips = {colorLinks: true, iconizeLinks: true, iconSize: 'medium'};</script>
    <script src="https://wow.zamimg.com/widgets/power.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="h-screen bg-gradient-to-b from-red-700 to-pink-900 flex flex-col">
<header class="font-sans text-gray-200 antialiased mx-auto p-10 bg-gray-800 w-full flex-none text-center md:text-left">
    Karazhan Chess Team Guild Bank
</header>
<div class="flex-grow">
    <div class="flex flex-col justify-center items-center pt-12 px-4">
        <div class="w-full md:w-1/2 text-gray-200 antialiased mx-auto p-10 bg-gray-800 w-full flex-none rounded-2xl shadow-lg">
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
