<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailVerification extends Notification
{
    use Queueable;

    protected $verificationUrl;
    protected $userName;

    public function __construct($verificationUrl, $userName)
    {
        $this->verificationUrl = $verificationUrl;
        $this->userName = $userName;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Verifikasi Email Anda')
            ->greeting('Halo, ' . $this->userName . ' 👋')
            ->line('Terima kasih telah mendaftar. Silakan verifikasi email Anda dengan menekan tombol di bawah ini.')
            ->action('Verifikasi Sekarang', $this->verificationUrl)
            ->line('Jika Anda tidak membuat akun ini, abaikan saja email ini.');
    }
}
