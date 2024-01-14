<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Owenoj\LaravelGetId3\GetId3;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SongController extends Controller
{
    //
    public function index(Request $request)
    {
        $user_id = auth()->user()->id;
        $songs = DB::table('songs')
            ->leftJoin('artists_has_songs','songs.id', '=', 'artists_has_songs.song_id')
            ->leftJoin('artists', 'artists.id', '=', 'artists_has_songs.artist_id')
            ->where('user_id', $user_id)
            ->select('songs.*', 'artists.name as artist')
            ->get();
            // dd($songs);
        foreach ($songs as $song){
            $song->song_path = asset($song->song_path);
        }
        return Inertia::render('Dashboard', [
            'data' => [
                'songs' => $songs
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
