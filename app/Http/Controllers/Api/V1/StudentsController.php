<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Students;
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
            )->get();
        } else {
            $students = DB::table('students')->
            leftJoin('groups', 'students.group_id', '=', 'groups.id')->
            select('students.id', 'students.first_name', 'students.last_name', 'groups.group_name')->get();
        }

        return response()->json($students, 200, [], 0);
    }

    public function destroy(Request $request, $id): Response
    {
        Students::destroy($id);
        return response()->json('student with id='.$id.' successfully deleted', 200, [], 0);
    }

    public function store(Request $request): Response
    {
        $firstName = ucfirst(trim($request->post('first_name')));
        $lastName = ucfirst(trim($request->post('last_name')));
        $groupName = ucfirst(trim($request->post('group_name')));
        $groupId = DB::table('groups')->where('group_name', $groupName)->get('id');

        DB::table('students')->insert([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'group_id' => $groupId[0]->id,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        return response()->json('new student successfully created', 200, [], 0);
    }

}
