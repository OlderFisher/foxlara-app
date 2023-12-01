<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groupNames = [];
        $namesCount = 0;
        while ($namesCount < 10) {
            $name = Str::random(2);
            if (!in_array($name, $groupNames) && preg_match('/[a-zA-Z]{2}/', $name)) {
                $groupNames[] = $name;
                $namesCount++;
            }
        }
        for ($i = 0; $i < 10; $i++) {
            DB::table('groups')->insert([
                'group_name' => Str::upper($groupNames[$i]).'-'.rand(10, 90),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
