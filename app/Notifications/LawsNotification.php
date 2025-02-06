<?php

namespace App\Notifications;

use App\Models\LawsFrameworkTb;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LawsNotification extends Notification
{
    use Queueable;

    protected LawsFrameworkTb $law;
    protected string $action;

    /**
     * Create a new notification instance.
     */
    public function __construct(LawsFrameworkTb $law,string $action)
    {
        //
        $this->law = $law;
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
            return (new MailMessage)->subject('New Submission: Laws and Frameworks')
                ->markdown('mail.laws.notification_all',['law'=>$this->law,'user'=> $notifiable]);
        }elseif($this->action=='save_notify_admin'){
            return (new MailMessage)->subject('New Submission: Laws and Frameworks')
            ->markdown('mail.laws.notification_admin',['law'=>$this->law,'user'=> $notifiable]);
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
