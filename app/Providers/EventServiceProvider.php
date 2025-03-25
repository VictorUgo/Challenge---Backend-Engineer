<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\AgentAssigned;
use App\Listeners\SendAgentAssignedNotification;
use App\Events\CapacityThresholdReached;
use App\Listeners\SendCapacityThresholdNotification;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        AgentAssigned::class => [
            SendAgentAssignedNotification::class,
        ],
        CapacityThresholdReached::class => [
            SendCapacityThresholdNotification::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
