<?php

namespace App\Http\Controllers;
use DB;

use Illuminate\Http\Request;

class mantenimientosController extends Controller
{

    public function obtenerCentrosEducativos(){
        $centros = DB::SELECT("select cn.*, rg.Regional ,ds.nombreDistriro from centroseducativos cn
                        JOIN regionales rg on  rg.id_regional = cn.id_regional
                        JOIN distritos ds on ds.id_distrito = cn.id_distrito");
        return $centros;
    }
    
    public function centrosEducativos (){
        $distritos = DB::table('distritos')->get();
        $regionales = DB::table('regionales')->get();
        $centros =  $this->obtenerCentrosEducativos();
        return view('mantenimientos.centrosEducativos',compact('centros','distritos','regionales'));
    }
    

    public function getEstudiantes(){
        $estudiantes = DB::SELECT("select ES.*,centroseducativos.centro from estudiante ES
             JOIN centroseducativos on centroseducativos.id_centroEducativo = ES.id_centro_educactivo");
             return  $estudiantes;
    }

    
    public function agregarEstudiante (Request $request){
        $dataEstudiante = $request->dataEstudiante;
        $estudiante = $this->getEstudiantes();

        /*unset($dataEstudiante['distrito']);
        unset($dataEstudiante['distrito']);
        unset($dataEstudiante['distrito']);
        unset($dataEstudiante['distrito']);*/
        unset($dataEstudiante['centro']);


        if(isset($dataEstudiante['id_estudiante'])){
            $idEstudiante = $dataEstudiante['id_estudiante'];
            unset($dataEstudiante['id_estuadiante']);
            DB::table('estudiante')->where('id_estudiante',$idEstudiante)->update($dataEstudiante);
            $estudiante =  $this->getEstudiantes();
            return response($estudiante,200);
        }

        try {
             DB::table('estudiante')->insert($dataEstudiante); 
             return response($estudiante,200);
        } catch (Exception $e) {
             return response('error',404);
        }
    }


    public function agregarCentroEducativo (Request $request){
        $dataCentroEducativo = $request->dataCentroEducativo;
        unset($dataCentroEducativo['distrito']);
        unset($dataCentroEducativo['regional']);

        try {
             DB::table('centroseducativos')->insert($dataCentroEducativo); 
             $centros =  $this->obtenerCentrosEducativos();
             return response($centros,200);

        } catch (Exception $e) {
             return response('error',404);
        }
    }
}
