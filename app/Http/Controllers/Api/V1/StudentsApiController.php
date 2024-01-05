<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\CustomClasses\StudentsManager;
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
class StudentsApiController extends Controller
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
        if ($groupName) {
            $studentsList = StudentsManager::getAllStudentsByGroupName($groupName);
        } else {
            $studentsList = $this->getAllStudents();
        }

        return response()->json($studentsList, 200, [], 0);
    }

    /**
     * @OA\Delete(
     *     path="api/v1/students/{studentId}",
     *     summary="Delete student by studentId",
     *     @OA\Parameter(
     *         name="studentId",
     *         in="params",
     *         description="Student Id for deletion",
     *         required=true,
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
     *        property="studentId",
     *        type="string",
     *        example="21"
     *      ),
     *    )
     */

    public function destroy(Request $request): Response
    {
        $requestUri = $request->getRequestUri();
        $studentId  = str_replace('/api/v1/students/', '', $requestUri);
        if (strlen($studentId) >= 1) {
            StudentsManager::deleteStudentById((int)$studentId);
        }
        // check for deleting success
        $count = DB::table('students')->where('id', (int)$studentId)->get();
        if (empty($count)) {
            $statusCode = 200;
        } else {
            $statusCode = 400;
        }

        return response()->json($this->getAllStudents(), $statusCode, [], 0);
    }

    /**
     * @OA\Post(
     *     path="api/v1/students",
     *     summary="Add new student",
     *     @OA\Parameter(
     *         name="first_name",
     *         in="body",
     *         description="Student first name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *          name="last_name",
     *          in="body",
     *          description="Student last name",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *     @OA\Parameter(
     *          name="group_name",
     *          in="body",
     *          description="Group name to add student",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
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
     *        property="first_name",
     *        type="string",
     *        example="Michael"
     *      ),
     *     @OA\Property(
     *         property="last_name",
     *         type="string",
     *         example="Frank"
     *       ),
     *     @OA\Property(
     *         property="group_name",
     *         type="string",
     *         example="NO-21"
     *       ),
     *    )
     */
    public function store(Request $request): Response
    {
        $allData = $request->post();
        $count   = DB::table('students')->insert([
            'first_name' => $allData['first_name'],
            'last_name'  => $allData['last_name'],
            'group_id'   => $allData['group_id'],
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        if ($count) {
            $statusCode = 200;
        } else {
            $statusCode = 500;
        }

        return response()->json($this->getAllStudents(), $statusCode, [], 0);
    }

    /**
     * @OA\Put(
     *     path="api/v1/students/{studentId}/groups/{groupId}",
     *     summary="Transfer student with studentId to group with groupId",
     *     @OA\Parameter(
     *         name="studentId",
     *         in="params",
     *         description="Student id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *          name="groupId",
     *          in="params",
     *          description="Group id",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *
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
     *        property="studentId",
     *        type="string",
     *        example="21"
     *      ),
     *     @OA\Property(
     *         property="groupId",
     *         type="string",
     *         example="4"
     *       ),
     *
     *    )
     */
    public function update(Request $request): Response
    {
        $requestUri      = $request->getRequestUri();
        $requestUriArray = explode('/', $requestUri);
        for ($i = 0; $i < count($requestUriArray); $i++) {
            if ($requestUriArray[$i] === 'students') {
                $student_id = $requestUriArray[$i + 1];
            }
            if ($requestUriArray[$i] === 'groups') {
                $group_id = $requestUriArray[$i + 1];
            }
        }

        $count = DB::table('students')->where('id', $student_id)->update(['group_id' => $group_id]);

        $statusCode = 200;
        if ($count == 0) {
            $statusCode = 400;
        }

        return response()->json($this->getAllStudents(), $statusCode, []);
    }

    /**
     * @OA\Put(
     *     path="api/v1/groups/{groupId}/students/{studentId}",
     *     summary="Remove student from current group ( transfer to free )",
     *     @OA\Parameter(
     *         name="studentId",
     *         in="params",
     *         description="Student id",
     *         required=true,
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
     *        property="studentId",
     *        type="string",
     *        example="21"
     *      ),
     *    )
     */
    public function remove(Request $request): Response
    {
        $requestUri      = $request->getRequestUri();
        $requestUriArray = explode('/', $requestUri);
        for ($i = 0; $i < count($requestUriArray); $i++) {
            if ($requestUriArray[$i] === 'students') {
                $student_id = $requestUriArray[$i + 1];
            }
        }
        $group_id = $this->getGroupIdByGroupName('free');

        $count = DB::table('students')->where('id', $student_id)->update(['group_id' => $group_id]);

        $statusCode = 200;
        if ($count == 0) {
            $statusCode = 400;
        }

        return response()->json($this->getAllStudents(), $statusCode, []);
    }

    /**
     * @OA\Put(
     *     path="api/v1/{studentId}/add/courses/{courseId}",
     *     summary="Add student with studentId to course with courseId",
     *     @OA\Parameter(
     *         name="studentId",
     *         in="params",
     *         description="Student id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *          name="groupId",
     *          in="params",
     *          description="Group id",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *
     *     @OA\Response(
     *      response="200",
     *      description="Students list  json data return. Response object = { {parameters} ....}.)",
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
     *        property="studentId",
     *        type="string",
     *        example="21"
     *      ),
     *     @OA\Property(
     *         property="courseId",
     *         type="string",
     *         example="4"
     *       ),
     *
     *    )
     */
    public function courseAdding(Request $request): Response
    {
        $requestUri      = $request->getRequestUri();
        $requestUriArray = explode('/', $requestUri);

        for ($i = 0; $i < count($requestUriArray); $i++) {
            if ($requestUriArray[$i] === 'students') {
                $studentId = $requestUriArray[$i + 1];
            }
            if ($requestUriArray[$i] === 'courses') {
                $courseId = $requestUriArray[$i + 1];
            }
        }
        $sql = DB::table('students_courses')
                 ->where('student_id', $studentId)
                 ->where('course_id', $courseId)
                 ->get('id');
        if ($sql->isEmpty()) {
            DB::table('students_courses')
              ->insert([
                  'student_id' => $studentId,
                  'course_id'  => $courseId
              ]);
        }

        return response()->json($this->getAllStudents(), 200, []);
    }

    /**
     * @OA\Put(
     *     path="api/v1/{studentId}/remove/courses/{courseId}",
     *     summary="Remove student with studentId to course with courseId",
     *     @OA\Parameter(
     *         name="studentId",
     *         in="params",
     *         description="Student id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *          name="groupId",
     *          in="params",
     *          description="Group id",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *
     *     @OA\Response(
     *      response="200",
     *      description="Students list  json data return. Response object = { {parameters} ....}.)",
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
     *        property="studentId",
     *        type="string",
     *        example="21"
     *      ),
     *     @OA\Property(
     *         property="courseId",
     *         type="string",
     *         example="4"
     *       ),
     *
     *    )
     */
    public function courseRemove(Request $request): Response
    {
        $requestUri      = $request->getRequestUri();
        $requestUriArray = explode('/', $requestUri);

        for ($i = 0; $i < count($requestUriArray); $i++) {
            if ($requestUriArray[$i] === 'students') {
                $studentId = $requestUriArray[$i + 1];
            }
            if ($requestUriArray[$i] === 'courses') {
                $courseId = $requestUriArray[$i + 1];
            }
        }
        $sql = DB::table('students_courses')
                 ->where('student_id', (int)$studentId)
                 ->where('course_id', (int)$courseId)
                 ->get('id');

        if ($sql->isEmpty()) {
            return response()->json('ERROR', 500, []);
        }
        DB::table('students_courses')->where('id', $sql[0]->id)->delete();

        return response()->json($this->getAllStudents(), 200, []);
    }

    /**
     * Function to get all  students list
     * @return string
     */
    private function getAllStudents(): array
    {
        $students = DB::table('students')
                      ->leftJoin('groups', 'students.group_id', '=', 'groups.id')
                      ->select('students.id', 'students.first_name', 'students.last_name', 'groups.group_name')
                      ->orderBy('students.id')
                      ->get();

        return $students->toArray();
    }

    /**
     * Function to find group id by group name
     *
     * @param  string  $groupName
     *
     * @return int
     */
    private function getGroupIdByGroupName(string $groupName): int
    {
        $sql = DB::table('groups')->where('group_name', $groupName)->get('id');

        return (int)$sql[0]->id;
    }

}
