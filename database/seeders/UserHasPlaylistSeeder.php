<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserHasPlaylistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $userHasFavorite = [
            'user_id' => 1,
            'playlist_id' => 1,
            'created_at' => now(),
        ];

        DB::table('users_has_playlists')->insert($userHasFavorite);
    }
}
