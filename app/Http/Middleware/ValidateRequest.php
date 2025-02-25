<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponseHelper;
use Closure;
use Illuminate\Http\Request;
use Exception;

class ValidateRequest
{
    use ApiResponseHelper;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $key = $request->header('ApiSecret');
            $appKey = decrypt($key);
            if (config('custom.appKey') != $appKey) {
                throw new Exception('Invalid api secret');
            }
            return $next($request);
        } catch (Exception $e) {
            return $this->apiResponse(false, 'Invalid api secret', [], 400);
        }

    }
}
