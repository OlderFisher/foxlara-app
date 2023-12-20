<?php

namespace App\Http\Controllers;

class CrudApiController extends Controller
{
    public function index()
    {
        return view('cruds.crudApiHome');
    }
}
