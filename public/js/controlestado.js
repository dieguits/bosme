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
    var table = $("#dtestados").DataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "autoWidth": false,
        //"paging": true,
        "ajax": {
            "url": "../controlestado/controlestado/obtenerControlEstados",
            "type": "POST"
        },
        //"data": obj.servicios,
        "columns": [
            {"data": "COD_OLD", "name": "COD_OLD"},
            {"data": "COD_NEW", "name": "COD_NEW"},
            {"data": "ACT", "name": "ACT"},
            {"data": "FECHA_CREA", "name": "FECHA_CREA"},
            //{"data": "FECHA_SERVICIO", "name": "FECHA_SERVICIO"},
            //{"data": "NRO_FACTURA", "name": "NRO_FACTURA"},
            {"data": "COD_OLD", "name": "CONTROL", "width": "50px"}

        ],
        "columnDefs": [
            /*{
             "targets": 1,
             "data": "EST_DESCR",
             "orderable": false
             },*/
            {
                "targets": -1,
                "data": "COD",
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
    $('#dtestados tbody').on('click', 'a', function() {
        var enlace = $(this);
        var data = table.row(enlace.parents('tr')).data();
        //alert( 'You clicked on ' + data.DESCR + ' row' );
        
        $("#cod_old").val(data.COD_OLD);
        $("#cod_new").val(data.COD_NEW);
        $("#seq_nro").val(data.SEQ);
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
                        "../controlestado/controlestado/guardarControlEstado",
                        {
                            cod_old: $("#cod_old").val(),
                            cod_new: $("#cod_new").val(),
                            activo: $("#activo").val()
                        },
                function(res) {
                    //alert(res);
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
                        "../controlestado/controlestado/actualizarControlEstado",
                        {
                            cod_old: $("#cod_old").val(),
                            cod_new: $("#cod_new").val(),
                            seq_nro: $("#seq_nro").val(),
                            activo: $("#activo").val()
                        },
                function(res) {
                    //alert(res);
                    if (res == 1) {
                        table.draw();
                        limpiarForm();
                        myApp.hidePleaseWait();
                        toastr["success"]("El registro ha sido actualizado.");
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
    $("#divcod_old").attr('class', 'form-group');
    $("#divcod_new").attr('class', 'form-group');
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
    $("#cod_old").val('-1');
    $("#cod_new").val('-1');
    $("#seq_nro").val('-1');
    $("#activo").val('-1');
    quitarError();
    $("#guardar").val('Guardar');
}

/**
 * 
 * @returns {Boolean}
 */
function validarCampos() {
    var flag = true;

    if ($("#cod_old").val() === '-1') {
        $("#divcod_old").attr('class', 'form-group has-error');
        flag = false;
    } else if ($("#cod_new").val() === '-1' && flag) {
        $("#divcod_new").attr('class', 'form-group has-error');
        flag = false;
    } else if ($("#activo").val() === '-1' && flag) {
        $("#divactivo").attr('class', 'form-group has-error');
        flag = false;
    }

    return flag;
}





