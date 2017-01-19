<!--div style="text-align: center;">
    <input type="text" ng-model="idusuario" ng-change="idusuario = idusuario.toUpperCase();" placeholder="USUARIO" style="{{estilo}}"><br><br>
    <input type="password" ng-model="clave" placeholder="CONTRASEÑA" style="{{estilo}}"><br><br>
    <input type="button" ng-click="logear()" value="Login" style="width: 174px;">
    <p ng-show="flag" style="color: red;">{{mensaje}}</p>
</div-->


<!--div class="middle-box text-center">
    <form class="form-signin" role="form">

        <h3>Bienvenido a BOSME</h3>
        <div class="form-group">
            <input type="text" ng-model="idusuario" ng-change="idusuario = idusuario.toUpperCase();" class="form-control" placeholder="Usuario" required="" autofocus="">
        </div>
        <div class="form-group">
            <input type="password" ng-model="clave" class="form-control" placeholder="Contraseña" required="" data-translatable-string="Password">
        </div>
        <div class="form-group">
            <button class="btn btn-lg btn-primary btn-block" ng-click="logear()" type="button" >Iniciar sesión</button>
        </div>
        <div class="alert alert-danger" ng-show="flag" role="alert">
            <strong>
                Usuario o clave incorrectos.
            </strong>
        </div>

    </form>
</div-->

<!DOCTYPE html>
<html lang="es" ng-app="MyApp">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>BOSME</title>
        <link rel="shortcut icon" href="<?php echo base_url('public/images/favicon.ico');?>" type="image/x-icon">
        <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery-ui.min.js"></script>
        <!--link href="< ?php echo base_url(); ?>public/css/jquery-ui.min.css" rel="stylesheet"-->
        <link href="<?php echo base_url(); ?>public/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>public/font-awesome/css/font-awesome.css" rel="stylesheet">

        <link href="<?php echo base_url(); ?>public/css/animate.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>public/css/plugins/toastr/toastr.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>public/css/style.css" rel="stylesheet">
        <script type="text/javascript" src="<?php echo base_url() . 'public/js/' . $controlador . '.js'; ?>"></script>

    </head>

    <body class="gray-bg" ng-controller="MyController">

        <div class="loginColumns animated fadeInDown">
            <div class="row">
                <div class="col-md-12 text-center">
                    <img src="<?php echo base_url(); ?>/public/images/logo.png" 
                         alt="Telebucaramanga">
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-md-6 text-center">
                    <br><br>
                    <br>
                    <h2 class="font-bold">Bienvenido a SGC</h2>

                    <p>
                        Sistema de Gestión de Contratos.
                    </p>

                    <!--p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                    </p>

                    <p>
                        When an unknown printer took a galley of type and scrambled it to make a type specimen book.
                    </p>

                    <p>
                        <small>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</small>
                    </p-->

                </div>
                <div class="col-md-6">
                    <div class="ibox-content">
                        <form class="m-t" role="form" data-url="" ng-submit="logear()">

                            <div id="divcoduser" class="form-group">
                                <input id="idusuario" type="text" 
                                       ng-model="idusuario" 
                                       ng-change="idusuario = idusuario.toUpperCase();" 
                                       class="form-control" placeholder="Usuario" required=""
                                       maxlength="3">
                            </div>
                            <div class="form-group">
                                <input type="password" ng-model="clave" class="form-control" placeholder="Contraseña" required="">
                            </div>

                            <button type="submit" id="btnInicio" name="btnInicio" 
                                    class="btn btn-primary block full-width m-b" 
                                    ng-click="logear()">Iniciar Sesion</button>

                            <a id="recucontra" href="#" class="text-right">
                                <small>Recuperar Contraseña.</small>
                            </a>
                            <div class="alert alert-danger" ng-show="flag" role="alert">
                                <strong>
                                    Usuario o clave incorrectos.
                                </strong>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-12 text-center">
                    Copyright 
                    <!--/div>
                    <div class="col-md-6 text-right"-->
                    <small>© 2016 - Telebucaramangaa. Creado por la Subgerencia de Informática y Tecnología.</small>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>public/js/plugins/toastr/toastr.min.js"></script>
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
    </body>

</html>