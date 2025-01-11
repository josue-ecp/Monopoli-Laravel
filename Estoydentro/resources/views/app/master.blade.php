<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Empty Page</title>

    <link href="{{asset('app/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('app/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{asset('app/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('app/css/style.css')}}" rel="stylesheet">

</head>

<body class="">

    <div id="wrapper">

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                             <!-- <img alt="image" class="rounded-circle" src="{{ getPlayerImage() }}" width="50" height="50" /> -->
                          
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="block m-t-xs font-bold">David Williams</span>
                                <span class="text-muted text-xs block">Opciones <b class="caret"></b></span>
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            @if(valida_permiso('GERO'))
                                <li><a class="dropdown-item" href="{{ action([App\Http\Controllers\JugadorController::class, 'home']) }}">Home de Jugador</a></li>
                            @endif

                                <li><a class="dropdown-item" href="contacts.html">Contacts</a></li>
                                <li><a class="dropdown-item" href="mailbox.html">Mailbox</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="login.html">Cerrar sesión</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            IN+
                        </div>
                    </li>
                    @if(valida_permiso('GERO'))
                    <li>
                        <a href="{{ action([App\Http\Controllers\RolController::class,'index']) }}"><i class="fa fa-diamond"></i> <span class="nav-label">Roles</span></a>
                    </li>
                    @endif
                    @if(valida_permiso('GUSU'))
                    <li>
                        <a href="{{ action([App\Http\Controllers\UsuariosController::class,'listado']) }}"><i class="fa fa-diamond"></i> <span class="nav-label">Usuarios</span></a>
                    </li>
                    @endif
                    @if(valida_permiso('GEJU'))
                    <li>
                        <a href="{{ action([App\Http\Controllers\JugadorController::class,'listado']) }}"><i class="fa fa-diamond"></i> <span class="nav-label">Jugadores</span></a>
                    </li>
                    @endif
                    @if(valida_permiso('GEPRO'))
                    <li>
                        <a href="{{ action([App\Http\Controllers\PropiedadController::class,'listado']) }}"><i class="fa fa-diamond"></i> <span class="nav-label">Propiedades</span></a>
                    </li>
                    @endif
                    @if(valida_permiso('GEPA'))
                    <li>
                        <a href="{{ action([App\Http\Controllers\PartidaController::class,'index']) }}"><i class="fa fa-diamond"></i> <span class="nav-label">Partidas</span></a>
                    </li>
                    @endif
                    @if(valida_permiso('GETP'))
                    <li>
                        <a href="{{ action([App\Http\Controllers\TipopropiedadController::class,'index']) }}"><i class="fa fa-diamond"></i> <span class="nav-label">Tipo Propiedad</span></a>
                    </li>
                    @endif
                    @if(valida_permiso('GEPROJU'))
                    <li>
                        <a href="{{ action([App\Http\Controllers\PropiedadxjugadorController::class,'listado']) }}"><i class="fa fa-diamond"></i> <span class="nav-label">Propiedad x Jugador</span></a>
                    </li>
                    @endif
                    @if(valida_permiso('GEPER'))
                    <li>
                        <a href="{{ action([App\Http\Controllers\PermisoController::class,'index']) }}"><i class="fa fa-diamond"></i> <span class="nav-label">Permisos</span></a>
                    </li>
                    @endif
                    
                    @if(valida_permiso('GERE'))
                    <li>
                        <a href="{{ action([App\Http\Controllers\RegionController::class,'listado']) }}"><i class="fa fa-diamond"></i> <span class="nav-label">Regiones</span></a>
                    </li>
                    @endif
                </ul>
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#"><i class="fa fa-bars"></i></a>
                        <form role="search" class="navbar-form-custom" action="search_results.html">
                            <div class="form-group">
                                <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                            </div>
                        </form>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <?php
                            $usuario = dame_usuario();
                            ?>
                            <span class="m-r-sm text-muted welcome-message">{{$usuario->email}}</span>
                        </li>
                        <li>
                            <a href="{{ action([App\Http\Controllers\LoginController::class,'cerrar_sesion']) }}">
                                <i class="fa fa-sign-out"></i> Cerrar sesión
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2>@yield('titulo','Sin título')</h2>
                </div>
            </div>
            <div class="wrapper wrapper-content">
                @yield('contenido','Sin contenido')
            </div>
            <div class="footer">
                <div class="float-right">
                    10GB of <strong>250GB</strong> Free.
                </div>
                <div>
                    <strong>Copyright</strong> Example Company &copy; 2014-2018
                </div>
            </div>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{asset('app/js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('app/js/popper.min.js')}}"></script>
    <script src="{{asset('app/js/bootstrap.js')}}"></script>
    <script src="{{asset('app/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{asset('app/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{asset('app/js/inspinia.js')}}"></script>
    <script src="{{asset('app/js/plugins/pace/pace.min.js')}}"></script>

</body>

</html>
