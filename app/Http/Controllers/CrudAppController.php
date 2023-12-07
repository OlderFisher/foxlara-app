<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
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
        $firstName = ucfirst(trim($request->post('first_name')));
        $lastName = ucfirst(trim($request->post('last_name')));
        $groupName = strtoupper(trim($request->post('group_name')));
        $message = null;

        $request = Request::create(
            'api/v1/students',
            'POST',
            $request->all()
        );
        $response = Route::dispatch($request);

        if ($response->getStatusCode() == 200) {
            $request = Request::create('api/v1/students'.'/?groupName='.$groupName, 'GET');
            $response = Route::dispatch($request);
            $studentsList = json_decode($response->getContent());
            $message = 'New student '.$firstName.' '.$lastName.' for group '.$groupName.' successfully created';
        } else {
            redirect('/crudapp');
        }
        return view('studentsCrud', ['dbData' => $studentsList, 'message' => trim($message)]);
    }

    public function destroy(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $studentId = $request->post('student_id');
        $request = Request::create("api/v1/students/{studentId}", 'POST', ['studentId' => $studentId]);
        $response = Route::dispatch($request);

        $message = null;
        $studentsList = [];
        if ($response->getStatusCode() == 200) {
            $request = Request::create('api/v1/students', 'GET');
            $response = Route::dispatch($request);
            $studentsList = json_decode($response->getContent());
            $message = 'Student with ID '.$studentId.' successfully deleted';
        }

        return view('studentsCrud', ['dbData' => $studentsList, 'message' => trim($message)]);
    }
}
