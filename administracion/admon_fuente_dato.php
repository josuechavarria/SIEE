<?php
include '../phpIncluidos/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$stmt_fuentes = $conn->query('SELECT * FROM siee_fuente_dato ORDER BY titulo');
	$fuentes = $stmt_fuentes->fetchAll();
	$stmt_fuentes->closeCursor();
}
?>
<div class="encabezado" id="seccionEncabezadoReporteria">
    <div class="icono">
        <img src="recursos/iconos/preparaReporteIcon_48px.png">
    </div>
    <div class="lineaVertical">&nbsp;</div>
    <div class="descripcion" id="seccionDescripcionEncabezadoReporteria">
        <div class="titulo">
            Administraci&oacute;n De Fuentes De Datos
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
    <div id="tabsFuenteDato">
        <ul>
            <li><a href="#tabsFuenteDato-1" optionInd="1" >
                    <img class="tabIcons" src="recursos/iconos/plus.png" />
                    Registrar Nueva Fuente
                </a>
            </li>
            <li><a href="#tabsFuenteDato-2" optionInd="2">
                    <img class="tabIcons" src="recursos/iconos/pencil.png" />
                    Modificar Fuente
                </a>
            </li>
            <li><a href="#tabsFuenteDato-3" optionInd="3">
                    <img class="tabIcons" src="recursos/iconos/traffic-light.png" />
                    Activar / Desactivar Fuente
                </a>
            </li>
        </ul>
        <div id="tabsFuenteDato-1">
            <div class="formularios">
                <div id="CamposFormulario">
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_TituloFuenteDato">
                        </ul>
                        <label for="TituloFuenteDato">Titulo de la Fuente:</label>
                        <input id="TituloFuenteDato" name="tituloFuenteDato"  type="text" maxlength="128" style="width:499px;" />
                    </div>

                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_DescripcionFuenteDato">
                        </ul>
                        <label for="DescripcionFuenteDato">Descripci&oacute;n:</label>
                        <textarea id="DescripcionFuenteDato" name="descripcionFuenteDato" maxlength="265" ></textarea>
                    </div>
                </div>
				
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarAdminFuenteDato()">Guardar Fuente De Dato</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="tabsFuenteDato-2">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="buscadorFuenteDato" style="max-width: 400px;">Escribe aqu&iacute; el titulo de la fuente:</label>
                        <br/>
                        <input id="buscadorFuenteDato" type="text" onkeyup='filtroDeFuenteDato(this.value)' style="width:677px;"/>
                    </div>
                </div>
                <div class="listado" id="panelListadoModificarFuenteDato" style="height:auto;max-height:600px">
                    <ul id="listadoModificarFuenteDato">
					<?php
					$titulos_fuentes = '';
					foreach ($fuentes as $fuente) {
						if ($fuente['activo']){
							$titulos_fuentes .= utf8_decode(strtolower($fuente['titulo'])) . ',';
							echo '<li  titulo_fuente="' . utf8_decode(strtolower($fuente['titulo'])) . '">
									<div class="descripcion">
										<div class="items">
										<span style="font-weight: bold;">' . htmlentities($fuente['titulo']) . '</span>
										</div>
										<div class="items">
											' . htmlentities(substr($fuente['descripcion'], 0, 70)) . '...
										</div>
									</div>
									<div class="opciones">
										<button id="' . $fuente['id'] . '" class="ui-boton-modificar" onclick="cargarPanelModificacionFuenteDato(this.id)">Modificar</button>
									</div>
								</li>';
						}
					}
					?>                                                
                    </ul>
                </div>
            </div>            
        </div>

        <div id="tabsFuenteDato-3">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="radioBtn_filtroActInact" style="max-width: 400px;">Filtra las fuentes de datos que deseas ver:</label>
                        <div id="radioBtn_filtroActInact" name="radioOptions">
                            <label for="radioBtn_filtroActInact1" style="height: 30px;">Fuentes Activas</label>
                            <input type="radio" id="radioBtn_filtroActInact1" value="1" name="radioOptionsActDesactFuenteDato" onclick='filtroDeFuenteDatoMod(this.value)' />
                            <label for="radioBtn_filtroActInact2" style="height: 30px;">Todos</label>
                            <input type="radio" id="radioBtn_filtroActInact2" value="2" name="radioOptionsActDesactFuenteDato" onclick='filtroDeFuenteDatoMod(this.value)' checked="checked"/>
                            <label for="radioBtn_filtroActInact3" style="height: 30px;">Fuentes Inactivas</label>
                            <input type="radio" id="radioBtn_filtroActInact3" value="0" name="radioOptionsActDesactFuenteDato" onclick='filtroDeFuenteDatoMod(this.value)' />
                        </div>
                        <br/>
                    </div>
                </div>
                <div class="listado" id="panelListadoActDesactFuenteDato" style="height:auto;max-height:600px">
                    <ul id="listadoActDesactFuenteDato">
					<?php
					foreach ($fuentes as $fuente) {
						if ($fuente['activo']) {
							echo '<li  titulo_fuente="' . utf8_encode(strtolower($fuente['titulo'])) . '" esta_activa="' . $fuente['activo'] . '">
									<div class="descripcion">
										<div class="items">
										<span style="font-weight: bold;">' . htmlentities($fuente['titulo']) . '</span>
										</div>
										<div class="items">
											' . htmlentities(substr($fuente['descripcion'], 0, 70)) . '...
										</div>
									</div>
									<div class="opciones">
										<label class="chkDesactivar"><input name="estatusFuenteDato" type="checkbox" value="' . $fuente['id'] . '" onchange="uiActDesact(this)"/>Desactivar</label>
									</div>
								</li>';
						} else {
							echo '<li  titulo_fuente="' . utf8_encode(strtolower($fuente['titulo'])) . '" esta_activa="' . $fuente['activo'] . '">
									<div class="descripcion">
										<div class="items">
										<span style="font-weight: bold;">' . $fuente['id'] . '</span> - ' . htmlentities(substr($fuente['titulo'], 0, 64)) . '...
										</div>
										<div class="items">
											' . htmlentities(substr($fuente['descripcion'], 0, 70)) . '...
										</div>
									</div>
									<div class="opciones">
										<label class="chkActivar"><input name="estatusFuenteDato" type="checkbox" value="' . $fuente['id'] . '" onchange="uiActDesact(this)" />Activar</label>
									</div>
								</li>';
						}
					}
					?>                                                
                    </ul>
                </div>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarFuenteDatoActivarDesactivar()">Guardar Activaciones / Desactivaciones</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        var _data_fuente_dato = '<?php echo $titulos_fuentes; ?>'.split(',');
        
        $('#buscadorFuenteDato').autocomplete({
            source : _data_fuente_dato
        });
        
        $( "#tabsFuenteDato" ).tabs();
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
