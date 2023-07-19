<?php

namespace App\Notifications;

use App\Models\Course;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Request;

class CertificateUpdateNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $user = User::find($this->data['user_id']);
        $course = Course::find($this->data['course_id']);
        $message = 'Certificate for '.$course->name.' has been updated by '.$user->name.'.';
        $link = Request::root().'/'.'approve/certificate/user_id/'.$this->data['user_id'].'/course_id/'.$this->data['course_id'];

        return [

            'title' => 'Course Completed',
            'excerpt' => $message,
            'link' => $link
        ];
    }
}
