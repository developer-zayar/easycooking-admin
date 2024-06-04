<?php

namespace App\Http\Middleware;

use App\Models\ApiKeys;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-KEY') ?? $request->query('api_key');

        $apiKeyModel = ApiKeys::where('key', $apiKey)->first();

        if (!$apiKeyModel) {
            return response()->json('Unauthorized', 401);
        }
        // if ($apiKey != env('API_KEY')) {
        //     return response()->json('Unauthorized', 401);
        // }

        return $next($request);
    }
}
