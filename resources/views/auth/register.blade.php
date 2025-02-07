@extends('layouts.app')

@section('content')
<link href="{{asset('css/vue-select.css')}}"  rel="stylesheet" />
<link href="{{asset('css/vue-select.css')}}"  rel="stylesheet" />
<div class="container"  id ='regApp'>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" id="formulario">
                <div class="card-header">{{ __('Registro  Nuevo Usuario') }}</div>

                <div class="card-body">
                        <div class="row mb-3">


                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" v-model='userData.name' class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="regional" class="col-md-4 col-form-label text-md-end">{{ __('Regional') }}</label>
                            <div class="col-md-6">
                                <v-select  v-model='userData.id_regional' name='regional' id='regional' label="Regional"  :reduce="(option) => option.id_regional" v-model="regional" :options="regionales"></v-select>  
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
                                <v-select    v-model="userData.id_centroEducativo" name='centro' id='centro'  label="centro"  :reduce="(option) => option.id_centroEducativo"  :options="centrosEducativosFiltrados"></v-select>       
                            </div>  
                        </div>

                        <div class="row mb-3">
                            <label for="regional" class="col-md-4 col-form-label text-md-end">{{ __('Usuario') }}</label>
                            <div class="col-md-6">
                                <v-select   v-model="tipoDeUsuario" name='tipoDeusuario' id='tipoDeusuario'    :options="tiposDeusuarios"></v-select>       
                            </div>
                        </div>

                        <div class="row mb-3" v-show="tipoDeUsuario == 'ETP' ">
                            <label for="regional" class="col-md-4 col-form-label text-md-end">{{ __('Tipo de Usuario') }}</label>
                            <div class="col-md-6">
                                <v-select   v-model="userData.tipoDeUsuario" name='tipoDeusuario' id='tipoDeusuario'    :options="tiposDeusuarios"></v-select>       
                            </div>
                        </div>

                        <div class="row mb-3"  v-show="tipoDeUsuario =='Centro Educativo'">
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

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password"   v-model="userData.password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                              
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmar contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password"  v-model="userData.password_confirmation" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button v-on:click="registrar()" class="btn btn-primary">
                                    {{ __('Registrar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <div v-show="formErrores">
                        <div v-for="error in formErrores" class="alert alert-danger" role="alert">
                           <p v-for="m in error"> @{{m}} </p>
                        </div>
                    </div>    

                </div>
            </div>
        </div>
    </div>
</div> 

<script src="{{asset('js/vue.js')}}"></script>
<script src="{{asset('js/VueResources.js')}}"></script>
<script src="{{asset('js/vue-select.js')}}"></script>


<script type="text/javascript">
    var homepath = '{{url("/")}}'
    var imagenlogo = homepath +'/images/ETP.png'
    $.LoadingOverlaySetup({
        background      : "rgba(255, 255, 255, 0.8)",
        image           : imagenlogo,
        imageAnimation  : "1.5s fadein",
        imageColor      : "#ffcc00"
    });
   
    var _token = '{{csrf_token()}}'
    Vue.component('v-select', VueSelect.VueSelect);
 
    Vue.http.headers.common['X-CSRF-TOKEN'] = _token;
    var homepath = '{{url("/")}}';

    var app = new Vue({
    el: '#regApp',

    data:{
        regionales:[],
        distritos: [],
        regional: null,
        distrito: null,
        centrosEducativos:[],
        centrosEducativosFiltrados:[],
        distritosFiltrados:[],
        tipoDeUsuario: null,
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
            'name' : null,
            'email': null,
            'password': null,
            'id_regional': null,
            'id_distrito': null,
            'id_centroEducativo':null,
            'tipoDeUsuario': null
        },
        formErrores: []
        

    },
    watch: {
        'userData.id_regional': function(val){
            var id_regional = val
            this.distritosFiltrados = this.distritos.filter(function(item){
                return  item.id_regional == id_regional;
            });   
            this.userData.id_distrito = null;  
        },
        'userData.id_distrito': function(val){
            var id_distrito = val
            this.centrosEducativosFiltrados = this.centrosEducativos.filter(function(item){
                return item.id_distrito ==  id_distrito;
            });
        }    
    },
    methods:{
        registrar : function(){
            _this = this;
            $("#formulario").LoadingOverlay("show");

            this.$http.post(homepath  + '/register', {data:_this.userData}).then(response => {
                var respuesta = response.body; 
                console.log(response.body)
                $("#formulario").LoadingOverlay("hide");
             
                if(respuesta == 'registrado'){
                    location.replace(homepath  + '/')
                }     
            }, response => {
                _this.formErrores= response.body.errors;
                $("#formulario").LoadingOverlay("hide");
            });
                
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
    }
})
</script>
@endsection
