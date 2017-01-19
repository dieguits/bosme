<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Control Estado <small>Creación y edición de Control de Estados.</small></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <!--FORMULARIO -->
                <?php echo form_open('/estado/estado/registraEstado', array('id' => 'frmestado', 'enctype' => 'multipart/form-data'));
                ?>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div id="divcod_old" class="form-group">
                                <label>Código Anterior</label>
                                <select id="cod_old" name="cod_old" class="form-control m-b">
                                    <option value="-1">-- Seleccione Estado --</option>
                                    <?php
                                    foreach ($estados as $estado) {
                                        echo '<option value="' . $estado->COD . '">' . $estado->DESCR . '</option>';
                                    }
                                    ?>
                                </select>
                                <!--input type="text" id="cod_old" name="cod_old"
                                       ng-model="codigo" 
                                       ng-change="codigo = codigo.toUpperCase();"
                                       maxlength="4"
                                       placeholder="Código Estado" class="form-control" -->
                                <input type="hidden" id="seq_nro" name="seq_nro" value="-1">
                            </div>
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div id="divcod_new" class="form-group">
                                <label>Código Nuevo</label>
                                <select id="cod_new" name="cod_new" class="form-control m-b">
                                    <option value="-1">-- Seleccione Estado --</option>
                                    <?php
                                    foreach ($estados as $estado) {
                                        echo '<option value="' . $estado->COD . '">' . $estado->DESCR . '</option>';
                                    }
                                    ?>
                                </select>
                                <!--input type="text" id="cod_new" name="cod_new" 
                                       ng-model="codigo_new" 
                                       ng-change="codigo_new = codigo_new.toUpperCase();"
                                       maxlength="4"
                                       placeholder="Descripción Estado" class="form-control" -->
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
                    <h5>Control de Estados</h5>
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
                                <th>Código Anterior</th>
                                <th>Código Nuevo</th>
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