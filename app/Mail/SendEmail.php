<?php

namespace App\Mail;

use App\Services\UtilityHelper\UtilityHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailData;

    /**
     * Create a new message instance.
     * @param $emailData
     */
    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.send_email',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        $email = $this->view('emails.send_email') // Шаблон письма
        ->subject($this->emailData['subject'])
            ->with([
                'subject' => $this->emailData['subject'],
                'textEmail' => $this->emailData['textEmail'],
                'signature' => $this->emailData['signature'],
            ]);

        // Добавление вложения, если есть
        if ($this->emailData['file'] === true) {
            $fileCheck = UtilityHelper::getFilePDF($this->emailData['check']);
            $filePath = preg_replace('/[\/:*?"<>|]/', '_', $fileCheck['name'] . '.pdf');
            $email->attach(Storage::path($filePath));
        }

        // Добавление логотипа, если есть
        if (file_exists(Storage::path('public/icon/Logo.jpg'))) {
            $email->attach(Storage::path('public/icon/Logo.jpg'), [
                'as' => 'Logo.jpg',
                'mime' => 'image/jpeg',
            ]);
        }

        return $email;
    }
}
