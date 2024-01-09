<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasPlaylist extends Model
{
    use HasFactory;

    protected $table = ['users_has_playlists'];

    protected $fillable = [
        'user_id',
        'playlist_id'
    ];
}
