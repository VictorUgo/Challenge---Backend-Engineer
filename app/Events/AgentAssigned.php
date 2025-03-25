<?php

namespace App\Events;

use App\Models\Company;
use App\Models\RegisteredAgent;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AgentAssigned
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public Company $company;
    public RegisteredAgent $agent;

    public function __construct(Company $company, RegisteredAgent $agent)
    {
        $this->company = $company;
        $this->agent = $agent;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
