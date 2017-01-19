Number.prototype.formatMoney = function(c, d, t) {
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

app.controller("MyController", function($scope, $http) {


});

/**
 * Codigo JQuery.
 * date 14/03/2016.
 * author D4P.
 */
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
            },
        };
    })();

    $('#data_1 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });
    /**
     * Autocompletar, servicio para autocompletar.
     *
     * @date 17/04/2014.
     * @author Diego.Pérez - Mayer.Leal.
     */
    $("#nomprovedor").autocomplete({
        source: function(request, response) {
            //myApp.showPleaseWait();
            /*, value:item.codigo, tipo:item.tipo, valor:item.valor, cantidad:item.canti, idarti:item.id, idinve:item.idd, ventacanti:item.cantiventa, valorventauni:item.artvalorventa*/
            $.post(
                    "../solicitud/solicitud/buscar",
                    {"term": request.term},
            function(data) {
                response($.map(data, function(item) {
                    //myApp.hidePleaseWait();
                    return{
                        label: item.ORDEN_NUMERO + ' - ' + item.PROV_DESCRI,
                        value: item.PROV_DESCRI,
                        nro_orden: item.ORDEN_NUMERO,
                        telefono1: item.TELEFONO_RESP,
                        telefono2: item.FAX_RESPONSABLE,
                        contact: item.PROV_RESPONSABLE,
                        nro_orden_local: item.NRO_ORDEN_LOCAL,
                        idProveedor: item.ID_PROVEEDOR,
                        cod_usua_prov: item.ID_PROVEEDOR,
                        valor_bolsa: item.VALOR_TOTAL,
                        fecha_entrega: item.FECHA_ENTREGA,
                        categoria: item.CATEGORIA,
                        resonsable: item.USR_RESP,
                        v_bolsa: item.V_BOLSA,
                        s_bolsa: item.SALDO_BOLSA,
                        email: item.EMAIL,
                        descripcion: item.DESCRIPCION,
                        estado: item.ESTADO,
                        nro_sol: item.NRO_SOL
                        , total_iva: item.VAL_SER_IVA
                        , total: item.VAL_SER
                        , alerta: item.ALERTA
                        , alertafecha: item.ALERTAFECHA
                        , cobraiva: item.COBRAIVA
                    }
                }));
            },
                    'json'
                    );

        },
        select: function(event, ui) {
            //alert(ui.item);
            $("#nomprovedor").val(ui.item.value);
            $("#nro_orden").val("");
            $("#nro_orden").val(ui.item.nro_orden);
            if (ui.item.telefono2 != null && ui.item.telefono1 != ui.item.telefono2) {
                $("#tele").val(ui.item.telefono1 + ' - ' + ui.item.telefono2);
            } else {
                $("#tele").val(ui.item.telefono1);
            }

            $("#contact").val(ui.item.contact);
            $("#idProveedor").val(ui.item.idProveedor);
            $("#cod_usr_proveedor").val(ui.item.cod_usua_prov);
            $("#fecha_entrega").val(ui.item.fecha_entrega);
            var emailu = ui.item.email.split(' ');
            $("#email").val(emailu[0]);
            $("#descripcion").val(ui.item.descripcion);
            $("#estado").val(ui.item.estado);
            if (ui.item.nro_sol !== null) {
                $("#nro_solicitud").val(ui.item.nro_sol);
            }

            if (ui.item.nro_orden_local == '0') {
                $("#valorBolsa").val('$' + parseFloat(ui.item.valor_bolsa).formatMoney(2, ",", "."));
                $("#saldobolda").val('$' + parseFloat(ui.item.valor_bolsa).formatMoney(2, ",", "."));
                $("#btnSolicitud").val('Guardar');
                $("#btnSolicitud").attr('style', '');
            } else {
                $("#categoria").val(ui.item.categoria);
                $("#selectusuario").val(ui.item.resonsable);
                $("#valorBolsa").val('$' + parseFloat(ui.item.v_bolsa).formatMoney(2, ",", "."));
                $("#saldobolda").val('$' + parseFloat(ui.item.s_bolsa).formatMoney(2, ",", "."));
                $("#total").val('$' + parseFloat(ui.item.total).formatMoney(2, ",", "."));
                $("#iva").val('$' + parseFloat(ui.item.total_iva).formatMoney(2, ",", "."));
                
                //OPCIONES PARA CHECKEAR SI COBRA O NO IVA
                if(ui.item.cobraiva === 'S') {
                    $('#chiva').iCheck('check');
                }else {
                    $('#chiva').iCheck('uncheck');
                }
                
                $("#btnSolicitud").val('Actualizar');
                $("#btnSolicitud").attr('style', '');
            }

            if (ui.item.alerta === 'S') {
                $("#divsaldispo").attr('class', 'form-group has-error');
            } else {
                $("#divsaldispo").attr('class', 'form-group');
            }

            if (ui.item.alertafecha === 'S') {
                $("#divalefecha").attr('class', 'input-group date has-error');
            } else {
                $("#divalefecha").attr('class', 'input-group date');
            }

            $("#nombrecontacto").val(ui.item.value);
            $("#correocontacto").val(emailu[0]);
        },
        close: function(event, ui) {
            //alert($("#nomprovedor").val());
            if ($("#idProveedor").val() != "") {
                $("#nro_orden").focus();
            }
        },
        minLength: 4
    });

    /**
     * Función para obtener los servicios dependiendo del proveedor y solicitud
     * seleccionados por el usuario.
     */
    $("#nro_orden").focusin(function(e) {

        if ($("#nro_orden").val() != '' && $("#nro_solicitud").val() != '-1'
                && buscarServicio) {

            table.draw();
            buscarServicio = false;
        }
    });

    /**
     * Función para limpiar los campos.
     */
    $("#nbusque").click(function(e) {
        e.preventDefault();
        myApp.showPleaseWait();
        limpiar();
        table.draw();
        myApp.hidePleaseWait();
    });

    /**
     * Función para realizar inclusión de la solicitud a la base de datos.
     *
     * @date 14/03/2016.
     * @author D4P.
     */
    $("#frmSetSolicitud").submit(function(e) {
        e.preventDefault();
        myApp.showPleaseWait();
        quitarError();
        console.log($(this).serialize());
        //alert($("#chiva").prop('checked'));
        if (validarCampos()) {

            $.post(
                    $(this).attr('action'),
                    $(this).serialize(),
                    function(res) {
                        console.log(res);
                        //if (res == 1) {
                        toastr["success"](res);
                        table.draw();
                        limpiar();
                        myApp.hidePleaseWait();
                        //}
                    }
            );
        }
    });

    /**
     * Ordenamiento y configuración de la tabla.
     * 
     * @type @call;$@call;DataTable
     * @date 07/04/2016.
     * @author D4P.
     */
    var table = $('#tdsolicitud').DataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "autoWidth": false,
        "fixedColumns": true,
        //"paging": true,
        "ajax": {
            "url": "../solicitud/solicitud/obtenerDatos",
            "data": function(d) {
                return $.extend({}, d, {
                    'nro_solicitud': $("#nro_solicitud").val()
                });
            },
            "type": "POST"
        },
        //"data": obj.servicios,
        "columns": [
            {"data": "EST_DESCR", "name": "EST_DESCR"},
            {"data": "FECHA_SERVICIO", "name": "FECHA_SERVICIO"},
            {"data": "TIPO_SERVICIO", "name": "TIPO_SERVICIO"},
            //{"data": "VALOR", "name": "VALOR"},
            {data: "VALOR", render: $.fn.dataTable.render.number('.', ',', 2, '$')},
            {"data": "FECHA_SOLICITA", "name": "FECHA_SOLICITA"},
            {"data": "NRO_FACTURA", "name": "NRO_FACTURA"},
            {"data": "FECHA_RADICADO", "name": "FECHA_RADICADO"}

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
            }/*,
             {
             "targets": -1,
             "data": "NRO_SERVICIO",
             "render": function(data, type, full, meta) {
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
             }//_'+data+'*/
        ],
        "language": {
            "url": "../../public/css/plugins/datatable-style/lang/Spanish.json"
        }
    });

});

/*****************************************************************
 ****************************JAVASCRIPT****************************
 *****************************************************************/

//Variable para saber si ya se buscaron los servicios de la solicitud.
var buscarServicio = true;

/**
 * Función para limpiar los controles y poder realizar otra busqueda.
 * @returns void.
 */
function limpiar() {
    //Se cancelan los campos a cero o null
    $("#nomprovedor").val('');
    $("#nro_orden").val('');
    $("#tele").val('');
    $("#contact").val('');
    $("#idProveedor").val('' - 1);
    $("#cod_usr_proveedor").val('' - 1);
    $("#fecha_entrega").val('');
    $("#email").val('');
    $("#descripcion").val('');

    $("#valorBolsa").val('');
    $("#saldobolda").val('');
    $("#btnSolicitud").attr('style', 'display: none;');
    $("#divcategoria").attr('class', 'form-group');
    $("#divadminista").attr('class', 'form-group');
    $("#divalefecha").attr('class', 'input-group date');

    $("#categoria").val('-1');
    $("#selectusuario").val('-1');
    $("#saldobolda").val('');
    $("#estado").val('');
    $("#nro_solicitud").val('-1');
    
    $('#chiva').iCheck('uncheck');

    buscarServicio = true;
    //quitarError();
    //limpiarTabla(true);
}

/**
 * Función para quitar los estilos de color rojo cuando valida los campos.
 * @returns void
 * 
 * @date 22/03/2016.
 * @author D4P.
 */
function quitarError() {
    $("#divcategoria").attr('class', 'form-group');
    $("#divadminista").attr('class', 'form-group');
    $("#divadminista").attr('class', 'form-group');
    $("#divsaldispo").attr('class', 'form-group');
}

/**
 * Función para validar que los campos requeridos se encuentren diligenciados.
 * @returns {flag|Boolean} Variable para validar el ingreso.
 * 
 * @date 22/03/2016.
 * @author D4P.
 */
function validarCampos() {

    flag = true;

    if ($("#categoria").val() === '-1') {
        $("#divcategoria").attr('class', 'form-group has-error');
        flag = false;
    } else if ($("#selectusuario").val() === '-1' && flag) {
        $("#divadminista").attr('class', 'form-group has-error');
        flag = false;
    } else if ($("#nomprovedor").val() === '' && flag) {
        $("#divproveedor").attr('class', 'form-group has-error');
        flag = false;
    } else if ($("#nro_orden").val() === '' && flag) {
        $("#divnrocontrato").attr('class', 'form-group has-error');
        flag = false;
    }

    return flag;
}