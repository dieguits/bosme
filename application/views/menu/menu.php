<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Menú <small>Creación y edición de Menú.</small></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <!--FORMULARIO -->
                <?php echo form_open('/menu/menu/registraMenu', array('id' => 'frmmenu', 'enctype' => 'multipart/form-data')); ?>
                <div class="ibox-content">
                    <div class="col-sm-5 b-r col-md-offset-1">
                        <div id="divdescri" class="form-group">
                            <label>Descripción</label>
                            <input type="text" id="descri" name="descri" 
                                   placeholder="Descripción Menú" class="form-control" >
                            <input type="hidden" id="seq_nro" name="seq_nro" value="-1">
                        </div>
                        <div id="divnivel" class="form-group">
                            <label>Nivel</label>
                            <input type="number" id="nivel" name="nivel"
                                   max="2"
                                   placeholder="Descripción Menú" class="form-control" >
                        </div>
                        <div id="divsubnivel" class="form-group">
                            <label>Padre</label>
                            <select id="subnivel" name="subnivel" class="form-control m-b">
                                <option value="">-- Seleccione Sub-Nivel --</option>
                                <?php
                                    foreach ($menus->result() as $menu) {
                                        echo '<option value="'.$menu->SEQ_NRO.'">'.$menu->DESCR.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div id="divorden" class="form-group">
                            <label>Orden</label>
                            <input type="number" id="orden" name="orden" 
                                   max="99"
                                   placeholder="Orden Menú" class="form-control" >
                        </div>
                        <div id="divruta" class="form-group">
                            <label>Ruta Menú</label>
                            <input type="text" id="ruta" name="ruta" 
                                   placeholder="Ruta Menú" class="form-control" >
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
                    <h5>Menús</h5>
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
                    <table id="dtmenu" 
                           class="table table-striped table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Nivel</th>
                                <th>Padre</th>
                                <!--th>Apellido</th-->
                                <th>Orden</th>
                                <th>Ruta</th>
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


