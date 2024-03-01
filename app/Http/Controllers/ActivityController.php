<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Termwind\Components\Dd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ActivityController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $activity = $user->notifications()->get();

        $groupedNotifications = $activity->groupBy(function ($item) {
            return $item->created_at->toDateString();
        })->toArray();
        // dd($groupedNotifications);
        return Inertia::render('Profile/ActivityLog', [
            'data' => $groupedNotifications
        ]);
    }

    public function markAllAsRead()
    {
        foreach (auth()->user()->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
        return Redirect::back();
    }
}
