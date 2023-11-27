<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CrudStructureController extends Controller
{
    public function index(): View
    {
        return view('reports.crudstructure');
    }
}
