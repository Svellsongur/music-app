<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\SongController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\RecycleBinController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'), //Phương thức has để hiển thị nút login nếu có route này
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);
    return redirect('/login');
});

Route::get('/songs', [SongController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Songs
    Route::match(['GET', 'POST'], '/songs/add', [SongController::class, 'store'])->name('songs.add');
    Route::match(['GET', 'POST'], '/songs/update/{id}', [SongController::class, 'update'])->name('songs.update');
    Route::delete('/songs/delete/{id}', [SongController::class, 'destroy'])->name('songs.delete');

    //Playlists
    Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlists');
    Route::get('/playlists/detail/{id}', [PlaylistController::class, 'detail'])->name('playlists.detail');
    Route::post('/playlists/add', [PlaylistController::class, 'store'])->name('playlist.add');
    Route::delete('/playlists/delete/{id}', [PlaylistController::class, 'destroy'])->name('playlist.delete');
    Route::get('/playlists/add-song/{id}', [PlaylistController::class, 'addSong'])->name('playlist.add-song');
    Route::post('/playlists/add-song/{id}', [PlaylistController::class, 'addSong']);
    Route::match(['GET', 'POST'],'/playlists/add-songs-to-playlist/{id}', [PlaylistController::class, 'addSongToPlaylist'])->name('playlist.add-songs-to-playlist');
    Route::delete('/playlists/remove-song/{playlistID}/{id}', [PlaylistController::class, 'removeSong'])->name('playlist.remove-song');

    //Albums
    Route::get('/albums', [AlbumController::class, 'index'])->name('albums');
    Route::get('/albums/detail/{id}', [AlbumController::class, 'detail'])->name('albums.detail');

    //Artists
    Route::get('/artists', [ArtistController::class, 'index'])->name('artists');
    Route::get('/artists/detail/{id}', [ArtistController::class, 'detail'])->name('artists.detail');

    //Recycle Bin
    Route::get('/recycle-bin', [RecycleBinController::class, 'index'])->name('recycle-bin');
    Route::get('/recycle-bin/detail/{id}', [RecycleBinController::class, 'detail'])->name('recycle-bin.detail');
    Route::post('/recycle-bin/restore/{id}', [RecycleBinController::class, 'restore'])->name('recycle-bin.restore');
    Route::post('/recycle-bin/restore-all', [RecycleBinController::class, 'restoreAll'])->name('recycle-bin.restore-all');
    Route::delete('/recycle-bin/delete/{id}', [RecycleBinController::class, 'delete'])->name('recycle-bin.delete');
    Route::delete('/recycle-bin/delete-all', [RecycleBinController::class, 'deleteAll'])->name('recycle-bin.delete-all');

    //Activity Log
    Route::get('/activity-log', [ActivityController::class, 'index'])->name('activity-log');
    Route::get('/activity-log/mark-all-as-read', [ActivityController::class, 'markAllAsRead'])->name('activity-log.mark-all-as-read');
});

Route::match(['get', 'post'], '/test', [SongController::class, 'check'])->name('test');
Route::match(['get', 'post'], '/test/vue', [SongController::class, 'testVue'])->name('test-vue');

require __DIR__ . '/auth.php';
