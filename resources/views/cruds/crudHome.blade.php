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
                <h2 class="font-semibold text-xl">LARAVEL TASK 9: STUDENTS WEB APPLICATION</h2>
            </div>
        </div>
    </div>
    <?php
    ?>
    <div class="container flex flex-row" style="margin:0 auto; padding: 10px 40px;">
        <div class="left-side" style="width:45%; height: 485px">
            <h3 class="border border-solid border-bottom-2 border-current text-center mb-5">FULL STUDENTS LIST</h3>
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
                            @if($data->group_name === 'free')
                                <td class="border border-slate-300 text-center"
                                    style="color:cadetblue;">{{$data->group_name}}</td>
                            @else
                                <td class="border border-slate-300 text-center">{{$data->group_name}}</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="right-side px-10" style="width:45%; height: auto">
            <h3 class="border border-solid border-bottom-2 border-current text-center mb-5"> POSSIBLE CRUD
                FUNCTIONS</h3>
            <ul>
                <li>
                    <a href="/web/students/groups" class="text-blue-500 hover:underline">Get students by group name</a>
                </li>
                <li>
                    <a href="/web/students/create" class="text-blue-500 hover:underline">Create new student</a>
                </li>
                <li>
                    <a href="/web/students/destroy" class="text-blue-500 hover:underline">Remove student by Id</a>
                </li>
                <li>
                    <a href="/web/students/groups/transfer" class="text-blue-500 hover:underline">Transfer student from
                        one group to another</a>
                </li>
                <li>
                    <a href="/web/students/groups/remove" class="text-blue-500 hover:underline">Remove student from the
                        group</a>
                </li>
                <li>
                    <a href="/web/students/courses/add" class="text-blue-500 hover:underline">Add student to the new
                        course</a>
                </li>
                <li>
                    <a href="/web/students/courses/transfer" class="text-blue-500 hover:underline">Transfer student from
                        one course to another</a>
                </li>
                <li>
                    <a href="/web/students/courses/remove" class="text-blue-500 hover:underline">Remove student from the
                        course</a>
                </li>
            </ul>
        </div>
    </div>
</div>

</body>
</html>