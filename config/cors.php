<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Configuración CORS para permitir peticiones desde React Native local
    | y cualquier cliente en desarrollo. En producción, restricciones adicionales.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // Permite peticiones desde cualquier origen durante desarrollo
    // En producción, reemplaza con ['https://tu-dominio.com']
    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [
        '/^http:\/\/(localhost|127\.0\.0\.1):[0-9]+$/',  // localhost con cualquier puerto
        '/^http:\/\/192\.168\.[0-9]{1,3}\.[0-9]{1,3}:[0-9]+$/',  // IPs privadas 192.168.x.x
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // Permite cookies/credenciales en peticiones de origen cruzado
    'supports_credentials' => true,

];
