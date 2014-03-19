<?php
include '../phpIncluidos/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt_listado_usuario = $conn->query('	SELECT	U.id, U.primer_nombre, U.segundo_nombre, 
													U.primer_apellido, U.segundo_apellido,
													U.nombre_usuario, R.titulo_rol, U.activo
											FROM siee_usuario U 
											INNER JOIN siee_rol R ON U.rol_id = R.id
											WHERE U.oculto = 0 
											ORDER BY U.primer_nombre, U.primer_apellido');
    $lista_usuario = $stmt_listado_usuario->fetchAll();
    $stmt_listado_usuario->closeCursor();

    $stmt_listado_usuario_act = $conn->query('	SELECT	U.id, U.primer_nombre, U.segundo_nombre, 
														U.primer_apellido, U.segundo_apellido,
														U.nombre_usuario, R.titulo_rol, U.activo
												FROM siee_usuario U
												INNER JOIN siee_rol R ON U.rol_id = R.id
												WHERE U.activo = 1 AND U.oculto = 0
												ORDER BY U.primer_nombre, U.primer_apellido');
    $lista_usuario_act = $stmt_listado_usuario_act->fetchAll();
    $stmt_listado_usuario_act->closeCursor();

    $stmt_listado_roles_act = $conn->query('SELECT * FROM siee_rol WHERE activo = 1');
    $listaDeRolesDeUsuario = $stmt_listado_roles_act->fetchAll();
    $stmt_listado_roles_act->closeCursor();
}
?>
<div class="encabezado" id="seccionEncabezadoReporteria">
    <div class="icono">
        <img src="recursos/iconos/preparaReporteIcon_48px.png">
    </div>
    <div class="lineaVertical">&nbsp;</div>
    <div class="descripcion" id="seccionDescripcionEncabezadoReporteria">
        <div class="titulo">
            Administraci&oacute;n de Usuarios
            <div onclick="cerrarSeccionAdmin()" class="botonCerrarSeccion">Cerrar Secci&oacute;n</div> 
        </div>
        <div class="subTitulo">                                                    
        </div>                                                
    </div>
</div>
<div class="contenido">
    <br/>
    <div id="dialogWindow" title="" style="font-size: 10pt;">
    </div>
    <div id="tabsUsuario">
        <ul>
            <li><a href="#tabsUsuario-1" optionInd="1" >
                    <img class="tabIcons" src="recursos/iconos/plus.png" />
                    Registrar Nuevo Usuario
                </a>
            </li>
            <li><a href="#tabsUsuario-2" optionInd="2">
                    <img class="tabIcons" src="recursos/iconos/pencil.png" />
                    Modificar Usuario
                </a>
            </li>
            <li><a href="#tabsUsuario-3" optionInd="3">
                    <img class="tabIcons" src="recursos/iconos/traffic-light.png" />
                    Activar / Desactivar Usuario
                </a>
            </li>
        </ul>
        <div id="tabsUsuario-1">
            <div class="formularios">
                <div id="CamposFormulario">

                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_PrimerNombreUsuario">
                        </ul>
                        <label for="PrimerNombreUsuario">Primer nombre:</label>
                        <input id="PrimerNombreUsuario" name="primerNombreUsuario"  type="text" maxlength="200" />
                    </div>

                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_SegundoNombreUsuario">
                        </ul>
                        <label for="SegundoNombreUsuario">Segundo nombre:</label>
                        <input id="SegundoNombreUsuario" name="segundoNombreUsuario"  type="text" maxlength="200" />
                    </div>

                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_PrimerApellidoUsuario">
                        </ul>
                        <label for="PrimerApellidoUsuario">Primer apellido:</label>
                        <input id="PrimerApellidoUsuario" name="primerApellidoUsuario"  type="text" maxlength="200" />
                    </div>

                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_SegundoApellidoUsuario">
                        </ul>
                        <label for="SegundoApellidoUsuario">Segundo apellido:</label>
                        <input id="SegundoApellidoUsuario" name="segundoApellidoUsuario"  type="text" maxlength="200" />
                    </div>

                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_NombreUsuario">
                        </ul>
                        <label for="NombreUsuario">Nombre de usuario:</label>
                        <input id="NombreUsuario" name="nombreUsuario"  type="text" maxlength="100" />
                    </div>



                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_TelefonoFijoUsuario">
                        </ul>
                        <label for="TelefonoFijoUsuario">Tel&eacute;fono fijo:</label>
                        <input id="TelefonoFijoUsuario" name="telefonoFijoUsuario"  type="text" maxlength="10" />
                    </div>

                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_TelefonoMovilUsuario">
                        </ul>
                        <label for="TelefonoMovilUsuario">Tel&eacute;fono m&oacute;vil:</label>
                        <input id="TelefonoMovilUsuario" name="TelefonoMovilUsuario"  type="text" maxlength="10" />
                    </div>

                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_CorreoElectronicoUsuario">
                        </ul>
                        <label for="CorreoElectronicoUsuario">Correo electr&oacute;nico:</label>
                        <input id="CorreoElectronicoUsuario" name="correoElectronicoUsuario"  type="text" maxlength="512" />
                    </div>

                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_RolUsuario">
                        </ul>
                        <label for="ListaRolUsuario">Rol del usuario:</label>
                        <select id ="RolUsuario"name="listaDeRoles">
                            <?php
                            foreach ($listaDeRolesDeUsuario as $roles) {
                                $id_rol = $roles['id'];
                                $descripcion_rol = $roles['titulo_rol'];
                                echo '<option value="' . $id_rol . '">' . $descripcion_rol . '</option>';
                            }
                            ?>
							<option value="-1" selected="selected" style="font-style: italic;">Seleccione un rol...</option>
                        </select>
                    </div>
                </div>

                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarAdminUsuario()">Guardar Usuario</button>
                    </div>
                </div>
            </div>
        </div>
		
        <div id="tabsUsuario-2">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="buscadorUsuario" style="max-width: 400px;">Escribe aqu&iacute; el usuario que quieres encontrar:</label>
                        <br/>
                        <input id="buscadorUsuario" type="text" onkeyup='filtroDeUsuario(this.value)' style="width:677px;" />
                    </div>
                </div>
                <div class="listado" id="panelListadoModificarUsuario" style="height:auto;max-height:600px">
                    <ul id="listadoModificarUsuario">
                        <?php
                        $lista_de_usuario = "";
                        foreach ($lista_usuario_act as $usuario) { 
                            $idUsuario = $usuario['id'];
                            $nombreUsuario = $usuario['nombre_usuario'];
                            $primerNombreUsuario = $usuario['primer_nombre'];
                            $segundoNombreUsuario = $usuario['segundo_nombre'];
                            $primerApellidoUsuario = $usuario['primer_apellido'];
                            $segundoApellidoUsuario = $usuario['segundo_apellido'];

                            $lista_de_usuario .= utf8_encode(strtolower($nombreUsuario)) . ',';

                            echo '<li  nombre_usuario="' . utf8_encode(strtolower($nombreUsuario)) . '">
                                    <div class="descripcion">
                                        <div class="items">
                                           <span style="font-weight: bold;">' . $nombreUsuario . '</span> - ' . htmlentities(substr($primerNombreUsuario, 0, 64)) .
											' ' . htmlentities(substr($segundoNombreUsuario, 0, 64)) .
											' ' . htmlentities(substr($primerApellidoUsuario, 0, 64)) .
											' ' . htmlentities(substr($segundoApellidoUsuario, 0, 64)) . '
                                        </div>
                                        <div class="items">
                                            <span style="font-weight: bold;">Rol</span> - ' . htmlentities($usuario['titulo_rol']) . '
                                        </div>
                                    </div>
                                    <div class="opciones">
                                        <button id="' . $idUsuario . '" class="ui-boton-modificar" onclick="cargarPanelModificacionUsuario(this.id)">Modificar</button>
                                    </div>
                                </li>';
                        }
                        ?>                                                
                    </ul>
                </div>
            </div>            
        </div>
        <div id="tabsUsuario-3">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="radioBtn_filtroActInact" style="max-width: 400px;">Filtra los usuarios que deseas ver:</label>
                        <div id="radioBtn_filtroActInact" name="radioOptions">
                            <label for="radioBtn_filtroActInact1" style="height: 30px;">Usuarios Activos</label>
                            <input type="radio" id="radioBtn_filtroActInact1" value="1" name="radioOptionsActDesactUsuario" onclick='filtroDeUsuarioMod(this.value)' />
                            <label for="radioBtn_filtroActInact2" style="height: 30px;">Todos</label>
                            <input type="radio" id="radioBtn_filtroActInact2" value="2" name="radioOptionsActDesactUsuario" onclick='filtroDeUsuarioMod(this.value)' checked="checked"/>
                            <label for="radioBtn_filtroActInact3" style="height: 30px;">Usuarios Inactivos</label>
                            <input type="radio" id="radioBtn_filtroActInact3" value="0" name="radioOptionsActDesactUsuario" onclick='filtroDeUsuarioMod(this.value)' />
                        </div>
                        <br/>
                    </div>
                </div>
                <div class="listado" id="panelListadoActDesactUsuario" style="height:auto;max-height:600px">
                    <ul id="listadoActDesactUsuario">
                        <?php
                        foreach ($lista_usuario as $usuario) {
                            $idUsuario = $usuario['id'];
                            $nombreUsuario = $usuario['nombre_usuario'];
                            $primerNombreUsuario = $usuario['primer_nombre'];
                            $segundoNombreUsuario = $usuario['segundo_nombre'];
                            $primerApellidoUsuario = $usuario['primer_apellido'];
                            $segundoApellidoUsuario = $usuario['segundo_apellido'];
                            $esta_activa = $usuario['activo'];
                            if ($esta_activa) {
                                echo '<li  nombre_usuario="' . utf8_encode(strtolower($nombreUsuario)) . '" esta_activa="' . $esta_activa . '">
                                        <div class="descripcion">
                                            <div class="items">
                                                <span style="font-weight: bold;">' . $nombreUsuario . '</span> - ' . htmlentities(substr($primerNombreUsuario, 0, 64)) .
												' ' . htmlentities(substr($segundoNombreUsuario, 0, 64)) .
												' ' . htmlentities(substr($primerApellidoUsuario, 0, 64)) .
												' ' . htmlentities(substr($segundoApellidoUsuario, 0, 64)) . '
                                            </div>
                                            <div class="items">
                                                <span style="font-weight: bold;">Rol</span> - ' . htmlentities($usuario['titulo_rol']) . '
                                            </div>
                                        </div>
                                        <div class="opciones">
                                            <label class="chkDesactivar"><input name="estatusUsuario" type="checkbox" value="' . $idUsuario . '" onchange="uiActDesact(this)"/>Desactivar</label>
                                        </div>
                                    </li>';
                            } else {
                                echo '<li  nombre_usuario="' . utf8_encode(strtolower($nombreUsuario)) . '" esta_activa="' . $esta_activa . '">
                                        <div class="descripcion">
                                            <div class="items">
                                                <span style="font-weight: bold;">' . $nombreUsuario . '</span> - ' . htmlentities(substr($primerNombreUsuario, 0, 64)) .
													' ' . htmlentities(substr($segundoNombreUsuario, 0, 64)) .
													' ' . htmlentities(substr($primerApellidoUsuario, 0, 64)) .
													' ' . htmlentities(substr($segundoApellidoUsuario, 0, 64)) . '
                                            </div>
                                            <div class="items">
                                                <span style="font-weight: bold;">Rol</span> - ' . htmlentities($usuario['titulo_rol']) . '
                                            </div>
                                        </div>
                                        <div class="opciones">
                                            <label class="chkActivar"><input name="estatusUsuario" type="checkbox" value="' . $idUsuario . '" onchange="uiActDesact(this)" />Activar</label>
                                        </div>
                                    </li>';
                            }
                        }
                        ?>                                                
                    </ul>
                </div>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarUsuarioActivarDesactivar()">Guardar Activaciones / Desactivaciones</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        var _data_Usuario = '<?php echo $lista_de_usuario; ?>'.split(',');
        
        $('#buscadorUsuario').autocomplete({
            source : _data_Usuario
        });
        
        $( "#tabsUsuario" ).tabs();
        $( ".ui-boton-guardar" ).button({
            icons: {
                primary: "ui-icon ui-icon-disk"
            } 
        });
        $( ".ui-boton-modificar" ).button({
            icons: {
                primary: "ui-icon ui-icon-pencil"
            } 
        }); 
        $( ".ui-boton-cerrar" ).button({
            icons: {
                primary: "ui-icon ui-icon-closethick"
            } 
        });
        $('[name="radioOptions"]').buttonset();
    });    
    
    function uiActDesact(elemt)
    {
        if($(elemt).is(':checked'))
        {
            $(elemt).parent().addClass('chkSeleccionado');
        }
        else
        {
            $(elemt).parent().removeClass('chkSeleccionado');
        }
    }
</script>
