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
            orderBy('students.id')->
            get();
        }

        return response()->json($students, 200, [], 0);
    }

    public function destroy(Request $request): Response
    {
        $allData = $request->all();
        $id = (int)$allData['student_id'];

        $count = DB::table('students')->delete($id);

        $statusCode = 200;
        if ($count == 0) {
            $statusCode = 400;
        }
        $studentsList = json_decode($this->getAllStudents());
        return response()->json($studentsList, $statusCode, [], 0);
    }

    public function store(Request $request): Response
    {
        $allData = $request->all();
        $firstName = $allData['first_name'];
        $lastName = $allData['last_name'];
        $groupName = $allData['group_name'];
        $groupId = $this->getGroupIdByGroupName($groupName);

        $count = DB::table('students')->insert([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'group_id' => $groupId,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        if (!$count) {
            $statusCode = 500;
        } else {
            $statusCode = 200;
        }
        $studentsList = json_decode($this->getAllStudents());
        return response()->json($studentsList, $statusCode, [], 0);
    }

    public function update(Request $request): Response
    {
        $allData = $request->all();
        $student_id = (int)$allData['student_id'];
        $group_id = $this->getGroupIdByGroupName($allData['group_name']);

        $count = DB::table('students')->where('id', $student_id)->update(['group_id' => $group_id]);

        $statusCode = 200;
        if ($count == 0) {
            $statusCode = 400;
        }
        $studentsList = json_decode($this->getAllStudents());
        return response()->json($studentsList, $statusCode, []);
    }

    public function remove(Request $request): Response
    {
        $allData = $request->all();
        $student_id = (int)$allData['student_id'];

        $count = DB::table('students')->where('id', $student_id)->update(['group_id' => null]);

        $statusCode = 200;
        if ($count == 0) {
            $statusCode = 400;
        }
        $studentsList = json_decode($this->getAllStudents());
        return response()->json($studentsList, $statusCode, []);
    }

    private function getAllStudents(): string
    {
        $request = Request::create('api/v1/students', 'GET');
        $response = Route::dispatch($request);

        return $response->getContent();
    }

    private function getGroupIdByGroupName(string $groupName): int
    {
        $sql = DB::table('groups')->where('group_name', $groupName)->get('id');
        return (int)$sql[0]->id;
    }

}
