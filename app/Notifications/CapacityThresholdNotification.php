<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CapacityThresholdNotification extends Notification
{
    use Queueable;

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

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Capacidad de agentes alcanzada en ' . $this->state)
                    ->line("La capacidad del servicio de agentes en {$this->state} ha alcanzado el {$this->usedPercentage}% de su total.")
                    ->line("({$this->assignedCompanies} de {$this->totalCapacity} compañías asignadas).")
                    ->action('Ver Detalles', url('/admin/agents-capacity'))
                    ->line('Por favor, toma las medidas necesarias.');
    }
}
