<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\MonacoReport;
use Illuminate\Http\Request;
use Mtownsend\ResponseXml\Providers\ResponseXmlServiceProvider;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/report",
     *     summary="Get Monaco Race report data",
     *     @OA\Parameter(
     *         name="format",
     *         in="query",
     *         description="Response data format json | xml",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200|201", description="Monaco Race Reposrt data"),
     * )
     */
    public function index(Request $request): Response
    {
        $monacoRace = new MonacoReport();
        $raceReport = $monacoRace->buildRaceReport('pilot_name');

        $format = $request->get('format');
        if ($format === 'xml') {
            return response()->xml($raceReport);
        }
        return response()->json($raceReport, 200, [],0);
    }

}
