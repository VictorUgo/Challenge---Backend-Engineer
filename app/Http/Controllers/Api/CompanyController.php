<?php

namespace App\Http\Controllers\Api;

use App\Events\AgentAssigned;
use App\Events\CapacityThresholdReached;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\RegisteredAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{

    // Método para listar compañías
    public function index()
    {
        $companies = Company::all();
        return response()->json(['companies' => $companies]);
    }

    public function show($id)
    {
        $company = Company::find($id);
        if (!$company) {
            return response()->json(['error' => 'Compañía no encontrada'], 404);
        }
        return response()->json(['company' => $company]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'   => 'required|exists:users,id',
            'name'      => 'required|string',
            'state'     => 'required|string|size:2',
            'use_agent' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $company = new Company();
        $company->user_id = $data['user_id'];
        $company->name = $data['name'];
        $company->state = strtoupper($data['state']);

        if (!$data['use_agent']) {
            $company->registered_agent_type = 'user';
            $company->registered_agent_id = $data['user_id'];
        } else {
            $agent = $this->selectAgentForState($data['state']);
            if (!$agent) {
                return response()->json(['error' => 'No hay agentes disponibles en este estado'], 422);
            }
            $company->registered_agent_type = 'agent';
            $company->registered_agent_id = $agent->id;
        }

        $company->save();

        // Si se usó el servicio de agente, disparar el evento para notificar al agente
        if ($data['use_agent'] && isset($agent)) {
            event(new AgentAssigned($company, $agent));

            // Verificar la capacidad para el estado
            $totalCapacity = RegisteredAgent::where('state', $company->state)->sum('capacity');
            $assignedCompanies = Company::where('state', $company->state)
                ->where('registered_agent_type', 'agent')
                ->count();
            $usedPercentage = ($assignedCompanies / $totalCapacity) * 100;

            if ($usedPercentage >= 90) {
                event(new CapacityThresholdReached($company->state, $totalCapacity, $assignedCompanies, $usedPercentage));
            }
        }

        return response()->json(['company' => $company], 201);
    }

    // Actualizar el agente registrado de una compañía
    public function updateAgent(Request $request, $id)
    {
        $company = Company::find($id);
        if (!$company) {
            return response()->json(['error' => 'Compañía no encontrada'], 404);
        }

        $validator = Validator::make($request->all(), [
            'use_agent' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        if (!$data['use_agent']) {
            // Asignar el usuario como agente
            $company->registered_agent_type = 'user';
            $company->registered_agent_id = $company->user_id;
        } else {
            // Reasignar a un agente disponible
            $agent = $this->selectAgentForState($company->state, $excludeId = $company->registered_agent_id);
            if (!$agent) {
                return response()->json(['error' => 'No hay agentes disponibles en este estado'], 422);
            }
            $company->registered_agent_type = 'agent';
            $company->registered_agent_id = $agent->id;
        }

        $company->save();

        return response()->json(['company' => $company], 200);
    }

    // Consultar la capacidad disponible en un estado
    public function checkCapacity($state)
    {
        $state = strtoupper($state);
        $agents = RegisteredAgent::where('state', $state)->get();
        if ($agents->isEmpty()) {
            return response()->json(['error' => 'No hay agentes disponibles en este estado'], 404);
        }

        $totalCapacity = $agents->sum('capacity');
        $assignedCompanies = Company::where('state', $state)
            ->where('registered_agent_type', 'agent')
            ->count();
        $available = $totalCapacity - $assignedCompanies;
        $usedPercentage = ($assignedCompanies / $totalCapacity) * 100;

        return response()->json([
            'state'               => $state,
            'total_capacity'      => $totalCapacity,
            'assigned_companies'  => $assignedCompanies,
            'available_capacity'  => $available,
            'used_percentage'     => $usedPercentage,
        ]);
    }

    // Metodo auxiliar para seleccionar un agente con menor carga en un estado
    protected function selectAgentForState($state, $excludeId = null)
    {
        $state = strtoupper($state);
        $agents = RegisteredAgent::where('state', $state)
            ->when($excludeId, function ($query, $excludeId) {
                return $query->where('id', '!=', $excludeId);
            })->get();

        if ($agents->isEmpty()) {
            return null;
        }

        $agentLoad = [];
        foreach ($agents as $agent) {
            $count = Company::where('registered_agent_id', $agent->id)->count();
            if ($count >= $agent->capacity) {
                continue; // Se salta si la capacidad ya está llena
            }
            $agentLoad[] = ['agent' => $agent, 'count' => $count];
        }

        if (empty($agentLoad)) {
            return null;
        }

        // Ordenar los agentes por menor carga
        usort($agentLoad, function ($a, $b) {
            return $a['count'] <=> $b['count'];
        });

        return $agentLoad[0]['agent'];
    }
}
