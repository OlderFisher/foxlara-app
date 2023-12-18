<?php

namespace App\Http\Controllers;

use App\CustomClasses\StudentsWebManager;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class StudentsWebController extends Controller
{
    public function index(): Application|Factory|View|\Illuminate\Foundation\Application
    {
        return view(
            'cruds.crudHome',
            [
                'dbData' => StudentsWebManager::getAllStudents()
            ]
        );
    }

    public function show(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $groupName = $request->get('groupName');

        return view(
            'cruds.crudStudentsGroups',
            [
                'dbData' => StudentsWebManager::getAllStudentsByGroupName($groupName)
            ]
        );
    }

    public function create(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $allData = $request->all();

        return view(
            'cruds.crudStudentsCreate',
            [
                'dbData' => StudentsWebManager::createNewStudent($allData)
            ]
        );
    }

    public function destroy(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $allData = $request->all();

        if ( ! empty($allData) && isset($allData['studentId'])) {
            $id = (int)$allData['studentId'];
        } else {
            $id = null;
        }

        return view(
            'cruds.crudStudentsDestroy',
            [
                'dbData' => StudentsWebManager::deleteStudentById($id)
            ]
        );
    }

    public function groupTransfer(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $student_id = null;
        $group_id   = null;
        $allData    = $request->all();
        if ( ! empty($allData)) {
            $student_id = (int)$allData['studentId'];
            $group_id   = $allData['groupId'];
        }

        return view(
            'cruds.crudStudentsGroupTransfer',
            [
                'dbData' => StudentsWebManager::transferStudentByIdToGroupId($student_id, $group_id)
            ]
        );
    }

    public function groupRemove(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $studentId = null;
        $allData   = $request->all();
        if ( ! empty($allData)) {
            $studentId = $allData['studentId'];
        }

        return view(
            'cruds.crudStudentsGroupRemove',
            [
                'dbData' => StudentsWebManager::removeStudentByIdFromGroup($studentId)
            ]
        );
    }

    public function courseAdding(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $studentId = null;
        $courseId  = null;
        $allData   = $request->all();
        if ( ! empty($allData)) {
            $studentId = (int)$allData['studentId'];
            $courseId  = (int)$allData['courseId'];
        }


        return view(
            'cruds.crudStudentsCourseAdding',
            [
                'dbData' => StudentsWebManager::addStudentByIdToCourse($studentId, $courseId)
            ]
        );
    }

    public function courseTransfer(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $student_id   = null;
        $courseFromId = null;
        $courseToId   = null;
        $allData      = $request->all();
        if ( ! empty($allData)) {
            $student_id   = (int)$allData['studentId'];
            $courseFromId = $allData['courseIdFrom'];
            $courseToId   = $allData['courseIdTo'];
        }

        return view(
            'cruds.crudStudentsCourseTransfer',
            [
                'dbData' => StudentsWebManager::transferStudentByIdFromCourseToCourse(
                    $student_id,
                    $courseFromId,
                    $courseToId
                )
            ]
        );
    }

    public function courseRemove(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $studentId = null;
        $courseId  = null;
        $allData   = $request->all();
        if ( ! empty($allData)) {
            $studentId = $allData['studentId'];
            $courseId  = $allData['courseId'];
        }

        return view(
            'cruds.crudStudentsCourseRemove',
            [
                'dbData' => StudentsWebManager::removeStudentByIdFromCourse($studentId, $courseId)
            ]
        );
    }
}