<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesStudentsSeeder extends Seeder
{
    private array $studentIds;
    private array $courseIds;
    private array $coursesStudents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->setCoursesStudents();

        foreach ($this->coursesStudents as $item) {
            DB::table('courses_students')->insert([
                'student_id' => $item['student_id'],
                'course_id' => $item['course_id'],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }

    private function getStudentIds(): void
    {
        $students = DB::select('select id from students');
        $this->studentIds = [];
        foreach ($students as $student) {
            $this->studentIds[] = $student->id;
        }
    }

    private function getCourseIds(): void
    {
        $courses = DB::select('select id from courses');
        $this->courseIds = [];
        foreach ($courses as $course) {
            $this->courseIds[] = $course->id;
        }
    }

    private function setCoursesStudents(): void
    {
        $this->getStudentIds();
        $this->getCourseIds();

        $this->coursesStudents = [];

        foreach ($this->studentIds as $studentId) {
            $coursesValue = rand(1, 3);

            $randomCoursesForCurrentStudent = [];

            $courses = 0;
            while ($courses < $coursesValue) {
                $randomId = $this->courseIds[rand(0, count($this->courseIds) - 1)];
                if (!in_array($randomId, $randomCoursesForCurrentStudent)) {
                    $randomCoursesForCurrentStudent[] = $randomId;
                    $courses++;
                }
            }

            for ($i = 0; $i < count($randomCoursesForCurrentStudent); $i++) {
                $this->coursesStudents[] = [
                    'student_id' => $studentId,
                    'course_id' => $randomCoursesForCurrentStudent[$i]
                ];
            }
            unset($randomCoursesForCurrentStudent);
        }
    }
}
