<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run($raceReport): void
    {
        $teams = [];
        foreach ($raceReport as $key => $value) {
            $teams[] = $value['pilot_team'];
        }
        $teamsCleaned = array_unique($teams);
        foreach ($teamsCleaned as $team) {
            DB::table('teams')->insert([
                'team_name' => $team,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
