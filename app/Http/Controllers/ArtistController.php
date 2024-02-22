<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Song;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArtistController extends Controller
{
    //
    public function index(Request $request)
    {
        $user_id = auth()->user()->id;
        $artists = Artist::leftJoin('artists_has_songs','artists.id', '=', 'artists_has_songs.artist_id')
            ->leftJoin('songs', 'songs.id', '=', 'artists_has_songs.song_id')
            ->where('songs.user_id', $user_id)
            ->select('artists.*')
            ->groupBy('artists.name')
            ->orderBy('artists.name', 'asc')
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

    public function detail(Request $request, string $id){
        $user_id = auth()->user()->id;
        $songs = Song::where('user_id', $user_id)
            ->leftJoin('artists_has_songs', 'songs.id', '=', 'artists_has_songs.song_id')
            ->leftJoin('artists', 'artists.id', '=', 'artists_has_songs.artist_id')
            ->leftJoin('albums', 'albums.id', '=', 'songs.album_id')
            ->where('artists.id', '=', $id)
            ->select('songs.*', 'albums.name as album')
            ->orderBy('songs.name', 'asc')
            ->get();

        foreach ($songs as $song) {
            $song->song_path = asset($song->song_path);
            $song->artists = DB::table('artists_has_songs')
                ->where('song_id', $song->id)
                ->join('artists', 'artists.id', '=', 'artists_has_songs.artist_id')
                ->select('artists.name as artists')
                ->get();
        }
        // dd($songs);
        $totalSongs = count($songs);

        $artist = Artist::where('id', $id)->select('name')->first();

        return Inertia::render('Dashboard', [
            'data' => [
                'songs' => $songs,
                'totalSongs' => $totalSongs,
                'layoutType' => 2,
                'title' => 'Artist ' . $artist->name,
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
