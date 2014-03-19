<?php
include '../phpIncluidos/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt_listado_NivelEducativo = $conn->query('SELECT * FROM siee_nivel_educativo ORDER BY titulo');
    $lista_NivelEducativo = $stmt_listado_NivelEducativo->fetchAll();
    $stmt_listado_NivelEducativo->closeCursor();

    $stmt_listado_NivelEducativo_act = $conn->query('SELECT * FROM siee_nivel_educativo WHERE activo = 1');
    $lista_NivelEducativo_act = $stmt_listado_NivelEducativo_act->fetchAll();
    $stmt_listado_NivelEducativo_act->closeCursor();

}
?>
<div class="encabezado" id="seccionEncabezadoReporteria">
    <div class="icono">
        <img src="recursos/iconos/preparaReporteIcon_48px.png">
    </div>
    <div class="lineaVertical">&nbsp;</div>
    <div class="descripcion" id="seccionDescripcionEncabezadoReporteria">
        <div class="titulo">
            Administraci&oacute;n de Nivel Educativo
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
    <div id="tabsNivelEducativo">
        <ul>
            <li><a href="#tabsNivelEducativo-1" optionInd="1" >
                    <img class="tabIcons" src="recursos/iconos/plus.png" />
                    Registrar Nuevo Nivel Educativo
                </a>
            </li>
            <li><a href="#tabsNivelEducativo-2" optionInd="2">
                    <img class="tabIcons" src="recursos/iconos/pencil.png" />
                    Modificar Nivel Educativo
                </a>
            </li>
            <li><a href="#tabsNivelEducativo-3" optionInd="3">
                    <img class="tabIcons" src="recursos/iconos/traffic-light.png" />
                    Activar / Desactivar Nivel Educativo
                </a>
            </li>
        </ul>
        <div id="tabsNivelEducativo-1">
            <div class="formularios">
                <div id="CamposFormulario">
                    
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_TituloNivelEducativo">
                        </ul>
                        <label for="TituloNivelEducativo">Escriba el titulo nivel educativo:</label>
                        <input id="TituloNivelEducativo" name="TituloNivelEducativo"  type="text" maxlength="200" />
                    </div>
                    
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_DescripcionNivelEducativo">
                        </ul>
                        <label for="DescripcionNivelEducativo">Descripci&oacute;n:</label>
                        <textarea id="DescripcionNivelEducativo" name="DescripcionNivelEducativo" maxlength="1024" ></textarea>
                    </div>

                    

               </div>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarAdminNivelEducativo()">Guardar Nivel Educativo</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="tabsNivelEducativo-2">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="buscadorNivelEducativo" style="max-width: 400px;">Escribe aqu&iacute; el Nivel Educativo que quieres encontrar:</label>
                        <br/>
                        <br/>
                        <input id="buscadorNivelEducativo" type="text" onkeyup='filtroDeNivelEducativo(this.value)' />
                    </div>
                </div>
                <div class="listado" id="panelListadoModificarNivelEducativo" style="height:auto;max-height:600px">
                    <ul id="listadoModificarNivelEducativo">
                        <?php
                        $lista_de_NivelEducativo = "";
                        foreach ($lista_NivelEducativo_act as $NivelEducativo) {
                            
                            $idNivelEducativo = $NivelEducativo['id'];
                            $tituloNivelEducativo = $NivelEducativo['titulo'];
                            $descripcionNivelEducativo = $NivelEducativo['descripcion'];
                            

                            $lista_de_NivelEducativo .= utf8_encode(strtolower($tituloNivelEducativo)) . ',';

                            echo '<li  titulo_NivelEducativo="' . utf8_encode(strtolower($tituloNivelEducativo)) . '">
                                    <div class="descripcion">
                                        <div class="items">
                                           <span style="font-weight: bold;">' . $idNivelEducativo . '</span> - ' . htmlentities(substr($tituloNivelEducativo, 0, 64)) .'
                                        </div>
                                        <div class="items">
                                            ' . htmlentities(substr($descripcionNivelEducativo, 0, 70)) . '...
                                        </div>
                                    </div>
                                    <div class="opciones">
                                        <button id="' . $idNivelEducativo . '" class="ui-boton-modificar" onclick="cargarPanelModificacionNivelEducativo(this.id)">Modificar</button>
                                    </div>
                                </li>';
                        }
                        ?>                                                
                    </ul>
                </div>
            </div>            
        </div>
        <div id="tabsNivelEducativo-3">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="radioBtn_filtroActInact" style="max-width: 400px;">Filtra los niveles educativos que deseas ver:</label>
                        <div id="radioBtn_filtroActInact" name="radioOptions">
                            <label for="radioBtn_filtroActInact1" style="height: 30px;">Nivel Educativo Activos</label>
                            <input type="radio" id="radioBtn_filtroActInact1" value="1" name="radioOptionsActDesactNivelEducativo" onclick='filtroDeNivelEducativoMod(this.value)' />
                            <label for="radioBtn_filtroActInact2" style="height: 30px;">Todos</label>
                            <input type="radio" id="radioBtn_filtroActInact2" value="2" name="radioOptionsActDesactNivelEducativo" onclick='filtroDeNivelEducativoMod(this.value)' checked="checked"/>
                            <label for="radioBtn_filtroActInact3" style="height: 30px;">Nivel Educativo Inactivos</label>
                            <input type="radio" id="radioBtn_filtroActInact3" value="0" name="radioOptionsActDesactNivelEducativo" onclick='filtroDeNivelEducativoMod(this.value)' />
                        </div>
                        <br/>
                    </div>
                </div>
                <div class="listado" id="panelListadoActDesactNivelEducativo" style="height:auto;max-height:600px">
                    <ul id="listadoActDesactNivelEducativo">
                        <?php
                        foreach ($lista_NivelEducativo as $NivelEducativo) {
                         

                            $idNivelEducativo = $NivelEducativo['id'];
                            $tituloNivelEducativo = $NivelEducativo['titulo'];
                            $descripcionNivelEducativo = $NivelEducativo['descripcion'];
                            $esta_activa = $NivelEducativo['activo'];
                            


                            //$lista_de_NivelEducativo .= utf8_encode(strtolower($titulo)) . ',';

                            if ($esta_activa) {
                                echo '<li  titulo_NivelEducativo="' . utf8_encode(strtolower($tituloNivelEducativo)) . '" esta_activa="' . $esta_activa . '">
                                        <div class="descripcion">
                                            <div class="items">
                                                <span style="font-weight: bold;">' . $idNivelEducativo . '</span> - ' . htmlentities(substr($tituloNivelEducativo, 0, 64)) .'
                                            </div>
                                            <div class="items">
                                                ' . htmlentities(substr($descripcionNivelEducativo, 0, 70)) . '...
                                            </div>
                                        </div>
                                        <div class="opciones">
                                            <label class="chkDesactivar"><input name="estatusNivelEducativo" type="checkbox" value="' . $idNivelEducativo . '" onchange="uiActDesact(this)"/>Desactivar</label>
                                        </div>
                                    </li>';
                            } else {
                                echo '<li  titulo_NivelEducativo="' . utf8_encode(strtolower($tituloNivelEducativo)) . '" esta_activa="' . $esta_activa . '">
                                        <div class="descripcion">
                                            <div class="items">
                                                <span style="font-weight: bold;">' . $idNivelEducativo . '</span> - ' . htmlentities(substr($tituloNivelEducativo, 0, 64)) . '
                                            </div>
                                            <div class="items">
                                                ' . htmlentities(substr($descripcionNivelEducativo, 0, 70)) . '...
                                            </div>
                                        </div>
                                        <div class="opciones">
                                            <label class="chkActivar"><input name="estatusNivelEducativo" type="checkbox" value="' . $idNivelEducativo . '" onchange="uiActDesact(this)" />Activar</label>
                                        </div>
                                    </li>';
                            }
                        }
                        ?>                                                
                    </ul>
                </div>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarNivelEducativoActivarDesactivar()">Guardar Activaciones / Desactivaciones</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        var _data_NivelEducativo = '<?php echo $lista_de_NivelEducativo; ?>'.split(',');
        
        $('#buscadorNivelEducativo').autocomplete({
            source : _data_NivelEducativo
        });
        
        $( "#tabsNivelEducativo" ).tabs();
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
