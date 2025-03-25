@component('mail::message')
# Alerta de Capacidad

La capacidad del servicio de agentes en el estado **{{ $state }}** ha alcanzado el {{ number_format($usedPercentage, 2) }}% de su capacidad total.

**Total Capacidad:** {{ $totalCapacity }}
**Compañías Asignadas:** {{ $assignedCompanies }}

Por favor, revisa el sistema para tomar las medidas necesarias.

Gracias,<br>
{{ config('app.name') }}
@endcomponent
