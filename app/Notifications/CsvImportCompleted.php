<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CsvImportCompleted extends Notification
{
    use Queueable;

    public $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)->subject('Csv file import results');

        if (count($this->errors) > 0) {
            $mail->line('Errors ocurred during the csv file import: ');
            foreach ($this->errors as $error) {
                $mail->line(" - $error");
            }
        } else {
            $mail->line('No errors ocurred during the csv file import.');
        }

        return $mail;
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
