<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\SystemSetting;
use Illuminate\Http\Response;
use Auth;
class CheckMaintenanceStatus
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
       
        $ADMIN_ID = env("ADMIN_ID"); 

        if($ADMIN_ID ==Auth::user()->id){
             return $next($request);
        }
        $system_maintanance = SystemSetting::where('id',1)->value('system_maintanance');
        if ($system_maintanance == 1) {
            $name = $request->route()->getName();
            if($name !='dashboard'){
                return redirect()->route('dashboard');
            }
            return new Response(view('errors.maintenance'));
            //  abort(403, 'Site is under maintenance');
            //  return redirect()->route('redirect-route');
           
        }
        return $next($request);
    }
}
