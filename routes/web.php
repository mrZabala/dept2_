<?php

use Illuminate\Support\Facades\Route;


Auth::routes();


Route::get('/usuarioNoActivo', [App\Http\Controllers\HomeController::class, 'usuarioNoActivo'])->name('usuarioNoActivo');

    //utilidades 
    Route::post('/utilidades/opt_regionales', [App\Http\Controllers\utiliadadesController::class, 'opt_regionales'])->name('opt_regionales');
    Route::post('/utilidades/opt_distritos', [App\Http\Controllers\utiliadadesController::class, 'opt_distritos'])->name('opt_distritos');
    Route::post('/utilidades/opt_centros', [App\Http\Controllers\utiliadadesController::class, 'opt_centros'])->name('opt_centros');
    Route::post('/utilidades/opt_usuario', [App\Http\Controllers\utiliadadesController::class, 'opt_usuario'])->name('opt_usuario');
    Route::post('/utilidades/opt_tipoGastos', [App\Http\Controllers\utiliadadesController::class, 'opt_tipoGastos'])->name('opt_tipoGastos');
    Route::post('/utilidades/opt_suTipoGasto', [App\Http\Controllers\utiliadadesController::class, 'opt_suTipoGasto'])->name('opt_suTipoGasto');
    
route::group([
    "middleware" => ["auth:sanctum", "activo"]
], function(){
    Route::get('/noPermiso', [App\Http\Controllers\HomeController::class, 'noPermiso'])->name('noPermiso');

    Route::get('/', [App\Http\Controllers\HomeController::class, 'homeView'])->name('homeView');
    //controlPanelController
    Route::get('/ControlPanel', [App\Http\Controllers\controlPanelController::class, 'ControlPanel'])->name('ControlPanel');
    Route::post('/ControlPanel/actualizarUsuario', [App\Http\Controllers\controlPanelController::class, 'actualizarUsuario'])->name('actualizarUsuario');
    //mantenimientos
    Route::get('/subvenicones/registro', [App\Http\Controllers\subvencionesController::class, 'agregar'])->name('agregar');
    Route::get('/centrosEducativos', [App\Http\Controllers\mantenimientosController::class, 'centrosEducativos'])->name('centrosEducativos');
    Route::post('/centrosEducativos/agregar', [App\Http\Controllers\mantenimientosController::class, 'agregarCentroEducativo'])->name('agregarCentroEducativo');


    //suvenciones 
    Route::get('/subvenicones/registro', [App\Http\Controllers\subvencionesController::class, 'agregar'])->name('agregar');
    Route::post('/subvenicones/registro', [App\Http\Controllers\subvencionesController::class, 'registro'])->name('registro');
    Route::post('/subvenicones/eliminarGastoCentro', [App\Http\Controllers\subvencionesController::class, 'eliminarGastoCentro'])->name('eliminarGastoCentro');
    Route::post('/subvenicones/buscar', [App\Http\Controllers\subvencionesController::class, 'buscar'])->name('buscar');
    Route::get('/subvenicones/registroIngresos', [App\Http\Controllers\subvencionesController::class, 'registroIngresos'])->name('registroIngresos');

    Route::post('/subvenicones/guardarIngresos', [App\Http\Controllers\subvencionesController::class, 'guardarIngresos'])->name('guardarIngresos');
    Route::post('/subvenicones/eliminarIngreso', [App\Http\Controllers\subvencionesController::class, 'eliminarIngreso'])->name('eliminarIngreso');

    Route::post('/subvenicones/buscarIngresos', [App\Http\Controllers\subvencionesController::class, 'buscarIngresos'])->name('buscarIngresos');

    Route::get('/subvenicones/tableroSubvenciones', [App\Http\Controllers\subvencionesController::class, 'tableroSubvenciones'])->name('tableroSubvenciones');

    Route::get('/home', [App\Http\Controllers\subvencionesController::class, 'tableroSubvenciones'])->name('tableroSubvenciones');

    Route::get('/subvenicones/tableroGeneral', [App\Http\Controllers\subvencionesController::class, 'tableroGeneral'])->name('tableroGeneral');

    Route::get('/subvenicones/tableroSubvenciones/{id_centro}', [App\Http\Controllers\subvencionesController::class, 'tableroSubvencionesConsulta'])->name('tableroSubvencionesConsulta');


    
    //Estudiantes-Vinculacion
    Route::post('/estudiantes/agregar', [App\Http\Controllers\mantenimientosController::class, 'agregarEstudiante'])->name('agregarEstudiante');
    Route::get('/estudiantes', [App\Http\Controllers\vinculacionesController::class, 'estudiante'])->name('estudiante');

     //Empresa-Vinculacion
     Route::post('/empresas/agregar', [App\Http\Controllers\mantenimientosController::class, 'agregarEmpresa'])->name('agregarEmpresa');
     Route::get('/empresas', [App\Http\Controllers\vinculacionesController::class, 'empresa'])->name('empresa');

});



