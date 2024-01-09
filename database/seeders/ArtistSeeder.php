<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $artist = [
            'name' => 'Yoasobi',
            'created_at' => now()
        ];

        $artistHasSong = [
            'artist_id' => 1,
            'song_id' => 1,
            'created_at' => now()
        ];

        DB::table('artists')->insert($artist);
        DB::table('artists_has_songs')->insert($artistHasSong);
    }
}
