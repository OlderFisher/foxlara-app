<?php

namespace Tests\Unit;

use App\Models\MonacoReport;
use App\Models\ReportDb;
use Tests\TestCase;

class DbReportTest extends TestCase
{
    /**
     * Test Monaco Report from database Data.
     */
    public function testDbReportJson(): void
    {
        $monacoRace          = new MonacoReport();
        $raceFilesReport     = $monacoRace->buildRaceReport('race_time');
        $raceFilesReportJson = json_encode($raceFilesReport);

        $raceDbReport     = ReportDb::scopeReport();
        $raceDbReportJson = json_encode($raceDbReport);

        $this->assertJsonStringEqualsJsonString($raceFilesReportJson, $raceDbReportJson);
    }

}
