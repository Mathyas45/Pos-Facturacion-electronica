<?php
require_once('modelo/clsPerfil.php');

$objPer = new clsPerfil();

$listaOpciones = $objPer->listarOpcionesMenu($_SESSION['idperfil']);
$listaOpciones = $listaOpciones->fetchAll(PDO::FETCH_NAMED);

// echo '<pre>';
// print_r($listaOpciones);
// echo '</pre>';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="plugins/fileinput/css/fileinput.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="principal.php" class="nav-link">Inicio</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Usuario</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fa fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        <?php echo $_SESSION['nombre']; ?>
                                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm"><?php echo $_SESSION['perfil']; ?></p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>En Linea</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="index.php" class="btn btn-danger dropdown-footer">Cerrar Sesion</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">SISTEMA POS</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?php echo $_SESSION['nombre']; ?></a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                        <?php
                        $idmodulo = 0;
                        $siguiente = next($listaOpciones);

                        foreach ($listaOpciones as $k => $v) {
                            $ultimo = false;
                            if (isset($siguiente['idmodulo']) && ($siguiente['idmodulo'] != $v['idmodulo'])) {
                                $ultimo = true;
                            }

                            if ($v['idmodulo'] != $idmodulo) {
                                echo "<li class='nav-item'><a href='#' class='nav-link'><i class='nav-icon fas " . $v['modulo_icono'] . "'></i><p>" . $v['modulo'] . "<i class='fas fa-angle-left right'></i></p></a><ul class='nav nav-treeview'>";
                                $idmodulo = $v['idmodulo'];
                            }

                            echo "<li class='nav-item'><a href='#' style='padding-left:35px;' class='nav-link' onclick='AbrirPagina(\"" . $v['url'] . "\",\"" . $v['idopcion'] . "\");verificarSeleccionado(this)'><i class='fa " . $v['icono'] . " nav-icon'></i><p>" . $v['descripcion'] . "</p></a></li>";


                            if ($ultimo) {
                                echo "</ul></li>";
                            }

                            $siguiente = next($listaOpciones);
                        }

                        ?>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid" id="divPrincipal">
                    PAGINA DE INICIO
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content-header -->
        </div>

        <div class="modal fade" id="divmodal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title" id="divmodalTitulo">Titulo Modal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="divmodalContenido">
                        ...
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="divmodal1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title" id="divmodal1Titulo">Titulo Modal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="divmodal1Contenido">
                        ...
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="divmodal2">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title" id="divmodal2Titulo">Titulo Modal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="divmodal2Contenido">
                        ...
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="divmodal3">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title" id="divmodal3Titulo">Titulo Modal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="divmodal3Contenido">
                        ...
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <!-- /.modal de confirmacion-->
        <div class="modal fade" id="modalConfirmacion">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title">Confirmar</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="mensaje_confirmacion">
                        �Est� seguro de Anular la categor�a?
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <div id="boton_confirmacion">

                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <!-- DataTables  & Plugins -->
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="dist/js/adminlte.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- AdminLTE for demo purposes
  <script src="plugins/fileinput/js/fileinput.js"></script>
  <script src="plugins/fileinput/js/fileinput_locale_es.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script> -->
    <!-- Toastr -->
    <script src="plugins/toastr/toastr.min.js"></script>
    <!-- <script src="dist/js/demo.js"></script> -->
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        function AbrirPagina(urlx, idopcionx) {
            $.ajax({
                    method: 'POST',
                    url: urlx,
                    data: {
                        idopcion: idopcionx
                    }
                })
                .done(function(resultado) {
                    $('#divPrincipal').html(resultado);
                });
        }


        function mostrarModalConfirmacion(mensaje, accion) {
            $("#mensaje_confirmacion").html(mensaje);

            btn_html = '<button type="button" class="btn btn-primary" onclick="CerrarModalConfirmacion();' + accion + '">Confirmar</button>';

            $("#boton_confirmacion").html(btn_html);
            $("#modalConfirmacion").modal("show");
        }

        function CerrarModalConfirmacion() {
            $("#modalConfirmacion").modal("hide");
        }


        var opcionActiva = null;

        function verificarSeleccionado(element, menuvertical = 1) {
            $(opcionActiva).parent().parent().parent().removeClass("menu-is-opening menu-open");
            $(opcionActiva).parent().parent().css("display", "none");
            $(opcionActiva).parent().parent().prev().removeClass("active");
            $(opcionActiva).removeClass("bg-teal-active active");
            $(opcionActiva).parent().parent().prev().css("border-left-color", "");

            if (!$(element).parent().hasClass("active") && menuvertical == 1) {
                $(element).parent().parent().parent().addClass("menu-is-opening menu-open");
                $(element).parent().parent().css("display", "block");
                $(element).parent().parent().prev().addClass("active");
                $(element).addClass("bg-teal-active active");
                $(element).parent().parent().prev().css("border-left-color", "#458d94");

                opcionActiva = element;
            }
        }


        function mostrarContenido(urlx, parx, divx) {
            var s = "",
                r = /<script>([\s\S]+)<\/script>/mi;
            $.ajax({
                    method: "POST",
                    url: urlx + '.php?ajax=true&' + parx
                })
                .done(function(html) {

                    if (html.match(r)) {
                        s = RegExp.$1;
                        html = html.replace(r, "");
                    }
                    $("#" + divx).html(html);
                    var etiquetaScript = document.createElement("script");
                    document.getElementsByTagName("head")[0].appendChild(etiquetaScript);
                    etiquetaScript.text = s;

                })
        }

        function abrirModal(pagina, parametro, divmodal, titulo) {
            $('#' + divmodal).on('show.bs.modal', function(e) {
                $('#' + divmodal + "Titulo").html(titulo);
                mostrarContenido(pagina, parametro, divmodal + 'Contenido');
                $(e.currentTarget).unbind();
                $('#' + divmodal).on('hidden.bs.modal', function(e) {
                    $('#' + divmodal + "Titulo").html('');
                    $('#' + divmodal + 'Contenido').html("...");
                    $(e.currentTarget).unbind();
                    if ($('.modal:visible').length) {
                        $('body').addClass('modal-open');
                    }
                });
            }).modal({
                keyboard: false,
                backdrop: 'static'
            });
        }

        function solo_numero(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        function solo_decimal(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if ((charCode > 31 && (charCode < 46 || charCode > 57)) || charCode == 47) {
                return false;
            }
            return true;
        }

        function toastCorrecto(mensaje) {
            $(document).Toasts('create', {
                title: 'Mensaje',
                class: 'bg-success',
                autohide: true,
                delay: 3000,
                body: mensaje
            });
        }

        function toastError(mensaje) {
            $(document).Toasts('create', {
                title: 'Error',
                class: 'bg-danger',
                autohide: true,
                delay: 3000,
                body: mensaje
            });
        }

        function CloseModal(divmodal) {
            $('#' + divmodal).modal('hide');
        }
    </script>
</body>

</html>