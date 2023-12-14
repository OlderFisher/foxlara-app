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
                <h2 class="font-semibold text-xl">FILTER STUDENTS LIST BY GROUP NAME</h2>
                <p>You can add query parameter to url with the group name. For ex.
                    localhost:5000/web/students?groupName=CV-17</p>
                <br>


                <form method="get" class="flex justify-start items-center">
                    <?php
                    $groupsList = \App\Models\Groups::all();
                    ?>
                    <p class="pr-2">Or choose group name from the select</p>

                    <select id="groupName" name="groupName" class="px-5 mx-3 py-1 border border-info border-solid">
                        @foreach($groupsList as $group)
                            <option value={{$group->group_name}}>{{$group->group_name}}</option>
                        @endforeach
                    </select>

                    <input type="submit"
                           class="btn cursor-pointer btn-success border border-info rounded bg-dark px-5 py-1 bg-sky-800 text-white"
                           value="Submit">
                </form>

            </div>
        </div>
    </div>
    <?php
    ?>
    <div class="container flex flex-row " style="margin:0 auto 40px; padding: 10px 40px 40px 40px;">
        <div class="left-side" style="width:45%; height: 485px">
            <h3 class="border border-solid border-bottom-2 border-current text-center mb-5">STUDENTS LIST</h3>
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
            <a href="/web/students" class="text-blue-500 hover:underline">Go to web CRUD page</a>
        </div>
    </div>
</div>

</body>
</html>