<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $data) {}

    public function build(): static
    {
        return $this->subject('New contact message: '.($this->data['subject'] ?? 'No subject'))
            ->html(
                '<h2>New message from '.e($this->data['name']).'</h2>'.
                '<p><strong>Email:</strong> '.e($this->data['email']).'</p>'.
                '<p><strong>Message:</strong></p><p>'.nl2br(e($this->data['message'])).'</p>'
            );
    }
}
