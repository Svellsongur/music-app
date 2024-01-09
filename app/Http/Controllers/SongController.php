<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Owenoj\LaravelGetId3\GetId3;
use Illuminate\Support\Facades\Storage;

class SongController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = auth()->user()->id;
        $songs = Song::where('user_id', $user)->get();
        dd($songs);
        return Inertia::render('Dashboard',[
            'songs' => $songs
        ]);
    }

    public function store(Request $request){

    }

    public function update(Request $request){

    }

    public function destroy(Request $request){

    }
}
