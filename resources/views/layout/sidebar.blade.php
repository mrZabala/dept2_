 <!-- Top Bar -->
 <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand">DETP</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                   <li class="navbar-brand">{{Auth::user()->name}}</li>
                   <li class="navbar-brand">({{Auth::user()->email}})</li>

                    <!-- #END# Call Search -->
                    <!-- Notifications -->
                   
                    <!-- #END# Notifications -->
                  
                    <!-- #END# Tasks -->
                      <!--<li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li -->>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                   
                </div>
                <div class="info-container">
                    
                    
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">

                            <li role="seperator" class="divider"></li>
                            <li><a href="{{ route('logout') }}"  onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">      
                                <i class="material-icons">input</i> {{ __('Cerrar Sesion') }}
                                </a></li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">NAVEGACIÓN PRINCIPAL</li>
                    <li class="">
                       
                    </li> 
                    <!-- 
                    <li>
                        <a href="{{url('/ControlPanel')}}">
                            <i class="material-icons">event_note</i>
                            <span class="nav-label">Inclusion de Centro<span>
                        </a>
                    </li> 
                    -->
                    <li>
                        <a href="{{url('/ControlPanel')}}">
                            <i class="material-icons">build</i>
                            <span class="nav-label">Control Panel<span>
                        </a>
                    </li> 
                  
                    <li>
                        <a href="javascript:void(0)" class="menu-toggle">
                            <i class="material-icons">event_note</i>
                            <span class="nav-label">Configuraciones<span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            
                           
                            <li>
                                <a href="{{URL('/centrosEducativos')}}">Centros Educativos</a>
                            </li>
                           
                        </ul>
                    </li> 
                    <li>
                        <a href="javascript:void(0)" class="menu-toggle">
                            <i class="material-icons">event_note</i>
                            <span class="nav-label">Subvenciones<span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            
                            <li>
                                <a href="{{URL('/subvenicones/registro')}}">Registro Actividades</a>
                            </li>
                            <li>
                                <a href="{{URL('/subvenicones/registroIngresos')}}">Registro Ingresos</a>
                            </li>
                            <li>
                                <a href="{{URL('/subvenicones/tableroSubvenciones')}}">Tablero</a>
                            </li>
                           
                        </ul>
                    </li>
          
                    <li>
                        <a href="javascript:void(0)" class="menu-toggle">
                            <i class="material-icons">event_note</i>
                            <span class="nav-label">Vinculaciones<span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            
                            <li>
                                <a href="{{URL('/empresas')}}">Empresas</a>
                            </li>
                            <li>
                                <a href="{{URL('/estudiantes')}}">Estudiantes</a>
                            </li>
                            <li>
                                <a href="{{URL('')}}">Colocacion</a>
                            </li>
                           
                        </ul>
                    </li> 
                
                    <!-- 
                  
                    <li>
                        <a href="javascript:void(0)" class="menu-toggle">
                            <i class="material-icons">event_note</i>
                            <span class="nav-label">Reportes<span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            
                            <li>
                                <a href="{{URL('fraud_claims')}}">Empresas</a>
                            </li>
                            <li>
                                <a href="{{URL('non_fraud_claims')}}">Estudiantes</a>
                            </li>
                            <li>
                                <a href="{{URL('non_fraud_claims')}}">Subvenciones</a>
                            </li>
                           
                        </ul>
                    </li> 
                    -->
                </ul>  

            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2024 <a href="javascript:void(0);">EDSoftware</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.3
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
      
        <!-- #END# Right Sidebar -->
    </section>
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="index.html">DETP</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                    <!-- #END# Call Search -->
                    <!-- Notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <span class="label-count">7</span>
                        </a>
                       
                    </li>
                    <!-- #END# Notifications -->
                    <!-- Tasks -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">flag</i>
                            <span class="label-count">9</span>
                        </a>
                        
                    </li>
                    <!-- #END# Tasks -->
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->