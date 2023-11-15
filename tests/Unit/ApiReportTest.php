<?php

namespace Tests\Unit;

use App\Models\MonacoReport;
use Tests\TestCase;


class ApiReportTest extends TestCase
{
    /**
     * Test monaco report API.
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
