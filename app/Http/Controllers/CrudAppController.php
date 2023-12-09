<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

;

class CrudAppController extends Controller
{
    public function index(): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $request = Request::create('api/v1/students', 'GET');
        $response = Route::dispatch($request);
        $studentsList = json_decode($response->getContent());

        return view('studentsCrud', ['dbData' => $studentsList]);
    }

    public function show(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $groupName = $request->get('group_name') ?? "";
        $request = Request::create('api/v1/students'.'/?groupName='.$groupName, 'GET');
        $response = Route::dispatch($request);
        $studentsList = json_decode($response->getContent());

        return view('studentsCrud', ['dbData' => $studentsList]);
    }

    public function store(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $allData = $request->all();
        $firstName = $allData['first_name'];
        $lastName = $allData['last_name'];
        $groupName = $allData['group_name'];

        $request = Request::create(
            'api/v1/students',
            'POST',
            $request->all()
        );
        $response = Route::dispatch($request);
        $studentsList = json_decode($response->getContent());

        if ($response->getStatusCode() == 200) {
            $message = 'New student '.$firstName.' '.$lastName.' for group '.$groupName.' successfully created';
        } else {
            $message = 'Something went wrong with new student creation';
        }

        return view('studentsCrud', ['dbData' => $studentsList, 'message' => trim($message)]);
    }

    public function destroy(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $studentId = $request->post('student_id');
        $request = Request::create("api/v1/students/{studentId}", 'POST', ['studentId' => $studentId]);
        $response = Route::dispatch($request);

        $studentsList = json_decode($response->getContent());
        if ($response->getStatusCode() == 200) {
            $message = 'Student with ID '.$studentId.' successfully deleted';
        } else {
            $message = 'Something went wrong during Student with ID '.$studentId.' deletion';
        }

        return view('studentsCrud', ['dbData' => $studentsList, 'message' => trim($message)]);
    }

    public function update(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $studentId = $request->post('student_id');
        $groupName = $request->post('group_name');
        $groupId = $this->getGroupIdByGroupName($groupName);

        $request = Request::create(
            "api/v1/students/{studentId}/groups/{groupId}",
            'POST',
            ['studentId' => $studentId, 'groupId' => $groupId]
        );
        $response = Route::dispatch($request);

        $studentsList = json_decode($response->getContent());
        if ($response->getStatusCode() == 200) {
            $message = 'Student with ID = '.$studentId.' successfully transfered to group '.$groupName;
        } else {
            $message = 'Something went wrong during Student with ID '.$studentId;
        }

        return view('studentsCrud', ['dbData' => $studentsList, 'message' => trim($message)]);
    }

    public function remove(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $studentId = $request->post('student_id');
        $sql = DB::table('students')->where('id', $studentId)->get('group_id');
        $groupId = $sql[0]->group_id;

        $request = Request::create(
            "api/v1/groups/{groupId}/students/{studentId}",
            'POST',
            ['groupId' => $groupId, 'studentId' => $studentId]
        );
        $response = Route::dispatch($request);

        $studentsList = json_decode($response->getContent());
        if ($response->getStatusCode() == 200) {
            $sql = DB::table('groups')->where('id', $groupId)->get('group_name');
            $groupName = $sql[0]->group_name;
            $message = 'Student with ID = '.$studentId.' successfully removed from the group '.$groupName;
        } else {
            $message = 'Something went wrong during Student with ID '.$studentId;
        }

        return view('studentsCrud', ['dbData' => $studentsList, 'message' => trim($message)]);
    }

    private function getGroupIdByGroupName(string $groupName): int
    {
        $sql = DB::table('groups')->where('group_name', $groupName)->get('id');
        return (int)$sql[0]->id;
    }
}
