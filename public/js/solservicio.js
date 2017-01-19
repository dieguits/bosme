Number.prototype.formatMoney = function (c, d, t) {
    var n = this,
            c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "," : d,
            t = t == undefined ? "." : t,
            s = n < 0 ? "-" : "",
            i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
            j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

var app = angular.module("MyApp", []);

app.controller("MyController", function ($scope, $http) {


});

/**
 * Codigo JQuery.
 * @date 16/03/2016.
 * @author D4P.
 */
$(document).ready(function () {

    //MODAL CON ACCION DE ESTAR HACIENDO ALGO LA APPLICATION.
    var myApp;
    myApp = myApp || (function () {
        var pleaseWaitDiv = $('<div class="modal" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false"><div class="modal-body" style="padding: 370px;"><div class="sk-spinner sk-spinner-wave"><div class="sk-rect1" style="margin:1px"></div><div class="sk-rect2" style="margin:1px"></div><div class="sk-rect3" style="margin:1px"></div><div class="sk-rect4" style="margin:1px"></div><div class="sk-rect5" style="margin:1px"></div></div></div></div>');
        return {
            showPleaseWait: function () {
                pleaseWaitDiv.modal();
            },
            hidePleaseWait: function () {
                pleaseWaitDiv.modal('hide');
            }
        };
    })();

    $('#data_1 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });

    $('#data_2 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });

    inicializarTipoMovimiento();


    /**
     * Obtener el valor de la bolsa dependiento del proveedor seleccionado.
     * @date 16/03/2016.
     */
    $("#codProveedor").change(function () {
        var partes = $(this).val().split('&&');
        //alert(partes[1]);
        myApp.showPleaseWait();
        $.post(
                "../servicio/solservicio/valorBolsaSolicitud",
                {
                    //codprove: $(this).val(),
                    codprove: partes[0],
                    nro_sol: $("#seq_nro_sol").val(),
                    nro_orden: partes[1]
                },
                function (res) {
                    //alert("Pilas");
                    var obj = jQuery.parseJSON(res);
                    $('#tipServicio').children('option:not(:first)').remove();
                    console.log(obj.datos);
                    for (var i = 0; i < obj.tipo_servicios.length; i++) {
                        $('#tipServicio').append('<option value="' + obj.tipo_servicios[i].COD + '">' + obj.tipo_servicios[i].DESCRI + '</option>');
                    }
                    

                    //limpiarTabla(false);

                    $("#seq_nro_sol").val(obj.datos.SEQ_NRO);
                    table.draw();
                    $.post(
                            "../servicio/solservicio/valorBolsaSolicitud",
                            {
                                //codprove: $("#codProveedor").val(),
                                codprove: partes[0],
                                nro_sol: $("#seq_nro_sol").val(),
                                nro_orden: partes[1]
                            },
                            function (resp) {

                                var obj1 = jQuery.parseJSON(resp);
                                //alert(obj1.datos.SALDO_BOLSA);
                                if (obj1.datos.SALDO_BOLSA != null) {
                                    //$("#saldo").val(parseFloat(obj1.datos.SALDO_BOLSA.toString()).formatMoney(0));
                                    $("#saldo").val('$' + parseFloat(obj1.datos.SALDO_BOLSA.toString()).formatMoney(2, ",", "."));
                                } else {
                                    $("#saldo").val(obj1.datos.SALDO_BOLSA);
                                }
                            });

                    $("#nro_orden").val(obj.datos.NRO_ORDEN);
                    $("#usr_respon").val(obj.datos.COD_USR_RESPONSABLE);
                    $("#usr_contact").val(obj.datos.COD_USR_CONTACTO);
                    $("#valor").val('');
                    $("#valor").removeAttr('disabled');
                    //$("#example tbody").prepend(obj.servicios);
                    myApp.hidePleaseWait();
                }
        );
    });

    /**
     * Obtiene el valor del servicio ofertado.
     * @date 04/04/2016.
     */
    $("#tipServicio").change(function () {
        myApp.showPleaseWait();
        if ($(this).val() != '-1') {
            $.post(
                    "../servicio/solservicio/valorServicio",
                    {
                        tipservi: $(this).val(),
                        codprove: $("#codProveedor").val().split("&&")[0]
                    },
                    function (res) {
                        var obj = jQuery.parseJSON(res);
                        //alert(obj.VALOR);
                        $("#valor").removeAttr('disabled');
                        if (obj.VALOR !== null) {
                            var numero = '$' + parseFloat(obj.VALOR.toString()).formatMoney(2, ",", ".");
                            //alert(numero);
                            $("#valor").val(numero);
                            $("#valor").attr('disabled', 'disabled');
                        } else {
                            $("#valor").val();
                        }
                        //alert(obj.VALOR);
                        myApp.hidePleaseWait();
                    }
            );
        } else {
            $("#valor").removeAttr('disabled');
            $("#valor").val($("#valor").val().replace("$", ""));
            $("#valor").val($("#valor").val().replace(",", ""));
            myApp.hidePleaseWait();
        }
    });

    /**
     * Función para cancelar que se muestren los campos en el formulario.
     * 
     * @date 01/04/2016.
     */
    $("#cancelar").click(function (e) {
        e.preventDefault();
        limpiarFormulario();
        quitarError();
    });

    /**
     * Función para guardar el servicio solicitado.
     * @date 16/03/2016.
     */
    $("#guardar").click(function (e) {
        e.preventDefault();

        quitarError();
        if (validarCampos()) {
            myApp.showPleaseWait();
            //Se hace el llenado de un string para enviar por ajax.
            var isarchivo = 0;
            var dataf = new FormData();
            $.each($('#archivo')[0].files, function (i, file) {
                dataf.append('archivo-' + i, file);
                isarchivo = 1;
            });

            dataf.append('slcMovimiento', $('#slcMovimiento').val());
            dataf.append('fechareq', $('#fechareq').val());
            dataf.append('valor', $('#valor').val());
            dataf.append('canti', $('#canti').val());
            dataf.append('saldo', $('#saldo').val());
            dataf.append('facnro', $('#facnro').val());
            dataf.append('codProveedor', $('#codProveedor').val().split("&&")[0]);
            dataf.append('seq_nro_sol', $('#seq_nro_sol').val());
            dataf.append('nro_orden', $('#nro_orden').val());
            dataf.append('tipServicio', $('#tipServicio').val());
            dataf.append('fechaser', $('#fechaser').val());
            dataf.append('comi', $('#comi').val());
            dataf.append('radifac', $('#radifac').val());
            dataf.append('descripcion', $('#descripcion').val());
            dataf.append('facnro', $('#facnro').val());
            dataf.append('radifac', $('#radifac').val());
            dataf.append('trobs', $("#trobs").val());
            dataf.append('isarchivo', isarchivo);
            dataf.append('nro_servicio', $("#nro_servicio").val());
            dataf.append('usr_respon', $("#usr_respon").val());
            dataf.append('usr_contact', $("#usr_contact").val());
            dataf.append('activo', $("#activo").val());

            if ($("#archina").html() !== 'Nombre Archivo') {
                dataf.append('archiname', $("#archina").html());
            } else {
                dataf.append('archiname', '');
            }


            if ($("#guardar").val() === 'Guardar') {
                //alert("vamos a guardar " + $("#nro_servicio").val());
                var request = $.ajax({
                    type: "POST",
                    url: "../servicio/solservicio/registrarSolServicio",
                    enctype: 'multipart/form-data',
                    data: dataf,
                    dataType: "html",
                    cache: false,
                    contentType: false,
                    processData: false
                });
                request.done(function (html) {
                    console.log(html);
                    //$("#example tbody").prepend(html);
                    //if (html == 1) {
                    limpiarFormulario();
                    table.draw();
                    $('#archivo').val('');
                    myApp.hidePleaseWait();
                    toastr["success"]("El requerimiento de servicio ha sido registrado.");
                    //alert("El requerimiento de servicio ha sido registrado.");   
                    /*} else {
                     toastr["success"]("No se ha podido hacer el registro.");
                     //alert("No se ha podido hacer el registro.");
                     }*/
                });
                request.fail(function (jqXHR, textStatus) {
                    //myApp.hidePleaseWait();
                    toastr["success"]("No se ha podido hacer el registro.");
                    //alert("Request failed: " + textStatus);
                });

            } else {

                var request = $.ajax({
                    type: "POST",
                    url: "../servicio/solservicio/registrarSolServicio",
                    enctype: 'multipart/form-data',
                    data: dataf,
                    dataType: "html",
                    cache: false,
                    contentType: false,
                    processData: false
                });
                request.done(function (html) {
                    console.log(html);
                    //$("#tr" + $("#nro_servicio").val()).html(html);
                    //if (html == 1) {
                    limpiarFormulario();
                    table.draw();
                    $('#archivo').val('');
                    myApp.hidePleaseWait();
                    toastr["success"]("El requerimiento de servicio ha sido actualizado.");
                    //alert("El requerimiento de servicio ha sido registrado.");   
                    /*} else {
                     toastr["success"]("No se ha podido actualizar el registro.");
                     //alert("No se ha podido hacer el registro.");
                     }*/
                });
                request.fail(function (jqXHR, textStatus) {
                    //myApp.hidePleaseWait();
                    toastr["success"]("No se ha podido actualizar el registro.");
                    //alert("Request failed: " + textStatus);
                });
            }
        }
    });


    var $inputImage = $("#archivo");
    /**
     * Función para poner nombre de archivo seleccionado en el label.
     */
    if (window.FileReader) {
        $inputImage.change(function () {

            $("#archina").html($inputImage.val());
        });
    } else {
        $inputImage.addClass("hide");
    }

    var table = $('#example').DataTable({
        "order": [[0, 'desc']],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "autoWidth": false,
        //"paging": true,
        "ajax": {
            "url": "../servicio/solservicio/obtenerDatos",
            "data": function (d) {
                return $.extend({}, d, {
                    'codprove': $("#codProveedor").val().split("&&")[0],
                    'nro_sol': $("#seq_nro_sol").val()
                });
            },
            "type": "POST"
        },
        //"data": obj.servicios,
        "columns": [
            {"data": "NRO_SERVICIO", "name": "NRO_SERVICIO"},
            {"data": "EST_DESCR", "name": "EST_DESCR"},
            {"data": "SERV_DESCR", "name": "SERV_DESCR"},
            {"data": "NOM_COMPLE", "name": "NOM_COMPLE"},
            {"data": "FECHA_SERVICIO", "name": "FECHA_SERVICIO"},
            {"data": "NRO_SOLICITUD", "name": "NRO_SOLICITUD"},
            {"data": "TIPO_SERVICIO", "name": "TIPO_SERVICIO"},
            {"data": "NRO_FACTURA", "name": "NRO_FACTURA"},
            {"data": "ACCIONES", "name": "ACCIONES", "width": "50px"}

        ],
        "columnDefs": [
            /*{
                "targets": 0,
                "orderable": false
            },*/
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
            },
            {
                "targets": 4,
                "orderable": false
            },
            {
                "targets": 5,
                "orderable": false
            },
            {
                "targets": 6,
                "orderable": false
            },
            {
                "targets": 7,
                "orderable": false
            },
            {
                "targets": -1,
                "render": function (data, type, full, meta) {
                    var html = '';
                    html += '<div class="btn-group btn-group-xs" role="group" aria-label="Acciones">';
                    //html += '<a href="' + base_url + '#" class="btn btn-default" data-toggle="modal" data-target="#modalView" data-url="' + base_url + 'params/estado/view/' + data + '" data-title="Detalles del Estado" data-btn="false"><span class="glyphicon glyphicon-eye-open"></span> Ver</a>';
                    html += '<a href="#" class="btn btn-default" data-toggle="modal" data-target="#modalView" data-url="base_url params/estado/edit/' + data + '" data-title="Editar Estado" data-btn="true" data-btn-title="Guardar"><span class="glyphicon glyphicon-pencil"></span> Editar</a>';
                    //html += '<a href="' + base_url + '#" class="btn btn-default" data-toggle="modal" data-target="#modalView" data-url="' + base_url + 'params/estado/delete/' + data + '" data-title="Borrar Estado" data-btn="true"><span class="glyphicon glyphicon-remove"></span> Borrar</a>';
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
     * Función que sirve para editar los valores.
     */
    $('#example tbody').on('click', 'a', function () {
        myApp.showPleaseWait();
        var enlace = $(this);
        var data = table.row(enlace.parents('tr')).data();
        //alert( 'You clicked on ' + data.NRO_SERVICIO + ' row' );

        $("#nro_servicio").val(data.NRO_SERVICIO);
        //$("#NRO_SOLICITUD" + id).val()
        $("#tipServicio").val(data.TIPO_SERVICIO);

        //AJAX PARA LLENADO DE COMBO TIPO MOVIMIENTO DINAMICAMENTE
        $.post(
                "../servicio/solservicio/estadosDinamicos",
                {cod_estado: data.COD_ESTADO},
                function (res) {
                    //alert("1. " + res + " - " + res.COD_ESTADO);
                    var obj = jQuery.parseJSON(res);


                    $('#slcMovimiento').children('option:not(:first)').remove();

                    for (var i = 0; i < obj.length; i++) {
                        $('#slcMovimiento').append('<option value="' + obj[i].COD_ESTADO + '">' + obj[i].DESCRI + '</option>');
                    }

                    $("#slcMovimiento").val(data.COD_ESTADO);
                    $("#cod_estado_old").val(data.COD_ESTADO);

                    if ($("#idrol").val() !== 'ADM') {
                        $('#slcMovimiento').attr('disabled', 'disabled');

                        if ($("#slcMovimiento").val() !== 'REC') {
                            $("#fechareq").attr('disabled', 'disabled');

                            $("#canti").attr('disabled', 'disabled');
                            $("#tipServicio").attr('disabled', 'disabled');
                            $("#fechaser").attr('disabled', 'disabled');
                            $("#comi").attr('disabled', 'disabled');
                            $("#descripcion").attr('disabled', 'disabled');
                            $("#guardar").attr('disabled', 'disabled');
                            $("#archivo").attr('disabled', 'disabled');
                            $("#activo").attr('disabled', 'disabled');
                        }
                    }
                }
        );
        //console.log(data.VALOR);
        $("#fechareq").val(data.FECHA_SOLICITA);
        $("#valor").val('$' + parseFloat(data.VALOR).formatMoney(2, ",", "."));
        $("#valor").attr('disabled', 'disabled');
        $("#canti").val(data.CANTIDAD);
        $("#fechaser").val(data.FECHA_SERVICIO);
        $("#descripcion").val(data.OBSERVACIONES);
        $("#trobs").val(data.OBS_TRAMITE);
        $("#comi").val(data.COMISION);
        $("#radifac").val(data.FECHA_RADICADO);
        $("#activo").val(data.ACTIVO);
        //alert(data.ARCHIVO);
        if (data.ARCHIVO === '' || data.ARCHIVO === null) {
            $("#archina").html('Nombre Archivo');
        } else {
            $("#archina").html(data.ARCHIVO);
            //$('#archivo').val(data.ARCHIVO);
        }

        if (data.NRO_FACTURA !== '--') {
            $("#facnro").val(data.NRO_FACTURA);
        }
        $("#guardar").val('Actualizar');
        myApp.hidePleaseWait();
    });

});

function prueba(este) {
    var data = $("#example").row(este).data();
    alert('You clicked on ' + data[0] + '\'s row');
}

/**
 * Función para quitar registros de la tabla de servicios.
 * 
 * @returns void.
 * @date 23/03/2016.
 * @author D4P.
 */
function limpiarTabla(nodata) {

    $('#example tbody tr').each(function () {
        //if ($(this).attr('id') != 'idreferencia1' && typeof ($(this).attr('id')) != 'undefined') {

        $(this).remove();
        //}
    });

    if (nodata) {
        $("#example tbody").prepend('<tr id="tr_nodatafound" class="odd"><td valign="top" colspan="5" class="dataTables_empty">No se encontraron registros</td></tr>');
    }
}

/**
 * Función para limpiar el formulario.
 * 
 * @returns void.
 * @date 01/04/2016.
 */
function limpiarFormulario() {
    $("#slcMovimiento").val('-1');
    //$("#fechareq").val('');
    $("#fechaser").val('');
    $("#radifac").val('');
    $("#facnro").val('');
    //$("#codProveedor").val('-1');
    //$("#seq_nro_sol").val(-1);
    //$("#nro_orden").val('-1');
    $("#nro_servicio").val('-1');
    $("#cod_estado_old").val('-1');
    $("#tipServicio").val('-1');
    $("#valor").val('');
    $("#canti").val('');
    $("#comi").val('');
    //$("#saldo").val('');
    $("#descripcion").val('');
    $("#trobs").val('');
    $("#activo").val('-1');
    $("#archina").html('Nombre Archivo');

    $("#fechareq").removeAttr('disabled');
    $("#valor").removeAttr('disabled');
    $("#canti").removeAttr('disabled');
    $("#tipServicio").removeAttr('disabled');
    $("#fechaser").removeAttr('disabled');
    $("#comi").removeAttr('disabled');
    $("#descripcion").removeAttr('disabled');
    $("#guardar").removeAttr('disabled');
    $("#archivo").removeAttr('disabled');
    $("#activo").removeAttr('disabled');

    $("#guardar").val('Guardar');
    inicializarTipoMovimiento();
}

/**
 * Función para inicializar los tipos de movimiento y dejarlo solo en solicitud.
 * 
 * @returns void.
 * @date 01/04/2016.
 * @author D4P.
 */
function inicializarTipoMovimiento() {

    $('#slcMovimiento').removeAttr('disabled');
    $('#slcMovimiento').children('option:not(:first)').remove();
    $('#slcMovimiento').append('<option value="SOL">Solicitud Servicio</option>');
}

/**
 * Función para obtener los calores del servicio seleccionado para edición.
 * 
 * @returns void.
 * @author D4P.
 */
function obtenerValores(elemento) {

    //alert("Por lo menos " + elemento.id.split('_')[1]);

    var id = elemento.id.split('_')[1];

    $("#nro_servicio").val($("#NRO_SERVICIO" + id).val());
    //$("#NRO_SOLICITUD" + id).val()
    $("#tipServicio").val($("#TIPO_SERVICIO" + id).val());
    //$("#SERV_DESCR" + id).val()

    //AJAX PARA LLENADO DE COMBO TIPO MOVIMIENTO DINAMICAMENTE
    $.post(
            "../servicio/solservicio/estadosDinamicos",
            {cod_estado: $("#COD_ESTADO" + id).val()},
            function (res) {
                //alert("1. " + res + " - " + res.COD_ESTADO);
                var obj = jQuery.parseJSON(res);


                $('#slcMovimiento').children('option:not(:first)').remove();

                for (var i = 0; i < obj.length; i++) {
                    $('#slcMovimiento').append('<option value="' + obj[i].COD_ESTADO + '">' + obj[i].DESCRI + '</option>');
                }

                $("#slcMovimiento").val($("#COD_ESTADO" + id).val());
                $("#cod_estado_old").val($("#COD_ESTADO" + id).val());

                if ($("#idrol").val() !== 'ADM') {
                    $('#slcMovimiento').attr('disabled', 'disabled');

                    if ($("#slcMovimiento").val() != 'REC') {
                        $("#fechareq").attr('disabled', 'disabled');
                        $("#valor").attr('disabled', 'disabled');
                        $("#canti").attr('disabled', 'disabled');
                        $("#tipServicio").attr('disabled', 'disabled');
                        $("#fechaser").attr('disabled', 'disabled');
                        $("#comi").attr('disabled', 'disabled');
                        $("#descripcion").attr('disabled', 'disabled');
                        $("#guardar").attr('disabled', 'disabled');
                        $("#archivo").attr('disabled', 'disabled');
                    }
                }

            }
    );

    //$("#EST_DESCR" + id).val()
    $("#fechareq").val($("#FECHA_SOLICITA" + id).val());
    $("#valor").val($("#VALOR" + id).val());
    $("#canti").val($("#CANTIDAD" + id).val());
    $("#fechaser").val($("#FECHA_SERVICIO" + id).val());
    $("#descripcion").val($("#OBSERVACIONES" + id).val());
    $("#trobs").val($("#OBS_TRAMITE" + id).val());
    $("#comi").val($("#COMISION" + id).val());
    $("#radifac").val($("#FECHA_RADICADO" + id).val());
    if ($("#ARCHIVO" + id).val() === '') {
        $("#archina").html('Nombre Archivo');
    } else {
        $("#archina").html($("#ARCHIVO" + id).val());
    }
    //$("#USR_SOLICITA" + id).val()
    //$("#NOM_COMPLE" + id).val()
    if ($("#NRO_FACTURA" + id).val() != '--') {
        $("#facnro").val($("#NRO_FACTURA" + id).val());
    }
    $("#guardar").val('Actualizar');
    //$("#EST_DESCR" + id).val()
}

/**
 * Función para quitar estilos referentes a validación.
 * 
 * @returns void
 * @date 22/03/206.
 * @author D4P.
 */
function quitarError() {
    $("#divmovimiento").attr('class', 'form-group');
    $("#data_1").attr('class', 'form-group');
    $("#divalor").attr('class', 'form-group');
    $("#divproveedor").attr('class', 'form-group');
    $("#divtipservicio").attr('class', 'form-group');
    $("#divactivo").attr('class', 'form-group');
    $("#data_2").attr('class', 'form-group');
}

/**
 * Función para hacer la validación de los campos requeridos.
 * @returns void.
 * 
 * @date 22/03/2016.
 * @author D4P.
 */
function validarCampos() {

    flag = true;

    if ($("#slcMovimiento").val() === '-1') {
        $("#divmovimiento").attr('class', 'form-group has-error');
        flag = false;
    } else if ($("#fechareq").val() === '' && flag) {
        $("#data_1").attr('class', 'form-group has-error');
        flag = false;
    } else if ($("#valor").val() === '' && flag) {
        $("#divalor").attr('class', 'form-group has-error');
        flag = false;
    } else if ($("#codProveedor").val() === '-1' && flag) {
        $("#divproveedor").attr('class', 'form-group has-error');
        flag = false;
    } else if ($("#tipServicio").val() === '' && flag) {
        $("#divtipservicio").attr('class', 'form-group has-error');
        flag = false;
    } else if ($("#fechaser").val() === '' && flag) {
        $("#data_2").attr('class', 'form-group has-error');
        flag = false;
    } else if ($("#activo").val() === '-1' && flag) {
        $("#divactivo").attr('class', 'form-group has-error');
        flag = false;
    }

    return flag;
}