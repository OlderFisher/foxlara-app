<?php

namespace Tests\Unit;

use App\Models\MonacoReport;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;


class ApiReportTest extends TestCase
{
    /**
     * Test monaco report API.
     */
    public function testApiReportJson(): void
    {
        $response = $this->get('/api/v1/report');

        $monacoRace = new MonacoReport();
        $raceReport = $monacoRace->buildRaceReport('pilot_name');

        $response->assertStatus(200);
        $response->assertJsonFragment($raceReport);
    }

    public function testApiStudentsListJson(): void
    {
        $apiResponse = $this->get('api/v1/students');
        $collection = DB::table('students')->
        leftJoin('groups', 'students.group_id', '=', 'groups.id')->
        select('students.id', 'students.first_name', 'students.last_name', 'groups.group_name')->
        orderBy('students.id')->
        get();
        $students = [];
        foreach ($collection as $item) {
            $element = [];
            $element['id'] = $item->id;
            $element['first_name'] = $item->first_name;
            $element['last_name'] = $item->last_name;
            $element['group_name'] = $item->group_name;
            $students[] = $element;
        }

        $apiResponse->assertStatus(200);
        $apiResponse->assertJson($students);
    }

    public function testApiGroupsListJson(): void
    {
        $apiResponse = $this->get('api/v1/groups');
        $collection = DB::select(
            "select group_name,id,
                    (select count(*) from students where students.group_id=groups.id ) as students_count 
                    from groups  group by group_name,id  order by students_count asc"
        );
        $groups = [];
        foreach ($collection as $item) {
            $element = [];
            $element['group_name'] = $item->group_name;
            $element['id'] = $item->id;
            $element['students_count'] = $item->students_count;
            $groups[] = $element;
        }
        $apiResponse->assertStatus(200);
        $apiResponse->assertJson($groups);
    }

    public function testApiStudentGroupUpdate(): void
    {
        $singleStudentCollection = DB::table('students')->first();

        $student['first_name'] = $singleStudentCollection->first_name;
        $student['group_name'] = $this->getGroupGroupNameById($singleStudentCollection->group_id);
        $student['id'] = $singleStudentCollection->id;
        $student['last_name'] = $singleStudentCollection->last_name;


        $groupsCollection = DB::table('groups')->get();
        $groupIdsCollection = [];
        foreach ($groupsCollection as $group) {
            $element = [];
            $element['id'] = $group->id;
            $element['group_name'] = $group->group_name;
            $groupIdsCollection[] = $element;
        }
        $group = $groupIdsCollection[rand(0, count($groupIdsCollection) - 1)];

        $this->post(
            'api/v1/students/{studentId}/groups/{groupId}',
            ['studentId' => $student['id'], 'groupId' => $group['id']]
        );

        $apiResponse = $this->get('api/v1/students/?groupName='.$group['group_name']);
        $student['group_name'] = $this->getGroupGroupNameById($group['id']);

        $apiResponse->assertStatus(200);
        $apiResponse->assertJsonFragment($student);
    }

    private function getGroupGroupNameById(string $id): string
    {
        $sql = DB::table('groups')->where('id', $id)->get('group_name');
        return $sql[0]->group_name;
    }
}
