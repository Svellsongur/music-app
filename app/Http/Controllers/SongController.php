<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Owenoj\LaravelGetId3\GetId3;
use Illuminate\Support\Facades\Storage;

class SongController extends Controller
{
    //
    public function index(Request $request)
    {
       return Inertia::render('Dashboard');
    }
}
