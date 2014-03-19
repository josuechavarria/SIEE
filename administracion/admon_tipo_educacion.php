<?php
include '../phpIncluidos/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    $stmt_listado_tipoEducacion = $conn->query('SELECT * FROM siee_tipo_educacion ORDER BY titulo');
    $lista_tipoEducacion = $stmt_listado_tipoEducacion->fetchAll();
    $stmt_listado_tipoEducacion->closeCursor();

    $stmt_listado_tipoEducacion_act = $conn->query('SELECT * FROM siee_tipo_educacion WHERE activo = 1');
    $lista_tipoEducacion_act = $stmt_listado_tipoEducacion_act->fetchAll();
    $stmt_listado_tipoEducacion_act->closeCursor();

}
?>
<div class="encabezado" id="seccionEncabezadoReporteria">
    <div class="icono">
        <img src="recursos/iconos/preparaReporteIcon_48px.png">
    </div>
    <div class="lineaVertical">&nbsp;</div>
    <div class="descripcion" id="seccionDescripcionEncabezadoReporteria">
        <div class="titulo">
            Administraci&oacute;n de tipos de educaci&oacute;n
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
    <div id="tabsTipoEducacion">
        <ul>
            <li><a href="#tabsTipoEducacion-1" optionInd="1" >
                    <img class="tabIcons" src="recursos/iconos/plus.png" />
                    Nuevo Tipo De Educaci&oacute;n
                </a>
            </li>
            <li><a href="#tabsTipoEducacion-2" optionInd="2">
                    <img class="tabIcons" src="recursos/iconos/pencil.png" />
                    Modificar Tipo De Educaci&oacute;n
                </a>
            </li>
            <li><a href="#tabsTipoEducacion-3" optionInd="3">
                    <img class="tabIcons" src="recursos/iconos/traffic-light.png" />
                    Activar / Desactivar Tipo De Educaci&oacute;n
                </a>
            </li>
        </ul>
        <div id="tabsTipoEducacion-1">
            <div class="formularios">
                <div id="CamposFormulario">
                    
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_TituloTipoEducacion">
                        </ul>
                        <label for="TituloTipoEducacion">Titulo:</label>
                        <input id="TituloTipoEducacion" name="TituloTipoEducacion"  type="text" maxlength="200" />
                    </div>
                    
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_DescripcionTipoEducacion">
                        </ul>
                        <label for="DescripcionTipoEducacion">Descripci&oacute;n:</label>
                        <textarea id="DescripcionTipoEducacion" name="DescripcionTipoEducacion" maxlength="1024" ></textarea>
                    </div>

                    

               </div>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarAdminTipoEducacion()">Guardar Tipo De Educaci&oacute;n</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="tabsTipoEducacion-2">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="buscadorTipoEducacion" style="max-width: 400px;">Escribe aqu&iacute; el Tipo De Educaci&oacute;n que quieres encontrar:</label>
                        <br/>
                        <br/>
                        <input id="buscadorTipoEducacion" type="text" onkeyup='filtroDeTipoEducacion(this.value)' style="width:678px;"/>
                    </div>
                </div>
                <div class="listado" id="panelListadoModificarTipoEducacion" style="height:auto;max-height:600px">
                    <ul id="listadoModificarTipoEducacion">
                        <?php
                        $lista_de_TipoEducacion = "";
                        foreach ($lista_tipoEducacion_act as $TipoEducacion) {
                            
                            $idTipoEducacion = $TipoEducacion['id'];
                            $tituloTipoEducacion = $TipoEducacion['titulo'];
                            $descripcionTipoEducacion = $TipoEducacion['descripcion'];
                            

                            $lista_de_TipoEducacion .= utf8_encode(strtolower($tituloTipoEducacion)) . ',';

                            echo '<li  titulo_TipoEducacion="' . utf8_encode(strtolower($tituloTipoEducacion)) . '">
                                    <div class="descripcion">
                                        <div class="items">
                                           <span style="font-weight: bold;">' . $idTipoEducacion . '</span> - ' . htmlentities(substr($tituloTipoEducacion, 0, 64)) .'
                                        </div>
                                        <div class="items">
                                            ' . htmlentities(substr($descripcionTipoEducacion, 0, 70)) . '...
                                        </div>
                                    </div>
                                    <div class="opciones">
                                        <button id="' . $idTipoEducacion . '" class="ui-boton-modificar" onclick="cargarPanelModificacionTipoEducacion(this.id)">Modificar</button>
                                    </div>
                                </li>';
                        }
                        ?>                                                
                    </ul>
                </div>
            </div>            
        </div>
        <div id="tabsTipoEducacion-3">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="radioBtn_filtroActInact" style="max-width: 400px;">Filtra los niveles educativos que deseas ver:</label>
                        <div id="radioBtn_filtroActInact" name="radioOptions">
                            <label for="radioBtn_filtroActInact1" style="height: 30px;">Tipo De Educaci&oacute;n Activos</label>
                            <input type="radio" id="radioBtn_filtroActInact1" value="1" name="radioOptionsActDesactTipoEducacion" onclick='filtroDeTipoEducacionMod(this.value)' />
                            <label for="radioBtn_filtroActInact2" style="height: 30px;">Todos</label>
                            <input type="radio" id="radioBtn_filtroActInact2" value="2" name="radioOptionsActDesactTipoEducacion" onclick='filtroDeTipoEducacionMod(this.value)' checked="checked"/>
                            <label for="radioBtn_filtroActInact3" style="height: 30px;">Tipo De Educaci&oacute;n Inactivos</label>
                            <input type="radio" id="radioBtn_filtroActInact3" value="0" name="radioOptionsActDesactTipoEducacion" onclick='filtroDeTipoEducacionMod(this.value)' />
                        </div>
                        <br/>
                    </div>
                </div>
                <div class="listado" id="panelListadoActDesactTipoEducacion" style="height:auto;max-height:600px">
                    <ul id="listadoActDesactTipoEducacion">
                        <?php
                        foreach ($lista_tipoEducacion as $TipoEducacion) {
                         

                            $idTipoEducacion = $TipoEducacion['id'];
                            $tituloTipoEducacion = $TipoEducacion['titulo'];
                            $descripcionTipoEducacion = $TipoEducacion['descripcion'];
                            $esta_activa = $TipoEducacion['activo'];
                            


                            //$lista_de_TipoEducacion .= utf8_encode(strtolower($titulo)) . ',';

                            if ($esta_activa) {
                                echo '<li  titulo_TipoEducacion="' . utf8_encode(strtolower($tituloTipoEducacion)) . '" esta_activa="' . $esta_activa . '">
                                        <div class="descripcion">
                                            <div class="items">
                                                <span style="font-weight: bold;">' . $idTipoEducacion . '</span> - ' . htmlentities(substr($tituloTipoEducacion, 0, 64)) .'
                                            </div>
                                            <div class="items">
                                                ' . htmlentities(substr($descripcionTipoEducacion, 0, 70)) . '...
                                            </div>
                                        </div>
                                        <div class="opciones">
                                            <label class="chkDesactivar"><input name="estatusTipoEducacion" type="checkbox" value="' . $idTipoEducacion . '" onchange="uiActDesact(this)"/>Desactivar</label>
                                        </div>
                                    </li>';
                            } else {
                                echo '<li  titulo_TipoEducacion="' . utf8_encode(strtolower($tituloTipoEducacion)) . '" esta_activa="' . $esta_activa . '">
                                        <div class="descripcion">
                                            <div class="items">
                                                <span style="font-weight: bold;">' . $idTipoEducacion . '</span> - ' . htmlentities(substr($tituloTipoEducacion, 0, 64)) . '
                                            </div>
                                            <div class="items">
                                                ' . htmlentities(substr($descripcionTipoEducacion, 0, 70)) . '...
                                            </div>
                                        </div>
                                        <div class="opciones">
                                            <label class="chkActivar"><input name="estatusTipoEducacion" type="checkbox" value="' . $idTipoEducacion . '" onchange="uiActDesact(this)" />Activar</label>
                                        </div>
                                    </li>';
                            }
                        }
                        ?>                                                
                    </ul>
                </div>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarTipoEducacionActivarDesactivar()">Guardar Activaciones / Desactivaciones</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        var _data_TipoEducacion = '<?php echo $lista_de_TipoEducacion; ?>'.split(',');
        
        $('#buscadorTipoEducacion').autocomplete({
            source : _data_TipoEducacion
        });
        
        $( "#tabsTipoEducacion" ).tabs();
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
