<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Owenoj\LaravelGetId3\GetId3;
use Illuminate\Support\Facades\Storage;

class SongController extends Controller
{
    //
    public function check(Request $request)
    {

        if ($request->isMethod('POST')) {
            // $track = new GetId3(request()->file('file'));
            // echo($track->getArtwork(true));
            // echo(Storage::path('default_avatar.jpg'));
            $info = Storage::url('default_avatar.jpg');
            echo $info;
        }
        return view('songs.list');
    }
}
