<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $subject;
    public $content;

    public function __construct($subject, $content)
    {
        $this->subject = $subject;
        $this->content = $content;
         Log::info($this->subject);
        Log::info($this->content);

    }

    public function via(object $notifiable): array
    {
        return ['mail'];
        // return ['mail', 'database'];
    }


    public function toMail(object $notifiable): MailMessage
    {
        // Prepare the data to pass to the view
        $recipientName = $notifiable->name ?? $notifiable->users->name;

        $actionUrl = route('notification');

        return (new MailMessage)
            ->subject($this->subject)
            ->view('backend.layouts.notification.mailTemplate', [
                'subject' => $this->subject,
                'content' => $this->content,
                'recipientName' => $recipientName,
                'actionUrl' => $actionUrl,
            ]);
    }

  /*   public function toDatabase(object $notifiable): array
    {
        return [
            'subject' => $this->subject,
            'content' => $this->content,
            'url' => route('notification'),
        ];
    }

    public function toArray(object $notifiable): array
    {
        // Same structure for database and array
        return $this->toDatabase($notifiable);
    } */
}
