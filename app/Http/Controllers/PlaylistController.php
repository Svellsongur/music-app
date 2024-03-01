<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Playlist;
use Illuminate\Http\Request;
use App\Models\ArtistHasSong;
use App\Models\PlaylistHasSong;
use App\Notifications\ActivityLog;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Dd;

class PlaylistController extends Controller
{
    //
    public function index(Request $request)
    {
        $user_id = auth()->user()->id;
        $playlists = Playlist::where('user_id', $user_id)
            ->select('playlists.*')
            ->orderBy('playlists.name', 'asc')
            ->get();

        $favoritePlaylistKey = null;

        foreach ($playlists as $key => $playlist) {
            if ($playlist->name == "Favorite") {
                $favoritePlaylistKey = $key;
            }
        }

        if ($favoritePlaylistKey !== null) {
            $temp = $playlists[0];
            $playlists[0] = $playlists[$favoritePlaylistKey];
            $playlists[$favoritePlaylistKey] = $temp;
        }

        return Inertia::render('Dashboard', [
            'data' => [
                'playlists' => $playlists
            ],
            'message' => 'Success',
            'status' => 200
        ]);
    }

    public function detail(Request $request, string $id)
    {
        $songs = Playlist::where('playlists.id', $id)
            ->whereNotNull('playlists_has_songs.playlist_id')
            ->leftJoin('playlists_has_songs', 'playlists.id', '=', 'playlists_has_songs.playlist_id')
            ->leftJoin('songs', 'songs.id', '=', 'playlists_has_songs.song_id')
            ->leftJoin('albums', 'albums.id', '=', 'songs.album_id')
            ->select('songs.*', 'albums.name as album')
            ->orderBy('songs.name', 'asc')
            ->get();

        $playlists = Playlist::where('id', $id)->first();

        foreach ($songs as $song) {
            $song->song_path = asset($song->song_path);
            $song->artists = ArtistHasSong::where('song_id', $song->id)
                ->join('artists', 'artists.id', '=', 'artists_has_songs.artist_id')
                ->select('artists.name as artists')
                ->get();
        }

        $totalSongs = count($songs);

        // echo($songs);

        return Inertia::render('Dashboard', [
            'data' => [
                'songs' => $songs,
                'totalSongs' => $totalSongs,
                'layoutType' => 3,
                'playlist_id' => $id,
                'title' => 'Songs in ' . $playlists->name,
            ],
            'message' => 'Success',
            'status' => 200
        ]);
    }

    public function store(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $fileName = [];

        $playlist = Playlist::create([
            'name' => $request->name,
            'user_id' => $user->id
        ]);

        $playlists = Playlist::where('user_id', $user->id)
            ->select('playlists.*')
            ->orderBy('playlists.name', 'asc')
            ->get();

        array_push($fileName, $request->name);

        $user->notify(new ActivityLog($user->id, '0', $fileName, '2', '1'));

        return Inertia::render('Dashboard', [
            'data' => [
                'playlists' => $playlists
            ],
            'message' => 'Success',
            'status' => 200
        ]);
    }

    //add song to multiple playlist
    public function addSong(Request $request, string $song_id)
    {
        $songHasPlaylist = Playlist::where('user_id', auth()->user()->id)
            ->whereNotIn('id', function ($query) use ($song_id) {
                $query->select('playlist_id')
                    ->from('playlists_has_songs')
                    ->where('song_id', $song_id);
            })->get();

        if ($request->isMethod('POST')) {
            $playlists = $request->playlist_id;
            foreach ($playlists as $playlist) {
                PlaylistHasSong::create([
                    'playlist_id' => $playlist,
                    'song_id' => $song_id
                ]);
            }

            return Inertia::render('MainPages/AddSongToPlaylist', [
                'playlist' => $songHasPlaylist,
                'title' => 'Add to Playlists',
                'song_id' => $song_id
            ]);
        }

        return Inertia::render('MainPages/AddSongToPlaylist', [
            'playlist' => $songHasPlaylist,
            'title' => 'Add to Playlists',
            'song_id' => $song_id
        ]);
    }

    public function addSongToPlaylist(Request $request, string $id)
    {
        $playlist = Playlist::where('id', $id)->first();
        $songs = Song::where('user_id', auth()->user()->id)
            ->whereNotIn('id', function ($query) use ($id) {
                $query->select('song_id')
                    ->from('playlists_has_songs')
                    ->where('song_id', $id);
            })->get();

        if ($request->isMethod('POST')) {
            $songs = $request->song_id;
            foreach ($songs as $song) {
                PlaylistHasSong::create([
                    'playlist_id' => $id,
                    'song_id' => $song
                ]);
            }
        }

        return Inertia::render('MainPages/AddPlaylistToSong', [
            'songs' => $songs,
            'title' => 'Add to ' . $playlist->name,
            'playlist_id' => $id
        ]);
    }

    public function removeSong(string $playlistID, string $id)
    {
        PlaylistHasSong::where('playlist_id', $playlistID)
            ->where('song_id', $id)
            ->delete();
    }

    public function update(Request $request)
    {
    }

    public function destroy(Request $request, string $id)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $playlist = Playlist::where('id', $id)->first();
        $playlist->delete();
        PlaylistHasSong::where('playlist_id', $id)->delete();
        $fileName = [];
        array_push($fileName, $playlist->name);
        $user->notify(new ActivityLog($user->id, '0', $fileName, '2', '2'));
    }
}
