<?php

namespace App\Mail;

use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookStockOutMail extends Mailable
{
    use Queueable, SerializesModels;

    public Book $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Stock agotado: ' . $this->book->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.book-stock-out',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
