@extends('layout.layout')

@include('layout.sidebar')
@section('content')
<style>
    .dataTables_wrapper .dataTables_filter{
        float: right;
    }
</style>
<section class="content" id='app'>
<div v-for="centro in centrosEducativos " class="col-lg-4 col-md-4 col-sm-6 col-xs-12" v-on:click="abrirDashboard(centro)">
    <div class="card">
        <div class="header bg-cyan">
            <h2>
                @{{centro.centro}}
            </h2>
            <ul class="header-dropdown m-r--5">
                <li>
                    <a href="javascript:void(0);">
                        
                    </a>
                </li>
                
            </ul>
        </div>
        <div class="body">
            
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
        var centrosEducativos = {!! json_encode($centrosEducativos) !!};
       

        var app = new Vue({
        el: '#app',
        components: {
            vuejsDatepicker
        },
        data:{
            centrosEducativos:centrosEducativos,
          
        },
        watch: {
         
      

        },
        methods:{

            abrirDashboard: function (centro){
                var id_centro = centro.id_centroEducativo;
                var url = homepath + '/subvenicones/tableroSubvenciones/'+id_centro
               
                window.open(url,'_blank')
            }
         

        
        

        },
        mounted: function(){
           
        }
    })
	</script>
  
@endsection