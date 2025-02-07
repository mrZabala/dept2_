<?php

namespace App\Http\Controllers;
use Auth;
use DB;
use Illuminate\Http\Request;

class subvencionesController extends Controller
{

    public function gastos_centroseducativos(){
        $CentroUSuario = Auth::user()->id_centroEducativo;
        try {
            //return  DB::table('gastos_centroseducativos')->where('id_centro_educativo',Auth::user()->id_centroEducativo)->get();
            return DB::Select("select 
                    cn.* ,
                    tpg.nombre tipoGasto,
                    stpg.nombre  subTipoGasto
                    from  gastos_centroseducativos as cn
                    left join tipo_gasto  as tpg  on cn.tipo_gasto = tpg.id
                    left join sub_tipo_gasto as stpg on  cn.sub_tipo_gasto = stpg.id
                    where cn.estado = 1 and  cn.id_centro_educativo = $CentroUSuario
            
            ");
        } catch (Throwable $e) {
            //throw $th;
        }

    }
    public function eliminarGastoCentro(Request $request){
         $id_gasto = $request->id_gasto;
        try {
            DB::table('gastos_centroseducativos')->where('id_gasto', $id_gasto)->update([
                'estado' => 0,
                'eliminadoPor' => Auth::user()->id
            ]);
            $gastos_centroseducativos = $this->gastos_centroseducativos();
            return response( $gastos_centroseducativos,200);
        } catch (Throwable $e) {
           return response("error");
        }

    }
    public function agregar(){

        //del usuario logueado cual es su centro educativo
        $CentroUSuario= Auth::user()->id_centroEducativo;
        //a cual centro pertenece el usuario 
        $tipo_gastos = DB::table('tipo_gasto')->get();
        $sub_tipo_gastos = DB::table('sub_tipo_gasto')->get();
        $gastosDelcentro = $this->gastos_centroseducativos();
        $centro = DB::table('centroseducativos')->where('id_centroEducativo',$CentroUSuario)->first();
        return view("subvenciones.registroActividades",compact('centro','tipo_gastos','sub_tipo_gastos','gastosDelcentro'));
    }


    public function buscar(Request $request){
        $buscar = $request->buscar;
        $CentroUSuario= Auth::user()->id_centroEducativo;
        $desde= $buscar['desde'];
        $hasta= $buscar['hasta'];
        try {
             $data = DB::SELECT("SELECT * FROM gastos_centroseducativos WHERE id_centro_educativo = $CentroUSuario
             and fecha BETWEEN   '$desde' AND '$hasta'");
             $data = json_decode(json_encode( $data),true);        
             return response($data ,200);
        } catch (Throwable $e) {
            //throw $th;
        }
    }

    public function registro(Request $request){
        $gasto = $request->gasto;
        $gasto['id_personal_ingresante'] =   Auth::user()->id;
        $gasto['id_centro_educativo'] = Auth::user()->id_centroEducativo;
        try {
            DB::table('gastos_centroseducativos')->insert($gasto);
        } catch (Throwable $e) {
            return response('error');
        }
        $gastos_centroseducativos = $this->gastos_centroseducativos();
        return response($gastos_centroseducativos);

    }

    public function ingresosDelcentro (){
        $CentroUSuario= Auth::user()->id_centroEducativo;
        try {
            return DB::Select("select 
                    cn.* ,
                    tpi.tipo_ingreso tipoIngreso
                    from  ingreso_centro_educativo as cn
                    left join tipo_ingreso  as tpi  on cn.tipo_ingreso = tpi.id
                    where 
                    estado = 1 and
                    cn.id_centro_educativo =  $CentroUSuario
            ");
        } catch (Throwable $e) {
            //throw $th;
        }
    }

    public function registroIngresos(){
        //del usuario logueado cual es su centro educativo
        $CentroUSuario= Auth::user()->id_centroEducativo;
        //a cual centro pertenece el usuario 
        $tipo_ingreso = DB::table('tipo_ingreso')->get();
        $ingresosDelcentro = $this->ingresosDelcentro();
        $centro = DB::table('centroseducativos')->where('id_centroEducativo',$CentroUSuario)->first();
        return view("subvenciones.registroIngresos",compact('centro','tipo_ingreso','ingresosDelcentro'));

    }

    public function guardarIngresos(Request $request){
        $dataIngresos = $request->ingreso;
        $dataIngresos['id_persona_ingresante'] =   Auth::user()->id;
        $dataIngresos['id_centro_educativo'] = Auth::user()->id_centroEducativo;
     
        try {
             DB::table('ingreso_centro_educativo')->insert($dataIngresos);
        } catch (Throwable $e) {
            //throw $th;
        }
        $ingresosDelcentro = $this->ingresosDelcentro();

        return response($ingresosDelcentro);


    }

    public function eliminarIngreso(Request $request){
        $id_ingreso = $request->id_ingreso;
        try {
            DB::table('ingreso_centro_educativo')->where('id', $id_ingreso)->update([
                'estado' => 0,
                'eliminadoPor' => Auth::user()->id
            ]);
            $gastos_centroseducativos = $this->gastos_centroseducativos();
            return response( $gastos_centroseducativos,200);
        } catch (Throwable $e) {
           return response("error");
        }

    }

    public function buscarIngresos(Request $request){
        $buscar = $request->buscar;
        $CentroUSuario= Auth::user()->id_centroEducativo;
        $desde= $buscar['desde'];
        $hasta= $buscar['hasta'];
        try {
            $data = DB::SELECT("SELECT * FROM ingreso_centro_educativo WHERE id_centro_educativo = $CentroUSuario
            and fecha BETWEEN   '$desde' AND '$hasta'");
            $data = json_decode(json_encode( $data),true);        
            return response($data ,200);
       } catch (Throwable $e) {
           //throw $th;
       }
    }


    public function tableroData ($id_centroEducativo){
        $CentroUSuario = $id_centroEducativo;
        $centro = DB::table('centroseducativos')->where('id_centroEducativo',$CentroUSuario)->first();
        $distribucionPorTipoDeGasto =  DB::SELECT("SELECT count(*) as conteo, tp.nombre , SUM(gce.monto) sumatoria 
        FROM  gastos_centroseducativos as gce
            left JOIN tipo_gasto as tp on gce.tipo_gasto = tp.id
            left JOIN sub_tipo_gasto as stp on gce.sub_tipo_gasto = stp.id
            where gce.estado = 1 and gce.id_centro_educativo =   $CentroUSuario
            GROUP BY tp.nombre;");
        $distribucionPorSbuTipoDeGasto =  DB::SELECT("SELECT count(*) as conteo, stp.nombre , SUM(gce.monto) sumatoria 
            FROM  gastos_centroseducativos as gce
            left JOIN tipo_gasto as tp on gce.tipo_gasto = tp.id
            left JOIN sub_tipo_gasto as stp on gce.sub_tipo_gasto = stp.id
            where gce.estado = 1 and gce.id_centro_educativo =   $CentroUSuario
            GROUP BY stp.nombre;
        ");

        $distribucionPorMes = DB::select("SELECT MONTH(gce.fecha) mes, SUM(gce.monto) sumatoria 
        FROM gastos_centroseducativos as gce 
        left JOIN tipo_gasto as tp on gce.tipo_gasto = tp.id 
        left JOIN sub_tipo_gasto as stp on gce.sub_tipo_gasto = stp.id where gce.estado = 1  and gce.id_centro_educativo =   $CentroUSuario
        GROUP BY MONTH(gce.fecha)
        ");
        $totalDegastos = DB::Select("Select sum(monto)  total from gastos_centroseducativos where estado = 1 and id_centro_educativo =   $CentroUSuario; ");
        //----ingresos
        $distribucionIngresosPorTipo =  DB::SELECT("SELECT  tp.tipo_ingreso , SUM(ice.monto) sumatoria 
            FROM  ingreso_centro_educativo as ice
            LEFT JOIN  tipo_ingreso as tp on ice.tipo_ingreso = tp.id
            where ice.estado = 1  and ice.id_centro_educativo =   $CentroUSuario
            GROUP BY tp.tipo_ingreso;
        ");
        $totalIngresos = DB::select("Select sum(monto)  total from ingreso_centro_educativo where estado = 1 and id_centro_educativo =   $CentroUSuario;");
        $Subvenciones = DB::select("select 
                    cn.* ,
                    tpi.tipo_ingreso tipoIngreso
                    from  ingreso_centro_educativo as cn
                    left join tipo_ingreso  as tpi  on cn.tipo_ingreso = tpi.id
                    where 
                    estado = 1 and
                    cn.id_centro_educativo =  $CentroUSuario");
        $datos = [
            'centroNombre' => $centro->centro,
            'centro_id'=> $centro->id_centroEducativo,
            'gastos'=> [
               'distribucionPorTipoDeGasto' => $distribucionPorTipoDeGasto,
               'distribucionPorSbuTipoDeGasto' =>$distribucionPorSbuTipoDeGasto,
               'distribucionPorMes' =>  $distribucionPorMes,
               'totalDegastos' => $totalDegastos[0]
            ],
            'ingresos' =>[ 
                'distribucionIngresosPorTipo' => $distribucionIngresosPorTipo,
                'totalIngresos' =>    $totalIngresos[0],
                'Subvenciones' => $Subvenciones
            ]
        ];


        return $datos;
        

    }

    public function tableroSubvenciones (){
        $id_centroEducativo = Auth::user()->id_centroEducativo;
        $datos = $this->tableroData( $id_centroEducativo);
        return view('subvenciones.dashBoard',compact('datos'));

    }

    public function tableroGeneral(){
        $tipoDeUsuario = Auth::user()->tipoDeUsuario;
        if($tipoDeUsuario == 'ETP'){
            $centrosEducativos = DB::table('centroseducativos')->get();
            return view('subvenciones.dashBoardGeneral',compact('centrosEducativos'));;
        }else{
            return redirect('/noPermiso');
        }
       

    }

    public function tableroSubvencionesConsulta($id_centro){

        $tipoDeUsuario = Auth::user()->tipoDeUsuario;
        if($tipoDeUsuario == 'ETP'){
            $datos = $this->tableroData($id_centro);
            return view('subvenciones.dashBoard',compact('datos'));
        }else{
            return redirect('/noPermiso');
        }
      
    }



}
