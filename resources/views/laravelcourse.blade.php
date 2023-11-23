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
    <div class="p-4 lg:p-8">
        <h3 class="font-semibold">TASK 6 : Web report of Monaco 2018 Racing</h3>
        <hr>
        <p class="flex">Common Monaco Race statistics
            <a href="/report" class="">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/>
                </svg>
            </a>
        </p>
        <p class="flex">Common Pilots statistics.
            <a href="/drivers" class="">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/>
                </svg>
            </a>
            <span><i>Add list order view  by <span style="color:blue">../drivers/?order=asc|desc</span>. </i></span>
            <span><i>To see single driver info add to link.  <span
                            style="color:blue">../drivers/?driver_id=SVF</span></i></span>
        </p>
    </div>

    <div class="p-4 lg:p-8">
        <h3 class="font-semibold">TASK 7 : Create API endpoint to get Monaco 2018 Racing Report data</h3>
        <hr>
        <p class="flex">Monaco Racing Report data in JSON format
            <a href="/api/v1/report/?format=json" class="" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/>
                </svg>
            </a>
        </p>
        <p class="flex">Monaco Racing Report data in XML format.
            <a href="/api/v1/report/?format=xml" class="" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/>
                </svg>
            </a>
        </p>
    </div>

    <div class="p-4 lg:p-8">
        <h3 class="font-semibold">TASK 8 : Convert Monaco Race Report data and store to the database</h3>
        <hr>
        <p class="flex">Database Structure ( Scheme Drawing. Tables structure and content)
            <a href="/dbstructure" class="" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/>
                </svg>
            </a>
        </p>
        <p class="flex">Monaco Racing Report on DataBase data.
            <a href="/dbreport" class="" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/>
                </svg>
            </a>
        </p>
    </div>

</div>
</body>
</html>

