<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return view('notifications', ['notifications' => auth()->user()->notifications]);
    }

    public function unread()
    {
        return auth()->user()->unreadNotifications;
    }
}
