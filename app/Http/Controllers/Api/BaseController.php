<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BaseController extends Controller
{
    public function checkDirectoryExist()
    {
        //check folder
        if (!file_exists(public_path($this->folder_path))) {
            mkdir(public_path($this->folder_path));
        }
    }

    //check folder exits
    public function checkFolderExist($path)
    {
        if (!file_exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
            File::makeDirectory($path . '/thumbs', $mode = 0777, true, true);
        }
    }
    //rename directory if already exists
    public function renameDirectory($old_dir, $new_dir)
    {
        rename($old_dir, $new_dir);
    }

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
