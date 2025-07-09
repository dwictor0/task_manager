<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConteudoEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $tarefa;
    public $userId;

    /**
     * Create a new message instance.
     *
     * @param $data
     * @return void
     */
    public function __construct($emailData)
    {
        $this->tarefa = $emailData['tarefa'];
        $this->userId = $emailData['userId'];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Gerenciamento de Tarefas',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.alerta',  // Aqui define o nome da view
            with: [
                'tarefa' => $this->tarefa,   // Passando a tarefa para a view
                'userId' => $this->userId,   // Passando o userId para a view
            ]        
        );
    }

    /**
     * Summary of attachments
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}
