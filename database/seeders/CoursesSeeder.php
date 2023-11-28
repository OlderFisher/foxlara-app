<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesSeeder extends Seeder
{
    private array $courses = [
        'Digital' => 'Course about computer science',
        'Education' => 'Course how to teach students and schools',
        'Languages' => 'Any language you want to learn',
        'Biology' => 'Darvin theory of human',
        'Pharmacy' => 'How to made health care drugs',
        'Arts' => 'Course for designers and artists',
        'Nature' => 'Landscape design modern trends',
        'Media' => 'Course how to create best advertisement',
        'Physics' => 'Do you wanna be the new Opengaimer',
        'Society' => 'How to start to be a president'
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->courses as $key => $value) {
            DB::table('courses')->insert([
                'course_name' => $key,
                'course_description' => $value,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
