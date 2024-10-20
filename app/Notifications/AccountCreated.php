<?php

namespace App\Notifications;

use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Password;

class AccountCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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

//         $token = (new \Illuminate\Auth\Passwords\PasswordBroker)->createToken($notifiable);
        $token = Password::createToken($notifiable);
        $resetUrl = route('password.reset', ['token' => $token, 'email' => $notifiable->email]);

        return (new MailMessage)
            ->subject('Cuenta creada')
            ->view('emails.account-created',
                [
                    'user'=>$notifiable,
                    'loginUrl'=>route('login'),
                    'resetUrl'=>$resetUrl,
                ]);
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
