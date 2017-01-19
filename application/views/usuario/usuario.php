<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Usuario <small>Creación y edición de usuarios.</small></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <!--FORMULARIO -->
                <?php echo form_open('/usuario/usuario/registraUsuario', array('id' => 'frmusuario', 'enctype' => 'multipart/form-data')); ?>
                <div class="ibox-content">
                    <div class="col-sm-5 b-r col-md-offset-1">
                        <div id="divcodigo" class="form-group">
                            <label>Código</label>
                            <input type="text" id="codigo" name="codigo" 
                                   ng-model="codigo" 
                                   ng-change="codigo = codigo.toUpperCase();"
                                   maxlength="3"
                                   placeholder="Código Usuario" class="form-control" >
                            <input type="hidden" id="cod_old" name="cod_old" value="-1">
                        </div>
                        <div id="divrol" class="form-group">
                            <label>Rol Usuario</label>
                            <select id="rol" name="rol" class="form-control m-b">
                                <option value="-1">-- Seleccione Rol --</option>
                                <?php
                                foreach ($roles->result() as $rol) {

                                    echo '<option value="' . $rol->COD . '">' . $rol->DESCR . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div id="divnombre" class="form-group">
                            <label>Nombre</label>
                            <input type="text" id="nombre" name="nombre" 
                                   placeholder="Nombre Usuario" class="form-control" >
                        </div>
                        <div id="divapellido" class="form-group">
                            <label>Apellido</label>
                            <input type="text" id="apellido" name="apellido" 
                                   placeholder="Apellido Usuario" class="form-control" >
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div id="divcorreo" class="form-group">
                            <label>Correo</label>
                            <input type="email" id="correo" name="correo" 
                                   placeholder="Correo Usuario" class="form-control" >
                        </div>
                        <div id="divclave" class="form-group">
                            <label>Contraseña</label>
                            <input type="password" id="clave" name="clave" 
                                   placeholder="Contraseña Usuario" class="form-control" >
                        </div>
                        <div id="divusrback" class="form-group">
                            <label>Usuario Backup</label>
                            <select id="usrback" name="usrback" class="form-control m-b">
                                <option value="-1">-- Seleccione Usuario --</option>
                                <?php
                                foreach ($usuarios->result() as $usuario) {
                                    echo '<option value="'.$usuario->COD_USUA.'">'.$usuario->NOMBREC.'</option>';
                                }
                                ?>
                            </select>
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
                    <table id="dtusuarios" 
                           class="table table-striped table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Rol</th>
                                <th>Nombre</th>
                                <!--th>Apellido</th-->
                                <th>Correo</th>
                                <th>Activo</th>
                                <th>Backup</th>
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

