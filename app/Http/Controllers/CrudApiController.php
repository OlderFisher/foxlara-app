<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CrudApiController extends Controller
{
    public function index(): View
    {
        return view('cruds.crudApiHome');
    }
}
