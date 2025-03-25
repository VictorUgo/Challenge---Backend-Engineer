<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    |
    | Aquí se definen las rutas para las que se aplicará la política de CORS.
    | Puedes usar un comodín o especificar rutas particulares.
    |
    */

    'paths' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Allowed Methods
    |--------------------------------------------------------------------------
    |
    | Indica los métodos HTTP permitidos.
    |
    */

    'allowed_methods' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Allowed Origins
    |--------------------------------------------------------------------------
    |
    | Aquí defines los orígenes permitidos. Durante el desarrollo, puedes
    | permitir el origen de tu aplicación Angular (ej. http://localhost:4200).
    |
    */

    'allowed_origins' => ['http://localhost:4200'],

    /*
    |--------------------------------------------------------------------------
    | Allowed Origins Patterns
    |--------------------------------------------------------------------------
    |
    | Puedes definir patrones para orígenes permitidos si es necesario.
    |
    */

    'allowed_origins_patterns' => [],

    /*
    |--------------------------------------------------------------------------
    | Allowed Headers
    |--------------------------------------------------------------------------
    |
    | Indica los encabezados que pueden ser enviados en la solicitud.
    |
    */

    'allowed_headers' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Exposed Headers
    |--------------------------------------------------------------------------
    |
    | Estos encabezados serán expuestos a la aplicación cliente.
    |
    */

    'exposed_headers' => [],

    /*
    |--------------------------------------------------------------------------
    | Max Age
    |--------------------------------------------------------------------------
    |
    | Especifica el tiempo (en segundos) que se pueden almacenar en caché las
    | respuestas preflight de CORS.
    |
    */

    'max_age' => 0,

    /*
    |--------------------------------------------------------------------------
    | Supports Credentials
    |--------------------------------------------------------------------------
    |
    | Si se deben enviar cookies, cabeceras de autenticación, etc.
    |
    */

    'supports_credentials' => false,

];
