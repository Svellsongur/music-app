<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SongController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'), //Phương thức has để hiển thị nút login nếu có route này
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/songs', [SongController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::match(['GET','POST'], '/songs/add', [SongController::class, 'store'])->name('songs.add');
    Route::match(['GET','POST'], '/songs/update', [SongController::class, 'update'])->name('songs.add');
    Route::delete('/songs/delete', [SongController::class, 'destroy'])->name('songs.delete');

    Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlists');

    Route::get('/albums', [AlbumController::class, 'index'])->name('albums');

    Route::get('/artists', [ArtistController::class, 'index'])->name('artists');
});

Route::match(['get', 'post'], '/test', [SongController::class, 'check'])->name('test');

require __DIR__.'/auth.php';
