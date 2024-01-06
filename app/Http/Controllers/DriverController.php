<?php

namespace App\Http\Controllers;

use App\Models\MonacoReport;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DriverController extends Controller
{
    public function index(Request $request): View
    {
        $order    = $request->order;
        $driverId = $request->driver_id;

        $monacoRace = new MonacoReport();
        $raceReport = $monacoRace->buildRaceReport('pilot_name');
        if ('desc' == $order) {
            $raceReport = $monacoRace->buildRaceReport('pilot_name', SORT_DESC);
        }

        // If request has single driverId
        if (is_string($driverId) && strlen($driverId) == 3) {
            $pilotData = array_filter($raceReport, function ($key) use ($driverId) {
                return ($key == $driverId);
            }, ARRAY_FILTER_USE_KEY);

            $raceReport = $pilotData;
        }

        return view('reports.drivers', [
            'reportData' => $raceReport
        ]);
    }
}
