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
    var table = $("#dtmenu").DataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "autoWidth": false,
        //"paging": true,
        "ajax": {
            "url": "../menu/menu/obtenerMenus",
            "type": "POST"
        },
        //"data": obj.servicios,
        "columns": [
            {"data": "DESCR", "name": "DESCR"},
            {"data": "NIV", "name": "NIV"},
            {"data": "DESCRP", "name": "DESCRP"},
            {"data": "ORDEN", "name": "ORDEN"},
            {"data": "RUTA", "name": "RUTA"},
            {"data": "ACT", "name": "ACT"},
            {"data": "FECHA_CREA", "name": "FECHA_CREA"},
            //{"data": "FECHA_SERVICIO", "name": "FECHA_SERVICIO"},
            //{"data": "NRO_FACTURA", "name": "NRO_FACTURA"},
            {"data": "SEQ_NRO", "name": "SEQ_NRO", "width": "50px"}

        ],
        "columnDefs": [
            /*{
             "targets": 1,
             "data": "EST_DESCR",
             "orderable": false
             },*/
            {
                "targets": -1,
                "data": "SEQ_NRO",
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
    $('#dtmenu tbody').on('click', 'a', function() {
        var enlace = $(this);
        var data = table.row(enlace.parents('tr')).data();
        //alert( 'You clicked on ' + data.DESCR + ' row' );

        $("#descri").val(data.DESCR);
        $("#seq_nro").val(data.SEQ_NRO);
        $("#nivel").val(data.NIV);
        $("#subnivel").val(data.SUBNIV);
        $("#orden").val(data.ORDEN);
        $("#ruta").val(data.RUTA);
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
                        "../menu/menu/guardarMenu",
                        {
                            descri: $("#descri").val(),
                            nivel: $("#nivel").val(),
                            subnivel: $("#subnivel").val(),
                            orden: $("#orden").val(),
                            ruta: $("#ruta").val(),
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
                        "../menu/menu/actualizarMenu",
                        {
                            descri: $("#descri").val(),
                            seq: $("#seq_nro").val(),
                            nivel: $("#nivel").val(),
                            subnivel: $("#subnivel").val(),
                            orden: $("#orden").val(),
                            ruta: $("#ruta").val(),
                            activo: $("#activo").val()
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
    $("#divdescri").attr('class', 'form-group');
    $("#divnivel").attr('class', 'form-group');
    $("#divorden").attr('class', 'form-group');
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
    $("#descri").val('');
    $("#seq_nro").val('-1');
    $("#nivel").val('');
    $("#subnivel").val('');
    $("#orden").val('');
    $("#ruta").val('');
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

    if ($("#descri").val() === '') {
        $("#divdescri").attr('class', 'form-group has-error');
        flag = false;
    } else if ($("#nivel").val() === '' && flag) {
        $("#divnivel").attr('class', 'form-group has-error');
        flag = false;
    } else if ($("#orden").val() === '' && flag) {
        $("#divorden").attr('class', 'form-group has-error');
        flag = false;
    } else if ($("#activo").val() === '-1' && flag) {
        $("#divactivo").attr('class', 'form-group has-error');
        flag = false;
    }

    return flag;
}

