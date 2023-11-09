<?php

namespace Tests\Unit;

use App\Models\MonacoReport;
use Tests\TestCase;

class ApiReportTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function testApiReportJson(): void
    {
        $response = $this->get('/api/v1/report');

        $monacoRace = new MonacoReport();
        $raceReport = $monacoRace->buildRaceReport('pilot_name');

        $response->assertStatus(200);
        $response->assertJsonFragment($raceReport);
    }
}
