@component('mail::message')
# Nueva Asignación

Has sido asignado a una nueva compañía.

**Nombre de la Compañía:** {{ $company->name }}
**Estado:** {{ $company->state }}

@component('mail::button', ['url' => url('/companies/' . $company->id)])
Ver Compañía
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
