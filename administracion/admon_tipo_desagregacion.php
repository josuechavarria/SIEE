<?php
include '../phpIncluidos/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    $stmt_listado_TipoDesagregacion = $conn->query('SELECT * FROM siee_tipo_desagregacion ORDER BY titulo');
    $lista_TipoDesagregacion = $stmt_listado_TipoDesagregacion->fetchAll();
    $stmt_listado_TipoDesagregacion->closeCursor();

    $stmt_listado_TipoDesagregacion_act = $conn->query('SELECT * FROM siee_tipo_desagregacion WHERE activo = 1');
    $lista_TipoDesagregacion_act = $stmt_listado_TipoDesagregacion_act->fetchAll();
    $stmt_listado_TipoDesagregacion_act->closeCursor();

}
?>
<div class="encabezado" id="seccionEncabezadoReporteria">
    <div class="icono">
        <img src="recursos/iconos/preparaReporteIcon_48px.png">
    </div>
    <div class="lineaVertical">&nbsp;</div>
    <div class="descripcion" id="seccionDescripcionEncabezadoReporteria">
        <div class="titulo">
            Administraci&oacute;n de tipos de desagregaci&oacute;n
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
    <div id="tabsTipoDesagregacion">
        <ul>
            <li><a href="#tabsTipoDesagregacion-1" optionInd="1" >
                    <img class="tabIcons" src="recursos/iconos/plus.png" />
                    Registrar nvo. T. Desagregaci&oacute;n
                </a>
            </li>
            <li><a href="#tabsTipoDesagregacion-2" optionInd="2">
                    <img class="tabIcons" src="recursos/iconos/pencil.png" />
                    Modificar T. desagregaci&oacute;n
                </a>
            </li>
            <li><a href="#tabsTipoDesagregacion-3" optionInd="3">
                    <img class="tabIcons" src="recursos/iconos/traffic-light.png" />
                    Activar / Desactivar T. desagregaci&oacute;n
                </a>
            </li>
        </ul>
        <div id="tabsTipoDesagregacion-1">
            <div class="formularios">
                <div id="CamposFormulario">
                    
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_TituloTipoDesagregacion">
                        </ul>
                        <label for="TituloTipoDesagregacion">Titulo :</label>
                        <input id="TituloTipoDesagregacion" name="TituloTipoDesagregacion"  type="text" maxlength="200" />
                    </div>
                    
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_DescripcionTipoDesagregacion">
                        </ul>
                        <label for="DescripcionTipoDesagregacion">Descripci&oacute;n :</label>
                        <textarea id="DescripcionTipoDesagregacion" name="DescripcionTipoDesagregacion" maxlength="1024" ></textarea>
                    </div>
               </div>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarAdminTipoDesagregacion()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="tabsTipoDesagregacion-2">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="buscadorTipoDesagregacion" style="max-width: 400px;">Escribe aqu&iacute; el titulo de la desagregaci&oacute;n a buscar:</label>
                        <br/>
                        <input id="buscadorTipoDesagregacion" type="text" onkeyup='filtroDeTipoDesagregacion(this.value)' style="width:677px;" />
                    </div>
                </div>
                <div class="listado" id="panelListadoModificarTipoDesagregacion" style="height:auto;max-height:600px">
                    <ul id="listadoModificarTipoDesagregacion">
                        <?php
                        $lista_de_TipoDesagregacion = "";
                        foreach ($lista_TipoDesagregacion_act as $TipoDesagregacion) {
                            
                            $idTipoDesagregacion = $TipoDesagregacion['id'];
                            $tituloTipoDesagregacion = $TipoDesagregacion['titulo'];
                            $descripcionTipoDesagregacion = $TipoDesagregacion['descripcion'];
                            

                            $lista_de_TipoDesagregacion .= utf8_encode(strtolower($tituloTipoDesagregacion)) . ',';

                            echo '<li  titulo_TipoDesagregacion="' . utf8_encode(strtolower($tituloTipoDesagregacion)) . '">
                                    <div class="descripcion">
                                        <div class="items">
                                           <span style="font-weight: bold;">' . $idTipoDesagregacion . '</span> - ' . htmlentities(substr($tituloTipoDesagregacion, 0, 64)) .'
                                        </div>
                                        <div class="items">
                                            ' . htmlentities(substr($descripcionTipoDesagregacion, 0, 70)) . '...
                                        </div>
                                    </div>
                                    <div class="opciones">
                                        <button id="' . $idTipoDesagregacion . '" class="ui-boton-modificar" onclick="cargarPanelModificacionTipoDesagregacion(this.id)">Modificar</button>
                                    </div>
                                </li>';
                        }
                        ?>                                                
                    </ul>
                </div>
            </div>            
        </div>
        <div id="tabsTipoDesagregacion-3">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="radioBtn_filtroActInact" style="max-width: 400px;">Filtra los tipo de desagraci&oacute;n que deseas ver:</label>
                        <div id="radioBtn_filtroActInact" name="radioOptions">
                            <label for="radioBtn_filtroActInact1" style="height: 30px;">Activas</label>
                            <input type="radio" id="radioBtn_filtroActInact1" value="1" name="radioOptionsActDesactTipoDesagregacion" onclick='filtroDeTipoDesagregacionMod(this.value)' />
                            <label for="radioBtn_filtroActInact2" style="height: 30px;">Todas</label>
                            <input type="radio" id="radioBtn_filtroActInact2" value="2" name="radioOptionsActDesactTipoDesagregacion" onclick='filtroDeTipoDesagregacionMod(this.value)' checked="checked"/>
                            <label for="radioBtn_filtroActInact3" style="height: 30px;">Inactivas</label>
                            <input type="radio" id="radioBtn_filtroActInact3" value="0" name="radioOptionsActDesactTipoDesagregacion" onclick='filtroDeTipoDesagregacionMod(this.value)' />
                        </div>
                        <br/>
                    </div>
                </div>
                <div class="listado" id="panelListadoActDesactTipoDesagregacion" style="height:auto;max-height:600px">
                    <ul id="listadoActDesactTipoDesagregacion">
                        <?php
                        foreach ($lista_TipoDesagregacion as $TipoDesagregacion) {                         

                            $idTipoDesagregacion = $TipoDesagregacion['id'];
                            $tituloTipoDesagregacion = $TipoDesagregacion['titulo'];
                            $descripcionTipoDesagregacion = $TipoDesagregacion['descripcion'];
                            $esta_activa = $TipoDesagregacion['activo'];

                            if ($esta_activa) {
                                echo '<li  titulo_TipoDesagregacion="' . utf8_encode(strtolower($tituloTipoDesagregacion)) . '" esta_activa="' . $esta_activa . '">
                                        <div class="descripcion">
                                            <div class="items">
                                                <span style="font-weight: bold;">' . $idTipoDesagregacion . '</span> - ' . htmlentities(substr($tituloTipoDesagregacion, 0, 64)) .'
                                            </div>
                                            <div class="items">
                                                ' . htmlentities(substr($descripcionTipoDesagregacion, 0, 70)) . '...
                                            </div>
                                        </div>
                                        <div class="opciones">
                                            <label class="chkDesactivar"><input name="estatusTipoDesagregacion" type="checkbox" value="' . $idTipoDesagregacion . '" onchange="uiActDesact(this)"/>Desactivar</label>
                                        </div>
                                    </li>';
                            } else {
                                echo '<li  titulo_TipoDesagregacion="' . utf8_encode(strtolower($tituloTipoDesagregacion)) . '" esta_activa="' . $esta_activa . '">
                                        <div class="descripcion">
                                            <div class="items">
                                                <span style="font-weight: bold;">' . $idTipoDesagregacion . '</span> - ' . htmlentities(substr($tituloTipoDesagregacion, 0, 64)) . '
                                            </div>
                                            <div class="items">
                                                ' . htmlentities(substr($descripcionTipoDesagregacion, 0, 70)) . '...
                                            </div>
                                        </div>
                                        <div class="opciones">
                                            <label class="chkActivar"><input name="estatusTipoDesagregacion" type="checkbox" value="' . $idTipoDesagregacion . '" onchange="uiActDesact(this)" />Activar</label>
                                        </div>
                                    </li>';
                            }
                        }
                        ?>                                                
                    </ul>
                </div>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarTipoDesagregacionActivarDesactivar()">Guardar Activaciones/Desactivaciones</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        var _data_TipoDesagregacion = '<?php echo $lista_de_TipoDesagregacion; ?>'.split(',');
        
        $('#buscadorTipoDesagregacion').autocomplete({
            source : _data_TipoDesagregacion
        });
        
        $( "#tabsTipoDesagregacion" ).tabs();
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
