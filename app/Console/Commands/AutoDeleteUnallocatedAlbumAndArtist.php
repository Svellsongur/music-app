<?php

namespace App\Console\Commands;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Console\Command;

class AutoDeleteUnallocatedAlbumAndArtist extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-delete-unallocated-album-and-artist';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $unallocatedAlbum = Album::leftJoin('songs', 'albums.id', '=', 'songs.album_id')
            ->where('songs.id', '=', null)
            ->where('albums.updated_at', '<=', now()->subDays(3))
            ->orWhere('albums.updated_at', '=', null)
            ->select('songs.*', 'albums.id as album_id')
            ->forceDelete();

        $unallocatedArtist = Artist::leftJoin('artists_has_songs', 'artists.id', '=', 'artists_has_songs.artist_id')
            ->leftJoin('songs', 'songs.id', '=', 'artists_has_songs.song_id')
            ->where('songs.id', '=', null)
            ->where('artists.updated_at', '<=', now()->subDays(3))
            ->orWhere('artists.updated_at', '=', null)
            ->select('songs.*', 'artists.id as artist_id')
            ->forceDelete();
    }
}
