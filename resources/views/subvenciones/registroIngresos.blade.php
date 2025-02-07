@extends('layout.layout')

@include('layout.sidebar')
@section('content')
<style>
    .dataTables_wrapper .dataTables_filter{
        float: right;
    }
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
	<div class="page-heading">
        <h3>Resgistro de ingresos @{{centro.centro}}</h3>     
    </div>
    <div class="page-body">
    	<div class="panel panel-default">
            <div class="panel-heading">Actividades
                 <button class="btn btn-info m-l-15 pull-right" v-on:click="abrirFiltros()">Buscar</button>
                 <button class="btn btn-success m-l-15 pull-right" v-on:click="addupdaterecord()">Agregar ingresos</button>
            
            </div>
            <div class="panel-body">
            	<table class="table  table-hover" id="registros">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo de ingreso</th>
                            <th>Monto</th>
                            <th>Discripcion</th>
                            <th>Opciones</th>

                           
                        </tr>
                    </thead>
                    <tbody>
                     
                    </tbody>
                </table>
            </div>
        </div>
       
    </div>

    <div class="modal fade" id="newRecord" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">Agregar ingresos</h4>
                </div>
                <div class="modal-body clearfix">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Fecha</label>
                            <vuejs-datepicker v-model="fecha_entrada"  :format="customFormatter"></vuejs-datepicker>

                        </div>
                        <div class="col-lg-12">
                            <label for="">Tipo de ingresos</label>
                            <v-select label= "tipo_ingreso"  :reduce="(option) => option.id" :options="tipo_ingreso" v-model="ingreso.tipo_ingreso"></v-select>           
                        </div>
                        <div class="col-lg-12">
                            <label for="">Monto</label>
                            <input type="number"  v-model="ingreso.monto" class="form-control" >
                        </div>
                        <div class="col-lg-12">
                            <label for="">Descripcion</label>
                            <input type="text" v-model="ingreso.descripcion" class="form-control" >
                        </div>
                    </div>     
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" v-on:click="agregarIngreso()">Agregar</button>
                </div>
            </div>
        </div>
    </div>    
    <div class="modal fade" id="buscarModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="smallModalLabel">Buscar</h4>
                </div>
                <div class="modal-body clearfix">
                    <div class="col-lg-6">
                            <label for="">Desde</label>
                            <vuejs-datepicker v-model="desde"  :format="customFormatter"></vuejs-datepicker>
                    </div>
                    <div class="col-lg-6">
                            <label for="">Hasta</label>
                            <vuejs-datepicker v-model="hasta"  :format="customFormatter"></vuejs-datepicker>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" v-on:click="buscar">Buscar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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
        var centro = {!! json_encode($centro) !!};
        var tipo_ingreso = {!! json_encode($tipo_ingreso) !!};
        var ingresosDelcentro = {!! json_encode($ingresosDelcentro) !!};

        var app = new Vue({
        el: '#app',
        components: {
            vuejsDatepicker
        },
        data:{
            centro:centro,
            ingresosDelcentro: ingresosDelcentro,
            tipo_ingreso: tipo_ingreso ,
            fecha_entrada: null,
            dt:null,
            desde: null,
            hasta: null,
            buscarDato: {
                desde : null,
                hasta: null
            },
            ingreso: {
                'fecha': null,
                'tipo_ingreso': null,
                'monto': null,
                'descripcion':null
            }
        },
        watch: {
            ingresosDelcentro: function(val){
                this.dt.clear().draw();
                this.dt.row.add(val);
                this.dt.columns.adjust().draw();
            },
          
            'fecha_entrada': function(date){
                this.ingreso.fecha =  moment(date).format('yyyy/MM/DD');
            },
            'desde': function(date){
                this.buscarDato.desde =  moment(date).format('yyyy/MM/DD');
            },
            'hasta': function(date){
                this.buscarDato.hasta =  moment(date).format('yyyy/MM/DD');
            }

        },
        methods:{
            buscar: function(){
                _this = this;
                _this.$http.post(homepath  + '/subvenicones/buscarIngresos', {buscar : _this.buscarDato}).then(response => {
                        _this.gastosDelcentro =  response.data;
                        console.log( _this.gastosDelcentro );
                }, response => {
                // error callback
                });
            },

            abrirFiltros:  function(){
                $('#buscarModal').modal('show')
            },

            customFormatter: function(date) {
                return moment(date).format('MM/DD/yyyy');
            },
            eliminarIngreso:function(id){
                _this = this;
                Swal.fire({
                        title: 'Estas Seguro?',
                        text: 'Esta entrada esta a punto de ser Eliminada y no se podra recuperar',
                        showCancelButton: true,
                        confirmButtonText:"Proceder"   
                }).then(function(eliminar){
                        if(eliminar.isConfirmed){
                                _this.$http.post(homepath  + '/subvenicones/eliminarIngreso', {id_ingreso : id}).then(response => {
                                    location.reload();
                                }, response => {
                                // error callback
                                });
                        }  
                });
            },
            inciarTabla: function(){
                var _this = this;
                this.dt = $('#registros').DataTable({
                    responsive: true,
                    data: _this.ingresosDelcentro,
                    dom:'Bftip',
                    buttons:[
                        'excel'
                    ],
                    columns: [
                         {data : 'fecha'},
                         {data : 'tipoIngreso'},
                       
                         //{data : 'monto'},
                         {
                            render: function(data, t, row){
                                let usDollar = new Intl.NumberFormat('en-US',{
                                    style: 'currency',
                                    currency: 'USD'
                                })

                              return '<b>' + usDollar.format(row.monto) +'</b>';
                            } 
                         },
                         {data : 'descripcion'},
                         {
                            render: function(data, t, row){
                                var editar = '<button class="btn btn-info m-l-15 pull-right" onClick="app.addupdaterecord()">Editar</button>'
                                var eliminar = '<button class="btn btn-danger m-l-15 pull-right" onClick="app.eliminarIngreso('+ row.id+')">Eliminar</button>'
                                return  eliminar;
                            } 
                         }
                      
                    ]
                });

            },
            mostrarError: function(){
                Swal.fire({
                        title: 'Upps!',
                        text: 'Algo Salio Mal',
                        icon: 'error',
                        confirmButtonText: 'ok'
                })
            },
        
            agregarIngreso : function (){
                _this = this;
                this.$http.post(homepath  + '/subvenicones/guardarIngresos', {ingreso: _this.ingreso}).then(response => {
                    if(response.data){
                        Swal.fire({
                            title: 'Bien!',
                            text: 'Ingreso Registrado',
                            icon: 'success',
                            confirmButtonText: 'ok'
                        })
                        location.reload();
                    }else{
                        _this.mostrarError();
                    }
                }, response => {
                    _this.mostrarError();
                }); 
                $('#newRecord').modal('hide')
            },
        
            addupdaterecord: function(){
                $('#newRecord').modal('show')
            }

        },
        mounted: function(){
            this.inciarTabla();
        }
    })
	</script>
  
@endsection