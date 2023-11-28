<?php

namespace Database\Seeders;

use App\Models\MonacoReport;
use App\Models\Races;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Races::factory()->create();

        $monacoRace = new MonacoReport();
        $raceReport = $monacoRace->buildRaceReport('pilot_team');
        // Monaco Race Report Seeders
        $this->callWith(TeamsSeeder::class, ['raceReport' => $raceReport]);
        $this->callWith(PilotsSeeder::class, ['raceReport' => $raceReport]);
        $this->callWith(ResultsSeeder::class, ['raceReport' => $raceReport]);
        // Students and Courses Seeders
        $this->callWith(GroupsSeeder::class);
        $this->callWith(CoursesSeeder::class);
        $this->callWith(StudentsSeeder::class);
//        $this->callWith(CoursesStudentsSeeder::class);
    }
}
