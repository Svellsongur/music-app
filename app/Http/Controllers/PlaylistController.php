<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlaylistController extends Controller
{
    //
    public function index(Request $request)
    {
        $user_id = auth()->user()->id;
        $playlists = DB::table('playlists')
            ->where('user_id', $user_id)
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
