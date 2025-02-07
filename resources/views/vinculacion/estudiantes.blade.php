@extends('layout.layout')

@include('layout.sidebar')
@section('content')

<style>

    * {
        display: none;
    }
    .reglaPersonalizada {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .panel-default > .panel-heading {
        color: white;
        background-color: #233f8d;
    }
</style>

<section class="content" id='app'>
    <div class="container-fluid">
        <div class="block-header">
            <h2>Estudiantes</h2>
        </div>
        <div class="page-body">
            <div class="panel panel-default">
                <div class="panel-heading reglaPersonalizada">Estudiantes <button class="btn btn-success m-l-15" v-on:click="addupdaterecord()">Agregar Estudiante</button></div>
                <div class="panel-body">
                    <table class="table table-striped table-hover dataTable users-table">
                        <thead>
                            <tr>
                                <th>Centro Educativo</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Cedula</th>
                                <th>Poliza de riesgo laboral</th>
                                <th>Identificacion del titulo</th>
                                <th>Codigo del titulo</th>
                                <th>Tutor del centro educativo</th>
                                <th>Grado/seccion</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!---->
                            <tr v-for="estudiante in estudianteData">
                                <td>@{{estudiante.centro}}</td>
                                <td>@{{estudiante.nombre_estudiante}}</td>
                                <td>@{{estudiante.apellido_estudiante}}</td>
                                <td>@{{estudiante.cedula}}</td>
                                <td>@{{estudiante.poliza_riesgo_laboral}}</td>
                                <td>@{{estudiante.identificacion_titulo}}</td>
                                <td>@{{estudiante.codigo_titulo}}</td>
                                <td>@{{estudiante.tutor_centro_educativo}}</td>
                                <td>@{{estudiante.grado_seccion}}</td>
                                <td>
                                    <button type="button" v-on:click="editar(estudiante.id_estudiante)" class="btn btn-info">Editar</button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        
        </div>
    </div>

    <div class="modal fade" id="newRecord" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Agregar estudiante</h4>
            </div>
            
            <div class="modal-body clearfix">

                <div class="row">
    
                    <div class="col-lg-12">
                        <label for="">Nombre</label>
                        <input type="text" name=""  v-model='estudianteform.nombre_estudiante'  class="form-control" >
                    </div>

                    <div class="col-lg-12">
                        <label for="">Apellido</label>
                        <input type="text" name=""  v-model='estudianteform.apellido_estudiante'  class="form-control" >
                    </div>

                    <div class="col-lg-12">
                        <label for="">Poliza</label>
                        <input type="number" max="14" name=""  v-model='estudianteform.poliza_riesgo_laboral'  class="form-control" >
                    </div>

                    <div class="col-lg-12">
                        <label for="">Tutor de centro</label>
                        <input type="text" name=""  v-model='estudianteform.tutor_centro_educativo'  class="form-control" >
                    </div>

                    <div class="col-lg-12">
                        <label for="">Identificacion del titulo</label>
                        <input type="text" name=""  v-model='estudianteform.identificacion_titulo'  class="form-control" >
                    </div>

                    <div class="col-lg-12">
                        <label for="">Codigo del titulo</label>
                        <input type="text" name=""  v-model='estudianteform.codigo_titulo'  class="form-control" >
                    </div>


                    <div class="col-lg-12">
                        <label for="">Cedula</label>
                        <input type="text" name=""  v-model='estudianteform.cedula'  class="form-control" >
                    </div>


                    <div class="col-lg-12">
                        <label for="">Grado y seccion</label>
                        <input type="text" name=""  v-model='estudianteform.grado_seccion'  class="form-control" >
                    </div>

                    <div class="col-lg-12">
                        <label for="">Centro Educativo</label>
                        <v-select  label="centro"  :reduce="(option) => option.id_centroEducativo" v-model="estudianteform.id_centro_educactivo" :options="centrosEducativos"></v-select>       
                    </div
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" v-on:click="guardarEstudiante()">Agregar</button>
            </div>
        </div>
    </div>
</div>    
</section>

@endsection

@section('scripts')
   
	<script type="text/javascript">
        Vue.component('v-select', VueSelect.VueSelect);
        Vue.http.headers.common['X-CSRF-TOKEN'] = _token;
		var homepath = '{{url("/")}}';
        var centros = {!! json_encode($centros) !!};
        var regionales = {!! json_encode($regionales) !!};
        var distritos = {!! json_encode($distritos) !!};
        var estudianteData = {!! json_encode($estudiantes) !!};


        var app = new Vue({
        el: '#app',
        data:{
            centrosEducativos:centros,
            regionales:regionales,
            estudianteData:estudianteData,
            distritos: distritos,
            distritosFiltrados : [],
            estudianteform:{
                nombre_estudiante: null,
                apellido_estudiante: null,
                poliza_riesgo_laboral: null,
                tutor_centro_educativo: null,
                identificacion_titulo: null,
                codigo_titulo: null,
                cedula: null,
                grado_seccion: null,
                id_centro_educactivo: null
            },
            centroSeleccionado:[],
            estudianteSeleccionado: []
        },
        watch: {
            'centroEducativo.id_regional': function(val){
                console.log(val);
                var id_regional = val
                this.distritosFiltrados = this.distritos.filter(function(item){
                    return  item.id_regional == id_regional;
                });
            }
        },
        methods:{

            editar: function(id_estudiante){
                this.estudianteSeleccionado = this.estudianteData.filter(function(estudiante){
                    return estudiante.id_estudiante == id_estudiante
                })[0];
                console.log(this.estudianteSeleccionado )
                this.estudianteform = this.estudianteSeleccionado;
                this.$nextTick(()=>{
                this.estudianteform.id_centro_educactivo =  this.estudianteSeleccionado.id_centro_educactivo;
                })
                $('#newRecord').modal('show')
            },
         
            addupdaterecord: function(){
                $('#newRecord').modal('show')
            },
            guardarEstudiante : function(){
                 _this = this;
                 this.$http.post(homepath  + '/estudiantes/agregar', {dataEstudiante: _this.estudianteform}).then(response => {
                     console.log(response.body);
                     location.reload();
                }, response => {
                // error callback
                });
            }
        },
            mounted: function(){  
        }
    })
	</script>
  
@endsection