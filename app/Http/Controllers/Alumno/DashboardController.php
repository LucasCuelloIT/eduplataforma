<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('alumno.dashboard');
    }
}