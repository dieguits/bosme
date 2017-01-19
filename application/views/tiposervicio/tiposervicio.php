<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Tipo Servicio <small>Creación y edición de tipo de servicios.</small></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <!--FORMULARIO -->
                <?php echo form_open('/categoria/categoria/registraCategoria', array('id' => 'frmcategoria', 'enctype' => 'multipart/form-data')); ?>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div id="divcodigo" class="form-group">
                                <label>Código</label>
                                <input type="text" id="codigo" name="codigo"
                                       ng-model="codigo" 
                                       ng-change="codigo = codigo.toUpperCase();"
                                       maxlength="8"
                                       placeholder="Código Tipo Servicio" class="form-control" >
                                <input type="hidden" id="cod_old" name="cod_old" value="-1">
                                <input type="hidden" id="seq_nro" name="seq_nro" value="-1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div id="divdescri" class="form-group">
                                <label>Descripción</label>
                                <input type="text" id="descri" name="descri" 
                                       placeholder="Descripción Tipo Servicio" class="form-control" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div id="divdescri" class="form-group">
                                <label>Valor</label>
                                <input type="number" id="valor" name="valor" 
                                       placeholder="Valor Tipo Servicio" class="form-control" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div id="divproveedor" class="form-group">
                                <label>Proveedor</label>
                                <select id="provedor" name="provedor" class="form-control m-b">
                                    <option value="-1">-- Seleccione Proveedor --</option>
                                    <?php
                                    foreach ($proveedores->result() as $proveedor) {
                                        echo '<option value="' . $proveedor->COD_PROVEEDOR . '">' . $proveedor->NOM_PROVEEDOR . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div id="divactivo" class="form-group">
                                <label>Activo</label>
                                <select id="activo" name="activo" class="form-control m-b">
                                    <option value="-1">-- Seleccione Activo --</option>
                                    <option value="S">Si</option>
                                    <option value="N">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!--div class="col-md-10 col-md-offset-1">
                            <div class="form-group">
                                <label class="control-label">Descripción Servicio</label>
                                <textarea id="descripcion" name="descripcion" placeholder="Descripción Servicio"
                                          class="form-control" rows="5" cols="25"></textarea>
                            </div>
                        </div-->
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-4 col-sm-offset-6">
                                    <input type="button" id="cancelar" name="cancelar" 
                                           value="Cancelar" onclick="limpiarForm()" class="btn btn-white">
                                    <input type="submit" id="guardar" value="Guardar" class="btn btn-primary">
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
                    <h5>Tipos de Servicio</h5>
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
                    <table id="dtiposervicio" 
                           class="table table-striped table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th>Sequence</th>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Valor</th>
                                <th>Proveedor</th>
                                <th>Activo</th>
                                <th>Fecha Creación</th>
                                <th>Control</th>
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


