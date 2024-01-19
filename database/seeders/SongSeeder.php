<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $song = [
            'name' => 'Yoru ni Kakeru',
            'album_id' => 1,
            'song_path' => 'storage/user/1/songs/YOASOBI「夜に駆ける」 Official Music Video.mp3',
            'length' => '00:04:22',
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('songs')->insert($song);
    }
}
