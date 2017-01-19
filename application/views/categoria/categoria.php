<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Categoría <small>Creación y edición de categorías.</small></h5>
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
                                       placeholder="Código Categoría" class="form-control" >
                                <input type="hidden" id="cod_old" name="cod_old" value="-1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div id="divdescri" class="form-group">
                                <label>Descripción</label>
                                <input type="text" id="descri" name="descri" 
                                       placeholder="Descripción Categoría" class="form-control" >
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
                    <h5>Categorías</h5>
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
                    <table id="dtcategorias" 
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

