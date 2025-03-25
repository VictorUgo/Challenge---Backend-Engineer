<?php

namespace App\Notifications;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AgentAssignedNotification extends Notification
{
    use Queueable;

    protected Company $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Nueva asignación de compañía')
                    ->line('Has sido asignado a una nueva compañía.')
                    ->line('Nombre: ' . $this->company->name)
                    ->line('Estado: ' . $this->company->state)
                    ->action('Ver detalles', url('/companies/' . $this->company->id))
                    ->line('¡Gracias por usar nuestro servicio!');
    }
}
