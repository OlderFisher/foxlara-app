<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\MonacoReport;
use Illuminate\Http\Request;
//use Spatie\ArrayToXml\ArrayToXml;
use Mtownsend\ResponseXml\Providers\ResponseXmlServiceProvider;

class ReportController extends Controller
{
    public function index(Request $request): string|null
    {
        $monacoRace = new MonacoReport();
        $raceReport = $monacoRace->buildRaceReport('pilot_name');

        $format = $request->filled(['format']) ?  $request->only(['format']) : null;

        if (!$format || $format['format'] === 'json') {
            return json_encode(response()->json($raceReport, 200, [],0));
        }
        if ($format['format'] === 'xml') {
//            $xml = ArrayToXml::convert($raceReport);
            return response()->xml($raceReport);
        }
        return null;
    }

}
