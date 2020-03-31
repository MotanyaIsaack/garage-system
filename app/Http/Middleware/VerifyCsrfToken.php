<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/suspend/spares','/restore/spares','/suspend/vehicle_category','/restore/vehicle_category',
        '/suspend/vehicle_type','/restore/vehicle_type','/suspend/garage_service','/restore/garage_service',
        '/suspend/service_pricing','/restore/service_pricing','/get_categories_json','/get_services_json','/amount',
        '/add/request'
    ];
}
