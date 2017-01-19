<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Acceso Rol <small>Creación y edición de accesos de los Roles.</small></h5>
                </div>

                <!--FORMULARIO -->
                <?php echo form_open('/rol_menu/rol_menu/registraRolMenu', array('id' => 'frmrolmenu', 'enctype' => 'multipart/form-data')); ?>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div id="divrol" class="form-group">
                                <label>Rol</label>
                                <select id="rol" name="rol" class="form-control m-b">
                                    <option value="-1">-- Seleccione Rol --</option>
                                    <?php
                                        foreach ($roles->result() as $rol) { 
                                            echo '<option value="'.$rol->COD.'">'.$rol->DESCR.'</option>';
                                        }
                                    ?>
                                </select>
                                <input type="hidden" id="seq_nro_rol_menu" name="seq_nro_rol_menu" value="-1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div id="divmenu" class="form-group">
                                <label>Menu</label>
                                <select id="menu" name="menu" class="form-control m-b">
                                    <option value="-1">-- Seleccione Menu --</option>
                                    <?php
                                        foreach ($menus->result() as $menu) { 
                                            echo '<option value="'.$menu->SEQ_NRO.'">'.$menu->DESCR.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div id="divmodo" class="form-group">
                                <label>Modo</label>
                                <select id="modo" name="modo" class="form-control m-b">
                                    <option value="-1">-- Seleccione Modo --</option>
                                    <option value="A">Actualiza</option>
                                    <option value="C">Consulta</option>
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
                    <h5>Accesos Roles</h5>
                    <!--div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div-->
                </div>
                <div class="ibox-content">
                    <table id="dtrolmenu" 
                           class="table table-striped table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th>Rol</th>
                                <th>Menu</th>
                                <th>Modo</th>
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

