var app = angular.module("MyApp", []);

app.controller("MyController", function($scope, $http) {


});

$(document).ready(function() {

    //MODAL CON ACCION DE ESTAR HACIENDO ALGO LA APPLICATION.
    var myApp;
    myApp = myApp || (function() {
        var pleaseWaitDiv = $('<div class="modal" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false"><div class="modal-body" style="padding: 370px;"><div class="sk-spinner sk-spinner-wave"><div class="sk-rect1" style="margin:1px"></div><div class="sk-rect2" style="margin:1px"></div><div class="sk-rect3" style="margin:1px"></div><div class="sk-rect4" style="margin:1px"></div><div class="sk-rect5" style="margin:1px"></div></div></div></div>');
        return {
            showPleaseWait: function() {
                pleaseWaitDiv.modal();
            },
            hidePleaseWait: function() {
                pleaseWaitDiv.modal('hide');
            }
        };
    })();

    /**
     * Configuración de la tabla.
     */
    var table = $("#dtusuarios").DataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "autoWidth": false,
        //"paging": true,
        "ajax": {
            "url": "../usuario/usuario/obtenerUsuarios",
            "type": "POST"
        },
        //"data": obj.servicios,
        "columns": [
            {"data": "COD_USUA", "name": "COD_USUA"},
            {"data": "DESCRI", "name": "DESCRI"},
            {"data": "NOMBREC", "name": "NOMBREC"},
            {"data": "CORREO", "name": "CORREO"},
            {"data": "ACTIVO", "name": "ACTIVO"},
            {"data": "COD_BACK", "name": "COD_BACK"},
            {"data": "FECHA_CREA", "name": "FECHA_CREA"},
            //{"data": "FECHA_SERVICIO", "name": "FECHA_SERVICIO"},
            //{"data": "NRO_FACTURA", "name": "NRO_FACTURA"},
            {"data": "COD_USUA", "name": "COD_USUA", "width": "50px"}

        ],
        "columnDefs": [
            /*{
             "targets": 1,
             "data": "EST_DESCR",
             "orderable": false
             },*/
            {
                "targets": -1,
                "data": "COD_USUA",
                "render": function(data, type, full, meta) {
                    var html = '';
                    html += '<div class="btn-group btn-group-xs" role="group" aria-label="Acciones">';
                    html += '<a href="#" class="btn btn-default" data-toggle="modal" data-target="#modalView" data-url="base_url params/estado/edit/' + data + '" data-title="Editar Estado" data-btn="true" data-btn-title="Guardar"><span class="glyphicon glyphicon-pencil"></span> Editar</a>';
                    html += '</div>';
                    return (type == 'display') ? html : data;
                },
                "orderable": false,
                "searcheable": false
            }//_'+data+'
        ],
        "language": {
            "url": "../../public/css/plugins/datatable-style/lang/Spanish.json"
        }
    });

    /**
     * Acceso al valor que se editara.
     */
    $('#dtusuarios tbody').on('click', 'a', function() {
        var enlace = $(this);
        var data = table.row(enlace.parents('tr')).data();
        //alert( 'You clicked on ' + data.DESCR + ' row' );

        $("#codigo").val(data.COD_USUA);
        $("#cod_old").val(data.COD_USUA);
        $("#rol").val(data.COD_ROL);
        $("#nombre").val(data.NOMBRE);
        $("#apellido").val(data.APELLIDO);
        $("#correo").val(data.CORREO);
        $("#clave").val(data.CLAVE);
        $("#activo").val(data.ACTIVO);
        if(data.COD_BACK === '' || data.COD_BACK == null) {
            $("#usrback").val('-1');
        }else {
            $("#usrback").val(data.COD_BACK);
        }
        
        $("#guardar").val('Actualizar');

    });

    /**
     * Función para hacer el registro de la categoria.
     * 
     * @date 05/04/2016.
     * @author D4P.
     */
    $("#guardar").click(function(e) {
        e.preventDefault();

        quitarError();
        //alert($("#selectusuario").val());

        if (validarCampos()) {
            myApp.showPleaseWait();
            if ($("#guardar").val() === 'Guardar') {
                $.post(
                        "../usuario/usuario/guardarUsuario",
                        {
                            cod: $("#codigo").val(),
                            cod_old: $("#cod_old").val(),
                            rol: $("#rol").val(),
                            nombre: $("#nombre").val(),
                            apellido: $("#apellido").val(),
                            correo: $("#correo").val(),
                            clave: $("#clave").val(),
                            activo: $("#activo").val(),
                            usrback: $("#usrback").val()
                        },
                function(res) {
                    //console.log(res);
                    if (res == 1) {
                        table.draw();
                        limpiarForm();
                        myApp.hidePleaseWait();
                        toastr["success"]("El registro ha sido guardado");
                    }
                }
                );
            } else {
                $.post(
                        "../usuario/usuario/actualizarUsuario",
                        {
                            cod: $("#codigo").val(),
                            cod_old: $("#cod_old").val(),
                            rol: $("#rol").val(),
                            nombre: $("#nombre").val(),
                            apellido: $("#apellido").val(),
                            correo: $("#correo").val(),
                            clave: $("#clave").val(),
                            activo: $("#activo").val(),
                            usrback: $("#usrback").val()
                        },
                function(res) {
                    //alert(res);
                    if (res == 1) {
                        table.draw();
                        limpiarForm();
                        myApp.hidePleaseWait();
                        toastr["success"]("El registro ha sido actualizado.");
                    } else {
                        myApp.hidePleaseWait();
                        toastr["error"]("El registro no se ha podido actualizar.");
                    }
                }
                );
            }
        }
    });

});

/**
 * 
 * @returns {undefined}
 */
function quitarError() {
    $("#divcodigo").attr('class', 'form-group');
    $("#divrol").attr('class', 'form-group');
    $("#divnombre").attr('class', 'form-group');
    $("#divapellido").attr('class', 'form-group');
    $("#divcorreo").attr('class', 'form-group');
    $("#divclave").attr('class', 'form-group');
    $("#divactivo").attr('class', 'form-group');
}

/**
 * Método para vaciar formulario.
 * 
 * @returns void.
 * @date 05/04/2016.
 * @author D4P.
 */
function limpiarForm() {
    $("#codigo").val('');
    $("#cod_old").val('-1');
    $("#rol").val('-1');
    $("#nombre").val('');
    $("#apellido").val('');
    $("#correo").val('');
    $("#clave").val('');
    $("#activo").val('-1');
    $("#usrback").val('-1');
    quitarError();
    $("#guardar").val('Guardar');
}

/**
 * 
 * @returns {Boolean}
 */
function validarCampos() {
    var flag = true;

    if ($("#codigo").val() === '') {
        $("#divcodigo").attr('class', 'form-group has-error');
        flag = false;
    } else if ($("#rol").val() === '-1' && flag) {
        $("#divrol").attr('class', 'form-group has-error');
        flag = false;
    } else if ($("#nombre").val() === '' && flag) {
        $("#divnombre").attr('class', 'form-group has-error');
        flag = false;
    } else if ($("#apellido").val() === '' && flag) {
        $("#divapellido").attr('class', 'form-group has-error');
        flag = false;
    } else if ($("#correo").val() === '' && flag) {
        $("#divcorreo").attr('class', 'form-group has-error');
        flag = false;
    } else if ($("#clave").val() === '' && flag) {
        $("#divclave").attr('class', 'form-group has-error');
        flag = false;
    } else if ($("#activo").val() === '-1' && flag) {
        $("#divactivo").attr('class', 'form-group has-error');
        flag = false;
    }

    return flag;
}

