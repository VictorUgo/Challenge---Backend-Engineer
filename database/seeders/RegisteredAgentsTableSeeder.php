<?php

namespace Database\Seeders;

use App\Models\RegisteredAgent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegisteredAgentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Crear 2 agentes para California (CA)
        RegisteredAgent::create([
            'state' => 'CA',
            'name' => 'Agente CA 1',
            'email' => 'agent_ca1@example.com',
            'capacity' => rand(5, 15),
        ]);
        RegisteredAgent::create([
            'state' => 'CA',
            'name' => 'Agente CA 2',
            'email' => 'agent_ca2@example.com',
            'capacity' => rand(5, 15),
        ]);

        // Crear 2 agentes para Texas (TX)
        RegisteredAgent::create([
            'state' => 'TX',
            'name' => 'Agente TX 1',
            'email' => 'agent_tx1@example.com',
            'capacity' => rand(5, 15),
        ]);
        RegisteredAgent::create([
            'state' => 'TX',
            'name' => 'Agente TX 2',
            'email' => 'agent_tx2@example.com',
            'capacity' => rand(5, 15),
        ]);

        // Crear 1 agente por cada uno de los otros estados, excepto Illinois (IL)
        $states = ['AL', 'AK', 'AZ', 'AR', 'CO', 'CT', 'DE', 'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY'];

        foreach ($states as $state) {
            if (in_array($state, ['CA', 'TX', 'IL'])) {
                continue; // Saltar CA, TX y IL (sin agente)
            }
            RegisteredAgent::create([
                'state' => $state,
                'name' => 'Agente ' . $state,
                'email' => 'agent_' . strtolower($state) . '@example.com',
                'capacity' => rand(5, 15),
            ]);
        }
    }
}
