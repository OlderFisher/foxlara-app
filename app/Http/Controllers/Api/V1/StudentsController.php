<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
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
        $groupName = $request->get('group_name');
        if ($groupName && strlen($groupName) === 5) {
            $groupId = DB::table('groups')->where('group_name', $groupName)->get('id');
            $students = DB::table('students')->
            leftJoin('groups', 'students.group_id', '=', 'groups.id')->
            where('students.group_id', $groupId[0]->id)->
            select(
                'students.id',
                'students.first_name',
                'students.last_name',
                'students.group_id',
                'groups.group_name'
            )->orderBy('students.id')->get();
        } else {
            $students = DB::table('students')->
            leftJoin('groups', 'students.group_id', '=', 'groups.id')->
            select('students.id', 'students.first_name', 'students.last_name', 'groups.group_name')->
            get();
        }

        return response()->json($students, 200, [], 0);
    }

    public function destroy(Request $request): Response
    {
        $allData = $request->all();
        $id = (int)$allData['student_id'];

        $count = DB::table('students')->delete($id);
        if ($count > 0) {
            return response()->json('OK', 200, [], 0);
        } else {
            return response()->json('ERROR', 400, [], 0);
        }
    }

    public function store(Request $request): Response
    {
        $firstName = ucfirst(trim($request->post('first_name')));
        $lastName = ucfirst(trim($request->post('last_name')));
        $groupName = ucfirst(trim($request->post('group_name')));
        $groupId = DB::table('groups')->where('group_name', $groupName)->get('id');

        $count = DB::table('students')->insert([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'group_id' => $groupId[0]->id,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        $request = Request::create('api/v1/students', 'GET');
        $response = Route::dispatch($request);
        $studentsList = json_decode($response->getContent());
        if ($count > 0) {
            return response()->json($studentsList, 200, [], 0);
        } else {
            return response()->json($studentsList, 400, [], 0);
        }
    }

}
