<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArtistController extends Controller
{
    //
    public function index(Request $request)
    {
        $user_id = auth()->user()->id;
        $artists = DB::table('artists')
            ->leftJoin('artists_has_songs','artists.id', '=', 'artists_has_songs.artist_id')
            ->leftJoin('songs', 'songs.id', '=', 'artists_has_songs.song_id')
            ->where('songs.user_id', $user_id)
            ->select('artists.*')
            ->get();
            // dd($songs);
        return Inertia::render('Dashboard', [
            'data' => [
                'artists' => $artists
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
