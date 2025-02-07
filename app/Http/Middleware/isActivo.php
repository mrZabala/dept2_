<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Auth;

class isActivo {
    
    public function __construct(Application $app, Request $request){
        $this->app = $app;
        $this->request = $request;     
    }
    public function handle($request, Closure $next){
        
        if(Auth::Check()){
            if(Auth::user()->isActivo == 1){
                return $next($request);
            }
        }

        return redirect('/usuarioNoActivo');

    }


}








?>