<?php

namespace App\Notifications;

use App\Models\IncidentAnnouncement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IncidentNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected IncidentAnnouncement $incident;
    protected string $action;
    public function __construct(IncidentAnnouncement $incident, string $action)
    {
        //
        $this->incident= $incident;
        $this->action = $action;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        if ($this->action=='save_notify_all'){
            return (new MailMessage)->subject('New Submission: Incidents and Announcements')
                ->markdown('mail.incident.notification_all',['incident'=>$this->incident,'user'=> $notifiable]);
        }elseif($this->action=='save_notify_admin'){
            return (new MailMessage)->subject('New Submission: Incidents and Announcements')
            ->markdown('mail.incident.notification_admin',['incident'=>$this->incident,'user'=> $notifiable]);
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
