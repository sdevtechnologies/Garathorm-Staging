<?php

namespace App\Notifications;

use App\Models\IndustryReference;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IndustryNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected IndustryReference $industry;
    protected string $action;

    public function __construct(IndustryReference $industry,string $action)
    {
        //
        $this->industry = $industry;
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
            return (new MailMessage)->subject('New Submission: Industry References and Best Practices')
                ->markdown('mail.industry.notification_all',['industry'=>$this->industry,'user'=> $notifiable]);
        }elseif($this->action=='save_notify_admin'){
            return (new MailMessage)->subject('New Submission: Industry References and Best Practices')
            ->markdown('mail.industry.notification_admin',['industry'=>$this->industry,'user'=> $notifiable]);
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
