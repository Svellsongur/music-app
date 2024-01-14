<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlbumController extends Controller
{
    //
    public function index(Request $request)
    {
        $user_id = auth()->user()->id;
        $albums = DB::table('albums')
            ->leftJoin('songs', 'albums.id', '=', 'songs.album_id')
            ->where('songs.user_id', $user_id)
            ->select('albums.*')
            ->get();
            // dd($songs);
        return Inertia::render('Dashboard', [
            'data' => [
                'albums' => $albums
            ],
            'message' => 'Success',
            'status' => 200
        ]);
    }

    public function store(Request $request)
    {
    }

    public function update(Request $request)
    {
    }

    public function destroy(Request $request)
    {
    }
}
