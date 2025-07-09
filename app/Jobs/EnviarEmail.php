<?php

namespace App\Jobs;

use App\Mail\ConteudoEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Mail;

class EnviarEmail implements ShouldQueue
{
    use Queueable;

    public $data;
    public $userId;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data['tarefa']; 
        $this->userId = $data['user_id'];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        try {
            $emailData = [
                'userId' => $this->userId,
                'tarefa' => $this->data,
            ];

            Mail::to('email@example.com')->send(new ConteudoEmail($emailData));
        } catch (\Exception $e) {
            \Log::error("Erro ao enviar e-mail: " . $e->getMessage());
            throw $e;
        }
    }
}
