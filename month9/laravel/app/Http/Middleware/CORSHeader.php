<?php

namespace App\Http\Middleware;

use Closure;

class CORSHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $response->withHeaders([
            "Access-Control-Allow-origin" => "*",
            "Access-Control-Allow-Method" => "GET,POST,PUT,DELETE,OPTIONS,HEAD,TRACE",
            "Access-Control-Allow-Headers" => "Authorization,Content-Type,Content-Length,Accept,Accept-Encoding,Host,Referer,x-api-token",
        ]);
        return $response;


    }
}
