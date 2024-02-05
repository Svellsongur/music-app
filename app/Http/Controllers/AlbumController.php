<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlbumController extends Controller
{
    //
    public function index(Request $request)
    {
        $user_id = auth()->user()->id;
        $albums = Album::leftJoin('songs', 'albums.id', '=', 'songs.album_id')
            ->leftJoin('artists_has_songs', 'artists_has_songs.song_id', '=', 'songs.id')
            ->leftJoin('artists', 'artists.id', '=', 'artists_has_songs.artist_id')
            ->where('songs.user_id', $user_id)
            ->select('albums.*', 'artists.name as artist')
            ->groupBy('albums.name')
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
