var app = angular.module("MyApp", []);

app.controller("MyController", function($scope, $http) {


});

$(document).ready(function() {

    $('#data_1 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });

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
            },
        };
    })();

    $("#codprove").change(function() {
        myApp.showPleaseWait();
        $.post(
                "../reporte/conciliacion/nroSolicitudProveedor",
                {codprove: $(this).val()},
        function(res) {
            if (res != 0) {
                var obj = jQuery.parseJSON(res);
                $("#nro_soli").val(obj.NRO_SOLI);
            } else {
                $("#nro_soli").val('-1');
            }

            myApp.hidePleaseWait();
        }
        );
    });

    /**
     * 'codprove': $("#codprove").val()
     * Configuración de la tabla.
     */
    var table = $("#dtservicios").DataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "autoWidth": false,
        //"paging": true,
        "ajax": {
            "url": "../reporte/conciliacion/generar",
            "data": function(d) {
                return $.extend({}, d, {
                    codprove: $("#codprove").val(),
                    fechaini: $("#fechaini").val(),
                    fechafin: $("#fechafin").val(),
                    nro_soli: $("#nro_soli").val()
                });
            },
            "type": "POST"
        },
        "columns": [
            {"data": "FACTURA", "name": "FACTURA"},
            {"data": "VALOR_UNITARIO", "name": "VALOR_UNITARIO"},
            {"data": "CANTIDAD", "name": "CANTIDAD"},
            {"data": "VALOR_SIN_IVA", "name": "VALOR_SIN_IVA"},
            {"data": "IVA", "name": "IVA"},
            {"data": "VALOR_IVA", "name": "VALOR_IVA"},
            {"data": "FECHA_INICIAL", "name": "FECHA_INICIAL"},
            {"data": "FECHA_FINAL", "name": "FECHA_FINAL"}

        ],
        "columnDefs": [
            {
                "targets": 0,
                "orderable": false
            },
            {
                "targets": 1,
                "orderable": false
            },
            {
                "targets": 2,
                "orderable": false
            },
            {
                "targets": 3,
                "orderable": false
            }
        ],
        "language": {
            "url": "../../public/css/plugins/datatable-style/lang/Spanish.json"
        }
    });

    /**
     * Función para generar el pdf con el reporte de conciliacion.
     * 
     * @date 26/04/2016.
     * @author D4P.
     */
    $("#gen_pdf").click(function(e) {
        e.preventDefault();
        quitarError();
        if (validarCampos()) {
            myApp.showPleaseWait();
            $.post(
                    "../reporte/conciliacion/generarPdf",
                    {
                        codprove: $("#codprove").val(),
                        fechaini: $("#fechaini").val(),
                        fechafin: $("#fechafin").val(),
                        nro_soli: $("#nro_soli").val()
                    },
            function(res) {
                //alert(res);
                window.open(res);
                //if (res == 1) {
                //table.draw();
                //limpiarForm();
                myApp.hidePleaseWait();
                toastr["success"]("El pdf ha sido generado con exito");
                //}
            }
            );
        }
    });

    /**
     * Función para hacer el registro de la categoria.
     * 
     * @date 05/04/2016.
     * @author D4P.
     */
    $("#generar").click(function(e) {
        e.preventDefault();

        quitarError();
        //alert($("#selectusuario").val());
        table.draw();
        //if (validarCampos()) {
        /*myApp.showPleaseWait();
         $.post(
         "../reporte/conciliacion/generar",
         {
         codprove: $("#codprove").val(),
         fechaini: $("#fechaini").val(),
         fechafin: $("#fechafin").val(),
         nro_soli: $("#nro_soli").val()
         },
         function(res) {
         alert(res);
         //if (res == 1) {
         //table.draw();
         //limpiarForm();
         myApp.hidePleaseWait();
         toastr["success"]("El registro ha sido guardado");
         //}
         }
         );*/

        //}
    });

});

/**
 * 
 * @returns {undefined}
 */
function quitarError() {
    $("#divprove").attr('class', 'form-group');
    $("#divfeini").attr('class', 'input-group date');
    $("#divfefin").attr('class', 'input-group date');
}

/**
 * Método para vaciar formulario.
 * 
 * @returns void.
 * @date 05/04/2016.
 * @author D4P.
 */
function limpiarForm() {
    $("#codprove").val('');
    $("#fechaini").val('');
    $("#fechafin").val('');
    $("#nro_soli").val('-1');
    quitarError();
}

/**
 * 
 * @returns {Boolean}
 */
function validarCampos() {
    var flag = true;

    if ($("#codprove").val() === '-1') {
        $("#divprove").attr('class', 'form-group has-error');
        flag = false;
    } else if ($("#fechaini").val() === '' && flag) {
        $("#divfeini").attr('class', 'input-group date has-error');
        flag = false;
    } else if ($("#fechafin").val() === '' && flag) {
        $("#divfefin").attr('class', 'input-group date has-error');
        flag = false;
    }

    return flag;
}

