<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Notice;
use App\Models\User;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Company;

class AdminNotice extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Notice $notice)
    {
        $this->notice = $notice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        //$url = url('user/notification/'.$this->notice->user_id);

        return (new MailMessage)
                    ->greeting('Hello '.$this->name)
                    ->line($this->notice->title)
                    ->action('Check Notice', $url)
                    ->line('Check your notification area to see details!')
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
        return [
            //
        ];
    }


    public function toDatabase($notifiable)
    {
        return [
            'notice_id' => $this->notice->id,
            'notice_type' => $this->notice->type,
            'message' =>$this->notice->title,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'notice_id' => $this->notice->id,
            'notice_type' => $this->notice->type,
            'message' =>$this->notice->title,
        ]);
    }
}
