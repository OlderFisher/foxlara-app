<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\MonacoReport;
use Illuminate\Http\Request;
use Spatie\ArrayToXml\ArrayToXml;
use Mtownsend\ResponseXml\Providers\ResponseXmlServiceProvider;

class ReportController extends Controller
{
    public function index(Request $request): string|null
    {
        $format= $request->only(['format']);

        $monacoRace = new MonacoReport();
        $raceReport = $monacoRace->buildRaceReport('pilot_name');

        $response = null;
        if ($format['format'] === 'json' || !isset($format['format'])) {
            return response()->json($raceReport);
        }
        if ($format['format'] === 'xml') {
//            $xml = ArrayToXml::convert($raceReport);
            return response()->xml($raceReport);
        }
        return null;
    }

}
