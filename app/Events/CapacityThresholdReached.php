<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CapacityThresholdReached
{
    use Dispatchable, SerializesModels;

    public string $state;
    public int $totalCapacity;
    public int $assignedCompanies;
    public float $usedPercentage;

    public function __construct(string $state, int $totalCapacity, int $assignedCompanies, float $usedPercentage)
    {
        $this->state = $state;
        $this->totalCapacity = $totalCapacity;
        $this->assignedCompanies = $assignedCompanies;
        $this->usedPercentage = $usedPercentage;
    }
}
