<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->notifications()->paginate();
    }

    public function getNewNotifications(Request $request)
    {
        return $request->user()->unreadNotifications;
    }

    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();
        return ['message' => 'All notifications marked as read'];
    }

    public function markAsRead($id, Request $request)
    {
        $request->user()->unreadNotifications()->find($id)->markAsRead();
        return ['message' => 'Notification marked as read'];
    }

    public function destroy($id, Request $request)
    {
        $request->user()->notifications()->find($id)->delete();
        return ['message' => 'Notification has been deleted'];
    }

    public function destroyAll(Request $request)
    {
        $request->user()->notifications()->delete();
        return ['message' => 'All notification has been deleted'];
    }
}
