<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CapacityThresholdMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $state;
    public int $totalCapacity;
    public int $assignedCompanies;
    public float $usedPercentage;

    /**
     * Create a new message instance.
     */
    public function __construct(string $state, int $totalCapacity, int $assignedCompanies, float $usedPercentage)
    {
        $this->state = $state;
        $this->totalCapacity = $totalCapacity;
        $this->assignedCompanies = $assignedCompanies;
        $this->usedPercentage = $usedPercentage;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject("Capacidad alcanzada en el estado {$this->state}")
                    ->markdown('emails.capacity_threshold', [
                        'state' => $this->state,
                        'totalCapacity' => $this->totalCapacity,
                        'assignedCompanies' => $this->assignedCompanies,
                        'usedPercentage' => $this->usedPercentage,
                    ]);
    }
}
