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
                <h2 class="font-semibold text-xl">MONACO RACE DATA REPORT</h2>
            </div>
        </div>
    </div>
    <div class="p-4 lg:p-8">
        <table>
            <thead>
            <tr>
                <td style="padding: 10px 15px; border-bottom:1px solid black">#</td>
                <td style="padding: 10px 15px; border-bottom:1px solid black">Pilot Name</td>
                <td style="padding: 10px 15px; border-bottom:1px solid black">Pilot Team</td>
                <td style="padding: 10px 15px; border-bottom:1px solid black">Race Time</td>
            </tr>
            </thead>
            <tbody>
            {{--   Top race pilots mapping--}}
            <?php
            $index = 1 ?>
            @foreach ($topPilots as $key => $value)
                <tr>
                    <td style="padding: 10px 15px">{{ $index }}</td>
                    <td style="padding: 10px 15px">{{ $value['pilot_name'] }} &nbsp ({{ $key }})</td>
                    <td style="padding: 10px 15px">{{ $value['pilot_team'] }}</td>
                    <td style="padding: 10px 15px">{{ $value['race_time'] }}</td>
                </tr>
                    <?php
                    $index++; ?>
            @endforeach
            <tr>
                <td style="padding: 10px 15px; border-bottom:1px dashed black" colspan="4"></td>
            </tr>

            {{--   Slow pilots mapping--}}
            @foreach ($slowPilots as $key => $value)
                <tr>
                    <td style="padding: 10px 15px">{{ $index }}</td>
                    <td style="padding: 10px 15px">{{ $value['pilot_name'] }} &nbsp ({{ $key }})</td>
                    <td style="padding: 10px 15px">{{ $value['pilot_team'] }} </td>
                    <td style="padding: 10px 15px">{{ $value['race_time']  }} </td>
                </tr>
                    <?php
                    $index++; ?>
            @endforeach
            </tbody>
        </table>

    </div>

</div>
</body>
</html>


