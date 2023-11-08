<?php

namespace App\Http\Controllers;

use App\Models\MonacoReport;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $monacoRace = new MonacoReport();
        $raceReport = $monacoRace->buildRaceReport('race_time',SORT_ASC);

        return view('reports.report', [
            'reportData' => $raceReport,
            'topPilots' => array_slice($raceReport, 0, 15),
            'slowPilots' => array_slice($raceReport, 15, count($raceReport))
        ]);
    }
}
