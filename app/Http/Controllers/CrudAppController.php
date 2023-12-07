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

    public function students(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $groupName = $request->get('group_name') ?? "";
        $request = Request::create('api/v1/students'.'/?groupName='.$groupName, 'GET');
        $response = Route::dispatch($request);
        $studentsList = json_decode($response->getContent());
        return view('studentsCrud', ['dbData' => $studentsList]);
    }

    public function store(Request $request): Application|Factory|View|\Illuminate\Foundation\Application
    {
        $request = Request::create(
            'api/v1/students',
            'POST',
            $request->all()
        );
        $firstName = ucfirst(trim($request->post('first_name')));
        $lastName = ucfirst(trim($request->post('last_name')));
        $groupName = strtoupper(trim($request->post('group_name')));
        $message = null;

        $response = Route::dispatch($request);

        if (strlen($firstName) < 3 || strlen($lastName) < 3) {
            redirect('/crudapp');
        }

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
}
