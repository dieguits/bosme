<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Reporte <small>Generación de reporte de Conciliación.</small></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <!--FORMULARIO -->
                <?php echo form_open('/reporte/conciliacion/generar', array('id' => 'frmconciliacion', 'enctype' => 'multipart/form-data')); ?>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div id="divprove" class="form-group">
                                <label>Proveedor</label>
                                <select id="codprove" name="codprove" class="form-control m-b">
                                    <option value="-1">-- Seleccione Proveedor --</option>
                                    <?php
                                    foreach ($proveedores->result() as $proveedor) {
                                        echo '<option value="' . $proveedor->COD_PROVEEDOR . '">' . $proveedor->NOM_PROVEEDOR . '</option>';
                                    }
                                    ?>
                                </select>
                                <input type="hidden" id="nro_soli" name="nro_soli" value="-1">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="col-md-8 col-md-offset-2">
                            <div id="data_1" class="form-group">
                                <label>Fecha Inicial</label>
                                <div id="divfeini" class="input-group date">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" id="fechaini" name="fechaini" 
                                           class="form-control" placeholder="Fecha Inicial">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="col-md-8">
                            <div id="data_1" class="form-group">
                                <label>Fecha Final</label>
                                <div id="divfefin" class="input-group date">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" id="fechafin" name="fechafin" 
                                           class="form-control" placeholder="Fecha Final">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-4 col-sm-offset-8">
                                    <input type="button" id="cancelar" name="cancelar" 
                                           value="Cancelar" class="btn btn-white" onclick="limpiarForm()">
                                    <input type="submit" id="generar" value="Mostrar" class="btn btn-primary">
                                    <input type="submit" id="gen_pdf" value="Generar" class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
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
                    </div>
                </div>
                <div class="ibox-content">
                    <table id="dtservicios" 
                           class="table table-striped table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th>Factura</th>
                                <th>Valor Unitario</th>
                                <th>Cantidad</th>
                                <th>Valor Sin Iva</th>
                                <th>IVA</th>
                                <th>Valor con Iva</th>
                                <th>Fecha Inicial</th>
                                <th>Fecha Final</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <!----------------------------FIN TABLA----------------------------------->
    <!------------------------------------------------------------------------>

</div>


