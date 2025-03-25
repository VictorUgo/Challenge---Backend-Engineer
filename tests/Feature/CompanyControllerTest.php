<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\RegisteredAgent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use App\Events\AgentAssigned;
use App\Events\CapacityThresholdReached;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Prueba que el endpoint index retorne una lista de compañías.
     */
    public function test_index_returns_companies()
    {
        // Creamos un usuario y una compañía asociada (usa tus factories)
        $user = User::factory()->create();
        Company::factory()->create([
            'user_id'               => $user->id,
            'name'                  => $user->name . "'s Company",
            'state'                 => 'CA',
            'registered_agent_type' => 'user',
            'registered_agent_id'   => $user->id,
        ]);

        // Realiza la petición GET a la ruta
        $response = $this->getJson('/companies');

        // Verifica que el status sea 200 y la estructura contenga un arreglo de compañías
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'companies' => [
                         '*' => [
                             'id', 'user_id', 'name', 'state', 'registered_agent_type', 'registered_agent_id', 'created_at', 'updated_at'
                         ]
                     ]
                 ]);
    }

    /**
     * Prueba que se cree una compañía y se dispare el evento AgentAssigned.
     */
    public function test_store_creates_company_and_fires_agent_assigned_event()
    {
        // Creamos un usuario y un agente registrado en el estado CA
        $user = User::factory()->create();
        $agent = RegisteredAgent::factory()->create([
            'state'    => 'CA',
            'capacity' => 10,
        ]);

        // Usamos Event::fake() para interceptar los eventos
        Event::fake();

        $payload = [
            'user_id'   => $user->id,
            'name'      => 'Test Company',
            'state'     => 'CA',
            'use_agent' => true,
        ];

        $response = $this->postJson('/companies', $payload);

        // Verifica que la respuesta sea 201 y tenga la estructura de compañía
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'company' => [
                         'id', 'user_id', 'name', 'state', 'registered_agent_type', 'registered_agent_id', 'created_at', 'updated_at'
                     ]
                 ]);

        // Verifica que el evento AgentAssigned se haya disparado
        Event::assertDispatched(AgentAssigned::class);
    }

    /**
     * Prueba que el endpoint updateAgent actualice correctamente la asignación.
     */
    public function test_update_agent_updates_company()
    {
        // Crea un usuario
        $user = User::factory()->create();

        // Crea una compañía con el usuario asignado inicialmente, pero sin agente registrado
        $company = Company::factory()->create([
            'user_id' => $user->id,
            'name'    => 'Empresa de Prueba',
            'state'   => 'CA',
            'registered_agent_type' => 'user',
            'registered_agent_id'   => null, // Se deja null para que no se excluya ningún agente
        ]);

        // Crea un RegisteredAgent para el estado CA
        $agent = RegisteredAgent::factory()->create([
            'state'    => 'CA',
            'capacity' => 10,
            'name'     => 'Agent Test',
            'email'    => 'agent@example.com',
        ]);

        // Envía la petición para actualizar la compañía a usar agente
        $payload = [
            'use_agent' => true,
        ];

        $response = $this->putJson("/companies/{$company->id}/agent", $payload);
        $response->assertStatus(200)
                 ->assertJsonPath('company.registered_agent_type', 'agent');
    }



    /**
     * Prueba que el endpoint checkCapacity retorne la estructura correcta.
     */
    public function test_check_capacity_returns_correct_structure()
    {
        // Creamos un agente registrado en el estado CA
        RegisteredAgent::factory()->create([
            'state'    => 'CA',
            'capacity' => 10,
        ]);

        $response = $this->getJson('/agents/capacity/CA');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'state', 'total_capacity', 'assigned_companies', 'available_capacity', 'used_percentage'
                 ]);
    }
}
