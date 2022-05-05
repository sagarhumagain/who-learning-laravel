<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CourseAssignedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($course_assignment_setting)
    {
        $this->course_assignment_setting = $course_assignment_setting;
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
        return (new MailMessage)
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
        dd($this->course_assignment_setting['assigned_pillar_name']);
        $assigned_pillar_name  = $this->course_assignment_setting['assigned_pillar_name'] ?  'pillar'.implode(' , ', $this->course_assignment_setting['assigned_pillar_name']) : '';
        $assigned_contract_type_name  = $this->course_assignment_setting['assigned_contract_type_name'] ? implode(' , ', $this->course_assignment_setting['assigned_contract_type_name']) : '';
        $assigned_staff_type_name  = $this->course_assignment_setting['assigned_staff_type_name'] ? implode(' , ', $this->course_assignment_setting['assigned_staff_type_name']) : '';
        $assigned_staff_designation_name  = $this->course_assignment_setting['assigned_staff_designation_name'] ? implode(' , ', $this->course_assignment_setting['assigned_staff_designation_name']) : '';
        dd($assigned_pillar_name);

        return [
            'title' => 'New Course Assigned',
            'excerpt' => '',
        ];
    }
}
