<?php

declare(strict_types=1);

namespace App\CustomClasses;

use Illuminate\Support\Facades\DB;

final class StudentsWebManager
{
    public static function getAllStudents(): array
    {
        $students = DB::table('students')
                      ->leftJoin('groups', 'students.group_id', '=', 'groups.id')
                      ->select('students.id', 'students.first_name', 'students.last_name', 'groups.group_name')
                      ->orderBy('students.id')
                      ->get();

        return $students->toArray();
    }

    public static function getAllStudentsByGroupName(string|null $groupName): array
    {
        if ( ! $groupName) {
            return self::getAllStudents();
        }
        $groupId  = self::getGroupIdByName($groupName);
        $students = DB::table('students')->
        leftJoin('groups', 'students.group_id', '=', 'groups.id')->
        where('students.group_id', $groupId)->
        select(
            'students.id',
            'students.first_name',
            'students.last_name',
            'students.group_id',
            'groups.group_name'
        )->orderBy('students.id')->get();

        return $students->toArray();
    }

    public static function createNewStudent(array $studentData): array
    {
        if ( ! empty($studentData)) {
            $firstName = $studentData['first_name'];
            $lastName  = $studentData['last_name'];
            $groupId   = (int)$studentData['group_id'];
            $groupName = self::getGroupNameById($groupId);
            DB::table('students')
              ->insert([
                  'first_name' => $firstName,
                  'last_name'  => $lastName,
                  'group_id'   => $groupId,
                  'created_at' => date("Y-m-d H:i:s"),
                  'updated_at' => date("Y-m-d H:i:s"),
              ]);
            $studentsList = self::getAllStudentsByGroupName($groupName);
        } else {
            $studentsList = self::getAllStudents();
        }

        return $studentsList;
    }

    public static function deleteStudentById(int|null $studentId): array
    {
        if ( ! $studentId) {
            return self::getAllStudents();
        }
        DB::table('students')->delete($studentId);

        return self::getAllStudents();
    }

    public static function transferStudentByIdToGroupId(int|null $studentId, int|null $groupId): array
    {
        if (is_null($studentId) || is_null($groupId)) {
            return self::getAllStudents();
        }
        DB::table('students')
          ->where('id', $studentId)
          ->update(['group_id' => $groupId]);
        $groupName = self::getGroupNameById($groupId);

        return self::getAllStudentsByGroupName($groupName);
    }

    public static function removeStudentByIdFromGroup(int|null $studentId): array
    {
        if (is_null($studentId)) {
            return self::getAllStudents();
        }
        $freeGroupId = self::getGroupIdByName('free');
        DB::table('students')
          ->where('id', $studentId)
          ->update(['group_id' => $freeGroupId]);

        return self::getAllStudentsByGroupName('free');
    }

    public static function addStudentByIdToCourse(int|null $studentId, int|null $courseId): array
    {
        if (is_null($studentId) || is_null($courseId)) {
            return self::getAllStudents();
        }
        $sql   = DB::table('students_courses')
                   ->where('student_id', $studentId)
                   ->where('course_id', $courseId)
                   ->get('id');
        $count = $sql->toArray();
        if (empty($count)) {
            DB::table('students_courses')
              ->insert([
                  'student_id' => $studentId,
                  'course_id'  => $courseId
              ]);
        }

        return self::getAllStudents();
    }

    public static function transferStudentByIdFromCourseToCourse(
        int|null $studentId,
        int|null $courseIdFrom,
        int|null $courseIdTo
    ): array {
        if (is_null($studentId) || is_null($courseIdFrom) || is_null($courseIdTo)) {
            return self::getAllStudents();
        }
        $sql = DB::table('students_courses')
                 ->where('student_id', $studentId)
                 ->where('course_id', $courseIdFrom)
                 ->get('id');

        DB::table('students_courses')
          ->where('id', $sql[0]->id)
          ->update(['course_id' => $courseIdTo]);

        return self::getAllStudents();
    }

    public static function removeStudentByIdFromCourse(
        int|null $studentId,
        int|null $courseId,
    ): array {
        if (is_null($studentId) || is_null($courseId)) {
            return self::getAllStudents();
        }
        $sql = DB::table('students_courses')
                 ->where('student_id', $studentId)
                 ->where('course_id', $courseId)
                 ->get('id');

        DB::table('students_courses')->where('id', $sql[0]->id)->delete();

        return self::getAllStudents();
    }

// -----------
    private static function getGroupNameById(int $groupId): string
    {
        $groupName = DB::table('groups')->where('id', $groupId)->get('group_name');

        return $groupName[0]->group_name;
    }

    private static function getGroupIdByName(string $groupName): int
    {
        $groupId = DB::table('groups')->where('group_name', $groupName)->get('id');

        return $groupId[0]->id;
    }

}