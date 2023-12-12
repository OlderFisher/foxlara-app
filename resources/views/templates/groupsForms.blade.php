<?php

declare(strict_types=1);
?>
<form action="/crudapp/groups/students/update" method='POST'
      id="create-form" class="dialog-form border border-solid rounded px-10 py-5 text-center"
>
    @csrf
    <p class="text-left pb-5">Transfer student to another group</p>

    <div class="flex flex-grow-1 items-center justify-between">
        <label for="studentId" class="w-2/5 text-left">Student ID &nbsp;</label>
        <input type="text" id="studentId" name="studentId"
               class="border border-info border-solid py-1 px-3 mb-2 w-3/5"
        >
    </div>
    <div class="flex flex-grow-1 items-center justify-between">
        <label for="groupId">Select a Group name &nbsp;</label>
        <?php
        $groupsList = \App\Models\Groups::all();
        ?>
        <select id="group_name" name="groupId" class="px-2 py-1 border border-info border-solid">
            @foreach($groupsList as $group)
                <option value={{$group->id}}>{{$group->group_name}}</option>
            @endforeach
        </select>

        <input type="submit"
               class="btn cursor-pointer btn-success border border-info rounded bg-dark px-5 py-2 bg-sky-800 text-white"
               value="Change Group">
    </div>
</form>

<form action="/crudapp/groups/students/remove" method='POST'
      id="create-form" class="dialog-form border border-solid rounded px-10 py-5 text-center"
>
    @csrf
    <p class="text-left pb-5">Remove student from the current group</p>

    <div class="flex flex-grow-1 items-center justify-between">
        <label for="studentId" class="w-1/5 text-left">Student ID &nbsp;</label>
        <input type="text" id="studentId" name="studentId"
               class="border border-info border-solid py-1 px-3 mb-2 w-2/5"
        >
        <input type="submit"
               class="btn cursor-pointer btn-success border border-info rounded bg-dark px-5 py-2 bg-sky-800 text-white"
               value="Remove">
    </div>
</form>
