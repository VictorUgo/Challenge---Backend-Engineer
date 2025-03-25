<?php

namespace App\Listeners;

use App\Events\AgentAssigned;
use App\Notifications\AgentAssignedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendAgentAssignedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(AgentAssigned $event)
    {
        // Notificar al agente asignado
        $event->agent->notify(new AgentAssignedNotification($event->company));
    }
}
