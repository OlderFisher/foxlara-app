<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResultsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run($raceReport): void
    {
        $raceId = DB::table('races')->pluck('id');

        foreach ($raceReport as $key => $value) {
            $pilot = DB::select('select * from pilots where pilot_abbreviation = ?', [$key]);
            DB::table('results')->insert([
                'pilot_id' => $pilot[0]->id,
                'race_id' => $raceId[0],
                'start_time' => (int)$value['start_time'],
                'end_time' => (int)$value['end_time'],
                'race_time' => $value['race_time'],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
