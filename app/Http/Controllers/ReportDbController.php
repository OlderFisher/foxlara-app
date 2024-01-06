<?php

namespace App\Http\Controllers;

use App\Models\ReportDb;
use Illuminate\View\View;

class ReportDbController extends Controller
{
    public function index(): View
    {
        $raceReport = ReportDb::scopeReport();

        return view('reports.dbreport', [
            'reportData' => $raceReport,
            'topPilots'  => array_slice($raceReport, 0, 15),
            'slowPilots' => array_slice($raceReport, 15, count($raceReport))
        ]);
    }

}
