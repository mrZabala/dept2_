<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class controlPanelController extends Controller
{
     public function ControlPanel(){
        $users = DB::table('users')->get();
        return view('admin.SysadminControlPanel',compact('users'));
     }

     public function actualizarUsuario(Request $request){
        
         $userData = $request->userData;
         $idUsuario =  $userData['id'];
         unset($userData['id']);
         unset($userData['Regional']);
         unset($userData['nombreDistriro']);
         unset($userData['centro']);

         try {
            DB::table('users')->where('id', $idUsuario)->update($userData);
            return response('actualizado',200);
         } catch (Throwable $e) {
           return response('error',200);
         }



     }

  

}
