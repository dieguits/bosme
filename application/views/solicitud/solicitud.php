<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-8">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Proveedor <small>Busqueda y asignación de ordenes y proveedor.</small></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <!-- Comienzo del FORM -->
                <?php echo form_open('/solicitud/solicitud/agregarSolicitud', array('id' => 'frmSetSolicitud')); ?>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-6 b-r">
                            <form role="form">
                                <div id="divproveedor" class="form-group">
                                    <label>Proveedor</label>
                                    <div class="input-group">
                                        <input id="nomprovedor" placeholder="Proveedor" class="form-control" type="text" aria-label="Text input with multiple buttons">
                                        <div class="input-group-btn">
                                            <button class="btn btn-default" aria-label="help" type="button" id="nbusque">
                                                <span class="glyphicon glyphicon-search"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <!--input type="text" id="nomprovedor" placeholder="Proveedor" class="form-control"-->
                                    <input type="hidden" id="idProveedor" name="idProveedor">
                                    <input type="hidden" id="cod_usr_proveedor" name="cod_usr_proveedor" >
                                    <input type="hidden" id="nro_solicitud" name="nro_solicitud" value="-1">
                                    <input type="hidden" id="nombrecontacto" name="nombrecontacto" value="-1">
                                    <input type="hidden" id="correocontacto" name="correocontacto" value="-1">
                                </div>
                                <div id="divnrocontrato" class="form-group">
                                    <label>Nro Orden o Contrato</label>
                                    <input type="text" id="nro_orden" name="nro_orden" placeholder="Nor Orden" class="form-control">
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Estado</label>
                                <input type="text" id="estado" placeholder="Estado" class="form-control" readonly="">
                            </div>
                            <div class="form-group">
                                <label>Valor Bolsa</label>
                                <input type="text" id="valorBolsa" name="valorBolsa" placeholder="Valor Bolsa" class="form-control" readonly="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <div id="divcategoria" class="form-group">
                                <label class="control-label">Categoria</label>
                                <!--input type="text" id="categoria" name="categoria" placeholder="Categoria" class="form-control"-->
                                <select id="categoria" name="categoria" class="form-control">
                                    <option value="-1">-- Seleccione Categoria --</option>
                                    <?php
                                    foreach ($categorias->result() as $categoria) {
                                        echo '<option value="' . $categoria->COD . '">' . $categoria->DESCR . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div id="data_1" class="form-group">
                                <label>Fecha Vencimiento</label>
                                <div id="divalefecha" class="input-group date">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" id="fecha_entrega" name="fecha_entrega"
                                           class="form-control" placeholder="Fecha Requerida">
                                </div>
                            </div>
                            <div id="divadminista" class="form-group">
                                <label class="control-label">Administrador</label>

                                <!--div class=""-->
                                <select id="selectusuario" name="selectusuario" class="form-control m-b">
                                    <option value="-1">-- Seleccione Administrador --</option>
                                    <?php
                                    foreach ($usuarios->result() as $usuario) {
                                        echo '<option value="' . $usuario->COD_USUA . '">' . $usuario->NOMBREC . '</option>';
                                    }
                                    ?>
                                </select>
                                <!--/div-->
                            </div>

                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <div class="checkbox i-checks" style="margin-left: -20px;">
                                    <label id="intento"> 
                                        <input id="chiva" name="chiva" type="checkbox" value="1"> 
                                        <i></i> 
                                        Cobra IVA 
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-11">
                            <div class="row">
                                <div class="form-group">
                                    <input type="submit" id="btnSolicitud" 
                                           value="Guardar" 
                                           class="btn btn-primary col-md-offset-11 col-md-2" 
                                           style="display: none;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
                <!-- Fin del FORM -->

            </div>
        </div>
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Opciones</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content"><br><br>
                    <form class="form-horizontal">
                        <!--div class="form-group">
                            <div class="col-lg-12">
                                <input type="button" value="Personal Solicita Servicio" class="btn btn-primary col-md-12"> 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="button" value="Servicios Disponibles" class="btn btn-primary col-md-12"> 
                            </div>
                        </div-->
                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="button" value="Reporte Conciliación" class="btn btn-primary col-md-12"> 
                            </div>
                        </div>
                        <!--div class="form-group">
                            <div class="col-lg-12">
                                <input type="button" value="Reporte Acta Cumplido" class="btn btn-primary col-md-12"> 
                            </div>
                        </div-->
                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="button" value="Reporte Acta Terminación" class="btn btn-primary col-md-12"> 
                            </div>
                        </div>
                    </form>
                </div><br><br>
            </div>
        </div>
    </div>

    <!------------------------------------------------------------------------>
    <!------------------------------TABLA ------------------------------------>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Servicios por proveedor</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <!--a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a-->
                    </div>
                </div>
                <div class="ibox-content">

                    <table id="tdsolicitud" class="table table-striped table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th>Movimiento</th>
                                <th>Fecha Servicio</th>
                                <th>Servicio</th>
                                <th>Valor</th>
                                <th>Fecha Solicita</th>
                                <th>Factura</th>
                                <th>Radicado</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
                <div class="ibox-content">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-md-2 control-label col-md-offset-6">Total</label>
                            <div class="col-md-3">
                                <input type="text" id="total" placeholder="Total" 
                                       class="form-control" readonly="">
                            </div>
                        </div>

                    </div>
                    <div class="form-horizontal">


                        <div class="form-group">
                            <label class="col-md-2 control-label col-md-offset-6">IVA</label>
                            <div class="col-md-3">
                                <input type="text" id="iva" 
                                       placeholder="Precio con IVA" class="form-control" readonly="">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!----------------------------FIN TABLA----------------------------------->
    <!------------------------------------------------------------------------>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal">
                        <!--div class="row"-->
                        <!--div class="col-md-12"-->
                        <div id="divsaldispo" class="form-group">
                            <label class="col-md-2 control-label col-md-offset-6">Saldo Disponible</label>
                            <div class="col-md-3">
                                <input type="text" id="saldobolda" name="saldobolda" 
                                       placeholder="Saldo Pendiente" class="form-control" readonly="">
                            </div>
                        </div>
                        <!--/div-->
                        <!--/div-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Contacto</label>
                                    <div class="col-md-4">
                                        <input type="text" id="contact" placeholder="Contacto" class="form-control" readonly="">
                                    </div>
                                    <label class="col-md-2 control-label">Numero Contacto</label>
                                    <div class="col-md-3">
                                        <input type="text" id="tele" placeholder="Numero Contacto" 
                                               class="form-control" readonly="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Email Solicitud</label>
                            <div class="col-md-4">
                                <input type="email" id="email" placeholder="Email" class="form-control" readonly="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Observaciones</label>
                            <div class="col-md-8">
                                <textarea id="descripcion" rows="6" class="form-control" placeholder="Observaciones"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-11">
                                <input type="button" value="Listaro Reportes" class="btn btn-primary pull-right">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

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
<!-- Page-Level Scripts -->

<!--br>
<div style="margin: 40px auto;">
    <div style="background-color:orange; width:60%; float:left; margin: 0px 0px 0px 0px;  padding-top: 20px; padding-bottom: 28px;">
        < ?php echo form_open('/solicitud/solicitud/agregarSolicitud', array('id' => 'frmSetSolicitud')); ?>  
        <div class="ui-widget" style="float: left;">
            <label style="margin-left: 74px;">Proveedor: </label>
            <input type="text" id="nomprovedor" placeholder="Proveedor" value="" style="width: 212px; height: 22px; font-size: 16px;"/>
            <input type="hidden" id="idProveedor" name="idProveedor">
            <input type="hidden" id="cod_usr_proveedor" name="cod_usr_proveedor" >
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>

        <label style="margin-left: 2px;">Estado: </label>
        <input type="text" id="estado" placeholder="Estado" value="Vigente" class="input" readonly style="width: 212px; height: 22px; font-size: 16px;"/><br><br>
        <label for="nro_orden" style="margin-left: 10px;">Nro Orden o Contrato: </label>
        <input id="nro_orden" name="nro_orden" placeholder="Nro Orden o Contrato" value="" style="width: 212px; height: 22px; font-size: 16px;">
        <label style="margin-left: 30px;">Valor Bolsa: </label>
        <input type="text" id="valorBolsa" name="valorBolsa" style="width: 212px; height: 22px; font-size: 16px;" readonly><br><br>
        <label for="categoria" style="margin-left: 88px;">Categoria: </label>
        <input type="text" id="categoria" name="categoria" placeholder="Categoria" value="" style="width: 212px; height: 22px; font-size: 16px;"/><br><br>

        <label style="margin-left: 34px;">Fecha Vencimiento: </label>
        <input type="date" id="fecha_entrega" name="fecha_entrega" style="height: 22px;"/><br><br>

        <label style="margin-left: 62px;">Administrador:</label>
        <select id="selectusuario" name="selectusuario" style="width: 212px; height: 28px; font-size: 16px;">
            <option value="-1">-- Seleccione Administrador --</option>
            < ?php
            foreach ($usuarios->result() as $usuario) {
                echo '<option value="' . $usuario->COD_USUA . '">' . $usuario->NOMBREC . '</option>';
            }
            ?>
        </select><br><br>
        <div style="text-align: right;">
            <input type="submit" id="btnSolicitud" value="Guardar" style="display: none;">
        </div>
        < ?php echo form_close(); ?>
    </div>
    <div style="background-color:#f3f3e3; width:35%; float:right; text-align: center; margin:3px 10px 0x 0px; padding-bottom: 20px; padding-top: 20px;">
        <spam>Opciones</spam><br><br>
        <input type="button" value="Personal Solicita Servicios" style="width: 200px; margin: 2px;" /><br>
        <input type="button" value="Servicios Disponibles" style="width: 200px; margin: 2px;" /><br>
        <input type="button" value="Reporte Conciliación" style="width: 200px; margin: 2px;" /><br>
        <input type="button" value="Reporte Acta Cumplido" style="width: 200px; margin: 2px;" /><br>
        <input type="button" value="Reporte Acta Terminación" style="width: 200px; margin: 2px;" /><br>
    </div>
</div>
<br><br>
<div style="border: 1px dashed; margin: 20px auto 1px; display: inline-block; width: 99%;">
    <table width="100%">
        <tr>
            <th>1
            </th>
            <th>
                MOVIMIENTO
            </th>
            <th>
                FECHA
            </th>
            <th>
                SERVICIO
            </th>
            <th>
                VALOR
            </th>
            <th>
                Nro FACTURA
            </th>
            <th>
                RADICADO
            </th>
            <th>
                ESTADO
            </th>
        </tr>
        <tr>
            <td>26</td>
            <td>Reserva Inicial</td>
            <td>29/02/2016</td>
            <td>Reserva</td>
            <td>$615.000</td>
            <td>35684</td>
            <td>10/03/2016</td>
            <td>Pagado</td>
        </tr>
    </table>
</div>
<div style="margin-top: 20px;">
    <label>Saldo Pendiente: </label>
    <input type="text" id="saldobolda" name="saldobolda" value="" readonly /><br><br>
    <label>Contacto: </label>
    <input type="text" id="contact" value="" />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <label>Numero Contacto: </label>
    <input type="text" id="tele" value="" readonly /><br><br>
    <label>Observaciones: </label>
    <textarea rows="4" cols="50"></textarea>
    <div style="text-align: right; margin-right: 10px;">
        <input type="button" value="Reportes" style="height: 34px; width: 100px;"/>
    </div>
</div-->