<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
}
