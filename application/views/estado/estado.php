<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Estado <small>Creación y edición de Estados.</small></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <!--FORMULARIO -->
                <?php echo form_open('/estado/estado/registraEstado', 
                        array('id' => 'frmestado', 'enctype' => 'multipart/form-data')); ?>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div id="divcodigo" class="form-group">
                                <label>Código</label>
                                <input type="text" id="codigo" name="codigo"
                                       ng-model="codigo" 
                                       ng-change="codigo = codigo.toUpperCase();"
                                       maxlength="4"
                                       placeholder="Código Estado" class="form-control" >
                                <input type="hidden" id="cod_old" name="cod_old" value="-1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div id="divdescri" class="form-group">
                                <label>Descripción</label>
                                <input type="text" id="descri" name="descri" 
                                       placeholder="Descripción Estado" class="form-control" >
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
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-4 col-sm-offset-6">
                                    <input type="button" id="cancelar" name="cancelar" 
                                           value="Cancelar" class="btn btn-white" onclick="limpiarForm()">
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
                    <h5>Estados</h5>
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
                    <table id="dtestados" 
                           class="table table-striped table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descripción</th>
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