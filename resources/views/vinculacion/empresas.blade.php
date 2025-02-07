@extends('layout.layout')

@include('layout.sidebar')
@section('content')

<section class="content" id='app'>
    <div class="container-fluid">
        <div class="block-header">
            <h2>Empresas</h2>
        </div>
        <div class="page-body">
            <div class="panel panel-default">
                <div class="panel-heading">Empresas <button class="btn btn-success m-l-15 pull-right" v-on:click="addupdaterecord()">Agregar Empresa</button></div>
                <div class="panel-body">
                    <table class="table table-striped table-hover dataTable users-table">
                        <thead>
                            <tr>
                                <!--<th>Centro Educativo</th>-->
                                <th>Nombre empresa</th>
                                <th>Correo Electronico</th>
                                <th>Telefono</th>
                                <th>Actividad Comercial</th>
                                <th>RNC</th>
                                <th>Direccion</th>
                                <th>Longitud</th>
                                <th>Latitud</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="estudiante in estudianteData">
                                <td>@{{empresa.nombre_empresa}}</td>
                                <td>@{{empresa.correo_electronico}}</td>
                                <td>@{{empresa.telefono}}</td>
                                <td>@{{empresa.actividad_comercial}}</td>
                                <td>@{{empresa.rnc}}</td>
                                <td>@{{empresa.direccion}}</td>
                                <td>@{{empresa.longitud}}</td>
                                <td>@{{empresa.latitud}}</td>

                                <td>
                                    <button type="button"  v-on:click="editar(empresa.id_empresa)" class="btn btn-info" >Editar</button>
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
                <h4 class="modal-title" id="smallModalLabel">Agregar Empresa</h4>
            </div>
            
            <div class="modal-body clearfix">
                <div class="row">
                    <div class="col-lg-12">
                        <label for="">Nombre de la empresa</label>
                        <input type="text" name=""  v-model='empresaForm.nombre_empresa'  class="form-control" >
                    </div>

                    <div class="col-lg-12">
                        <label for="">Correo Electronico</label>
                        <input type="text" name=""  v-model='empresaForm.correo_electronico'  class="form-control" >
                    </div>

                    <div class="col-lg-12">
                        <label for="">Telefono</label>
                        <input type="number" max="14" name=""  v-model='empresaForm.telefono'  class="form-control" >
                    </div>

                    <div class="col-lg-12">
                        <label for="">Actividad Comercial</label>
                        <input type="text" name=""  v-model='empresaForm.actividad_comercial'  class="form-control" >
                    </div>

                    <div class="col-lg-12">
                        <label for="">RNC</label>
                        <input type="text" name=""  v-model='empresaForm.rnc'  class="form-control" >
                    </div>

                    <div class="col-lg-12">
                        <label for="">Direccion</label>
                        <input type="text" name=""  v-model='empresaForm.direccion'  class="form-control" >
                    </div>

                    <div class="col-lg-12">
                        <label for="">Longitud</label>
                        <input type="text" name="" v-model='empresaForm.longitud'  class="form-control" >
                    </div>

                    <div class="col-lg-12">
                        <label for="">Latitud</label>
                        <input type="text" name=""  v-model='empresaForm.latitud'  class="form-control" >
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" v-on:click="guardarEmpresa()">Agregar</button>
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
        var empresaData = {!! json_encode($empresa) !!};


        var app = new Vue({
        el: '#app',
        data:{
            centrosEducativos:centros,
            regionales:regionales,
            estudianteData:estudianteData,
            empresaData:empresaData,
            distritos: distritos,
            distritosFiltrados : [],
            empresaForm:{
                nombre_empresa: null,
                correo_electronico: null,
                telefono: null,
                actividad_social: null,
                rnc: null,
                direccion: null,
                longitud: null,
                latitud: null,
            },
            centroSeleccionado:[],
            estudianteSeleccionado: [],
            empresaSeleccionada: []
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
            editar: function(id_empresa){
                this.empresaSeleccionada = this.empresaData.filter(function(empresa){
                    return empresa.id_empresa == id_empresa
                })[0];
                console.log(this.empresaSeleccionada)
                this.empresaForm = this.empresaSeleccionada;
                this.$nextTick(()=>{
                this.empresaForm.id_empresa =  this.empresaForm.id_empresa;
                })
                $('#newRecord').modal('show')
            },
         
            addupdaterecord: function(){
                $('#newRecord').modal('show')
            },
            guardarEmpresa : function(){
                 _this = this;
                 this.$http.post(homepath  + '/empresas/agregar', {dataEmpresa: _this.empresaForm}).then(response => {
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