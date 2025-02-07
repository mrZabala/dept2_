<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class vinculacionesController extends Controller
{
    public function obtenerCentrosEducativos(){
        $centros = DB::SELECT("select cn.*, rg.Regional ,ds.nombreDistriro from centroseducativos cn
            JOIN regionales rg on  rg.id_regional = cn.id_regional
            JOIN distritos ds on ds.id_distrito = cn.id_distrito"
        );
        return $centros;
    } 
   
    public function estudiantes(){
       $estudiantes = DB::SELECT("select ES.*,centroseducativos.centro from estudiante ES
            JOIN centroseducativos on centroseducativos.id_centroEducativo = ES.id_centro_educactivo
            ");
            return  $estudiantes;
    }
    
    public function estudiante (){
        $distritos = DB::table('distritos')->get();
        $regionales = DB::table('regionales')->get();
        $estudiantes =  $this->estudiantes();
       // dd($estudiantes);
        $centros = $this->obtenerCentrosEducativos();
        return view('vinculacion.estudiantes',compact('estudiantes','centros','distritos','regionales'));
    }
    
    public function empresa (){
        //$distritos = DB::table('distritos')->get();
        //$regionales = DB::table('regionales')->get();
        //$estudiantes =  $this->estudiantes();
        //dd($estudiantes);
        //$centros = $this->obtenerCentrosEducativos();
        return view('vinculacion.estudiantes');
    }
    
    public function agregarCentroEducativo (Request $request){
        $dataCentroEducativo = $request->dataCentroEducativo;
        unset($dataCentroEducativo['distrito']);
        unset($dataCentroEducativo['regional']);
        unset($dataCentroEducativo['Regional']);
        unset($dataCentroEducativo['nombreDistriro']);

        if(isset($dataCentroEducativo['id_centroEducativo'])){
            $idCentro = $dataCentroEducativo['id_centroEducativo'];
            unset($dataCentroEducativo['id_centroEducativo']);
            DB::table('centroseducativos')->where('id_centroEducativo',$idCentro)->update($dataCentroEducativo);
            $centros =  $this->obtenerCentrosEducativos();
            return response($centros,200);
        }

        try {
             DB::table('centroseducativos')->insert($dataCentroEducativo); 
             $centros =  $this->obtenerCentrosEducativos();
             return response($centros,200);

        } catch (Exception $e) {
             return response('error',404);
        }
    }
}
