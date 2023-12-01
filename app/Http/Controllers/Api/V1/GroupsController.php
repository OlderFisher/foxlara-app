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
 *   title="Groups results basic API",
 *   version="1.0.0",
 *   @OA\Contact(
 *     email="lilik.aleksandr@gmail.com"
 *   )
 * )
 */
class GroupsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/groups",
     *     summary="Get sudents group with students quantity and students count limitstion",
     *     @OA\Parameter(
     *         name="count",
     *         in="query",
     *         description="Students count in groups response limitation",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *      response="200",
     *      description="Groups with students limit filter successful json data return. Response object = { {parameters} ....}.)",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              type="object",
     *              @OA\AdditionalProperties(
     *                  ref="#/components/schemas/Groups"
     *              ),
     *          )
     *      ),
     *     ),
     * )
     * @OA\Schema(
     *      schema="Groups",
     *      type="object",
     *
     *      @OA\Property(
     *        property="count",
     *        type="number",
     *        example=10
     *      ),
     *    )
     */
    public function index(Request $request): Response
    {
        $countLimit = $request->get('count');
        $countLimit = $countLimit ?? 100000000;

        $groups = DB::select(
            "select id,group_name,
                    (select count(*) from students where students.group_id=groups.id ) as students_count
                    from groups   group by group_name,id order by students_count asc"
        );

        $filteredGroups = [];
        foreach ($groups as $group) {
            if ($group->students_count <= $countLimit) {
                $filteredGroups[] = $group;
            }
        }

        return response()->json($filteredGroups, 200, [], 0);
    }

}