<?php

namespace App\Http\Controllers;

use App\CustomClasses\StudentsManager;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentsWebController extends Controller
{
    public function index(): Application|Factory|View|\Illuminate\Foundation\Application
    {
        return view(
            'cruds.crudHome',
            [
                'dbData' => $this->getAllStudents()
            ]
        );
    }

    public function show(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $groupName = $request->get('groupName');
        if ( ! $groupName) {
            $studentsList = $this->getAllStudents();
        } else {
            $studentsList = StudentsManager::getAllStudentsByGroupName($groupName);
        }

        return view('cruds.crudStudentsGroups', ['dbData' => $studentsList]);
    }

    public function create(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $allData = $request->all();
        if ( ! empty($allData)) {
            StudentsManager::createNewStudent($allData);
        }

        return view('cruds.crudStudentsCreate', ['dbData' => $this->getAllStudents()]);
    }

    public function destroy(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $allData = $request->all();

        if ( ! empty($allData) && isset($allData['studentId'])) {
            StudentsManager::deleteStudentById((int)$allData['studentId']);
        }

        return view('cruds.crudStudentsDestroy', ['dbData' => $this->getAllStudents()]);
    }

    public function groupTransfer(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $allData = $request->all();
        if ( ! empty($allData)) {
            StudentsManager::transferStudentByIdToGroupId(
                (int)$allData['studentId'],
                (int)$allData['groupId']
            );
        }

        return view('cruds.crudStudentsGroupTransfer', ['dbData' => $this->getAllStudents()]);
    }

    public function groupRemove(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $allData = $request->all();
        if ( ! empty($allData)) {
            StudentsManager::removeStudentByIdFromGroup((int)$allData['studentId']);
        }

        return view('cruds.crudStudentsGroupRemove', ['dbData' => $this->getAllStudents()]);
    }

    public function courseAdding(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $allData = $request->all();
        if ( ! empty($allData)) {
            StudentsManager::addStudentByIdToCourse(
                (int)$allData['studentId'],
                (int)$allData['courseId']
            );
        }

        return view('cruds.crudStudentsCourseAdding', ['dbData' => $this->getAllStudents()]);
    }

    public function courseTransfer(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $allData = $request->all();
        if ( ! empty($allData)) {
            StudentsManager::transferStudentByIdFromCourseToCourse(
                (int)$allData['studentId'],
                (int)$allData['courseIdFrom'],
                (int)$allData['courseIdTo']
            );
        }

        return view('cruds.crudStudentsCourseTransfer', ['dbData' => $this->getAllStudents()]);
    }

    public function courseRemove(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $allData = $request->all();
        if ( ! empty($allData)) {
            StudentsManager::removeStudentByIdFromCourse(
                (int)$allData['studentId'],
                (int)$allData['courseId']
            );
        }

        return view('cruds.crudStudentsCourseRemove', ['dbData' => $this->getAllStudents()]);
    }

    private function getAllStudents(): array
    {
        $students = DB::table('students')
                      ->leftJoin('groups', 'students.group_id', '=', 'groups.id')
                      ->select('students.id', 'students.first_name', 'students.last_name', 'groups.group_name')
                      ->orderBy('students.id')
                      ->get();

        return $students->toArray();
    }
}