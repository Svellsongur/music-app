<?php

namespace App\Http\Middleware;

use App\Models\Song;
use Inertia\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        if ($request->user()) {


            $songs = Song::where('user_id', $request->user()->id)
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
        }
        return [
            ...parent::share($request),
            'auth' => [
                'logo' => asset('/storage/system/default_images/logo.jpg'),
                'user' => $request->user(),
                'user_avatar' => ($request->user() ? ($request->user()->avatar == null ? asset('/storage/system/default_images/default_avatar.jpg') : $request->user()->avatar) : null),
                'allSongs' => $request->user() ? $songs : null,
            ],
        ];
    }
}
