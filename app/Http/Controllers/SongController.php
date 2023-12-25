<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Owenoj\LaravelGetId3\GetId3;

class SongController extends Controller
{
    //
    public function check(Request $request)
    {
        if ($request->isMethod('POST')) {
            $track = new GetId3(request()->file('file'));
            echo($track->getArtwork(true));
        }
        return view('songs.list');
    }
}
