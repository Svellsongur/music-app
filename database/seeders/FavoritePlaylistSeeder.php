<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

class FavoritePlaylistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $favoritePlaylist = [
            'name' => 'Favorite',
            'created_at' => now(),
            'user_id' => 1
        ];

        DB::table('playlists')->insert($favoritePlaylist);
    }
}
