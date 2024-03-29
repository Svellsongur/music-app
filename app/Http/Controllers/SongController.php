<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;
use App\Models\ArtistHasSong;
use App\Notifications\ActivityLog;
use Owenoj\LaravelGetId3\GetId3;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class SongController extends Controller
{
    //
    public function index(Request $request)
    {
        $user_id = auth()->user()->id;
        $songs = Song::where('user_id', $user_id)
            ->leftJoin('albums', 'albums.id', '=', 'songs.album_id')
            ->select('songs.*', 'albums.name as album')
            ->orderBy('songs.name', 'asc')
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
                'totalSongs' => $totalSongs,
                'layoutType' => 1,
                'title' => 'My Songs',
            ],
            'message' => 'Success',
            'status' => 200
        ]);
    }

    public function store(Request $request)
    {
        if ($request->isMethod('POST')) {
            $user = User::where('id', auth()->user()->id)->first();
            $fileCount = 0;
            $fileUploaded = [];

            foreach ($request->all() as $files) {
                foreach ($files as $file) {
                    $originalFile = $file['file'];
                    $file = new GetId3($file['file']);

                    // dd($file->getArtwork(true));
                    if ($file->getArtwork(true) != null) {
                        $artwork = uploadfile('/user/' . auth()->user()->id . '/songs/artworks', $file->getArtwork(true));
                    }

                    $url = 'storage/' .  uploadfile('/user/' . auth()->user()->id . '/songs', $originalFile);

                    $hasUrl = Song::where('song_path', $url)->first();

                    if (!$hasUrl) {
                        $song = Song::create([
                            'name' => $file->getTitle(),
                            'length' => $file->getPlaytime(),
                            'user_id' => auth()->user()->id,
                            'song_path' => $url,
                            'artwork_path' => $file->getArtwork(true) ? 'http://music-app.test/storage/' . $artwork : null,
                        ]);
                        $fileCount++;
                        array_push($fileUploaded, $file->getTitle());
                    } else {
                        return Inertia::render('MainPages/AddSong', [
                            'error' => 'File Duplicated!'
                        ])->withViewData([
                            'error' => true,
                        ]);
                    }
                    //check artist
                    $hasArtist = Song::leftJoin('artists_has_songs', 'songs.id', '=', 'artists_has_songs.song_id')
                        ->leftJoin('artists', 'artists.id', '=', 'artists_has_songs.artist_id')
                        ->where('songs.user_id', auth()->user()->id)
                        ->where('artists.name', trim($file->getArtist()))
                        ->select('artists.id as artist_id')
                        ->first();

                    //check album
                    $hasAlbum = Song::leftJoin('albums', 'songs.album_id', '=', 'albums.id')
                        ->where('songs.user_id', auth()->user()->id)
                        ->where('albums.name', trim($file->getAlbum()))
                        ->first();

                    //update artist if db already has one
                    if ($hasArtist == null) {
                        $newArtist = Artist::create([
                            'name' => trim($file->getArtist()),
                        ]);
                        ArtistHasSong::create([
                            'artist_id' => $newArtist->id,
                            'song_id' => $song->id
                        ]);
                    } else {
                        ArtistHasSong::create([
                            'artist_id' => $hasArtist->artist_id,
                            'song_id' => $song->id
                        ]);
                    }

                    //update album
                    if ($file->getAlbum() != null) {
                        if ($hasAlbum == null) {
                            $newAlbum = Album::create([
                                'name' => trim($file->getAlbum()),
                            ]);
                            $newSong = Song::find($song->id);
                            $newSong->album_id = $newAlbum->id;
                            $newSong->save();
                        } else {
                            $newSong = Song::find($song->id);
                            $newSong->album_id = $hasAlbum->id;
                            $newSong->save();
                        }
                    }
                }
            }

            if ($fileCount != 0) {
                $user->notify(new ActivityLog($user->id, $fileCount, $fileUploaded, '1', '1'));
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

            $hasAlbum = Song::leftJoin('albums', 'songs.album_id', '=', 'albums.id')
                ->where('songs.user_id', $user_id)
                ->where('albums.name', trim($data->album))
                ->first();


            //fixed bug thêm nhiều artist has song record
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
        // $album = Album::leftJoin('songs', 'albums.id', '=', 'songs.album_id')
        //     ->whereNull('songs.id')
        //     ->select('albums.id')
        //     ->delete();

        // dd($album);
    }

    public function testVue()
    {
        return Inertia::render('Test');
    }
}
