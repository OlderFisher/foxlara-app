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
        <div class="left-side " style="width:45%; height: 485px; overflow-y:scroll;">
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
        <div class="right-side px-10" style="width:45%; height: auto">
            {{--            Request Form to get full students list --}}
            <form id="list-form" class="dialog-form border border-solid rounded px-10 py-5 mb-2 text-center"
                  method="GET"
                  action="/crudapp/students">
                <div class="flex flex-grow-1 items-center justify-between">
                    <p class="text-left pb-5">Get full students list </p>
                    @csrf
                    <input type="submit"
                           class="btn btn-success border border-info rounded bg-dark px-5 py-2 bg-sky-800 text-white"
                           value="Submit">
                </div>
            </form>
            {{--            --}}
            {{--            Request Form to get the students list for choosen group name--}}
            <form id="group-form" class="dialog-form border border-solid rounded px-10 py-5 text-center" method="GET"
                  action="/crudapp/students">
                @csrf
                <p class="text-left pb-5">Get list of students by group name </p>
                <div class="flex flex-grow-1 items-center justify-between">
                    <label for="group_name">Select a Group name &nbsp;</label>
                    <?php
                    $groupsList = \App\Models\Groups::all();
                    ?>
                    <select id="group_name" name="group_name" class="px-2 py-1 border border-info border-solid">
                        @foreach($groupsList as $group)
                            <option value={{$group->group_name}}>{{$group->group_name}}</option>
                        @endforeach
                    </select>

                    <input type="submit"
                           class="btn btn-success border border-info rounded bg-dark px-5 py-2 bg-sky-800 text-white"
                           value="Submit">
                </div>
            </form>
            {{--            --}}
            {{--            Request Form to create new student --}}
            <form action="/crudapp/students/store" method='POST'
                  id="create-form" class="dialog-form border border-solid rounded px-10 py-5 text-center"
            >
                @csrf
                <p class="text-left pb-5">Create new student</p>
                @if(isset($message))
                    <p class="text-left pb-4 text-sky-800">{{$message}}</p>
                @endif

                <div class="flex flex-grow-1 items-center justify-between">
                    <label for="first_name" class="w-2/5 text-left">First name &nbsp;</label>
                    <input type="text" id="first_name" name="first_name"
                           class="border border-info border-solid py-1 px-3 mb-2 w-3/5"
                    >
                </div>
                <div class="flex flex-grow-1 items-center justify-between">
                    <label for="lastt_name" class="w-2/5 text-left">Last name &nbsp;</label>
                    <input type="text" id="last_name" name="last_name"
                           class="border border-info border-solid py-1 px-3 mb-2 w-3/5"
                    >
                </div>
                <div class="flex flex-grow-1 items-center justify-between">
                    <label for="group_name">Select a Group name &nbsp;</label>
                    <?php
                    $groupsList = \App\Models\Groups::all();
                    ?>
                    <select id="group_name" name="group_name" class="px-2 py-1 border border-info border-solid">
                        @foreach($groupsList as $group)
                            <option value={{$group->group_name}}>{{$group->group_name}}</option>
                        @endforeach
                    </select>

                    <input type="submit"
                           class="btn btn-success border border-info rounded bg-dark px-5 py-2 bg-sky-800 text-white"
                           value="Create student">
                </div>
            </form>
            {{--            --}}
            {{--            Request Form to delete student by id--}}
            <form action='/crudapp/students/destroy' method='POST'
                  id="delete-form" class="dialog-form border border-solid rounded px-10 py-5 text-center"
            >
                @csrf
                <p class="text-left pb-5">Delete student by ID</p>
                @if(isset($message))
                    <p class="text-left pb-4 text-sky-800">{{$message}}</p>
                @endif

                <div class="flex flex-grow-1 items-center justify-between">
                    <label for="student_id" class=" text-left">Student ID &nbsp;</label>
                    <input type="number" id="student_id" name="student_id" min="1"
                           class="border border-info border-solid py-1 px-3 mb-2"
                    >
                    <input type="submit"
                           class="btn btn-success border border-info rounded bg-dark px-5 py-2 bg-sky-800 text-white"
                           value="Delete student">
                </div>
            </form>
            {{--            --}}
        </div>
    </div>
</div>

</body>
</html>