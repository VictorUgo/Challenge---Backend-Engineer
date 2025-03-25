<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    /**
     * Maneja una solicitud entrante.
     */
    public function handle(Request $request, Closure $next)
    {
        // Si es una solicitud OPTIONS, responder directamente
        if ($request->isMethod('OPTIONS')) {
            $response = response('', 200);
        } else {
            $response = $next($request);
        }

        // Añadir las cabeceras CORS
        $response->header('Access-Control-Allow-Origin', 'http://localhost:4200')
                 ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                 ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');

        return $response;
    }
}
