<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PilotsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run($raceReport): void
    {
        foreach ($raceReport as $key => $value) {
            $team = DB::select('select * from teams where team_name = ?', [$value['pilot_team']]);
            DB::table('pilots')->insert([
                'pilot_name' => $value['pilot_name'],
                'pilot_abbreviation' => $key,
                'pilot_team_id' => $team[0]->id,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
