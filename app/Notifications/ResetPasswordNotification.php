<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly string $token
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        $expire = (int) config('auth.passwords.users.expire', 60);

        return (new MailMessage)
            ->subject('Reset Password Akun Anda')
            ->view('emails.auth.reset-password', [
                'nama' => $notifiable->nama ?? $notifiable->username ?? 'Pengguna',
                'email' => $notifiable->getEmailForPasswordReset(),
                'resetUrl' => $resetUrl,
                'expire' => $expire,
                'appName' => config('app.name'),
            ]);
    }
}
