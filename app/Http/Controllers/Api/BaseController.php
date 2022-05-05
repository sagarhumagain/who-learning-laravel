<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function notifications(Request $request)
    {
        $user = $request->user();
        $data['notifications'] = $user->unreadnotifications;
        return $data;
    }

    public function read(Request $request)
    {
        $notification = auth()->user()->notifications->where('id', '=', $request->read_notification)->first();
        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function unread(Request $request)
    {
        $notification = auth()->user()->notifications->where('id', '=', $request->unread_notification)->first();
        if ($notification) {
            $notification->markAsUnread();
        }
    }

    public function readAll()
    {
        $notification = auth()->user()->notifications;
        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function filterArrayByKey($datas, $key)
    {
        if (!$datas) {
            return [];
        }
        $val =  [];
        foreach ($datas as $data) {
            array_push($val, $data[$key]);
        }
        return $val;
    }
}
