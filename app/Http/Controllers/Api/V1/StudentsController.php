<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Info(
 *   title="Students results basic API",
 *   version="1.0.0",
 *   @OA\Contact(
 *     email="lilik.aleksandr@gmail.com"
 *   )
 * )
 */
class StudentsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/students",
     *     summary="Get sudents list with the group limitation",
     *     @OA\Parameter(
     *         name="groupName",
     *         in="query",
     *         description="Students with group name response limitation",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *      response="200",
     *      description="Students list with group limit filter successful json data return. Response object = { {parameters} ....}.)",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              type="object",
     *              @OA\AdditionalProperties(
     *                  ref="#/components/schemas/Students"
     *              ),
     *          )
     *      ),
     *     ),
     * )
     * @OA\Schema(
     *      schema="Students",
     *      type="object",
     *
     *      @OA\Property(
     *        property="groupName",
     *        type="string",
     *        example="NY-21"
     *      ),
     *    )
     */
    public function index(Request $request): Response
    {
        $groupName = $request->get('groupName');
        $students = DB::select(
            "select * from students inner join groups on students.group_id=groups.id"
        );
        if ($groupName) {
            $filteredStudents = [];
            foreach ($students as $student) {
                if ($student->group_name == $groupName) {
                    $filteredStudents[] = $student;
                }
            }
            $students = $filteredStudents;
        }

        return response()->json($students, 200, [], 0);
    }

}
