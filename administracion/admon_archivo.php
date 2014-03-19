<?php
include '../phpIncluidos/conexion.php';
?>
<div class="encabezado" id="seccionEncabezadoReporteria">
    <div class="icono">
        <img src="recursos/iconos/preparaReporteIcon_48px.png">
    </div>
    <div class="lineaVertical">&nbsp;</div>
    <div class="descripcion" id="seccionDescripcionEncabezadoReporteria">
        <div class="titulo">
            Administraci&oacute;n De Archivos
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
    <div id="tabsArchivo">
        <ul>
            <li><a href="#tabsArchivo-1" optionInd="1" >
                    <img class="tabIcons" src="recursos/iconos/plus.png" />
                    Carga De Archivo
                </a>
            </li>
            <li><a href="#tabsArchivo-2" optionInd="2">
                    <img class="tabIcons" src="recursos/iconos/pencil.png" />
                    Modificar Archivo
                </a>
            </li>
            <li><a href="#tabsArchivo-3" optionInd="3">
                    <img class="tabIcons" src="recursos/iconos/traffic-light.png" />
                    Activar / Desactivar Archivo
                </a>
            </li>
        </ul>

        <div id="tabsArchivo-1">
            <iframe src="administracion/carga_de_archivo.php" width="100%" height="600px">
            Su navegador no soporta iframes.
            </iframe>
        </div>

        <div id="tabsArchivo-2">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="buscadorArchivo" style="max-width: 400px;">Escribe aqu&iacute; el titulo del Archivo:</label>
                        <br/>
                        <br/>
                        <input id="buscadorArchivo" type="text" onkeyup='filtroDeArchivoMod(this.value)' />
                    </div>
                </div>

                <div class="listado" id="panelListadoModificarArchivo" style="height:auto;max-height:600px">
                    <ul id="listadoModificarArchivo">
                        <?php
                        $stmt_archivos = $conn->query('SELECT * FROM siee_archivo ORDER BY titulo;');
                        $archivos = $stmt_archivos->fetchAll();
                        $stmt_archivos->closeCursor();

                        foreach ($archivos as $archivo) {
                            if ($archivo['activo']) {
                                echo '<li titulo_archivo="' . utf8_encode(strtolower($archivo['titulo'] . '(' . $archivo['extension'] . ')')) . '">
                                        <div class="descripcion">
                                                <div class="items">
                                                <span style="font-weight: bold;">' . htmlentities($archivo['titulo']) . '</span>(' . htmlentities($archivo['extension']) . ')
                                                </div>
                                                <div class="items">
                                                        ' . htmlentities(substr($archivo['descripcion'], 0, 70)) . '...
                                                </div>
                                        </div>
                                        <div class="opciones">
                                                <button id="' . $archivo['id'] . '" class="ui-boton-modificar" onclick="cargarPanelModificacionArchivo(this.id)">Modificar</button>
                                        </div>
                                </li>';
                            }
                        }
                        ?>                                                
                    </ul>
                </div>
            </div>

            <iframe id="PanelModificacionDeArchivo" width="100%" height="0" src="" style="box-shadow: 0px 0px 10px #999; margin-top: 20px;">
            Su navegador no soporta iframes.
            </iframe>
        </div>

        <div id="tabsArchivo-3">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="radioBtn_filtroActInact" style="max-width: 400px;">Filtra los Archivos que deseas ver:</label>
                        <div id="radioBtn_filtroActInact" name="radioOptions">
                            <label for="radioBtn_filtroActInact1" style="height: 30px;">Archivos Activos</label>
                            <input type="radio" id="radioBtn_filtroActInact1" value="1" name="radioOptionsActDesactArchivo" onclick='filtroDeArchivoActivarDesactivar(this.value)' />
                            <label for="radioBtn_filtroActInact2" style="height: 30px;">Todos</label>
                            <input type="radio" id="radioBtn_filtroActInact2" value="2" name="radioOptionsActDesactArchivo" onclick='filtroDeArchivoActivarDesactivar(this.value)' checked="checked"/>
                            <label for="radioBtn_filtroActInact3" style="height: 30px;">Archivos Inactivos</label>
                            <input type="radio" id="radioBtn_filtroActInact3" value="0" name="radioOptionsActDesactArchivo" onclick='filtroDeArchivoActivarDesactivar(this.value)' />
                        </div>
                        <br/>
                    </div>
                </div>
                <div class="listado" id="panelListadoActDesactArchivo" style="height:auto;max-height:600px">
                    <ul id="listadoActDesactArchivo">
                        <?php
                        foreach ($archivos as $archivo) {
                            if ($archivo['activo'] == 1) {
                                echo '<li  titulo_archivo="' . utf8_encode(strtolower($archivo['titulo'])) . '" esta_activa="' . $archivo['activo'] . '">
                                        <div class="descripcion">
                                            <div class="items">
                                               <span style="font-weight: bold;">' . htmlentities($archivo['titulo']) . '</span>(' . htmlentities($archivo['extension']) . ')
                                            </div>
                                            <div class="items">
                                                ' . htmlentities(substr($archivo['descripcion'], 0, 70)) . '...
                                            </div>
                                        </div>
                                        <div class="opciones">
                                            <label class="chkDesactivar"><input name="estatusArchivo" type="checkbox" value="' . $archivo['id'] . '" onchange="uiActDesact(this)"/>Desactivar</label>
                                        </div>
                                    </li>';
                            } else {
                                echo '<li  titulo_archivo="' . utf8_encode(strtolower($archivo['titulo'])) . '" esta_activa="' . $archivo['activo'] . '">
                                        <div class="descripcion">
                                            <div class="items">
                                               <span style="font-weight: bold;">' . htmlentities($archivo['titulo']) . '</span>(' . htmlentities($archivo['extension']) . ')
                                            </div>
                                            <div class="items">
                                                ' . htmlentities(substr($archivo['descripcion'], 0, 70)) . '...
                                            </div>
                                        </div>
                                        <div class="opciones">
                                            <label class="chkActivar"><input name="estatusArchivo" type="checkbox" value="' . $archivo['id'] . '" onchange="uiActDesact(this)" />Activar</label>
                                        </div>
                                    </li>';
                            }
                        }
                        ?>                                                
                    </ul>
                </div>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarArchivoActivarDesactivar()">Guardar Activaciones / Desactivaciones</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {        
        $( "#tabsArchivo" ).tabs();
        $('[name="radioOptions"]').buttonset();
        $('.ui-boton-modificar').button({
            icons:{
                primary : 'ui-icon ui-icon-pencil'
            }
        });
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
