<?php

//Importamos clase de sesión y declaramos el objeto de la clase
require_once("clases/class.Sesion.php");
$se = new Sesion();

//Validamos que eixista una sesion iniciada
if(!isset($_SESSION['se_SAS']))
{
    //Si no existe una sesion iniciada enviamos a login.
    header("Location: login.php");
    exit;
}

//Importamos las clases que se van a utilizar
require_once("clases/conexcion.php");
require_once("clases/class.Funciones.php");
require_once("clases/class.Fechas.php");

//Declaramos objetos de clase
$db = new MySQL();

$fe = new Fechas();
$f = new Funciones();

//Declaramos variables y asignamos valores.
$fecha_actual = explode("-",$fe->fechaaYYYY_mm_dd_guion());

$tipo = $_SESSION['se_sas_Tipo'];





//Obtenemos el navegador que esta ejecutandose
$navegador = $f->navegador();



//Validamos que solo se pueda ejecutar en Chrome o en Safari
/*if ($navegador != "Google Chrome" && $navegador != "Safari")
{
    header("Location: error404.php");
    exit;   
}*/
?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/configuracion/imagentransparente.png"> 
    <title>Invitaciones Digitales · Dashboard</title>
    <!-- Custom CSS -->
    <link href="assets/libs/flot/css/float-chart.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type="text/css" href="dist/css/modal.css">
    <link rel="stylesheet" type="text/css" href="dist/css/switch.css">
    <link href="assets/libs/magnific-popup/dist/magnific-popup.css" rel="stylesheet">
    <link href="dist/css/mystyle.css?v=3" rel="stylesheet">
    <link href="assets/libs/chosen_v1.8.7/chosen.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="dist/css/modalfull.css">
    
    <link href="assets/libs/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.css" rel="stylesheet">
   
   

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body>


    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
  <!--   <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div> -->
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    
    
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5" >
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand wedding-brand" href=".">
                        <!-- Logo icon -->
                        <b class="logo-icon p-l-10">
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <!--<img src="assets/images/logo-icon.png" alt="homepage" class="light-logo" />-->

                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="brand-heart" aria-hidden="true"><i class="mdi mdi-heart-outline"></i></span>
                        <span class="logo-text"><strong>INVITACIONES</strong><em>Digitales</em></span>
                       <!-- Logo icon -->
                       <!-- <b class="logo-icon"> -->
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <!-- <img src="../../assets/images/logo-text.png" alt="homepage" class="light-logo" /> -->

                        <!-- </b> -->
                        <!--End Logo icon -->
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto">





                       <!--<li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>-->
                       <!-- ============================================================== -->
                       <!-- create new -->
                       <!-- ============================================================== -->
                        <!--<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <span class="d-none d-md-block">Create New <i class="fa fa-angle-down"></i></span>
                             <span class="d-block d-md-none"><i class="fa fa-plus"></i></span>   
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li>-->
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <!--<li class="nav-item search-box"> <a class="nav-link waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                            <form class="app-search position-absolute">
                                <input type="text" class="form-control" placeholder="Search &amp; enter"> <a class="srh-btn"><i class="ti-close"></i></a>
                            </form>
                        </li>-->
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">


                      <form class="">


                         <span class="nombreetiqueta" style="font-size: 12px!important;color: #fefefe;
                         top: 23px;padding-top: 1em;">¡BIENVENIDO! <?php echo $f->imprimir_cadena_utf8($_SESSION['se_Empleado']); ?></span>
                         
                     </form>

                     <!-- ============================================================== -->
                     <!-- Comment -->
                     <!-- ============================================================== -->
                        <!--<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell font-24"></i>
                            </a>
                             <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li>-->
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        <!--<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="font-24 mdi mdi-comment-processing"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown" aria-labelledby="2">
                                <ul class="list-style-none">
                                    <li>
                                        <div class="">
                                            <a href="javascript:void(0)" class="link border-top">
                                                <div class="d-flex no-block align-items-center p-10">
                                                    <span class="btn btn-success btn-circle"><i class="ti-calendar"></i></span>
                                                    <div class="m-l-10">
                                                        <h5 class="m-b-0">Event today</h5> 
                                                        <span class="mail-desc">Just a reminder that event</span> 
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="javascript:void(0)" class="link border-top">
                                                <div class="d-flex no-block align-items-center p-10">
                                                    <span class="btn btn-info btn-circle"><i class="ti-settings"></i></span>
                                                    <div class="m-l-10">
                                                        <h5 class="m-b-0">Settings</h5> 
                                                        <span class="mail-desc">You can customize this template</span> 
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="javascript:void(0)" class="link border-top">
                                                <div class="d-flex no-block align-items-center p-10">
                                                    <span class="btn btn-primary btn-circle"><i class="ti-user"></i></span>
                                                    <div class="m-l-10">
                                                        <h5 class="m-b-0">Pavan kumar</h5> 
                                                        <span class="mail-desc">Just see the my admin!</span> 
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="javascript:void(0)" class="link border-top">
                                                <div class="d-flex no-block align-items-center p-10">
                                                    <span class="btn btn-danger btn-circle"><i class="fa fa-link"></i></span>
                                                    <div class="m-l-10">
                                                        <h5 class="m-b-0">Luanch Admin</h5> 
                                                        <span class="mail-desc">Just see the my new admin!</span> 
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>-->
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i  alt="user" class="fa fa-user-circle" style=" font-size: 40px;margin-top: .2em;"></i></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                <a class="dropdown-item" href="javascript:void(0)"><i class="ti-user m-r-5 m-l-5"></i> Mi perfil</a>
                                <!--<a class="dropdown-item" href="javascript:void(0)"><i class="ti-wallet m-r-5 m-l-5"></i> My Balance</a>
                                <a class="dropdown-item" href="javascript:void(0)"><i class="ti-email m-r-5 m-l-5"></i> Inbox</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)"><i class="ti-settings m-r-5 m-l-5"></i> Account Setting</a>-->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php"><i class="fa fa-power-off m-r-5 m-l-5"></i> Cerrar sesi&oacute;n</a>
                                <!--<div class="dropdown-divider"></div>
                                    <div class="p-l-30 p-10"><a href="javascript:void(0)" class="btn btn-sm btn-success btn-rounded">View Profile</a></div>-->
                                </div>
                            </li>
                            <!-- ============================================================== -->
                            <!-- User profile and search -->
                            <!-- ============================================================== -->
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- ============================================================== -->
            <!-- End Topbar header -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->
            <aside class="left-sidebar" data-sidebarbg="skin5">
                <!-- Sidebar scroll-->
                <div class="scroll-sidebar">
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav" class="p-t-30">
                            <?php include("menu.php");?>
                        </ul>
                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->
            </aside>
            <!-- ============================================================== -->
            <!-- End Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Page wrapper  -->
            <!-- ============================================================== -->
            <div class="page-wrapper">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="page-breadcrumb">
                    <div class="row">
                        <div class="col-12 d-flex no-block align-items-center">
                            <!--<h4 class="page-title">Inicio</h4>-->
                            <div class="ml-auto text-right">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item" id="menuubicacion"><a href="#">Inicio /</a></li>

                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Container fluid  -->
                <!-- ============================================================== -->
                <div class="container-fluid" id="main">
                    <!-- ============================================================== -->
                    <!-- Sales Cards  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                         <div style="">
                            <!--  <img src="images/configuracion/market.png" alt="homepage" class="img-responsive" style="max-width: 200px; width: 90%;margin: auto;display: block;" /> -->
                         </div>
                     </div>
                     <div class="col-md-4"></div>
                 </div>
                 <div class="row" style="display: none;">
                    <!-- Column -->
                    <div class="col-md-6 col-lg-2 col-xlg-3">
                        <div class="card card-hover">
                            <div class="box bg-cyan text-center">
                                <h1 class="font-light text-white"><i class="mdi mdi-view-dashboard"></i></h1>
                                <h6 class="text-white">Inicio</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-4 col-xlg-3">
                        <div class="card card-hover">
                            <div class="box bg-success text-center">
                                <h1 class="font-light text-white"><i class="mdi mdi-chart-areaspline"></i></h1>
                                <h6 class="text-white">Gr&aacute;ficas</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-2 col-xlg-3">
                        <div class="card card-hover">
                            <div class="box bg-warning text-center">
                                <h1 class="font-light text-white"><i class="mdi mdi-collage"></i></h1>
                                <h6 class="text-white"></h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-2 col-xlg-3">
                        <div class="card card-hover">
                            <div class="box bg-danger text-center">
                                <h1 class="font-light text-white"><i class="mdi mdi-border-outside"></i></h1>
                                <h6 class="text-white"></h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-2 col-xlg-3">
                        <div class="card card-hover">
                            <div class="box bg-info text-center">
                                <h1 class="font-light text-white"><i class="mdi mdi-arrow-all"></i></h1>
                                <h6 class="text-white"></h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->                    
                </div>

                <div style="display: none; position:absolute;
                bottom:5px;
                right:10px;">
                <img src="images/configuracion/logo.png" alt="homepage" class="light-logo" style="max-width: 200px; width: 90%;" />
            </div>
            <!-- ============================================================== -->                

        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer text-center">


       </footer>
       <!-- ============================================================== -->
       <!-- End footer -->
       <!-- ============================================================== -->
   </div>
   <!-- ============================================================== -->
   <!-- End Page wrapper  -->
   <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->


<!-- ================================ MODALES ================================================== -->


<!-- MODAL DE NOTIFICACION -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-notificacion" style="z-index: 2000">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title" id="modal-title" style="text-align: center; width: 100%; font-weight: bold; font-size: 17px;">Modal title</p> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="display: none">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="hidden" name="bandera_modal" id="bandera_modal" value="0">
            <div class="modal-body" id="modal-body">
                <p id="c_modal">


                </p>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="modal-forms" tabindex="-1" role="dialog" style="overflow-y: scroll;" >
    <div class="modal-dialog modal-lg" id="largomodal">
        <div class="modal-content" id="">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-modal-forms">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="contenedor-modal-forms">

            </div>

                <!--<div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>-->
            </div>
        </div>
    </div>
    

    <div class="modal fade" id="modal-forms2" tabindex="-1" role="dialog" style="z-index: 1990;overflow-y: scroll;">
        <div class="modal-dialog modal-lg" id="largomodal">
            <div class="modal-content" id="">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo-modal-forms2">Modal title</h5>
                    <button type="button" id="regresar" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="contenedor-modal-forms2">

                </div>

                <div class="modal-footer" >
                    <div id="footer-modal-forms2"></div>
                    
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="modal-forms3" tabindex="-1" role="dialog" style="z-index: 1990;overflow-y: scroll;">
        <div class="modal-dialog modal-lg" id="largomodal">
            <div class="modal-content" id="">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo-modal-forms3">Modal title</h5>
                    <button type="button"  class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="contenedor-modal-forms3">

                </div>

                <div class="modal-footer" >
                    <div id="footer-modal-forms3"></div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-reportes" tabindex="-1" role="dialog" style="z-index: 1992;">
        <div class="modal-dialog modal-lg" role="document" style="height: 90%;">
            <div class="modal-content" style="height: 90%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo-modal-reportes"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="contenedor-modal-reportes" style="height: 90%;">

                </div>
                
                <!--<div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>-->
            </div>
        </div>
    </div>
    
    
    
    <!-- Modal -->
    <div class="modal fade" id="Modal-fotos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Nombre_imagen">Imagen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="imagen-colocar-producto" src="" width="100% ">
                </div>
            </div>
        </div>
    </div>
    
    
    <!-- Modal grupo -->
    <div class="modal fade" id="modalgrupo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo-productos">NUEVO OPCIÓN</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="contenedor-productos-modal" style="overflow: auto;">


                    <form action="">
                        <label for="">TÍTULO:</label>

                        <input type="text" id="nombregrupo" class="form-control">
                        <br>
                        <label for="">¿CUENTA CON COSTO ADICIONAL?</label>
                        <div class="form-check">


                          <input type="radio" id="conprecio" name="costoadicional" class="form-check-input" value="1">
                          <label class="form-check-label" for="exampleRadios1">
                             SI
                         </label>
                     </div>


                     <div class="form-check">


                      <input type="radio" id="sinprecio" name="costoadicional" class="form-check-input" value="0">
                      <label class="form-check-label" for="exampleRadios1">
                        NO
                     </label>
                 </div>

                 <br>

                        <label for="">¿LA SELECCIÓN ES MÚLTIPLE?</label>

               


             <div class="form-check">


              <input type="radio" id="unica" name="seleccionmultiple" class="form-check-input " value="1">
              <label class="form-check-label" for="exampleRadios1">
                 SI
              </label>
          </div>
            <div class="form-check">


                  <input type="radio" id="unica2" name="seleccionmultiple" class="form-check-input" value="0">
                  <label class="form-check-label" for="exampleRadios1">
                    NO
                 </label>
             </div>



          <br>




          <label for="">AGREGAR OPCIÓN<button type="button" onclick="AgregarOpciones()" class="btn btn-primary"><span class="mdi mdi-plus"></span></button>
          </label>

          <div id="opciones"></div>


         <div class="" style="padding-top: 1em;">
             <button type="button" onclick="AgregarGrupo();" class="btn btn-success" style="float: right;" title="">
               AGREGAR</button>

         </div>



      </form>



  </div>
</div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modaldirecciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulodirecciones">DIRECCIONES DE ENVÍO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body " >

                <div class="table-responsive" id="contenedor-direcciones"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modaldireccionesfiscales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulodirecciones">DATOS FISCALES</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body " >

                <div class="table-responsive" id="contenedor-direccionesfiscales"></div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-caja" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo-modal-caja">Cobrar pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="contenedor-modal-caja">

            </div>

                <!--<div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>-->
            </div>
        </div>
    </div>
    
    
    
    
    <!-- Modal -->
    <div class="modal fade" id="Modal-visor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo-visor"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="contenedor-visor-modal" style="overflow: auto;">
                </div>
            </div>
        </div>
    </div>
    
    
    
    <div class="modal fade" id="Modal-alertas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo-alerta" style="text-align: center;"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="contenedor-modal-alerta" style="overflow: auto; text-align: center;">
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================================================= -->
    
    
    <!-- MODAL DE VISTA DE SEGUIMIENTOS -->
    <div class="modal fade" tabindex="-1" role="dialog" style="display: none;" id="modal-seguimientos">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" id="modal-header-seguimientos">
                    <span class="modal-title" id="modal-title" style="font-size: 14px; font-weight: bold;">SEGUIMIENTOS</span> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!--<input type="hidden" name="bandera_modal" id="bandera_modal" value="0">-->
                <div class="modal-body" id="modal-body-seguimientos">
                    <p id="c_modal">


                    </p>
                </div>

            </div>
        </div>
    </div>

    <!-- MODAL DE ENVIO MAIL -->
    <div class="modal fade" tabindex="-1" role="dialog" style="display: none;" id="modal-mail">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" id="modal-header-mail">
                    <span class="modal-title" id="modal-title-mail" style="font-size: 14px; font-weight: bold;">COMPARTIR A EMAIL</span> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body-mail">
                </div>

            </div>
        </div>
    </div>
    
    <!-- MODAL DE FOTOS DE SEGUIMIENTOS -->
    <div class="modal FADE" tabindex="-1" role="dialog" id="modal-fotos">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title" id="modal-header-fotos" style="font-size: 14px; font-weight: bold;">FOTOS</span> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body-fotos">

                </div>

            </div>
        </div>
    </div>
    
    
    <!--  MODAL PARA REPORTE  -->


    <div class="modal fade" id="Modal_Reporte_Servicio_Camiones" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Reporte Servicios</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body" >
          <iframe width="100%" height="700px" id="m_reporte_pdf_servicioscamiones" frameborder="0" scrolling="auto" src="">

          </iframe>       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" style="display: none">Imprimir</button>
    </div>
</div>
</div>
</div>

<div class="modal fade" id="Modal_Reporte_Entrega_Requerimientos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">REPORTE DE ENTREGA DE REQUERIMIENTOS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body" >
      <iframe width="100%" height="700px" id="pdf_entrega_requerimientos" frameborder="0" scrolling="auto" src="">

      </iframe>       
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-primary" style="display: none">Imprimir</button>
</div>
</div>
</div>
</div>

<!---PEDIDOS PENDIENTES MODAL!-->

<div class="modal fade bd-example-modal-lg" id="modalinformacion" style="z-index: 1901;overflow-y: scroll;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" data-target=".bd-example-modal-lg" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" id="contenidomodal">
      <div class="modal-header">
        <h5 class="modal-title" id="titulomodal"></h5>
        <button type="button" class="close" data-dismiss="modal" id="regresarinfo" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body" id="bodymodal">

  </div>
  <div class="modal-footer">
    <div id="btnfooter"></div>
    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar">CERRAR</button>
</div>
</div>
</div>
</div>
<!---PEDIDOS PENDIENTES MODAL!-->
<div class="modal fade bd-example-modal-lg" id="modalinformacion3" style="z-index: 1901;overflow-y: scroll;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" data-target=".bd-example-modal-lg" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" id="contenidomodal">
      <div class="modal-header">
        <h5 class="modal-title" id="titulomodal3"></h5>
        <button type="button" class="close" data-dismiss="modal" id="regresarinfo3" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body" id="bodymodal3">

  </div>
  <div class="modal-footer">
    <div id="btnfooter3"></div>
    <button type="button" id="btnmodal3" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
</div>
</div>
</div>
</div>

<div class="modal fade " id="modalmonedero" style="z-index: 1901;overflow-y: scroll;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" data-target=".bd-example-modal-lg" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="contenidomodalmonedero">
      <div class="modal-header">
        <h5 class="modal-title" id="titulomodal"></h5>
        <button type="button" class="close" data-dismiss="modal" id="regresarinfo2" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body" id="bodymodalmonedero">

  </div>
  <div class="modal-footer">
    <div id="btnfootermonedero"></div>
</div>
</div>
</div>
</div>


<div class="modal fade bd-example-modal-lg" id="modalinformacion2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" data-target=".bd-example-modal-lg" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" id="contenidomodal2">
      <div class="modal-header">
        <h5 class="modal-title" id="titulomodal2"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body" id="bodymodal2">

  </div>
  <div class="modal-footer2">
    <div id="btnfooter"></div>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
</div>
</div>
</div>
</div>

<div class="modal fade" id="modalrfc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">DATOS FISCALES</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body" id="body-fiscal">

  </div>

  <div class="modal-footer">

     <button type="button" class="btn btn-success" onclick="GuardarFiscal()">GUARDAR</button>
     <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>

 </div>
</div>
</div>
</div>


<div class="modal fade bd-example-modal-lg" id="modal-caja-ok" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="overflow-y: scroll;z-index: 1900;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="modal-contenido">
        <div class="modal-header">
            <h5 class="modal-title" id="titulo-caja">PAGO</h5>
            <button type="button" class="close" data-dismiss="modal" id="recargarlistado" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>

      <div class="modal-body" id="body-caja-ok">

      </div>

  </div>
</div>
</div>


<div class="modal fullscreen-modal fade" id="myModalFullscreen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="titulo-modal-forms-full">Modal title</h4>
    </div>
    <div class="modal-body" id="contenedor-modal-forms-full">

    </div>
    <div class="modal-footer" style="display: none;">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
    </div>
</div>
</div>
</div>

<div class="modal fade " id="modalinformacion4" style="z-index: 1902;overflow-y: scroll;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" data-target=".bd-example-modal-lg" aria-hidden="true">
  <div class="modal-dialog " role="document">
    <div class="modal-content" id="contenidomodal">
      <div class="modal-header">
        <h5 class="modal-title" id="titulomodal4"></h5>
        <button type="button" class="close" data-dismiss="modal" id="regresarinfo" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body" id="bodymodal4">

  </div>
  <div class="modal-footer">
    <div id="btnfooter4"></div>
</div>
</div>
</div>
</div>


<!-- Modal -->
<div class="modal fade" id="Modalprecios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">PRECIOS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="Colocarbody">
       
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-primary" data-dismiss="modal">Guardar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modalpedidos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulopedidos"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body" id="bodypedidos">
    ...
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
</div>
</div>
</div>
</div>



<div class="modal fade" id="Modalmotivocancelacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title-cancelado" id="exampleModalLabel">MOTIVO DE CANCELACIÓN</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body">
    <label for=""></label>
    <textarea class="form-control" id="motivocancelacion"></textarea>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-primary" id="botonmotivocancelado">GUARDAR</button>
</div>
</div>
</div>
</div>



<style>

    .nombreetiqueta:hover {

      color:#fefefe;
  }







</style>


<!--  TERMINA MODAL PARA REPORTE  -->

<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="assets/libs/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
<script src="assets/extra-libs/sparkline/sparkline.js"></script>
<!--Wave Effects -->
<script src="dist/js/waves.js"></script>
<!--Menu sidebar -->
<script src="dist/js/sidebarmenu.js?v=2"></script>
<!--Custom JavaScript -->
<script src="dist/js/custom.min.js"></script>
<!--This page JavaScript -->
<!-- <script src="../../dist/js/pages/dashboards/dashboard1.js"></script> -->
<!-- Charts js Files -->
<script src="assets/libs/flot/excanvas.js"></script>
<script src="assets/libs/flot/jquery.flot.js"></script>
<script src="assets/libs/flot/jquery.flot.pie.js"></script>
<script src="assets/libs/flot/jquery.flot.time.js"></script>
<script src="assets/libs/flot/jquery.flot.stack.js"></script>
<script src="assets/libs/flot/jquery.flot.crosshair.js"></script>
<script src="assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
<script src="dist/js/pages/chart/chart-page-init.js"></script>
<script src="assets/extra-libs/DataTables/datatables.min.js"></script>
<script src="assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>


<script src="assets/libs/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js"></script>

<script src="assets/libs/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.es.js"></script>

<script src="assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
<script src="assets/libs/magnific-popup/meg.init.js"></script>

<script src="dist/js/raphael-min.js"></script>
<script src="dist/js/kuma-gauge.jquery.js"></script>    

<script src="js/fn_Funciones.js"></script>
<script src="js/fn_Jquery.js" type="text/javascript" ></script>
<script src="assets/libs/chosen_v1.8.7/chosen.jquery.js"></script>

<script src="js/fn_usuarios.js" type="text/javascript" ></script>
<script src="js/fn_Administrador.js" type="text/javascript"></script>
<script src="js/fn_Configuracion.js"></script>
<script src="js/fn_LoginTime.js"></script>
<script src="js/fn_productos.js"></script>
<!-- <script src="js/fn_presentacion.js"></script>
 -->
 <script src="js/fn_categoriasproductos.js"></script>
<script src="js/fn_unidad_medida.js"></script>
<script src="js/fn_notificacion.js"></script>
<script src="js/modal.js"></script>
<script src="js/fn_sucursales.js"></script>
<script src="js/fn_proveedores.js"></script>

<script src="js/fn_clientes.js?<?php echo time(); ?>"></script>
<script src="js/fn_costoenvio.js"></script>


<script src="js/fn_tipodepago.js?<?php echo time(); ?>"></script>
<script src="js/fn_subirarchivos.js?<?php echo time(); ?>"></script>
<script src="js/fn_subirarchivoscategorias.js?<?php echo time(); ?>"></script>
<script src="js/fn_subirarchivospaquetes.js?<?php echo time(); ?>"></script>

<!-- js nuevos de mike -->
<!-- <script src="js/fn_banner.js"></script>
<script src="js/fn_preguntas.js"></script>
<script src="js/fn_testimoniales.js"></script>
<script src="js/fn_emailpub.js"></script>
<script src="js/fn_categoriasrecetas.js"></script>
<script src="js/fn_recetas.js"></script> -->
<script src="js/fn_PagConfig.js"></script>
<script src="js/fn_Cotizaciones.js"></script>
<script src="js/fn_marcas.js"></script>
<script src="js/fn_prospectos.js"></script>
<script src="js/fn_Comisionistas.js"></script>
<script src="js/fn_VentasProgramadas.js"></script>      
<script src="js/fn_reportes.js"></script>
<script src="js/fn_pago.js?<?php echo time(); ?>"></script>
<script src="js/fn_funcionesextras.js?<?php echo time(); ?>"></script>
<script src="js/fn_datofiscal.js?<?php echo time(); ?>"></script>

<!-- <script src="js/fn_monedero.js?<?php echo time(); ?>"></script>
<script src="js/fn_paginas.js?<?php echo time(); ?>"></script>
<script src="js/fn_contacto.js?<?php echo time(); ?>"></script> -->
<script src="js/fn_paquetes.js?<?php echo time(); ?>"></script>
<script src="js/fn_grupo.js?<?php echo time(); ?>"></script>
<script src="js/fn_paquetessucursales.js?<?php echo time(); ?>"></script>
<script src="js/fn_estadomuni.js?<?php echo time(); ?>"></script>
<script src="js/fn_opcionpedido.js?<?php echo time(); ?>"></script>
<script src="js/fn_precios.js?<?php echo time(); ?>"></script>
<script src="js/fn_cupones.js?<?php echo time(); ?>"></script>
<script src="js/fn_notificaciones.js"></script>
<script src="js/fn_seccion.js"></script>
<script src="js/fn_dashboard.js?v=3"></script>
<script src="js/fn_anuncios.js"></script>
<script src="js/fn_anunciosclientes.js"></script>
<script src="js/fn_costoenviodia.js"></script>

<!-- <script src="js/fn_espacios.js?<?php echo time(); ?>"></script>
<script src="js/fn_cupones.js?<?php echo time(); ?>"></script>
<script src="js/fn_horario.js?<?php echo time(); ?>"></script>
<script src="js/fn_tipopartido.js?<?php echo time(); ?>"></script>
<script src="js/fn_partidos.js?<?php echo time(); ?>"></script>
<script src="js/fn_pagos.js?<?php echo time(); ?>"></script>
<script src="js/fn_tipojuego.js?<?php echo time(); ?>"></script>
<script src="js/fn_posicion.js?<?php echo time(); ?>"></script>
<script src="js/fn_nivel.js?<?php echo time(); ?>"></script>
<script src="js/fn_torneo.js?<?php echo time(); ?>"></script>
<script src="js/fn_juego.js?<?php echo time(); ?>"></script>
-->
<!-- <script src="js/fn_reportes_VentasBitacora.js?<?php echo time(); ?>"></script>
<script src="js/fn_reportes_AlmacenSalidaLotes.js?<?php echo time(); ?>"></script>
<script src="js/fn_reportes_Bitacora_Programos.js?<?php echo time(); ?>"></script>
<script src="js/fn_facturacion.js?<?php echo time(); ?>"></script> -->

<script src="js/fn_codigopostal.js?<?php echo time(); ?>"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.ckeditor.com/4.14.1/standard-all/ckeditor.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>


<div class="alert alert-primary" role="alert" style="display: none">
  A simple primary alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
</div>
<div class="alert alert-secondary" role="alert"  style="display: none">
  A simple secondary alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
</div>
<div class="alert alert-success" role="alert"  style="display: none" id="alert_ok">

</div>
<div class="alert alert-danger" role="alert"  style="display: none">
  A simple danger alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
</div>
<div class="alert alert-warning" role="alert"  style="display: none">
  A simple warning alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
</div>
<div class="alert alert-info" role="alert" style="display: none">
  A simple info alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
</div>
<div class="alert alert-light" role="alert" style="display: none">
  A simple light alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
</div>
<div class="alert alert-dark" role="alert" style="display: none">
  A simple dark alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
</div>

</body>
</html>
