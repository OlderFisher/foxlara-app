<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

?>
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
                <h2 class="font-semibold text-xl">STUDENTS AND COURSES APP DATABASE STRUCTURE</h2>
            </div>
        </div>
    </div>
    <div class="p-4 lg:p-8">
        <h3 class="font-semibold">DataBase structure drawing</h3>
        <hr>
        <img src="{{ asset('images/students_courses.png') }}" alt="database scheme" width="500px"
             height="auto">
    </div>

    <div class="p-4 lg:p-8">
        <?php
        $dbName = DB::getDatabaseName(); ?>
        <h3 class="font-semibold">DataBase name : {{$dbName}}</h3>
        <hr>
    </div>
    <div class="p-4 lg:p-8">
        <h3 class="font-semibold">DataBase Tables structure</h3>
        <hr>
        <?php
        $tables = DB::select("SELECT tablename FROM pg_catalog.pg_tables WHERE schemaname='public'");
        $pilots = DB::select("SELECT * FROM pilots");
        ?>
        <div class="p-4 lg:p-8">
            <table class="table-fixed border-collapse border border-slate-400">
                <thead>
                <tr>
                    <th class="border border-slate-300 w-200">Table</th>
                    <th class="border border-slate-300 w-200">Table Columns</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($tables as $table)
                    @if($table->tablename === 'migrations' ||
                        $table->tablename === 'personal_access_tokens' ||
                        $table->tablename === 'teams' ||
                        $table->tablename === 'pilots' ||
                        $table->tablename === 'results' ||
                        $table->tablename === 'races'
                    )
                        @php continue @endphp
                    @endif
                    <tr>
                        <td class="border border-slate-300 pl-10">{{$table->tablename}}</td>
                        @php  $columns = Schema::getColumnListing($table->tablename); @endphp
                        <td class="border border-slate-300 pl-5">
                            <ul>
                                @foreach($columns as $column)
                                    @if($column === 'created_at' || $column === 'updated_at')
                                        @php continue @endphp
                                    @endif
                                    <li>{{$column}}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>

</div>
</body>
</html>





