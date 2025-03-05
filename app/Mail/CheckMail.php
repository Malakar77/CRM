<?php

namespace App\Mail;

use App\Services\UtilityHelper\UtilityHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CheckMail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailData;

    /**
     * Create a new message instance.
     */
    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: Auth::user()->login,
            to: $this->emailData['emailCompany'],
            subject: $this->emailData['subject'], // Отправитель
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $post = $this->post(Auth::user()->dolzhost);

        return new Content(
            view: 'emails.check_email', // Шаблон письма
            with: [
                'body' => nl2br($this->emailData['textEmail']),
                'signature' => Auth::user()->signature,
                'subject' => $this->emailData['subject'],
                'manager' => Auth::user()->name,
                'post' => $post->name,
                'phone' => Auth::user()->mobile,
                'email' => Auth::user()->login,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        $attachments = [];

        // Добавление вложений, если есть файл
        if ($this->emailData['file'] === true) {
            $fileCheck = UtilityHelper::getFilePDF($this->emailData['check']);
            $filePath = preg_replace('/[\/:*?"<>|]/', '_', $fileCheck['name'] . '.pdf');
            $attachments[] = \Illuminate\Mail\Mailables\Attachment::fromStorage($filePath);
        }

        // Добавление логотипа, если он существует
        if (file_exists(Storage::path('public/icon/Logo.jpg'))) {
            $attachments[] = \Illuminate\Mail\Mailables\Attachment::fromStorage('public/icon/Logo.jpg')
                ->as('logo.jpg')
                ->withMime('image/jpeg');
        }

        return $attachments;
    }

    public function post($id)
    {
        return DB::table('post_youth')
            ->select('post_youth.name')
            ->where('post_youth.id', $id)
            ->first();
    }
}
