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
        if ($this->case->status == 'Aceptado') {
            return (new MailMessage)
                ->subject('Tu caso ha sido aceptado')
                ->view('emails.case-reviewed',
                [   'case'=>$this->case,
                    'user'=>$notifiable,
                    'caseUrl'=>route('cases.show',$this->case->id),
                ]);
        }
        else{
            return (new MailMessage)
                ->subject('Tu caso ha sido rechazado')
                ->view('emails.case-reviewed',
                    [   'case'=>$this->case,
                        'user'=>$notifiable,
                        'caseUrl'=>route('cases.show',$this->case->id),
                    ]);
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
