<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistHasSong extends Model
{
    use HasFactory;

    protected $table = 'artists_has_songs';

    protected $fillable = [
        'artist_id',
        'song_id'
    ];
}
