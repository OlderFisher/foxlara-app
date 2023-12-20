<?php

declare(strict_types=1);

namespace App\CustomClasses;

use Illuminate\Support\Facades\DB;

final class StudentsManager
{

    public static function getAllStudentsByGroupName(string $groupName): array
    {
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

    public static function createNewStudent(array $studentData): void
    {
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
    }

    public static function deleteStudentById(int $studentId): void
    {
        DB::table('students')->delete($studentId);
    }

    public static function transferStudentByIdToGroupId(int $studentId, int $groupId): void
    {
        DB::table('students')
          ->where('id', $studentId)
          ->update(['group_id' => $groupId]);
    }

    public static function removeStudentByIdFromGroup(int $studentId): void
    {
        $freeGroupId = self::getGroupIdByName('free');
        DB::table('students')
          ->where('id', $studentId)
          ->update(['group_id' => $freeGroupId]);
    }

    public static function addStudentByIdToCourse(int $studentId, int $courseId): void
    {
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
    }

    public static function transferStudentByIdFromCourseToCourse(
        int $studentId,
        int $courseIdFrom,
        int $courseIdTo
    ): void {
        $sql = DB::table('students_courses')
                 ->where('student_id', $studentId)
                 ->where('course_id', $courseIdFrom)
                 ->get('id');

        DB::table('students_courses')
          ->where('id', $sql[0]->id)
          ->update(['course_id' => $courseIdTo]);
    }

    public static function removeStudentByIdFromCourse(
        int $studentId,
        int $courseId,
    ): void {
        $sql = DB::table('students_courses')
                 ->where('student_id', $studentId)
                 ->where('course_id', $courseId)
                 ->get('id');

        DB::table('students_courses')->where('id', $sql[0]->id)->delete();
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