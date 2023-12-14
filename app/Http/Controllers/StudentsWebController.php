<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentsWebController extends Controller
{
    public function index(): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $students = DB::table('students')->
        leftJoin('groups', 'students.group_id', '=', 'groups.id')->
        select('students.id', 'students.first_name', 'students.last_name', 'groups.group_name')->
        orderBy('students.id')->
        get();
        $studentsList = $students->toArray();
        return view('cruds.crudHome', ['dbData' => $studentsList]);
    }

    public function show(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $groupName = $request->get('groupName');
        $studentsList = $this->getStudentsList($groupName);
        return view('cruds.crudStudentsGroups', ['dbData' => $studentsList]);
    }

    public function create(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $allData = $request->all();
        if (!empty($allData)) {
            $firstName = $allData['first_name'];
            $lastName = $allData['last_name'];
            $groupId = $allData['group_id'];
            $groupName = $this->getGroupNameById($groupId);

            $count = DB::table('students')->insert([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'group_id' => $groupId,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
            $studentsList = $this->getStudentsList($groupName);
        } else {
            $studentsList = $this->getStudentsList();
        }
        return view('cruds.crudStudentsCreate', ['dbData' => $studentsList]);
    }

    public function destroy(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $allData = $request->all();
        if (!empty($allData)) {
            $id = (int)$allData['studentId'];
            DB::table('students')->delete($id);
        }
        $studentsList = $this->getStudentsList();
        return view('cruds.crudStudentsDestroy', ['dbData' => $studentsList]);
    }

    public function transfer(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $allData = $request->all();
        if (!empty($allData)) {
            $student_id = (int)$allData['studentId'];
            $group_id = $allData['groupId'];
            DB::table('students')->where('id', $student_id)->update(['group_id' => $group_id]);

            $groupName = $this->getGroupNameById($group_id);
            $studentsList = $this->getStudentsList($groupName);
        } else {
            $studentsList = $this->getStudentsList();
        }

        return view('cruds.crudStudentsGroupTransfer', ['dbData' => $studentsList]);
    }

    public function remove(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $allData = $request->all();

        if (!empty($allData)) {
            $student_id = $allData['studentId'];
            $groupName = 'free';
            $groupId = $this->getGroupIdByName($groupName);
            DB::table('students')->where('id', $student_id)->update(['group_id' => $groupId]);

            $studentsList = $this->getStudentsList($groupName);
        } else {
            $studentsList = $this->getStudentsList();
        }

        return view('cruds.crudStudentsGroupRemove', ['dbData' => $studentsList]);
    }

    private function getStudentsList(string $groupName = null): array
    {
        if ($groupName && strlen($groupName) >= 4) {
            $groupId = DB::table('groups')->where('group_name', $groupName)->get('id');
            $students = DB::table('students')->
            leftJoin('groups', 'students.group_id', '=', 'groups.id')->
            where('students.group_id', $groupId[0]->id)->
            select(
                'students.id',
                'students.first_name',
                'students.last_name',
                'students.group_id',
                'groups.group_name'
            )->orderBy('students.id')->get();
        } else {
            $students = DB::table('students')->
            leftJoin('groups', 'students.group_id', '=', 'groups.id')->
            select('students.id', 'students.first_name', 'students.last_name', 'groups.group_name')->
            orderBy('students.id')->
            get();
        }
        return $students->toArray();
    }

    private function getGroupNameById(int $groupId): string
    {
        $groupName = DB::table('groups')->where('id', $groupId)->get('group_name');
        return $groupName[0]->group_name;
    }

    private function getGroupIdByName(string $groupName): string
    {
        $groupId = DB::table('groups')->where('group_name', $groupName)->get('id');
        return $groupId[0]->id;
    }
}