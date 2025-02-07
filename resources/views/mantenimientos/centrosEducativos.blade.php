@extends('layout.layout')

@include('layout.sidebar')
@section('content')
<style>
.panel-default > .panel-heading {
    color: #333;
    background-color: #233f8d;
    border-color: #ddd;
    color: white;
}
.modal .modal-header {
    border: none;
    padding: 25px 25px 5px 25px;
    background-color: #233f8d;
    color: white;
}
</style>
<section class="content" id='app'>
    <div class="container-fluid">
        <div class="block-header">
            
        </div>
        <div class="page-body">
            <div class="panel panel-default">
                <div class="panel-heading">Centros Educativos 
                    <button class="btn btn-success  pull-right" v-on:click="addupdaterecord()">Agregar Centro</button>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-hover" id="centrosEducativo">
                        <thead>
                            <tr>
                                <th>Regional</th>
                                <th>Distrito Educativo</th>
                                <th>Centro Educativo</th>
                                <th>Director</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="centro in centrosEducativos">
                                <td>@{{centro.Regional}}</td>
                                <td>@{{centro.nombreDistriro}}</td>
                                <td>@{{centro.centro}}</td>
                                <td>@{{centro.DirectorDelCentro}}</td>
                                <td>
                                    <button type="button"  v-on:click="editar(centro.id_centroEducativo)" class="btn btn-info" >Editar</button>
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
                <h4 class="modal-title" id="smallModalLabel">Agregar Centro Educativo</h4>
            </div>
            <div class="modal-body clearfix">
                <div class="row">
                    <div class="col-lg-12">
                        <label for="">Regional</label>
                        <v-select  label="Regional"  :reduce="(option) => option.id_regional" v-model='centroEducativo.id_regional' :options="regionales"></v-select>      
                    </div>
                    <div class="col-lg-12">
                        <label for="">Distrito</label>
                        <v-select  label="nombreDistriro"  :reduce="(option) => option.id_distrito" v-model='centroEducativo.id_distrito' :options="distritosFiltrados"></v-select>       
                    </div>

                    <div class="col-lg-12">
                        <label for="">Centro</label>
                        <input type="text" name=""  v-model='centroEducativo.centro'  class="form-control" >
                    </div>

                    <div class="col-lg-12">
                        <label for="">Director</label>
                        <input type="text" name=""  v-model='centroEducativo.DirectorDelCentro' class="form-control" id="labordays">
                    </div>

                    <div class="col-lg-12">
                        <label for="">Numero de Cuenta Banco</label>
                        <input type="number" name=""  v-model='centroEducativo.numeroDeCuantaBanco' class="form-control" >
                    </div>

                    
                    <div class="col-lg-12">
                        <label for="">Total Estudiantes</label>
                        <input type="number" name=""  v-model='centroEducativo.totalEstudiantes' class="form-control" >
                    </div>


                </div>     
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" v-on:click="guardarCentroEducativo()">Agregar</button>
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
        var imagenlogo = homepath +'/images/ETP.png'
        $.LoadingOverlaySetup({
            background      : "rgba(255, 255, 255, 0.8)",
            image           : imagenlogo,
            imageAnimation  : "1.5s fadein",
            imageColor      : "#ffcc00"
        });
   
        var centros = {!! json_encode($centros) !!};
        var regionales = {!! json_encode($regionales) !!};
        var distritos = {!! json_encode($distritos) !!};


        var app = new Vue({
        el: '#app',
        data:{
            centrosEducativos:centros,
            regionales:regionales,
            distritos: distritos,
            distritosFiltrados : [],
            centroEducativo:{
                centro: null,
                DirectorDelCentro: null,
                id_distrito: null,
                id_regional: null,
                numeroDeCuantaBanco:null,
                totalEstudiantes: null
            },
            centroSeleccionado:[]



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

            editar: function(id_centroEducativo){
                $("#app").LoadingOverlay("show");

                this.centroSeleccionado = this.centrosEducativos.filter(function(centro){
                    return centro.id_centroEducativo == id_centroEducativo
                })[0];
                this.centroEducativo =  this.centroSeleccionado;
                this.$nextTick(()=>{
                    this.centroEducativo.id_distrito =  this.centroSeleccionado.id_distrito
                })
                $('#newRecord').modal('show')
                $("#app").LoadingOverlay("hide");
            },
         
            addupdaterecord: function(){
                $('#newRecord').modal('show')
            },
            guardarCentroEducativo : function(){
                 _this = this;
                 $("#newRecord").LoadingOverlay("show");
                 this.$http.post(homepath  + '/centrosEducativos/agregar', {dataCentroEducativo: _this.centroEducativo}).then(response => {
                     console.log(response.body);
                     location.reload();
                }, response => {
                    $("#app").LoadingOverlay("hide");
                });
                $("#newRecord").LoadingOverlay("hide");
            }

        },
        mounted: function(){
            $('#centrosEducativo').DataTable({
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