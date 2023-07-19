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
        $url = url('/courses/'.$this->course_assignment_setting['id'].'/edit');

        return (new MailMessage())
                    ->line('Course Assignment and Deadline')
                    ->line('We are pleased to inform you that you have been assigned a new course to complete within a specified deadline. Please review the details below:')
                    ->line('Course Name: '.$this->course_assignment_setting['course_name'])
                    ->line('Course Deadline: '.$this->course_assignment_setting['due_date'])
                    ->action('Notification Action', $url)
                    ->line('Thank you!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $assigned_pillar_name  = $this->course_assignment_setting['assigned_pillar_name'] ? 'Pillar '.implode(' , ', $this->course_assignment_setting['assigned_pillar_name']) : '';
        $assigned_contract_type_name  = $this->course_assignment_setting['assigned_contract_type_name'] ? 'contract type '. implode(' , ', $this->course_assignment_setting['assigned_contract_type_name']) : '';
        $assigned_staff_type_name  = $this->course_assignment_setting['assigned_staff_type_name'] ? 'staff type '. implode(' , ', $this->course_assignment_setting['assigned_staff_type_name']) : '';
        $assigned_staff_designation_name  = $this->course_assignment_setting['assigned_staff_designation_name'] ? 'staff designation '. implode(' , ', $this->course_assignment_setting['assigned_staff_designation_name']) : '';

        $message = 'New Course '.$this->course_assignment_setting['course_name'].' has been assigned by '.auth()->user()->name.' to ';
        if($assigned_pillar_name) {
            $message = $message . $assigned_pillar_name . ' ,';
        }if ($assigned_contract_type_name) {
            $message = $message . $assigned_contract_type_name . ' ,';
        }if ($assigned_staff_type_name) {
            $message = $message . $assigned_staff_type_name . ' ,';
        }if ($assigned_staff_designation_name) {
            $message = $message . $assigned_staff_designation_name . '.';
        }

        return [
            'title' => 'New Course Assigned',
            'excerpt' => $message,
            'link' => '/courses/'.$this->course_assignment_setting['id'].'/edit',
        ];
    }
}
