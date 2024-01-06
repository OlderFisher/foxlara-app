<?php

namespace Database\Seeders;

use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentsSeeder extends Seeder
{
    private array $students;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->addFakeStudents();
        $this->addFakeGroups();

        foreach ($this->students as $student) {
            DB::table('students')->insert([
                'first_name' => $student['first_name'],
                'last_name'  => $student['last_name'],
                'group_id'   => $student['group_id'],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }

    private function addFakeStudents(): void
    {
        $faker          = app(Generator::class);
        $fakeFirstNames = [];
        $fakeLastNames  = [];
        for ($i = 0; $i < 20; $i++) {
            $fakeFirstNames[] = $faker->unique()->firstName();
            $fakeLastNames[]  = $faker->unique()->lastName();
        }
        $this->students = [];
        $namesQuantity  = 0;
        while ($namesQuantity < 200) {
            $firstName = $fakeFirstNames[rand(0, 19)];
            $lastName  = $fakeLastNames[rand(0, 19)];
            $fakeName  = $firstName . ' ' . $lastName;
            if ( ! in_array($fakeName, $this->students)) {
                $this->students[$namesQuantity]['first_name'] = $firstName;
                $this->students[$namesQuantity]['last_name']  = $lastName;
                $namesQuantity++;
            }
        }
    }

    private function addFakeGroups(): void
    {
        $ids    = DB::select('select id from groups');
        $groups = [];
        foreach ($ids as $id) {
            $groups[] = $id->id;
        }

        for ($i = 0; $i < count($this->students); $i++) {
            $this->students[$i]['group_id'] = $groups[rand(0, count($groups) - 1)];
        }
    }
}
