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
        '/get/price',
		'/save/customer',
		'/get/price/townrun',
        '/get/price/hire',
        '/get/price/delivery',
		'/booking/details',
		'/send/booking/info',
		'/save/token',
        '/save/order',
        '/dealer/sync/product'
    ];
}
