<?php

namespace App\Http\Middleware;

use Fideloper\Proxy\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array
     * @var array|string
     */
    protected $proxies = '*';

    /**
     * The current proxy header mappings.
     * The headers that should be used to detect proxies.
     *
     * @var array
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}
