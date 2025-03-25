<?php

namespace App\Mail;

use App\Models\Company;
use App\Models\RegisteredAgent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AgentAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Company $company;
    public RegisteredAgent $agent;

    /**
     * Create a new message instance.
     */
    public function __construct(Company $company, RegisteredAgent $agent)
    {
        $this->company = $company;
        $this->agent = $agent;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Nueva asignación de compañía')
                    ->markdown('emails.agent_assigned', [
                        'company' => $this->company,
                        'agent'   => $this->agent,
                    ]);
    }

}
