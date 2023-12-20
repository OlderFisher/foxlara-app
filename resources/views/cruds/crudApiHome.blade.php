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
                <h2 class="font-semibold text-xl">LARAVEL TASK 9: STUDENTS API APPLICATION</h2>
            </div>
        </div>
    </div>
    <?php
    ?>
    <div class="container flex flex-row" style="margin:0 auto; padding: 10px 40px;">
        <div class="right-side px-10" style="width:45%; height: auto">
            <h3 class="border border-solid border-bottom-2 border-current text-center mb-5"> API FUNCTIONS</h3>
            <div class="api-div mb-2">
                <p>API Request Get All Students.</p>
                <p> API GET route <span class="text-blue-500">localhost:5000/api/v1/students</span></p>
                <p>Response : {{\App\CustomClasses\StudentsApiManager::getApiStudentsList()}}</p>
            </div>
            <div class="api-div mb-2">
                <p>API Request Get Students list by GroupName.</p>
                <p>API GET route <span class="text-blue-500">localhost:5000/api/v1/students?groupName=QK-21</span></p>
                <p>Response : {{\App\CustomClasses\StudentsApiManager::getApiStudentsListByGroupName('QK-21')}}</p>
            </div>
            <div class="api-div mb-2">
                <p>API Request Create New Student.</p>
                <p>API POST route <span class="text-blue-500">localhost:5000/api/v1/students</span></p>
                <?php
                $studentData = [
                    'first_name' => 'Alex',
                    'last_name'  => 'Baldwin',
                    'group_name' => 'QK-21'
                ]
                ?>
                <p>Response : {{\App\CustomClasses\StudentsApiManager::createNewStudent($studentData)}}</p>
            </div>
            <div class="api-div mb-2">
                <p>API Request Delete Student By Id.</p>
                <p>API POST route <span class="text-blue-500">localhost:5000/api/v1/students/{studentId}</span></p>
                <p>Response : {{\App\CustomClasses\StudentsApiManager::deleteStudentById(204)}}</p>
            </div>


        </div>
    </div>
</div>

</body>
</html>



