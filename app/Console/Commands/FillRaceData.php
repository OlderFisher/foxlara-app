<?php

namespace App\Console\Commands;

use App\Models\MonacoReport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FillRaceData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fill-race-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to fill race data to database';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $monacoRace = new MonacoReport();
        $raceReport = $monacoRace->buildRaceReport('pilot_team');

        $this->fillRaces();
        $this->fillTeams($raceReport);
        $this->fillPilots($raceReport);
        $this->fillResults($raceReport);
    }

    private function fillRaces(): void
    {
        DB::table('races')->insert([
            'race_name' => 'Monaco Race',
        ]);
    }

    private function fillTeams(array $raceReport): void
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

    private function fillPilots(array $raceReport): void
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

    private function fillResults(array $raceReport): void
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
