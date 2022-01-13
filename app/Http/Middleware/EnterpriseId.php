<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Enterprise;
use Illuminate\Http\Request;

class EnterpriseId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->route()->getName() == 'login'){
            if(request('ent') !== null) {
                return $next($request);
            }
            else{
                $enterpriseId = Enterprise::first();
                return redirect('/login?ent='.$enterpriseId->enid);
            }
            // return abort(404);            
        }
        return $next($request);
    }
}
