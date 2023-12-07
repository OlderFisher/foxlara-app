<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Foxminded</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    <!-- Styles -->
    @vite('resources/css/app.css')
</head>
<body class="antialiased">
<header class="text-left p-6">
    <a href="/">
        <img src="{{ asset('foxmindedlogo.png') }}" width="150" height="auto" alt="foxminded logo">
    </a>
</header>
<hr/>
<div id="main" class="container">
    <div class="p-4 lg:p-8">
        <div class="text-left">
            <div>
                <h2 class="font-semibold text-xl">PHP COURSE - LARAVEL TASKS BOARD</h2>
            </div>
        </div>
    </div>

    @include('task6')
    @include('task7')
    @include('task8')
    @include('task9')

</div>
</body>
</html>

