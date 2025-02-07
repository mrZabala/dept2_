@extends('layout.layout')
@include('layout.sidebar')
@section('content')
<style>
.sidebar .menu {
    overflow-y: hidden !important;
}
</style>
<section class="content" id='app'>
<div class="container-fluid" >
            <div class="page-heading">
                 <h3>Tablero Subvenciones @{{dataTabl.centroNombre}}</h3> 
            </div>
            <!-- Widgets -->
            <div class="row clearfix">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Gastos
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li><h2 v-html="montoFix(dataTabl.gastos.totalDegastos.total)"></h2></li>
                               
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div  v-for='tipo in dataTabl.gastos.distribucionPorTipoDeGasto' class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <div class="info-box bg-pink hover-expand-effect">
                                        <div class="icon">
                                            <i class="material-icons">receipt</i>
                                        </div>
                                        <div class="content">
                                            <div class="text">@{{tipo.nombre}} </div>
                                            <div class="number count-to" data-from="0" :data-to="tipo.sumatoria" data-speed="15" data-fresh-interval="20"></div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        </div>
                    </div>
                    
                

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Gastos Detalles
                            </h2>
                            <ul class="header-dropdown m-r--5">
                         
                               
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <canvas id="distribucionPorSubTipoDeGastos"></canvas>
                                </div>  
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <canvas id="graficaPorMEs"></canvas>
                                </div>   
                            </div> 
                        </div>
                        </div>
                    </div>
                    
                </div>

         
                           
         
</div>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Ingresos
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li><h2 v-html="montoFix(dataTabl.ingresos.totalIngresos.total)"></h2></li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <canvas id="distribucionIngresosPorTipo"></canvas>
                                </div>  
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">

                                <table class="table">
                                    <tr>
                                        <th>Tipo de Ingreso</th>
                                        <th>Fecha</th>
                                        <th>Monto</th>
                                    </tr>
                                    <tr v-for="sub in dataTabl.ingresos.Subvenciones">
                                        <td>@{{sub.tipoIngreso}}</td>
                                        <td>@{{sub.fecha}}</td>
                                        <td v-html="montoFix(sub.monto)"></td>
                                    </tr>
                                </table>
                                    
                                </div>   
                            </div> 
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
        var dataTabl = {!! json_encode($datos) !!};
        var app = new Vue({
        el: '#app',
        components: {
            vuejsDatepicker
        },
        data:{
            dataTabl:dataTabl,
            buscarDato: {
                desde : null,
                hasta: null
            },
          
        },
        watch: {
        
            'desde': function(date){
                this.buscarDato.desde =  moment(date).format('yyyy/MM/DD');
            },
            'hasta': function(date){
                this.buscarDato.hasta =  moment(date).format('yyyy/MM/DD');
            }

        },
        methods:{
            montoFix: function(monto){
                let usDollar = new Intl.NumberFormat('en-US',{
                                    style: 'currency',
                                    currency: 'USD'
                                })

                return '<b>' + usDollar.format(monto) +'</b>';
                        
            },
            graficaIngresos: function(){
                var datosOrdenados = this.dataTabl.ingresos.distribucionIngresosPorTipo;
                const ctx = document.getElementById('distribucionIngresosPorTipo');
                new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: datosOrdenados.map(row => row.tipo_ingreso),
                    datasets: [{
                    label: 'Distribucion de Ingresos por Tipo ingresos',
                    data: datosOrdenados.map(row => row.sumatoria),
                    borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                    y: {
                        beginAtZero: true
                    }
                    }
                }
                });
            },
            graficaGastosDetalle: function(){
                var datosOrdenados = this.dataTabl.gastos.distribucionPorSbuTipoDeGasto;
                const ctx = document.getElementById('distribucionPorSubTipoDeGastos');
                new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: datosOrdenados.map(row => row.nombre),
                    datasets: [{
                    label: 'Distribucion de Gastos por Sub Tipos de Gastos ',
                    data: datosOrdenados.map(row => row.sumatoria),
                    borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                    y: {
                        beginAtZero: true
                    }
                    }
                }
                });
            },
            graficaPorMEs: function(){
                var datosOrdenados = this.dataTabl.gastos.distribucionPorMes;
                const ctx = document.getElementById('graficaPorMEs');
                new Chart(ctx, {
                type: 'line',
                data: {
                    labels: datosOrdenados.map(row => row.mes),
                    datasets: [{
                    label: 'Comportamiento de Gastos por Mes',
                    data: datosOrdenados.map(row => row.sumatoria),
                    borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                    y: {
                        beginAtZero: true
                    }
                    }
                }
                });
            },
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
         
          
            mostrarError: function(){
                Swal.fire({
                        title: 'Upps!',
                        text: 'Algo Salio Mal',
                        icon: 'error',
                        confirmButtonText: 'ok'
                })
            },
   
        
        
        },
        mounted: function(){
            this.graficaGastosDetalle();
            this.graficaPorMEs();
            this.graficaIngresos();
        }
    })
	</script>
  
@endsection
