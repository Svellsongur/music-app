<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;
use App\Models\ArtistHasSong;
use Owenoj\LaravelGetId3\GetId3;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Termwind\Components\Dd;

class SongController extends Controller
{
    //
    public function index(Request $request)
    {
        $user_id = auth()->user()->id;
        $songs = Song::where('user_id', $user_id)
            ->leftJoin('albums', 'albums.id', '=', 'songs.album_id')
            ->select('songs.*', 'albums.name as album')
            ->get();
        // dd($songs);

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

        return Inertia::render('Dashboard', [
            'data' => [
                'songs' => $songs,
                'totalSongs' => $totalSongs
            ],
            'message' => 'Success',
            'status' => 200
        ]);
    }

    public function store(Request $request)
    {
        if ($request->isMethod('POST')) {
            foreach ($request->all() as $files) {
                foreach ($files as $file) {
                    $file = new GetId3($file['file']);
                    Song::create([
                        'name' => $file->getTitle(),
                        'length' => $file->getPlaytime(),
                        'user_id' => auth()->user()->id,
                        'song_path' => 'abc',
                    ]);
                }
            }
        }
        return Inertia::render('MainPages/AddSong');
    }

    public function update(Request $request, string $id)
    {
        $user_id = auth()->user()->id;

        $song = Song::leftJoin('artists_has_songs', 'songs.id', '=', 'artists_has_songs.song_id')
            ->leftJoin('artists', 'artists.id', '=', 'artists_has_songs.artist_id')
            ->leftJoin('albums', 'albums.id', '=', 'songs.album_id')
            ->where('user_id', $user_id)
            ->where('songs.id', $id)
            ->select('songs.id', 'songs.name', 'songs.length', 'songs.song_path', 'songs.artwork_path', 'songs.created_at', 'songs.updated_at', 'artists.id as artist_id', 'artists.name as artist', 'albums.name as album')
            ->first();

        if ($song->updated_at == null) {
            $song->updated_at = $song->created_at;
        }

        if ($request->isMethod('POST')) {
            $data = json_decode(json_encode($request->except('_token')));

            $hasArtist = Song::leftJoin('artists_has_songs', 'songs.id', '=', 'artists_has_songs.song_id')
                ->leftJoin('artists', 'artists.id', '=', 'artists_has_songs.artist_id')
                ->where('songs.user_id', $user_id)
                ->where('artists.name', trim($data->artist))
                ->select('artists.id as artist_id')
                ->first();

            // dd($hasArtist);

            $hasAlbum = Song::leftJoin('albums', 'songs.album_id', '=', 'albums.id')
                ->where('songs.user_id', $user_id)
                ->where('albums.name', trim($data->album))
                ->first();


            //fix thành công bug thêm nhiều artist has song record
            if ($hasArtist == null) {
                $newArtist = Artist::create([
                    'name' => trim($data->artist),
                ]);
                ArtistHasSong::create([
                    'artist_id' => $newArtist->id,
                    'song_id' => $data->id
                ]);
                ArtistHasSong::where('song_id', $data->id)
                    ->where('artist_id', $data->artist_id)
                    ->delete();
            } else {
                ArtistHasSong::where('song_id', $data->id)
                    ->where('artist_id', $data->artist_id)
                    ->delete();
                ArtistHasSong::create([
                    'artist_id' => $hasArtist->artist_id,
                    'song_id' => $data->id
                ]);
            }

            if ($hasAlbum == null) {
                $newAlbum = Album::create([
                    'name' => trim($data->album),
                ]);
                $newSong = Song::find($data->id);
                $newSong->album_id = $newAlbum->id;
                $newSong->save();
            } else {
                $newSong = Song::find($data->id);
                $newSong->album_id = $hasAlbum->id;
                $newSong->save();
            }

            Song::where('id', $data->id)
                ->update([
                    'name' => trim($data->name),
                ]);
        }

        return Inertia::render('Detail_layout/SongDetail', [
            'data' => [
                'song' => $song
            ],
            'message' => 'Success',
            'status' => 200
        ]);
    }

    public function destroy(Request $request, string $id)
    {
        Song::where('id', $id)
            ->delete();
    }

    public function check()
    {
    }

    public function testVue()
    {
        return Inertia::render('Test');
    }
}
