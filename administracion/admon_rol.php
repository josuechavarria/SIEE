<?php
include '../phpIncluidos/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt_listado_rol = $conn->query('SELECT * FROM siee_rol ORDER BY titulo_rol');
    $lista_de_rol = $stmt_listado_rol->fetchAll();
    $stmt_listado_rol->closeCursor();

    $stmt_listado_rol_act = $conn->query('SELECT * FROM siee_rol WHERE activo = 1 ORDER BY titulo_rol');
    $lista_de_rol_act = $stmt_listado_rol_act->fetchAll();
    $stmt_listado_rol_act->closeCursor();    
}
?>
<div class="encabezado" id="seccionEncabezadoReporteria">
    <div class="icono">
        <img src="recursos/iconos/preparaReporteIcon_48px.png">
    </div>
    <div class="lineaVertical">&nbsp;</div>
    <div class="descripcion" id="seccionDescripcionEncabezadoReporteria">
        <div class="titulo">
            Administraci&oacute;n De Rol
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
    <div id="tabsRol">
        <ul>
            <li><a href="#tabsRol-1" optionInd="1" >
                    <img class="tabIcons" src="recursos/iconos/plus.png" />
                    Registrar Nuevo Rol
                </a>
            </li>
            <li><a href="#tabsRol-2" optionInd="2">
                    <img class="tabIcons" src="recursos/iconos/pencil.png" />
                    Modificar Rol
                </a>
            </li>
            <li><a href="#tabsRol-3" optionInd="3">
                    <img class="tabIcons" src="recursos/iconos/traffic-light.png" />
                    Activar / Desactivar Rol
                </a>
            </li>
        </ul>
        <div id="tabsRol-1">
            <div class="formularios">
                <div id="CamposFormulario">
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_TituloRol">
                        </ul>
                        <label for="TituloRol">Titulo del Rol:</label>
                        <input id="TituloRol" name="tituloRol"  type="text" maxlength="128" style="width:499px;" />
                    </div>

                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_DescripcionRol">
                        </ul>
                        <label for="DescripcionRol">Descripci&oacute;n:</label>
                        <textarea id="DescripcionRol" name="descripcionRol" maxlength="1024" ></textarea>
                    </div>
					
					<div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_Administrador">
                        </ul>
                        <label>¿Es administrador?</label>
						<span id="RadioAdministrador">
							<input type="radio" id="AdministradorSi" name="administrador" value="1"/><label for="AdministradorSi">Si</label>
							<input type="radio" id="AdministradorNo" name="administrador" value="0" checked="checked" /><label for="AdministradorNo">No</label>
						</span>
					</div>
					
					<div class="itemsFormularios">
						<ul class="errores_por_campo" id="errors_AlertasDeDesviaciones"></ul>
						<label>¿Ver desviaciones?</label>
						<span id="RadioAlertasDeDesviaciones">	
							<input type="radio" id="AlertasDeDesviacionesSi"name="alertas_de_desviaciones" value="1"/><label for="AlertasDeDesviacionesSi">Si</label>
							<input type="radio" id="AlertasDeDesviacionesNo"name="alertas_de_desviaciones" value="0" checked="checked" /><label for="AlertasDeDesviacionesNo">No</label>
						</span>
					</div>
					
					<div class="itemsFormularios">
						<ul class="errores_por_campo" id="errors_IndicadoresPrivados"></ul>
						<label>¿Ver indicadores privados?</label>
						<span id="RadioIndicadoresPrivados">	
							<input type="radio" id="IndicadoresPrivadosSi"name="indicadores_privados" value="1"/><label for="IndicadoresPrivadosSi">Si</label>
							<input type="radio" id="IndicadoresPrivadosNo"name="indicadores_privados" value="0" checked="checked" /><label for="IndicadoresPrivadosNo">No</label>
						</span>
					</div>
					
					<div class="itemsFormularios">
						<ul class="errores_por_campo" id="errors_Proyecciones"></ul>
						<label>¿Aplicar proyecciones?</label>
						<span id="RadioProyecciones">	
							<input type="radio" id="ProyeccionesSi"name="proyecciones" value="1"/><label for="ProyeccionesSi">Si</label>
							<input type="radio" id="ProyeccionesNo"name="proyecciones" value="0" checked="checked" /><label for="ProyeccionesNo">No</label>
						</span>
					</div>
					
					<div class="itemsFormularios">
						<ul class="errores_por_campo" id="errors_Moderador"></ul>
						<label>¿Moderador de comentarios?</label>
						<span id="RadioModerador">	
							<input type="radio" id="ModeradorSi"name="moderador" value="1"/><label for="ModeradorSi">Si</label>
							<input type="radio" id="ModeradorNo"name="moderador" value="0" checked="checked" /><label for="ModeradorNo">No</label>
						</span>
					</div>
                </div>
				
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarAdminRol()">Guardar Rol</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="tabsRol-2">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="buscadorRol" style="max-width: 400px;">Escribe aqu&iacute; el titulo del rol:</label>
                        <br/>
                        <input id="buscadorRol" type="text" onkeyup='filtroDeRol(this.value)' style="width:677px;"/>
                    </div>
                </div>
                <div class="listado" id="panelListadoModificarRol" style="height:auto;max-height:600px">
                    <ul id="listadoModificarRol">
					<?php
					$lista_titulos_rol = "";
					foreach ($lista_de_rol_act as $rol) {
						$id_rol = $rol['id'];
						$titulo = $rol['titulo_rol'];
						$descripcion = $rol['descripcion_rol'];

						$lista_titulos_rol .= utf8_encode(strtolower($titulo)) . ',';

						echo '<li  titulo_rol="' . utf8_encode(strtolower($titulo)) . '">
								<div class="descripcion">
									<div class="items">
									<span style="font-weight: bold;">' . htmlentities($titulo) . '</span>
									</div>
									<div class="items">
										' . htmlentities(substr($descripcion, 0, 70)) . '...
									</div>
								</div>
								<div class="opciones">
									<button id="' . $id_rol . '" class="ui-boton-modificar" onclick="cargarPanelModificacionRol(this.id)">Modificar</button>
								</div>
							</li>';
					}
					?>                                                
                    </ul>
                </div>
            </div>            
        </div>

        <div id="tabsRol-3">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="radioBtn_filtroActInact" style="max-width: 400px;">Filtra los roles que deseas ver:</label>
                        <div id="radioBtn_filtroActInact" name="radioOptions">
                            <label for="radioBtn_filtroActInact1" style="height: 30px;">Rol Activos</label>
                            <input type="radio" id="radioBtn_filtroActInact1" value="1" name="radioOptionsActDesactRol" onclick='filtroDeSeriesRolMod(this.value)' />
                            <label for="radioBtn_filtroActInact2" style="height: 30px;">Todos</label>
                            <input type="radio" id="radioBtn_filtroActInact2" value="2" name="radioOptionsActDesactRol" onclick='filtroDeSeriesRolMod(this.value)' checked="checked"/>
                            <label for="radioBtn_filtroActInact3" style="height: 30px;">Rol Inactivos</label>
                            <input type="radio" id="radioBtn_filtroActInact3" value="0" name="radioOptionsActDesactRol" onclick='filtroDeSeriesRolMod(this.value)' />
                        </div>
                        <br/>
                    </div>
                </div>
                <div class="listado" id="panelListadoActDesactRol" style="height:auto;max-height:600px">
                    <ul id="listadoActDesactRol">
					<?php
					foreach ($lista_de_rol as $rol) {
						$id_rol = $rol['id'];
						$titulo = $rol['titulo_rol'];
						$descripcion = $rol['descripcion_rol'];
						$esta_activa = $rol['activo'];
						
						if ($esta_activa) {
							echo '<li  titulo_rol="' . utf8_encode(strtolower($titulo)) . '" esta_activa="' . $esta_activa . '">
									<div class="descripcion">
										<div class="items">
										<span style="font-weight: bold;">' . htmlentities($titulo) . '</span>
										</div>
										<div class="items">
											' . htmlentities(substr($descripcion, 0, 70)) . '...
										</div>
									</div>
									<div class="opciones">
										<label class="chkDesactivar"><input name="estatusRol" type="checkbox" value="' . $id_rol . '" onchange="uiActDesact(this)"/>Desactivar</label>
									</div>
								</li>';
						} else {
							echo '<li  titulo_rol="' . utf8_encode(strtolower($titulo)) . '" esta_activa="' . $esta_activa . '">
									<div class="descripcion">
										<div class="items">
										<span style="font-weight: bold;">' . $id_rol . '</span> - ' . htmlentities(substr($titulo, 0, 64)) . '...
										</div>
										<div class="items">
											' . htmlentities(substr($descripcion, 0, 70)) . '...
										</div>
									</div>
									<div class="opciones">
										<label class="chkActivar"><input name="estatusRol" type="checkbox" value="' . $id_rol . '" onchange="uiActDesact(this)" />Activar</label>
									</div>
								</li>';
						}
					}
					?>                                                
                    </ul>
                </div>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarRolActivarDesactivar()">Guardar Activaciones / Desactivaciones</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        var _data_rol = '<?php echo $lista_titulos_rol; ?>'.split(',');
        
        $('#buscadorRol').autocomplete({
            source : _data_rol
        });
        
        $( "#tabsRol" ).tabs();
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
		
		$( "#RadioAdministrador" ).buttonset();
		$( "#RadioAlertasDeDesviaciones" ).buttonset();
		$( "#RadioIndicadoresPrivados" ).buttonset();
		$( "#RadioProyecciones" ).buttonset();
		$( "#RadioModerador" ).buttonset();
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
