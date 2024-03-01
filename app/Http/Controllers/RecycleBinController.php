<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Song;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Album;
use App\Models\Artist;
use Termwind\Components\Dd;
use Illuminate\Http\Request;
use App\Models\ArtistHasSong;
use App\Models\PlaylistHasSong;
use App\Notifications\ActivityLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class RecycleBinController extends Controller
{
    //
    public function index()
    {
        $user_id = auth()->user()->id;
        $trashedSongs = Song::where('user_id', $user_id)
            ->onlyTrashed()
            ->leftJoin('albums', 'albums.id', '=', 'songs.album_id')
            ->select('songs.*', 'albums.name as album')
            ->get();

        foreach ($trashedSongs as $song) {
            $song->song_path = asset($song->song_path);
            $song->artists = DB::table('artists_has_songs')
                ->where('song_id', $song->id)
                ->join('artists', 'artists.id', '=', 'artists_has_songs.artist_id')
                ->select('artists.name as artists')
                ->get();
            $song->deleted_at->format('d-m-Y H:i:s');
        }

        $totalDeletedSongs = count($trashedSongs);

        return Inertia::render('Profile/RecycleBin', [
            'trashedSongs' => $trashedSongs,
            'totalDeletedSongs' => $totalDeletedSongs
        ]);
    }

    public function detail(Request $request, string $id)
    {
        $trashedSong = Song::onlyTrashed()
            ->where('songs.id', $id)
            ->leftJoin('albums', 'albums.id', '=', 'songs.album_id')
            ->select('songs.*', 'songs.created_at as created_at', 'songs.deleted_at as deleted_at', 'albums.name as album')
            ->first();

        $trashedSong->song_path = asset($trashedSong->song_path);

        $trashedSong->artists = DB::table('artists_has_songs')
            ->where('song_id', $trashedSong->id)
            ->join('artists', 'artists.id', '=', 'artists_has_songs.artist_id')
            ->select('artists.name as artists')
            ->get();

        $trashedSong->created_at->format('d-m-Y H:i:s');
        $trashedSong->deleted_at->format('d-m-Y H:i:s');

        // dd($trashedSong);

        return Inertia::render('Profile/Partials/RecycleBinDetail', [
            'data' => [
                'song' => $trashedSong
            ],
            'message' => 'Success',
            'status' => 200
        ]);
    }

    public function restore(Request $request, string $id)
    {
        $user_id = auth()->user()->id;
        $trashedSong = Song::onlyTrashed()
            ->where('songs.id', $id)
            ->where('user_id', $user_id)
            ->restore();

        return Redirect::route('recycle-bin');
    }

    public function delete(Request $request, string $id)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $trashedSong = Song::onlyTrashed()
            ->where('songs.id', $id)
            ->where('user_id', $user->id)
            ->first();
        $fileName = [];

        $dlted = unlink($trashedSong->song_path);
        if ($dlted) {
            $trashedSong->forceDelete();

            $dltedDHS = PlaylistHasSong::where('song_id', $trashedSong->id);
            if ($dltedDHS) {
                $dltedDHS->delete();
            }
            $dltedAHS = ArtistHasSong::where('song_id', $trashedSong->id)->delete();
            if ($dltedAHS) {
                Artist::leftJoin('artists_has_songs', 'artists.id', '=', 'artists_has_songs.artist_id')
                    ->whereNull('artists_has_songs.artist_id')
                    ->delete();
            }

            Album::leftJoin('songs', 'albums.id', '=', 'songs.album_id')
                ->whereNull('songs.id')
                ->select('albums.id')
                ->delete();

            array_push($fileName, $trashedSong->name);
        }
        $user->notify(new ActivityLog($user->id, '1', $fileName, '1', '2'));
        return Redirect::route('recycle-bin');
    }

    public function deleteAll(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $fileCount = 0;
        $fileDeleted = [];

        $trashedSongs = Song::onlyTrashed()
            ->where('user_id', $user->id)
            ->get();

        foreach ($trashedSongs as $song) {
            $dlted = unlink($song->song_path);
            if ($dlted) {
                $song->forceDelete();
                $fileCount++;
                array_push($fileDeleted, $song->name);
            }
        }

        $user->notify(new ActivityLog($user->id, $fileCount, $fileDeleted, '1', '2'));
        return Redirect::route('recycle-bin');
    }

    public function restoreAll(Request $request)
    {
        $user_id = auth()->user()->id;
        $trashedSongs = Song::onlyTrashed()
            ->where('user_id', $user_id)
            ->restore();

        return Redirect::route('recycle-bin');
    }
}
