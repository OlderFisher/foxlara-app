<?php

namespace App\Http\Controllers;

use App\Models\MonacoReport;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index():View
    {
        $monacoRace = new MonacoReport();
        $raceReport = $monacoRace->buildRaceReport(SORT_ASC);

        return view('report.index',[
            'reportData'=>$raceReport,
            'topPilots' => array_slice($raceReport, 0, 15),
            'slowPilots'=> array_slice($raceReport, 15, count($raceReport))
            ]);
    }
}
