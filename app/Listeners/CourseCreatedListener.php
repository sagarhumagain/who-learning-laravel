<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\CourseCreatedNotification;
use App\Notifications\WelcomeMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class CourseCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $admins =  User::whereHas('roles', function ($query) {
            $query->where('name', 'course-admin')->orWhere('name', 'super-admin');
        })->get();

        Notification::send($admins, new CourseCreatedNotification($event->course));
    }
}
