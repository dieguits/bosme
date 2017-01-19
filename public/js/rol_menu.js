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
    var table = $("#dtrolmenu").DataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "autoWidth": false,
        //"paging": true,
        "ajax": {
            "url": "../rol_menu/rol_menu/obtenerRolesMenu",
            "type": "POST"
        },
        //"data": obj.servicios,
        "columns": [
            {"data": "DESCR_ROL", "name": "DESCR_ROL"},
            {"data": "DESCR_MENU", "name": "DESCR_MENU"},
            {"data": "DESCR_MODO", "name": "DESCR_MODO"},
            {"data": "ACT", "name": "ACT"},
            {"data": "FECHA_CREA", "name": "FECHA_CREA"},
            //{"data": "FECHA_SERVICIO", "name": "FECHA_SERVICIO"},
            //{"data": "NRO_FACTURA", "name": "NRO_FACTURA"},
            {"data": "SEQ_ROL_MENU", "name": "SEQ_ROL_MENU", "width": "50px"}

        ],
        "columnDefs": [
            /*{
             "targets": 1,
             "data": "EST_DESCR",
             "orderable": false
             },*/
            {
                "targets": -1,
                "data": "SEQ_ROL_MENU",
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
    $('#dtrolmenu tbody').on('click', 'a', function() {
        var enlace = $(this);
        var data = table.row(enlace.parents('tr')).data();
        //alert( 'You clicked on ' + data.DESCR + ' row' );

        $("#rol").val(data.COD_ROL);
        $("#seq_nro_rol_menu").val(data.SEQ_ROL_MENU);
        $("#menu").val(data.SEQ_MENU);
        $("#modo").val(data.MODO);
        $("#activo").val(data.ACT);

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
                        "../rol_menu/rol_menu/guardarRolMenu",
                        {
                            rol: $("#rol").val(),
                            menu: $("#menu").val(),
                            modo: $("#modo").val(),
                            activo: $("#activo").val()
                        },
                function(res) {
                    console.log(res);
                    if (res == 1) {
                        table.draw();
                        limpiarForm();
                        myApp.hidePleaseWait();
                        toastr["success"]("El registro ha sido guardado");
                    }else {
                        toastr["warning"]("El registro ya existe.");
                    }
                }
                );
            } else {
                $.post(
                        "../rol_menu/rol_menu/actualizarRolMenu",
                        {
                            rol: $("#rol").val(),
                            seq_nro_rol_menu: $("#seq_nro_rol_menu").val(),
                            menu: $("#menu").val(),
                            modo: $("#modo").val(),
                            activo: $("#activo").val()
                        },
                function(res) {
                    //alert(res);
                    table.draw();
                    limpiarForm();
                    myApp.hidePleaseWait();
                    toastr["success"](res);

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
    $("#divrol").attr('class', 'form-group');
    $("#divmenu").attr('class', 'form-group');
    $("#divmodo").attr('class', 'form-group');
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
    $("#rol").val('-1');
    $("#seq_nro_rol_menu").val('-1');
    $("#menu").val('-1');
    $("#modo").val('-1');
    $("#activo").val('-1');
    quitarError();
    $("#guardar").val('Guardar');
}

/**
 * Función para validar el registro.
 * @returns {Boolean}
 */
function validarCampos() {

    var flag = true;

    if ($("#rol").val() === '-1') {
        $("#divrol").attr('class', 'form-group has-error');
        flag = false;
    } else if ($("#menu").val() === '-1' && flag) {
        $("#divmenu").attr('class', 'form-group has-error');
        flag = false;
    } else if ($("#modo").val() === '-1' && flag) {
        $("#divmodo").attr('class', 'form-group has-error');
        flag = false;
    } else if ($("#activo").val() === '-1' && flag) {
        $("#divactivo").attr('class', 'form-group has-error');
        flag = false;
    }

    return flag;
}

