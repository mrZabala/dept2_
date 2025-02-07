<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function usuarioNoActivo(){
        return view('noActivo');
    }
    public function noPermiso(){
        return view('noPermiso');
    }
    public function  homeView(){
        //deterinar tipo de usuario
        $tipoDeUsuario = Auth::user()->tipoDeUsuario;
        if($tipoDeUsuario == 'ETP'){
            return redirect('/subvenicones/tableroGeneral');
        
        }else{
            return redirect('/subvenicones/tableroSubvenciones');
        }
        
    }

  

}
