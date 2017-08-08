<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Mail\Markdown;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $introLine = 'You are receiving this email because we received a password reset request for your account.';
        $actionText = 'Reset Password';
        $actionUrl = route('password.reset', $this->token);
        $outroLine = 'If you did not request a password reset, no further action is required.';

        return (new MailMessage)
            ->markdown('emails.auth.password_reset', compact('introLine', 'actionText', 'actionUrl', 'outroLine'));
    }
}
