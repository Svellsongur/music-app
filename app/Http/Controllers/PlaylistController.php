<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // dd($songs);
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
    }

    public function store(Request $request)
    {
        $user_id = auth()->user()->id;

        Playlist::create([
            'name' => $request->name,
            'user_id' => $user_id
        ]);

        $playlists = Playlist::where('user_id', $user_id)
            ->select('playlists.*')
            ->orderBy('playlists.name', 'asc')
            ->get();
        // dd($songs);
        return Inertia::render('Dashboard', [
            'data' => [
                'playlists' => $playlists
            ],
            'message' => 'Success',
            'status' => 200
        ]);
    }

    public function update(Request $request)
    {
    }

    public function destroy(Request $request)
    {
    }
}
