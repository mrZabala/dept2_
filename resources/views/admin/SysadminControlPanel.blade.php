@extends('layout.layout')

@include('layout.sidebar')
@section('content')
<link href="{{asset('css/vue-select.css')}}"  rel="stylesheet" />
<section class="content" id='app'>
	<div class="page-heading">
        <h1>Panel  de Control Usuarios</h1>
       
    </div>
    <div class="page-body">
    	<div class="panel panel-default">
            <div class="panel-heading">Panel de control usurarios</div>
            <div class="panel-body">
            	<table class="table  dataTable users-table" id="users-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" v-cloak>
                            <td>@{{ user.name }}</td>
                            <td>@{{ user.email }}</td>
                            <td>
                                <button type="button"  v-on:click="abrirDetallesUsuarios(user.id)" class="btn btn-info" >Opciones</button>   
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
       
    </div>

    <div class="modal fade" id="informacionUsuario" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">Informacion de usuario :  @{{userData.name}}</h4>
                </div>
                <div class="modal-body clearfix">
                    <div class="row">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" v-model='userData.name' class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="regional" class="col-md-4 col-form-label text-md-end">{{ __('Regional') }}</label>
                            <div class="col-md-6">
                                <v-select   v-model='userData.id_regional' name='regional' id='regional' label="Regional"  :reduce="(option) => option.id_regional" v-model="regional" :options="regionales"></v-select>  
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="distrito" class="col-md-4 col-form-label text-md-end">{{ __('Distrito') }}</label>
                            <div class="col-md-6">
                                <v-select v-model="userData.id_distrito" name='distrito' id='distrito' label="nombreDistriro" v-model='distrito' :reduce="(option) => option.id_distrito"  :options="distritosFiltrados"></v-select>       
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="centro" class="col-md-4 col-form-label text-md-end">{{ __('Centro Educativo') }}</label>
                            <div class="col-md-6">
                                <v-select  v-model="userData.id_centroEducativo" name='centro' id='centro'  label="centro"  :reduce="(option) => option.id_centroEducativo"  :options="centrosEducativosFiltrados"></v-select>       
                            </div>  
                        </div>

                        <div class="row mb-3">
                            <label for="regional" class="col-md-4 col-form-label text-md-end">{{ __('Usuario') }}</label>
                            <div class="col-md-6">
                                <v-select   v-model="tipoDeUsuario" name='tipoDeusuario' id='tipoDeusuario'    :options="tiposDeusuarios"></v-select>       
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="regional" class="col-md-4 col-form-label text-md-end">{{ __('Tipo de Usuario') }}</label>
                            <div class="col-md-6">
                                <v-select   v-model="userData.tipoDeUsuario" name='tipoDeusuario' id='tipoDeusuario'    :options="tiposDeusuarios"></v-select>       
                            </div>
                        </div>

                        <div class="row mb-3"  >
                            <label for="email"  class="col-md-4 col-form-label text-md-end">{{ __('Correo (Minerd)') }}</label>

                            <div class="col-md-6">
                                <input id="email"   v-model="userData.email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            </div>
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-md-6">
                            <label for="activo"  class="col-md-4 col-form-label text-md-end">{{ __('Activo') }}</label>
                            <div class="switch">
                                <label><input type="checkbox" :checked="userData.isActivo == 1"  v-model="checkActivo"/><span class="lever"></span></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="activo"  class="col-md-4 col-form-label text-md-end">{{ __('Administrador') }}</label>
                            <div class="switch">
                                <label><input type="checkbox" :checked="userData.isadmins == 1"  v-model="checkActivo"/><span class="lever"></span></label>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" v-on:click="actualizarUsuario()" >Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('scripts')
<script src="{{asset('js/vue-select.js')}}"></script>
	<script type="text/javascript">
		var homepath = '{{url("/")}}';
        var imagenlogo = homepath +'/images/ETP.png'
        $.LoadingOverlaySetup({
            background      : "rgba(255, 255, 255, 0.8)",
            image           : imagenlogo,
            imageAnimation  : "1.5s fadein",
            imageColor      : "#ffcc00"
        });
        var users = {!! json_encode($users) !!};
        var _token = '{{csrf_token()}}'
        Vue.component('v-select', VueSelect.VueSelect);
        Vue.http.headers.common['X-CSRF-TOKEN'] = _token;
        var app = new Vue({
        el: '#app',
        data:{
            users:users,
            usuarioSeleccionado : [],
            regionales:[],
            distritos: [],
            regional: null,
            distrito: null,
            centrosEducativos:[],
            checkActivo: null,
            checkAdmin: null,
            tipoDeUsuario: null,

            centrosEducativosFiltrados:[],
            distritosFiltrados:[],
           
            tiposDeusuarios:[
                'ETP',
                'Centro Educativo',
            ],
            usuariosEtp:[
                'Subvenciones',
                'Vincualaciones'
            ],
            usuariosCetroEducativo:[
                'Director',
                'Contador'
            ],
            userData:{
                'id': null,
                'name' : null,
                'email': null,
                'password': null,
                'id_regional': null,
                'id_distrito': null,
                'id_centroEducativo':null,
                'tipoDeUsuario': null,
                'isActivo': null,
            }
        },
        watch: {
            'userData.id_regional': function(val){
                $("#informacionUsuario").LoadingOverlay("show");
                var id_regional = val
                this.distritosFiltrados = this.distritos.filter(function(item){
                    return  item.id_regional == id_regional;
                });   
                this.distrito = null;  
                $("#informacionUsuario").LoadingOverlay("hide");
                
            },
            'userData.id_distrito': function(val){
                $("#informacionUsuario").LoadingOverlay("show");
                var id_distrito = val
                this.centrosEducativosFiltrados = this.centrosEducativos.filter(function(item){
                    return item.id_distrito ==  id_distrito;
                });
               
                $("#informacionUsuario").LoadingOverlay("hide");

            },
            'userData.isActivo': function(val){
                if(val == 1){
                    this.checkActivo = 'TRUE';
                }
            },
            checkActivo:function(val){
                if(val){
                    this.userData.isActivo = 1
                }else{
                    this.userData.isActivo = 0
                }
            }
           

        },
        methods:{
            actualizarUsuario: function(){
                $("#informacionUsuario").LoadingOverlay("show");
                _this = this;
                this.$http.post(homepath  + '/ControlPanel/actualizarUsuario', {userData: _this.userData}).then(response => {
                    $("#informacionUsuario").LoadingOverlay("hide");
                     location.reload();
                }, response => {
                // error callback
                });  
            },
         
            abrirDetallesUsuarios: function(id){
                //informacionUsuario
                this.opt_usuario(id);
                $('#informacionUsuario').modal('show');
            },
            opt_usuario : function(id){
                 _this = this;
                $("#informacionUsuario").LoadingOverlay("show");
                 this.$http.post(homepath  + '/utilidades/opt_usuario', {idUsuario : id}).then(response => {
                     var respuesta = response.data[0];
                    _this.userData = respuesta;
                     $('#informacionUsuario').modal('show');
                }, response => {
                // error callback
                });
                $("#informacionUsuario").LoadingOverlay("hide");       
            },
            
            opt_regionales : function(){
                    _this = this;
                    this.$http.post(homepath  + '/utilidades/opt_regionales', {}).then(response => {
                        _this.regionales = response.body;    
                    }, response => {
                    // error callback
                    });       
            },
            opt_distritos : function(){
                    _this = this;
                    this.$http.post(homepath  + '/utilidades/opt_distritos', {}).then(response => {
                        _this.distritos = response.body;       
                    }, response => {
                    // error callback
                    });       
            },
            opt_centrosEducativos : function(){
                    _this = this;
                    this.$http.post(homepath  + '/utilidades/opt_centros', {}).then(response => {
                        _this.centrosEducativos = response.body;
                    }, response => {
                    // error callback
                    });       
            },
        },
        mounted: function(){
            this.opt_regionales();
            this.opt_distritos();
            this.opt_centrosEducativos();
           $('#users-table').DataTable({
                responsive: true,
                dom:'Bftip',
                buttons:[
                    'excel'
                ],
           });
        }
    })
	</script>
  
@endsection