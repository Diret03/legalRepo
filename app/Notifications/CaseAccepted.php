<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;


class CaseAccepted extends Notification
{
    use Queueable;

    private $case;

    public function __construct($case)
    {
        $this->case = $case;

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

        return (new MailMessage)->view(
            'emails.case-accepted',
            ['case'=>$this->case,
                'user'=>$notifiable,
                'caseUrl'=>route('cases.show',$this->case->id),
            ],
        );
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
