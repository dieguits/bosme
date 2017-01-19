<!DOCTYPE html>
<html lang="es" ng-app="MyApp">
    <head><!--jquery-1.11.3.min-->
        <title>BOSME</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--?php echo link_tag('public/images/favicon.ico', 'shortcut icon', 'image/x-icon'); ?-->
        <link rel="shortcut icon" href="<?php echo base_url('public/images/favicon.ico');?>" type="image/x-icon">
        <script src="<?php echo base_url(); ?>public/js/angular.min.js"></script>
        <!--script src="http: //ajax.googleapis.com/ajax/libs/angularjs/1.4.8/ angular.min.js"></script -->
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery-2.1.1.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery-ui.min.js"></script>
        <link href="<?php echo base_url(); ?>public/css/jquery-ui.min.css" rel="stylesheet">
        
        <link href="../../../bosme/public/css/bootstrap.min.css" rel="stylesheet">
        <link href="../../../bosme/public/font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>public/css/plugins/iCheck/custom.css" rel="stylesheet">

        <!-- Data Tables -->
        <link href="<?php echo base_url(); ?>public/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>public/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>public/css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">

        <link href="<?php echo base_url(); ?>public/css/animate.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>public/css/plugins/toastr/toastr.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>public/css/style.css" rel="stylesheet">

        <link href="<?php echo base_url(); ?>public/css/plugins/datapicker/datepicker3.css" rel="stylesheet">

        <script type="text/javascript" src="<?php echo base_url() . 'public/js/' . $controlador . '.js'; ?>"></script>

    </head>
    <body class="<?php echo $clasebody; ?>" ng-controller="MyController">

        <div id="wrapper">
            <div id="page-wrapper" class="gray-bg">
                <div class="row border-bottom white-bg">
                    <nav class="navbar navbar-static-top" role="navigation">
                        <div class="navbar-header">
                            <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                                <i class="fa fa-reorder"></i>
                            </button>
                            <a href="#" alt="Sistema de Gestión de Contratos" class="navbar-brand">SGC</a>
                        </div>
                        <div class="navbar-collapse collapse" id="navbar">
                            <ul class="nav navbar-nav">
                                <?php echo $menu; ?>
                                <li>
                                    <a aria-expanded="false" role="button" href="#">
                                        Prueba
                                    </a>
                                </li>
                                <!--li>
                                    <a aria-expanded="false" role="button" href="../servicio/solservicio">
                                        Servicio
                                    </a>
                                </li-->
                                <!--li class="dropdown">
                                    <a aria-expanded="false" role="button" href="#"
                                       class="dropdown-toggle" data-toggle="dropdown">
                                        Usuario
                                        <span class="caret"></span>
                                    </a>
                                    <ul role="menu" class="dropdown-menu">
                                        <li><a href="../usuario/usuario">Usuario</a></li>
                                        <li><a href="../rol/rol">Rol</a></li>
                                        <li><a href="../menu/menu">Menu</a></li>
                                        <li><a href="../rol_menu/rol_menu">Rol Menu</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a aria-expanded="false" role="button" href="#"
                                       class="dropdown-toggle" data-toggle="dropdown">
                                        Estado
                                        <span class="caret"></span>
                                    </a>
                                    <ul role="menu" class="dropdown-menu">
                                        <li><a href="../estado/estado">Estado</a></li>
                                        <li><a href="../controlestado/controlestado">Control Estado</a></li>
                                    </ul>
                                </li--> 

                            </ul>
                            <ul class="nav navbar-top-links navbar-right">
                                <li>
                                    <span class="m-r-sm text-muted welcome-message">Bienvenido <?php echo ucwords(strtolower($nomusua)); ?></span>
                                </li>
                                <li>
                                    <a href="../login/login/logout">
                                        <i class="fa fa-sign-out"></i> Cerrar Sesión
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>

                <!--?php echo $titulo; ?-->
                <?php $this->load->view($content); ?>        
            </div>
        </div>

        <div id="content" class="container middle-box text-center">
            <!--?= $titulo; ?-->
            <!--?php $this->load->view($content); ?-->
        </div><!-- /container -->
        <div id="footer">

        </div>
        <?php
        /* if(isset($script)) {
          echo $script;
          } else {
          echo $script;
          } */
        ?>
        <script src="<?php echo base_url(); ?>public/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>public/js/plugins/toastr/toastr.min.js"></script>
        <script src="<?php echo base_url(); ?>public/js/plugins/datapicker/bootstrap-datepicker.js"></script>
        <script type="text/javascript">
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "onclick": null,
                    "showDuration": "400",
                    "hideDuration": "1000",
                    "timeOut": "3000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
        </script>

        <!-- Data Tables -->
        <script src="<?php echo base_url(); ?>public/js/plugins/dataTables/jquery.dataTables.js"></script>
        <script src="<?php echo base_url(); ?>public/js/plugins/dataTables/dataTables.bootstrap.js"></script>
        <script src="<?php echo base_url(); ?>public/js/plugins/dataTables/dataTables.responsive.js"></script>
        <script src="<?php echo base_url(); ?>public/js/plugins/dataTables/dataTables.tableTools.min.js"></script>
        <script src="<?php echo base_url(); ?>public/js/plugins/jeditable/jquery.jeditable.js"></script>
        <!-- Data Tables -->

        <!-- Page-Level Scripts -->
        <script>
                $(document).ready(function() {
                    var oTable = $('.dataTables-example').dataTable({
                        responsive: true,
                        "dom": 'T<"clear">lfrtip',
                        /*"tableTools": {
                         "sSwfPath": "< ?php echo base_url(); ?>public/js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
                         }*/
                        language: {
                            url: '<?php echo base_url(); ?>public/js/plugins/dataTables/Spanish.json'
                        }
                    });

                    /* Init DataTables */
                    $('#editable').dataTable();

                    /*Apply the jEditable handlers to the table 
                     oTable.$('td').editable('../example_ajax.php', {
                     "callback": function(sValue, y) {
                     var aPos = oTable.fnGetPosition(this);
                     oTable.fnUpdate(sValue, aPos[0], aPos[1]);
                     },
                     "submitdata": function(value, settings) {
                     return {
                     "row_id": this.parentNode.getAttribute('id'),
                     "column": oTable.fnGetPosition(this)[2]
                     };
                     },
                     "width": "90%",
                     "height": "100%"
                     });*/


                });

                function fnClickAddRow() {
                    $('#editable').dataTable().fnAddData([
                        "Custom row",
                        "New row",
                        "New row",
                        "New row",
                        "New row"]);

                }
        </script>
        
        <script src="<?php echo base_url(); ?>public/js/plugins/iCheck/icheck.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            });
        </script>
        
        <style>
            body.DTTT_Print {
                background: #fff;

            }
            .DTTT_Print #page-wrapper {
                margin: 0;
                background:#fff;
            }

            button.DTTT_button, div.DTTT_button, a.DTTT_button {
                border: 1px solid #e7eaec;
                background: #fff;
                color: #676a6c;
                box-shadow: none;
                padding: 6px 8px;
            }
            button.DTTT_button:hover, div.DTTT_button:hover, a.DTTT_button:hover {
                border: 1px solid #d2d2d2;
                background: #fff;
                color: #676a6c;
                box-shadow: none;
                padding: 6px 8px;
            }

            .dataTables_filter label {
                margin-right: 5px;

            }
        </style>
    </body>
</html>