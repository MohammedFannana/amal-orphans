<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\Sponsorship;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SponsorshipEndingSoon extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $sponsorship;

    protected $message;

    public function __construct(Sponsorship $sponsorship, string $message)
    {
        $this->sponsorship = $sponsorship;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'تنبيه: قرب انتهاء كفالة',
            'message' => $this->message,
            'sponsorship_id' => $this->sponsorship->id,
            'orphan_id' => $this->sponsorship->orphan->id,
            'status' => 'active',
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //         ->line('The introduction to the notification.')
    //         ->action('Notification Action', url('/'))
    //         ->line('Thank you for using our application!');
    // }

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
