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
    <div class="p-4 lg:p-8" style="width:45%">
        <div class="text-left">
            <div>
                <h2 class="font-semibold text-xl">REMOVE STUDENT FROM THE CURRENT COURSE</h2>
                <p>Enter student ID and course in the form below</p>
                <br>


                <form method='POST'
                      id="create-form" class="dialog-form border border-solid rounded px-10 py-5 text-center"
                >
                    @csrf
                    <p class="text-left pb-5">Remove student from the course</p>

                    <div class="flex flex-grow-1 items-center justify-between">
                        <label for="studentId" class="w-2/5 text-left">Student ID &nbsp;</label>
                        <input type="text" id="studentId" name="studentId"
                               class="border border-info border-solid py-1 px-3 mb-2 w-3/5"
                        >
                    </div>
                    <div class="flex flex-grow-1 items-center justify-between">
                        <label for="courseId">Select a Course name &nbsp;</label>
                        <?php
                        $coursesList = DB::table('courses')->orderBy('course_name')->get();
                        ?>
                        <select id="courseId" name="courseId" class="px-2 py-1 border border-info border-solid">
                            @foreach($coursesList as $course)
                                <option value={{$course->id}}>{{$course->course_name}}</option>
                            @endforeach
                        </select>

                        <input type="submit"
                               class="btn cursor-pointer btn-success border border-info rounded bg-dark px-5 py-2 bg-sky-800 text-white"
                               value="Remove">
                    </div>
                </form>

            </div>
        </div>
    </div>
    <?php
    ?>
    <div class="container flex flex-row " style="margin:0 auto 40px; padding: 10px 40px 40px 40px;">
        <div class="left-side" style="width:60%; height: 485px">
            <h3 class="border border-solid border-bottom-2 border-current text-center mb-5">STUDENTS LIST</h3>
            <div style="width:100%; height: 485px;overflow-y:scroll;">
                <table class="border-collapse border border-slate-400 ..." style="width:100%;">
                    <thead>
                    <tr>
                        <th class="border border-slate-300 ...">Student Id</th>
                        <th class="border border-slate-300 ...">Sudent Name</th>
                        <th class="border border-slate-300 ...">Group</th>
                        <th class="border border-slate-300 ...">Courses</th>
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
                            <td class="border border-slate-300 text-center">{{getStudentCourses($data->id)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="right-side px-10" style="width:30%; height: auto">
            <a href="/web/students" class="text-blue-500 hover:underline">Go to web CRUD page</a>
        </div>
    </div>
</div>

</body>
</html>

<?php
function getStudentCourses(int $studentId): string {
    $sqlCourses = DB::table('courses')->get();
    $courses = [];
    foreach ($sqlCourses as $course) {
        $courses[$course->id] = $course->course_name;
    }
    $sqlStudentCourses = DB::table('students_courses')->where('student_id', $studentId)->get('course_id');
    $coursesForStudent = [];
    foreach ($sqlStudentCourses as $course) {
        $coursesForStudent[] = $courses[$course->course_id];
    }
    return implode(',', $coursesForStudent);
}
