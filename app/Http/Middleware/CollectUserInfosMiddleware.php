<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CollectUserInfosMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        //Log

        Log::channel("AccessInfo")->info("log d'accès",[
            "temps d'accès" => Carbon::now(),
            "Le lien accédé" => url()->full(),
            "user_id" => Auth::id(),
            "IP" => $request->ip(),
            "user_agent" => request()->header('User-Agent')
        ]);
        
        return $next($request);
    }
}
