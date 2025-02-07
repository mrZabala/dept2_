<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class utiliadadesController extends Controller
{
    //
    public function opt_regionales(Request $request){
        $regionales = DB::table('regionales')->get();
        return response($regionales);
    }
    public function opt_distritos (Request $request){
        $distritos = DB::table('distritos')->get();
        return response($distritos);
    }

    public function opt_centros (Request $request){
        $centros = DB::SELECT("select cn.*, rg.Regional ,ds.nombreDistriro from centroseducativos cn
        JOIN regionales rg on  rg.id_regional = cn.id_regional
        JOIN distritos ds on ds.id_distrito = cn.id_distrito");
        return response($centros);
    }
    //optener informacion de usuario
    public function opt_usuario(Request $request){
        $idUsuario =  $request->idUsuario;
        $usuario = DB::SELECT("SELECT us.name, 
            us.email, 
            us.isadmin,
            us.id,
            us.id_regional, 
            us.id_distrito ,
            us.id_centroEducativo, 
            us.tipoDeUsuario,
            us.isActivo,
            rg.Regional, 
            dis.nombreDistriro,
            cn.centro 
        FROM users as us
        LEFT JOIN regionales as rg on us.id_regional = rg.id_regional
        LEFT JOIN distritos as  dis on us.id_distrito = dis.id_distrito
        LEFT JOIN centroseducativos as cn ON us.id_centroEducativo = cn.id_centroEducativo
        where us.id = $idUsuario
        limit 1
        ");

        return response( $usuario);
         
    }


    public function opt_tipoGastos(Request $request){
        $tipoGastos = DB::table('tipo_gasto')->get();
         return response($tipoGastos);
    }

    public function opt_suTipoGasto(Request $request){
        $suTipoGasto = DB::table('sub_tipo_gasto')->get();
        return  response($suTipoGasto);
    }
}
