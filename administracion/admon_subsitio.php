<?php
include '../phpIncluidos/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$stmt_listado_Subsitio = $conn->query('SELECT * FROM siee_subsitio ORDER BY titulo');
	$lista_Subsitio = $stmt_listado_Subsitio->fetchAll();
	$stmt_listado_Subsitio->closeCursor();

	$stmt_listado_Subsitio_act = $conn->query('SELECT * FROM siee_subsitio WHERE activo = 1');
	$lista_Subsitio_act = $stmt_listado_Subsitio_act->fetchAll();
	$stmt_listado_Subsitio_act->closeCursor();
}
?>
<div class="encabezado" id="seccionEncabezadoReporteria">
    <div class="icono">
        <img src="recursos/iconos/preparaReporteIcon_48px.png">
    </div>
    <div class="lineaVertical">&nbsp;</div>
    <div class="descripcion" id="seccionDescripcionEncabezadoReporteria">
        <div class="titulo">
            Administraci&oacute;n de Subsitio
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
    <div id="tabsSubsitio">
        <ul>
            <li><a href="#tabsSubsitio-1" optionInd="1" >
                    <img class="tabIcons" src="recursos/iconos/plus.png" />
                    Registrar Nuevo Subsitio
                </a>
            </li>
            <li><a href="#tabsSubsitio-2" optionInd="2">
                    <img class="tabIcons" src="recursos/iconos/pencil.png" />
                    Modificar Subsitio
                </a>
            </li>
            <li><a href="#tabsSubsitio-3" optionInd="3">
                    <img class="tabIcons" src="recursos/iconos/traffic-light.png" />
                    Activar / Desactivar Subsitio
                </a>
            </li>
        </ul>
        <div id="tabsSubsitio-1">
            <div class="formularios">
                <div id="CamposFormulario">
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_TituloSubsitio">
                        </ul>
                        <label for="TituloSubsitio">Titulo subsitio:</label>
                        <input id="TituloSubsitio" name="TituloSubsitio"  type="text" maxlength="200" />
                    </div>
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_DescripcionSubsitio">
                        </ul>
                        <label for="DescripcionSubsitio">Descripci&oacute;n:</label>
                        <textarea id="DescripcionSubsitio" name="DescripcionSubsitio" maxlength="1024" ></textarea>
                    </div>
					<div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_AbreviaturaSubsitio">
                        </ul>
                        <label for="AbreviaturaSubsitio">Abreviatura del titulo:</label>
                        <input id="AbreviaturaSubsitio" name="AbreviaturaSubsitio"  type="text" maxlength="4" />
                    </div>
					<div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_UrlSubsitio">
                        </ul>
                        <label for="UrlSubsitio">URL del subsitio:</label>
                        <input id="UrlSubsitio" name="UrlSubsitio"  type="text" maxlength="100" />
                    </div>
				</div>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarAdminSubsitio()">Guardar Subsitio</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="tabsSubsitio-2">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="buscadorSubsitio" style="max-width: 400px;">Escriba aqu&iacute; el titulo del subsitio a buscar : </label>
                        <br/>
                        <input id="buscadorSubsitio" type="text" onkeyup='filtroDeSubsitio(this.value)' style="width:677px;"/>
                    </div>
                </div>
                <div class="listado" id="panelListadoModificarSubsitio" style="height:auto;max-height:600px">
                    <ul id="listadoModificarSubsitio">
						<?php
						$lista_de_Subsitio = "";
						foreach ($lista_Subsitio_act as $Subsitio) {

							$idSubsitio = $Subsitio['id'];
							$tituloSubsitio = $Subsitio['titulo'];
							$descripcionSubsitio = $Subsitio['descripcion'];


							$lista_de_Subsitio .= utf8_encode(strtolower($tituloSubsitio)) . ',';

							echo '<li  titulo_Subsitio="' . utf8_encode(strtolower($tituloSubsitio)) . '">
                                    <div class="descripcion">
                                        <div class="items">
                                           <span style="font-weight: bold;">' . $idSubsitio . '</span> - ' . htmlentities(substr($tituloSubsitio, 0, 64)) . '
                                        </div>
                                        <div class="items">
                                            ' . htmlentities(substr($descripcionSubsitio, 0, 70)) . '...
                                        </div>
                                    </div>
                                    <div class="opciones">
                                        <button id="' . $idSubsitio . '" class="ui-boton-modificar" onclick="cargarPanelModificacionSubsitio(this.id)">Modificar</button>
                                    </div>
                                </li>';
						}
						?>                                                
                    </ul>
                </div>
            </div>            
        </div>
        <div id="tabsSubsitio-3">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="radioBtn_filtroActInact" style="max-width: 400px;">Filtra los subsitios que deseas ver: </label>
                        <div id="radioBtn_filtroActInact" name="radioOptions">
                            <label for="radioBtn_filtroActInact1" style="height: 30px;">Subsitio Activos</label>
                            <input type="radio" id="radioBtn_filtroActInact1" value="1" name="radioOptionsActDesactSubsitio" onclick='filtroDeSubsitioMod(this.value)' />
                            <label for="radioBtn_filtroActInact2" style="height: 30px;">Todos</label>
                            <input type="radio" id="radioBtn_filtroActInact2" value="2" name="radioOptionsActDesactSubsitio" onclick='filtroDeSubsitioMod(this.value)' checked="checked"/>
                            <label for="radioBtn_filtroActInact3" style="height: 30px;">Subsitio Inactivos</label>
                            <input type="radio" id="radioBtn_filtroActInact3" value="0" name="radioOptionsActDesactSubsitio" onclick='filtroDeSubsitioMod(this.value)' />
                        </div>
                        <br/>
                    </div>
                </div>
                <div class="listado" id="panelListadoActDesactSubsitio" style="height:auto;max-height:600px">
                    <ul id="listadoActDesactSubsitio">
						<?php
						foreach ($lista_Subsitio as $Subsitio) {


							$idSubsitio = $Subsitio['id'];
							$tituloSubsitio = $Subsitio['titulo'];
							$descripcionSubsitio = $Subsitio['descripcion'];
							$esta_activa = $Subsitio['activo'];



							//$lista_de_Subsitio .= utf8_encode(strtolower($titulo)) . ',';

							if ($esta_activa) {
								echo '<li  titulo_Subsitio="' . utf8_encode(strtolower($tituloSubsitio)) . '" esta_activa="' . $esta_activa . '">
                                        <div class="descripcion">
                                            <div class="items">
                                                <span style="font-weight: bold;">' . $idSubsitio . '</span> - ' . htmlentities(substr($tituloSubsitio, 0, 64)) . '
                                            </div>
                                            <div class="items">
                                                ' . htmlentities(substr($descripcionSubsitio, 0, 70)) . '...
                                            </div>
                                        </div>
                                        <div class="opciones">
                                            <label class="chkDesactivar"><input name="estatusSubsitio" type="checkbox" value="' . $idSubsitio . '" onchange="uiActDesact(this)"/>Desactivar</label>
                                        </div>
                                    </li>';
							} else {
								echo '<li  titulo_Subsitio="' . utf8_encode(strtolower($tituloSubsitio)) . '" esta_activa="' . $esta_activa . '">
                                        <div class="descripcion">
                                            <div class="items">
                                                <span style="font-weight: bold;">' . $idSubsitio . '</span> - ' . htmlentities(substr($tituloSubsitio, 0, 64)) . '
                                            </div>
                                            <div class="items">
                                                ' . htmlentities(substr($descripcionSubsitio, 0, 70)) . '...
                                            </div>
                                        </div>
                                        <div class="opciones">
                                            <label class="chkActivar"><input name="estatusSubsitio" type="checkbox" value="' . $idSubsitio . '" onchange="uiActDesact(this)" />Activar</label>
                                        </div>
                                    </li>';
							}
						}
						?>                                                
                    </ul>
                </div>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarSubsitioActivarDesactivar()">Guardar Activaciones / Desactivaciones</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        var _data_Subsitio = '<?php echo $lista_de_Subsitio; ?>'.split(',');
        
        $('#buscadorSubsitio').autocomplete({
            source : _data_Subsitio
        });
        
        $( "#tabsSubsitio" ).tabs();
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