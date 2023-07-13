<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\CertificateApprovalNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class CertificateApprovalListener
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
        $user = User::where('id', $event->data->user_id)->first();

        Notification::send($user, new CertificateApprovalNotification($event->data));

    }
}