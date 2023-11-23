<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DbStructureController extends Controller
{
    public function index(): View
    {
        return view('reports.dbstructure');
    }
}
