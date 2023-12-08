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
                <h2 class="font-semibold text-xl">LARAVEL TASK 9: STUDENTS API CONTROL APPLICATION</h2>
            </div>
        </div>
    </div>
    <?php
    ?>
    <div class="container flex flex-row" style="margin:0 auto; padding: 10px 40px;">
        <div class="left-side" style="width:45%; height: 485px">
            <div style="width:100%; height: 485px;overflow-y:scroll;">
                <table class="border-collapse border border-slate-400 ..." style="width:100%;">
                    <thead>
                    <tr>
                        <th class="border border-slate-300 ...">Student Id</th>
                        <th class="border border-slate-300 ...">Sudent Name</th>
                        <th class="border border-slate-300 ...">Group</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($dbData as $data)
                        <tr>
                            <td class="border border-slate-300 text-center">{{$data->id}}</td>
                            <td class="border border-slate-300 text-left">{{$data->first_name}} {{$data->last_name}}</td>
                            <td class="border border-slate-300 text-center">{{$data->group_name}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                @if(isset($message))
                    @if(str_contains($message,'wrong'))
                        <p class="text-left pt-3  pb-4 text-rose-600">{{$message}}</p>
                    @else
                        <p class="text-left pt-3  pb-4 text-blue-700">{{$message}}</p>
                    @endif

                @endif
            </div>
        </div>

        <div class="right-side px-10" style="width:45%; height: auto">

            <div class="container">
                <div class="relative right-0">
                    <ul
                            class="relative flex flex-wrap p-1 list-none bg-blue-gray-50/60 border border-solid border-b-black text-grey-500 font-bold"
                            style="border-left: unset;border-right: unset;border-top: unset"
                            data-tabs="tabs"
                            role="list"
                    >
                        <li class="z-30 flex-auto text-center">
                            <a
                                    class="z-30 flex items-center justify-left w-full px-0 py-1 mb-0
                                    border-0 cursor-pointer text-grey-500 bg-inherit hover:text-blue-700"
                                    data-tab-target=""
                                    active=""
                                    role="tab"
                                    aria-selected="true"
                                    aria-controls="app"
                            >
                                <span class="ml-1">Students</span>
                            </a>
                        </li>
                        <li class="z-30 flex-auto text-center">
                            <a
                                    class="z-30 flex items-center justify-left w-full px-0 py-1 mb-0
                                    border-0  cursor-pointer text-grey-500 bg-inherit hover:text-blue-700"
                                    data-tab-target=""
                                    role="tab"
                                    aria-selected="false"
                                    aria-controls="message"
                            >
                                <span class="ml-1">Groups</span>
                            </a>
                        </li>

                    </ul>
                    <div data-tab-content="" class="p-5">
                        <div class="block opacity-100" id="app" role="tabpanel">
                            @include('studentsForms')
                        </div>
                        <div class="hidden opacity-0" id="message" role="tabpanel">
                            <p class="block font-sans text-base antialiased font-light leading-relaxed text-inherit text-blue-gray-500">
                                Groups
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://unpkg.com/@material-tailwind/html@latest/scripts/tabs.js"></script>

</body>
</html>