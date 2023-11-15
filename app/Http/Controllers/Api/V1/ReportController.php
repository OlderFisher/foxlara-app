<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\MonacoReport;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Info(
 *   title="Mmonaco Race results basic API",
 *   version="1.0.0",
 *   @OA\Contact(
 *     email="lilik.aleksandr@gmail.com"
 *   )
 * )
 */
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
     *     @OA\Response(
     *      response="200",
     *      description="Monaco Race Report successful json|xml data return",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              type="object",
     *              @OA\AdditionalProperties(
     *                  ref="#/components/schemas/Report"
     *              ),
     *          )
     *      ),
     *      @OA\MediaType(
     *           mediaType="application/xml",
     *       ),
     *
     *     ),
     * )
     * @OA\Schema(
     *      schema="Report",
     *      type="object",
     *
     *      @OA\Property(
     *        property="pilot_name",
     *        type="string",
     *        example="Michael Shumacher"
     *      ),
     *
     *      @OA\Property(
     *        property="pilot_team",
     *        type="string",
     *        example="Ferrari"
     *      ),
     *
     *        @OA\Property(
     *          property="race_time",
     *          type="string",
     *          format="date-time"
     *        ),
     *    )
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
