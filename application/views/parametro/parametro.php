<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Parametro <small>Creación y edición de parametros.</small></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <!--FORMULARIO -->
                <?php echo form_open('/parametro/parametro/registraParametro', array('id' => 'frmparametro', 'enctype' => 'multipart/form-data')); ?>
                <div class="ibox-content">
                    <div class="col-sm-5 b-r col-md-offset-1">
                        <div id="divcodigo" class="form-group">
                            <label>Código Parametro</label>
                            <input type="text" id="codigo" name="codigo" 
                                   ng-model="codigo" 
                                   ng-change="codigo = codigo.toUpperCase();"
                                   maxlength="4"
                                   placeholder="Código Parametro" class="form-control" >
                            <input type="hidden" id="cod_old" name="cod_old" value="-1">
                        </div>
                        <div id="divdescri" class="form-group">
                            <label>Descripción</label>
                            <input type="text" id="descri" name="descri" 
                                   placeholder="Descripción Parametro" class="form-control" >
                        </div>
                        <div id="divtiparam" class="form-group">
                            <label>Tipo Parametro</label>
                            <select id="tiparam" name="tiparam" class="form-control m-b">
                                <option value="-1">-- Seleccione Activo --</option>
                                <option value="N">Numerico</option>
                                <option value="C">Caracteres</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div id="divvlrn" class="form-group">
                            <label>Valor Numerico</label>
                            <input type="text" id="vlrn" name="vlrn" 
                                   placeholder="Valor Numerico" class="form-control" >
                        </div>
                        <div id="divvlrc" class="form-group">
                            <label>Valor Caracteres</label>
                            <input type="text" id="vlrc" name="vlrc" 
                                   placeholder="Valor Caracteres" class="form-control" >
                        </div>
                        <div id="divactivo" class="form-group">
                            <label>Activo</label>
                            <select id="activo" name="activo" class="form-control m-b">
                                <option value="-1">-- Seleccione Activo --</option>
                                <option value="S">Si</option>
                                <option value="N">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-4 col-sm-offset-9">
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
                    <h5>Usuarios</h5>
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
                    <table id="dtparametros" 
                           class="table table-striped table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Descripción</th>
                                <th>Tipo Parametro</th>
                                <th>Valor Numerico</th>
                                <th>Valor Caracteres</th>
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

