<?php
include '../phpIncluidos/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt_listado_series_indicadores= $conn->query('SELECT * FROM siee_serie_indicadores ORDER BY titulo');
    $lista_series_indicadores = $stmt_listado_series_indicadores->fetchAll();
    $stmt_listado_series_indicadores->closeCursor();
    
    $stmt_listado_series_indicadores_act= $conn->query('SELECT * FROM siee_serie_indicadores WHERE activo = 1 ORDER BY titulo');
    $lista_series_indicadores_act = $stmt_listado_series_indicadores_act->fetchAll();  
    $stmt_listado_series_indicadores_act->closeCursor(); 
}
?>
<div class="encabezado" id="seccionEncabezadoReporteria">
    <div class="icono">
        <img src="recursos/iconos/preparaReporteIcon_48px.png">
    </div>
    <div class="lineaVertical">&nbsp;</div>
    <div class="descripcion" id="seccionDescripcionEncabezadoReporteria">
        <div class="titulo">
            Administraci&oacute;n de Series de Indicadores
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
    <div id="tabsSerieIndicadores">
        <ul>
            <li><a href="#tabsSerieIndicadores-1" optionInd="1" >
                    <img class="tabIcons" src="recursos/iconos/plus.png" />
                    Registrar Nueva Serie
                </a>
            </li>
            <li><a href="#tabsSerieIndicadores-2" optionInd="2">
                    <img class="tabIcons" src="recursos/iconos/pencil.png" />
                    Modificar Serie
                </a>
            </li>
            <li><a href="#tabsSerieIndicadores-3" optionInd="3">
                    <img class="tabIcons" src="recursos/iconos/traffic-light.png" />
                    Activar / Desactivar Series
                </a>
            </li>
        </ul>
        <div id="tabsSerieIndicadores-1">
            <div class="formularios">
                <div id="CamposFormulario">
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_TituloSerie">
                        </ul>
                        
                        <label for="TituloSerie">Escriba el titulo de la Serie:</label>
                        <input id="TituloSerie" name="tituloSerie"  type="text" maxlength="128" />
                    </div>
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_CantidadDeIndicadores">
                        </ul>
                        <label for="CantidadDeIndicadores">Cantidad de Indicadores:</label>
                        <input id="CantidadDeIndicadores" name="cantidadDeIndicadores" maxlength="4" placeholder="0"  type="text" onkeyup='$(this).val($(this).val().replace(/[^0-9]/g, ""))' onblur='$(this).val($(this).val().replace(/[^0-9]/g, ""))' style="text-align: center; width: 40px;"/>
                    </div>
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_DescripcionSerie">
                        </ul>
                        <label for="DescripcionSerie">Descripci&oacute;n:</label>
                        <textarea id="DescripcionSerie" name="descripcionSerie" maxlength="1024" ></textarea>
                    </div>
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_ObservacionSerie">
                        </ul>
                        <label for="ObservacionSerie" >Observaciones:</label>
                        <textarea id="ObservacionSerie" placeholder="Ninguna" name="observacionSerie" maxlength="512" ></textarea>
                    </div>
                </div>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarSerieIndicadores()">Guardar Serie</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="tabsSerieIndicadores-2">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="buscadorSeriesIndicadores" style="max-width: 400px;">Escribe aqu&iacute; el titulo de la serie que quieres encontrar:</label>
                        <br/>
                        <br/>
                        <input id="buscadorSeriesIndicadores" type="text" onkeyup='filtroDeSeriesIndicadores(this.value)' />
                    </div>
                </div>
                <div class="listado" id="panelListadoModificarIndicadores" style="height:auto;max-height:600px">
                    <ul id="listadoModificarIndicadores">
                        <?php
                        $lista_titulos_series = "";
                        foreach ($lista_series_indicadores_act as $serie_ind)
                        {
                            $id_serie = $serie_ind['id'];
                            $codigo = $serie_ind['codigo_serie_indicadores'];
                            $titulo = $serie_ind['titulo'];
                            $descripcion = $serie_ind['descripcion'];                           
                            
                            $lista_titulos_series .= utf8_encode(strtolower($titulo)) . ',';
                            
                            echo '<li  titulo_serie="'. utf8_encode(strtolower($titulo)) .'">
                                    <div class="descripcion">
                                        <div class="items">
                                           <span style="font-weight: bold;">'. $codigo .'</span> - '. htmlentities(substr($titulo, 0, 64)) .'...
                                        </div>
                                        <div class="items">
                                            '. htmlentities(substr($descripcion, 0, 70)) .'...
                                        </div>
                                    </div>
                                    <div class="opciones">
                                        <button id="'. $id_serie .'" class="ui-boton-modificar" onclick="cargarPanelModificacionSeries(this.id)">Modificar</button>
                                    </div>
                                </li>';
                        }
                        ?>                                                
                    </ul>
                </div>
            </div>            
        </div>
        <div id="tabsSerieIndicadores-3">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="radioBtn_filtroActInact" style="max-width: 400px;">Filtra las Series que deseas ver:</label>
                        <div id="radioBtn_filtroActInact" name="radioOptions">
                            <label for="radioBtn_filtroActInact1" style="height: 30px;">Series Activas</label>
                            <input type="radio" id="radioBtn_filtroActInact1" value="1" name="radioOptionsActDesactSeries" onclick='filtroDeSeriesIndicadoresMod(this.value)' />
                            <label for="radioBtn_filtroActInact2" style="height: 30px;">Todas</label>
                            <input type="radio" id="radioBtn_filtroActInact2" value="2" name="radioOptionsActDesactSeries" onclick='filtroDeSeriesIndicadoresMod(this.value)' checked="checked"/>
                            <label for="radioBtn_filtroActInact3" style="height: 30px;">Series Inactivas</label>
                            <input type="radio" id="radioBtn_filtroActInact3" value="0" name="radioOptionsActDesactSeries" onclick='filtroDeSeriesIndicadoresMod(this.value)' />
                        </div>
                        <br/>
                    </div>
                </div>
                <div class="listado" id="panelListadoActDesactIndicadores" style="height:auto;max-height:600px">
                    <ul id="listadoActDesactIndicadores">
                        <?php
                        foreach ($lista_series_indicadores as $serie_ind)
                        {
                            $id_serie = $serie_ind['id'];
                            $codigo = $serie_ind['codigo_serie_indicadores'];
                            $titulo = $serie_ind['titulo'];
                            $descripcion = $serie_ind['descripcion'];
                            $esta_activa = $serie_ind['activo'];
                            
                            //$lista_titulos_series .= utf8_encode(strtolower($titulo)) . ',';
                            
                            if($esta_activa)
                            {
                                echo '<li  titulo_serie="'. utf8_encode(strtolower($titulo)) .'" esta_activa="' . $esta_activa . '">
                                        <div class="descripcion">
                                            <div class="items">
                                               <span style="font-weight: bold;">'. $codigo .'</span> - '. htmlentities(substr($titulo, 0, 64)) .'...
                                            </div>
                                            <div class="items">
                                                '. htmlentities(substr($descripcion, 0, 70)) .'...
                                            </div>
                                        </div>
                                        <div class="opciones">
                                            <label class="chkDesactivar"><input name="estatusSerieIndicadores" type="checkbox" value="'. $id_serie .'" onchange="uiActDesact(this)"/>Desactivar</label>
                                        </div>
                                    </li>';
                                
                            }else
                            {
                                echo '<li  titulo_serie="'. utf8_encode(strtolower($titulo)) .'" esta_activa="' . $esta_activa . '">
                                        <div class="descripcion">
                                            <div class="items">
                                               <span style="font-weight: bold;">'. $codigo .'</span> - '. htmlentities(substr($titulo, 0, 64)) .'...
                                            </div>
                                            <div class="items">
                                                '. htmlentities(substr($descripcion, 0, 70)) .'...
                                            </div>
                                        </div>
                                        <div class="opciones">
                                            <label class="chkActivar"><input name="estatusSerieIndicadores" type="checkbox" value="'. $id_serie .'" onchange="uiActDesact(this)" />Activar</label>
                                        </div>
                                    </li>';
                            } 
                        }
                        ?>                                                
                    </ul>
                </div>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarSerieIndicadoresActivarDesactivar()">Guardar Activaciones / Desactivaciones</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        var _data_series = '<?php echo $lista_titulos_series; ?>'.split(',');
        
        $('#buscadorSeriesIndicadores').autocomplete({
            source : _data_series
        });
        
        $( "#tabsSerieIndicadores" ).tabs();
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
