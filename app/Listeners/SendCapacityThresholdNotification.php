<?php

namespace App\Listeners;

use App\Events\CapacityThresholdReached;
use App\Notifications\CapacityThresholdNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendCapacityThresholdNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(CapacityThresholdReached $event)
    {
        // Notificar al admin a través de la ruta de correo
        Notification::route('mail', 'admin@bizee.test')
            ->notify(new CapacityThresholdNotification(
                $event->state,
                $event->totalCapacity,
                $event->assignedCompanies,
                $event->usedPercentage
            ));
    }
}
