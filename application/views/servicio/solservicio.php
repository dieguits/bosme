<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Servicio <small>Busqueda y asignación de servicios por proveedor.</small></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <!-- Comienzo del FORM -->
                <?php echo form_open('/servicio/solservicio/crearSolServicio', array('id' => 'frmSolServicio', 'enctype' => 'multipart/form-data')); ?>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-5 col-md-offset-1">
                            <div id="divmovimiento" class="form-group">
                                <label>Tipo Movimiento</label>
                                <select id="slcMovimiento" name="slcMovimiento" 
                                class="form-control m-b" <?php $idrol != 'ADM' ? 'disabled=""' : ''; ?> >
                                    <option value="-1">-- Seleccione Movimiento --</option>
                                    <?php
                                    foreach ($estados->result() as $estado) {
                                        echo '<option value="' . $estado->COD_ESTADO . '">' . $estado->DESCRI . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="hr-line-dashed"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5 b-r col-md-offset-1">
                            <form role="form">

                                <div id="data_1" class="form-group">
                                    <label>Fecha Requerida</label>
                                    <!--input type="date" id="fechareq" name="fechareq" value="<?php echo date("Y-m-d"); ?>" placeholder="Fecha Requerida" class="form-control"-->
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" id="fechareq" name="fechareq" 
                                               value="<?php echo date("d/m/Y"); ?>" 
                                               class="form-control" placeholder="Fecha Requerida">
                                    </div>
                                </div>
                                <div id="divalor" class="form-group">
                                    <label>Valor Servicio</label>
                                    <input type="text" id="valor" name="valor" 
                                           placeholder="Valor Servicio" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Cantidad</label>
                                    <input type="number" id="canti" name="canti" placeholder="Cantidad" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Saldo Disponible</label>
                                    <input type="text" id="saldo" name="saldo" class="form-control" placeholder="Saldo Disponible" readonly="">
                                </div>
                            <?php 
                            if ($idrol == 'ADM') { ?>
                                <div class="form-group">
                            <?php }else { ?>
                                <div class="form-group hide">
                            <?php } ?>
                                    <label class="control-label">Factura Nro</label>
                                    <input type="text" id="facnro" name="facnro" 
                                           class="form-control" placeholder="Nro Factura">
                                </div>
                            <?php 
                            if ($idrol == 'ADM') { ?>
                                <div id="divactivo" class="form-group">
                            <?php }else { ?>
                                <div id="divactivo" class="form-group hide">
                            <?php } ?>
                                    <label>Activo</label>
                                    <select id="activo" name="activo" class="form-control m-b">
                                        <option value="-1">-- Seleccione Activo --</option>
                                        <option value="S">Si</option>
                                        <option value="N">No</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-5">
                            <div id="divproveedor" class="form-group">
                                <label>Proveedor</label>
                                <select id="codProveedor" name="codProveedor" class="form-control m-b">
                                    <option value="-1">-- Seleccione Proveedor --</option>
                                    <?php
                                    foreach ($proveedores->result() as $proveedor) {
                                        
                                        if ($proveedor->ESTADO === 'VIGENTE') {
                                            echo '<option value="'.$proveedor->COD_PROVEEDOR.'&&'.$proveedor->ORDEN.'">' .$proveedor->ORDEN.' - '. $proveedor->NOM_PROVEEDOR . '</option>';
                                        } else {
                                            echo '<option style="background-color: #CC0000; color: white;" value="'.$proveedor->COD_PROVEEDOR.'&&'.$proveedor->ORDEN.'">' .$proveedor->ORDEN.' - '. $proveedor->NOM_PROVEEDOR . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <input type="hidden" id="seq_nro_sol" name="seq_nro_sol" value="-1">
                                <input type="hidden" id="nro_orden" name="nro_orden" value="-1">
                                <input type="hidden" id="nro_servicio" name="nro_servicio" value="-1">
                                <input type="hidden" id="cod_estado_old" name="cod_estado_old" value="-1">
                                <input type="hidden" id="idrol" name="idrol" value="<?php echo $idrol; ?>">
                                <input type="hidden" id="usr_respon" name="usr_respon" value="">
                                <input type="hidden" id="usr_contact" name="usr_contact" value="">
                            </div>
                            <div id="divtipservicio" class="form-group">
                                <label>Tipo Servicio</label>
                                <select id="tipServicio" name="tipServicio" class="form-control m-b">
                                    <option value="-1">-- Seleccione Servicio --</option>
                                    <!--?php
                                    foreach ($tipoServicios->result() as $tipo) {
                                        echo '<option value="' . $tipo->COD_TSERVICIO . '"> ' . $tipo->NOM_TSERVICIO . '</option>';
                                    }
                                    ?-->
                                </select>
                            </div>
                            <div id="data_2" class="form-group">
                                <label>Fecha Entrega</label>
                                <!--input type="date" id="fechaser" name="fechaser" placeholder="Fecha Servicio" class="form-control"-->
                                <div class="input-group date">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" id="fechaser" name="fechaser" placeholder="Fecha Servicio" 
                                           value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Comision</label>
                                <input type="number" id="comi" name="comi" 
                                       placeholder="Comision" class="form-control">
                            </div>
                        <?php 
                        if ($idrol == 'ADM') { 
                        ?>
                            <div id="data_2" class="form-group">
                        <?php 
                        }else {
                        ?>
                            <div id="data_2" class="form-group hide">
                        <?php
                        } 
                        ?>
                                <label>Radicado Factura</label>
                                <div class="input-group date">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" id="radifac" name="radifac" 
                                           placeholder="Fecha Radicado" value="" class="form-control">
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="form-group">
                                <label class="control-label">Descripción Servicio</label>
                                <textarea id="descripcion" name="descripcion" placeholder="Descripción Servicio"
                                          class="form-control" rows="5" cols="25"></textarea>
                            </div>
                        </div>
                        <div class="col-md-7 col-md-offset-1">
                            <div class="form-group" id="div_archivo">
                                <!--label class="col-sm-3 control-label" for="archivo">Archivo soporte</label-->
                                <label title="Adjuntar Archivo" for="archivo" class="btn btn-primary">
                                    <input type="file" accept="image/*,application/pdf" name="archivo" 
                                           id="archivo" class="hide">
                                    Adjuntar Archivo
                                </label>
                                <label id="archina" for="archivo">Nombre Archivo</label>
                                <!--div class="col-sm-10">
                                    <input type="file" id="archivo" name="archivo" 
                                           accept="image/*,application/pdf" />
                                </div-->
                            </div>
                        </div>
                        <?php
                        if ($idrol == 'ADM') { ?>
                            <div class="col-md-10 col-md-offset-1">
                        <?php
                        } else {
                        ?>
                            <div class="col-md-10 col-md-offset-1 hide">
                        <?php
                        }
                        ?>
                            <div class="form-group">
                                <label class="control-label">Observación de Tramite</label>
                                <textarea id="trobs" name="trobs" placeholder="Observación Tramite"
                                          class="form-control" rows="5" cols="25"></textarea>
                            </div>
                        </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-4 col-sm-offset-9">
                                        <input type="button" id="cancelar" name="cancelar" value="Cancelar" class="btn btn-white">
                                        <input type="submit" id="guardar" value="Guardar" class="btn btn-primary">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                    <!-- Fin del FORM -->

                </div>
            </div>
        </div>

        <!------------------------------------------------------------------------>
        <!------------------------------TABLA ------------------------------------>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Servicios</h5>
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

                        <table id="example" 
                               class="table table-striped table-bordered table-hover" >
                            <thead>
                                <tr>
                                    <th>Numero Servicio</th>
                                    <th>Tipo Movimiento</th>
                                    <th>Tipo Servicio</th>
                                    <th>Solicitante</th>
                                    <th>Fecha Entrega</th>
                                    <th class="never">Numero Solicitud</th>
                                    <th class="never">Tipo Servicio</th>
                                    <!--th>Descripcion</th-->
                                    <th>Nro Factura</th>
                                    <th>Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--tr class="gradeX">
                                    <td>Trident</td>
                                    <td>Internet
                                        Explorer 4.0
                                    </td>
                                    <td>Win 95+</td>
                                    <td class="center">4</td>
                                    <td class="center">X</td>
                                </tr>
                                
                                <tr class="gradeU">
                                    <td>Other browsers</td>
                                    <td>All others</td>
                                    <td>-</td>
                                    <td class="center">-</td>
                                    <td class="center">U</td>
                                </tr-->
                            </tbody>
                            <!--tfoot>
                                <tr>
                                    <th>Tipo Movimiento</th>
                                    <th>Tipo Servicio</th>
                                    <th>Solicitante</th>
                                    <th>Fecha Requerida</th>
                                    <th>Descripcion</th>
                                    <th>Nro Factura</th>
                                    <th>Control</th>
                                </tr>
                            </tfoot-->
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <!----------------------------FIN TABLA----------------------------------->
        <!------------------------------------------------------------------------>

    </div>
    <!-------------------------------Final------------------------------>
    <!--br>
    <div style="margin-left: auto; margin-right: auto; display: table; padding-top: 25px; width: 60%;">
        < ?php echo form_open('/servicio/solservicio/crearSolServicio', array('id' => 'frmSolServicio')); ?>
        <label style="padding-left: 32px;">Tipo Movimiento: </label>
        <select id="slcMovimiento" name="slcMovimiento">
            <option value="-1">-- Seleccione Movimiento --</option>
            <option value="RIN">Reserva Inicial</option>
            <option value="SOL">Solicitud Servicio</option>
            <option value="PRO">Prorroga Servicio</option>
            <option value="PAG">Pago Servicio</option>
        </select><br><br>
        <label style="padding-left: 56px;">Tipo Servicio: </label>
        <select>
            <option>-- Seleccione Servicio --</option>
        </select>
        <hr><br>
        <label style="padding-left: 38px;">Fecha requerida: </label>
        <input type="date" id="fechareq" name="fechareq" value="< ?php echo date("Y-m-d"); ?>"><br><br>
        <label style="padding-left: 40px;">Fecha Servicio: </label>
        <input type="date" id="fechaser" name="fechaser" value=""><br><br>
        <label style="padding-left: 72px;">Proveedor: </label>
        <select id="codProveedor" name="codProveedor">
            <option value="-1">-- Seleccione Proveedor --</option>
            < ?php
            foreach ($proveedores->result() as $proveedor) {
                echo '<option value="' . $proveedor->COD_PROVEEDOR . '">' . $proveedor->NOM_PROVEEDOR . '</option>';
            }
            ?>
        </select>
        <input type="hidden" id="seq_nro_sol" name="seq_nro_sol">
        <input type="hidden" id="nro_orden" name="nro_orden">
        <br><br>
        <label style="padding-left: 56px;">Tipo Servicio: </label>
        <select id="tipServicio" name="tipServicio">
            <option value="-1">-- Seleccione Servicio --</option>
            < ?php
            foreach ($tipoServicios->result() as $tipo) {
                echo '<option value="' . $tipo->COD_TSERVICIO . '"> ' . $tipo->NOM_TSERVICIO . '</option>';
            }
            ?>
        </select><br><br>
        <label style="padding-left: 52px;">Valor Servicio: </label>
        <input type="number" id="valor" name="valor" value=""><br><br>
        <label style="padding-left: 82px;">Cantidad: </label>
        <input type="number" id="canti" name="canti" value=""><br><br>
        <label style="padding-left: 82px;">Comision: </label>
        <input type="number" id="comi" name="comi" value=""><br><br>
        <label style="padding-left: 34px;">Saldo Disponible: </label>
        <input type="number" id="saldo" name="saldo" value="" readonly><br><br>
        <label for="descripcion" style="padding-left: 66px;">Descripción: </label>
        <textarea id="descripcion" name="descripcion" cols="35" rows="5"></textarea><br><br>
        <div style="text-align: right; padding-right: 240px;">
            <input type="submit" value="Guardar" id="guardar" style="width: 100px; height: 30px;">&nbsp;&nbsp;&nbsp;
            <input type="button" value="Rechazar" style="width: 100px; height: 30px;">
        </div>
        <? echo form_close(); ?>
    </div-->