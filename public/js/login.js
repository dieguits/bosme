var app = angular.module("MyApp", []);

app.controller("MyController", function($scope, $http, $window) {

    $scope.flag = false;
    $scope.estilo = "";
    $scope.categorias = [];

    /**
     * Función para hacer la validación y login del usuario.
     */
    $scope.logear = function() {
        $scope.flag = false;
        if ($scope.idusuario != null && $scope.idusuario != '' && $scope.clave != null && $scope.clave != '') {

            if ($scope.idusuario.length < 3) {
                $scope.mesaje = "Usuario invalido";
                $scope.flag = true;
                //toastr["error"]("Mensaje", "Error de conexión");
            } else if ($scope.clave.length >= 6) {

                $http.post('index.php/login/login/validar_ingreso',
                        {
                            idusuario: $scope.idusuario,
                            clave: $scope.clave
                        }).success(function(data, status, headers, config) {

                            //alert(data.idrol);
                            if (data.ingreso == "N") {
                                $scope.mensaje = "Usuario o clave incorrectos.";
                                $scope.flag = true;
                                //toastr["error"]("Mensaje", "Error de conexión");
                            } else {
                                //alert(data.idrol + " - " + data.ingreso);
                                if (data.idrol == "ADM") {
                                    $window.location.href = 'index.php/solicitud/solicitud';
                                } else {
                                    $window.location.href = 'index.php/servicio/solservicio';
                                }
                            }

                    /*for(var i = 0; i<data.length; i++) {
                     $scope.categorias.push(data[i]);
                     console.log(i + ' - ' + data.length);
                     }
                     
                     console.log($scope.categorias);*/


                }).error(function(error, status, headers, config) {
                    console.log(error);
                });

            } else {
                $scope.mensaje = "La clave no cumple con los parametros de longitud";
                $scope.flag = true;
                //toastr["error"]("Mensaje", "Error de conexión");
            }
        } else {
            //alert("Vamos bien");
            //toastr["error"]("Mensaje", "Error de conexión");
            $scope.mensaje = "Todos los campos son requeridos";
            //$scope.estilo = "border: 1px inset; border-color: red; ";
            $scope.flag = true;
        }

    }

});

$(document).ready(function() {

    $("#recucontra").click(function() {
        if ($("#idusuario").val() !== '') {
            $("#divcoduser").attr('class', 'form-group');

            $.post(
                    "index.php/login/login/recuperarClave",
                    {
                        idusuario: $("#idusuario").val()
                    },
            function(res) {
                toastr["success"](res);
            }
            );
        } else {
            $("#divcoduser").attr('class', 'form-group has-error');
            toastr["warning"]("Ingrese el codigo de usuario.");
        }
    });
    
});