<?php
include '../phpIncluidos/conexion.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $no_hay_errores = FALSE;

    if (ISSET($_GET['id'])) {
        $usuario_id = $_GET['id'];
        $id_usuario = -1;

        try {
            $id_usuario = (int) $usuario_id;
            $no_hay_errores = TRUE;
        } catch (Exception $e) {
            $no_hay_errores = FALSE;
        }

        if ($no_hay_errores) {
           // echo ($id_usuario);
            $stmt_usuario = $conn->query('SELECT * FROM siee_usuario WHERE id = ' . $id_usuario . ' AND activo = 1');
            $sql_usuario = $stmt_usuario->fetch();
            $stmt_usuario->closeCursor();

            $no_hay_errores = (sizeof($sql_usuario) > 1);
        }
    } else {
        $no_hay_errores = false;
    }
}

if ($no_hay_errores) {
	?>
    <div id="PanelModificacionDeUsuarios" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
        <div class="headerFromularios">
            Panel de modificaci&oacute;n de usuario
        </div>
        <div id="CamposFormulario">
            <div class="itemsFormularios">
                <div class="itemsFormularios">
                    <ul class="errores_por_campo" id="errors_PrimerNombreUsuario_mod">
                    </ul>
                    <label for="PrimerNombreUsuario_mod">Primer nombre:</label>
                    <input id="PrimerNombreUsuario_mod" name="primerNombreUsuario"  type="text" maxlength="200" value="<?php echo htmlentities($sql_usuario['primer_nombre']) ?>" />
                </div>

                <div class="itemsFormularios">
                    <ul class="errores_por_campo" id="errors_SegundoNombreUsuario_mod">
                    </ul>
                    <label for="SegundoNombreUsuario_mod">Segundo nombre:</label>
                    <input id="SegundoNombreUsuario_mod" name="segundoNombreUsuario_mod"  type="text" maxlength="200" value="<?php echo htmlentities($sql_usuario['segundo_nombre']) ?>" />
                </div>

                <div class="itemsFormularios">
                    <ul class="errores_por_campo" id="errors_PrimerApellidoUsuario_mod">
                    </ul>
                    <label for="PrimerApellidoUsuario_mod">Primer apellido:</label>
                    <input id="PrimerApellidoUsuario_mod" name="primerApellidoUsuario_mod"  type="text" maxlength="200" value="<?php echo htmlentities($sql_usuario['primer_apellido']) ?>" />
                </div>

                <div class="itemsFormularios">
                    <ul class="errores_por_campo" id="errors_SegundoApellidoUsuario_mod">
                    </ul>
                    <label for="SegundoApellidoUsuario_mod">Segundo apellido:</label>
                    <input id="SegundoApellidoUsuario_mod" name="segundoApellidoUsuario_mod"  type="text" maxlength="200" value="<?php echo htmlentities($sql_usuario['segundo_apellido']) ?>" />
                </div>

                <div class="itemsFormularios">
                    <ul class="errores_por_campo" id="errors_NombreUsuario_mod">
                    </ul>
                    <label for="NombreUsuario_mod">Nombre de usuario:</label>
                    <input id="NombreUsuario_mod" name="nombreUsuario_mod"  type="text" maxlength="100" value="<?php echo htmlentities($sql_usuario['nombre_usuario']) ?>" />
                </div>

                <div class="itemsFormularios">
                    <ul class="errores_por_campo" id="errors_TelefonoFijoUsuario_mod">
                    </ul>
                    <label for="TelefonoFijoUsuario_mod">Tel&eacute;fono fijo:</label>
                    <input id="TelefonoFijoUsuario_mod" name="telefonoFijoUsuario_mod"  type="text" maxlength="10" value="<?php echo htmlentities($sql_usuario['telefono_fijo']) ?>" />
                </div>

                <div class="itemsFormularios">
                    <ul class="errores_por_campo" id="errors_TelefonoMovilUsuario_mod">
                    </ul>
                    <label for="TelefonoMovilUsuario_mod">Tel&eacute;fono m&oacute;vil:</label>
                    <input id="TelefonoMovilUsuario_mod" name="TelefonoMovilUsuario_mod"  type="text" maxlength="10" value="<?php echo htmlentities($sql_usuario['telefono_movil']) ?>" />
                </div>

                <div class="itemsFormularios">
                    <ul class="errores_por_campo" id="errors_CorreoElectronicoUsuario_mod">
                    </ul>
                    <label for="CorreoElectronicoUsuario_mod">Correo electr&oacute;nico:</label>
                    <input id="CorreoElectronicoUsuario_mod" name="correoElectronicoUsuario_mod"  type="text" maxlength="512" value="<?php echo htmlentities($sql_usuario['correo_electronico']) ?>" />
                </div>
                
                <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_RolUsuario_mod">
                        </ul>
                        <label for="RolUsuario_mod">Rol del usuario:</label>
                        <select id ="RolUsuario_mod" name="rolUsuario_mod">
							<?php
							$stmt_listado_roles_act = $conn->query('SELECT * FROM siee_rol WHERE activo = 1');
							$listaDeRolesDeUsuario = $stmt_listado_roles_act->fetchAll();
							$stmt_listado_roles_act->closeCursor();
							
                            foreach ($listaDeRolesDeUsuario as $roles) {
                                $id_rol = $roles['id'];
                                
								if ($roles['id'] == $sql_usuario['rol_id']) {
									echo '<option value="' . $id_rol . '"  selected="selected">' . $roles['titulo_rol'] . '</option>';
								}else{
									echo '<option value="' . $id_rol . '">' . $roles['titulo_rol'] . '</option>';
								}
                            }
                            ?>
                        </select>
                </div>
     
                <input style="display: none;" type="text" id="IdUsuario_mod" value="<?php echo $sql_usuario['id']?>"/>
                
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionDeUsuarios')">Cerrar sin guardar</button>
                        <button class="ui-boton-guardar" onclick="guardarModificacionUsuario()">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $( ".ui-boton-guardar" ).button({
                icons: {
                    primary: "ui-icon ui-icon-disk"
                } 
            });
            $( ".ui-boton-cerrar" ).button({
                icons: {
                    primary: "ui-icon ui-icon-closethick"
                } 
            });
        });
    </script>

    <?php
} else {
//si se encontraron errores
    ?>
    <div id="PanelModificacionUsuario" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
        <div class="headerFromularios">
            No se encontr&oacute; al usuario seleccionado
        </div>
        <div id="CamposFormulario">
            <div class="itemsFormularios">
                El Usuario que tratas de modificar no ha sido encontrada en el SIEE,
                refresca la pagina, vuelve a entrar a esta secci&oacute;n y realiza la tarea de nuevo.
            </div>
            <div class="itemsFormularios">
                <div class="optionPane">
                    <button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionUsuario')">Cerrar panel</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $( ".ui-boton-cerrar" ).button({
                icons: {
                    primary: "ui-icon ui-icon-closethick"
                } 
            });
        });
    </script>
    <?php
}
?>
