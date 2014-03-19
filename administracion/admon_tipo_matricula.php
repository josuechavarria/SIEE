<?php
include '../phpIncluidos/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    $stmt_listado_TipoMatricula = $conn->query('SELECT * FROM siee_tipo_matricula ORDER BY titulo');
    $lista_TipoMatricula = $stmt_listado_TipoMatricula->fetchAll();
    $stmt_listado_TipoMatricula->closeCursor();

    $stmt_listado_TipoMatricula_act = $conn->query('SELECT * FROM siee_tipo_matricula WHERE activo = 1');
    $lista_TipoMatricula_act = $stmt_listado_TipoMatricula_act->fetchAll();
    $stmt_listado_TipoMatricula_act->closeCursor();

}
?>
<div class="encabezado" id="seccionEncabezadoReporteria">
    <div class="icono">
        <img src="recursos/iconos/preparaReporteIcon_48px.png">
    </div>
    <div class="lineaVertical">&nbsp;</div>
    <div class="descripcion" id="seccionDescripcionEncabezadoReporteria">
        <div class="titulo">
            Administraci&oacute;n de tipo de matricula
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
    <div id="tabsTipoMatricula">
        <ul>
            <li><a href="#tabsTipoMatricula-1" optionInd="1" >
                    <img class="tabIcons" src="recursos/iconos/plus.png" />
                    Nuevo Tipo De Matr&iacute;cula
                </a>
            </li>
            <li><a href="#tabsTipoMatricula-2" optionInd="2">
                    <img class="tabIcons" src="recursos/iconos/pencil.png" />
                    Modificar Tipo De Matr&iacute;cula
                </a>
            </li>
            <li><a href="#tabsTipoMatricula-3" optionInd="3">
                    <img class="tabIcons" src="recursos/iconos/traffic-light.png" />
                    Activar / Desactivar Tipo De Matr&iacute;cula
                </a>
            </li>
        </ul>
        <div id="tabsTipoMatricula-1">
            <div class="formularios">
                <div id="CamposFormulario">
                    
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_TituloTipoMatricula">
                        </ul>
                        <label for="TituloTipoMatricula">Titulo :</label>
                        <input id="TituloTipoMatricula" name="TituloTipoMatricula"  type="text" maxlength="100" style="width:500px;"/>
                    </div>
                    
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_DescripcionTipoMatricula">
                        </ul>
                        <label for="DescripcionTipoMatricula">Descripci&oacute;n:</label>
                        <textarea id="DescripcionTipoMatricula" name="DescripcionTipoMatricula" maxlength="1024" ></textarea>
                    </div>

                    

               </div>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarAdminTipoMatricula()">Guardar Tipo De Matr&iacute;cula</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="tabsTipoMatricula-2">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="buscadorTipoMatricula" style="max-width: 400px;">Escribe aqui el Tipo De Matricula que quieres encontrar:</label>
                        <br/>
                        <br/>
                        <input id="buscadorTipoMatricula" type="text" onkeyup='filtroDeTipoMatricula(this.value)' style="width:678px;" />
                    </div>
                </div>
                <div class="listado" id="panelListadoModificarTipoMatricula" style="height:auto;max-height:600px">
                    <ul id="listadoModificarTipoMatricula">
                        <?php
                        $lista_de_TipoMatricula = "";
                        foreach ($lista_TipoMatricula_act as $TipoMatricula) {
                            
                            $idTipoMatricula = $TipoMatricula['id'];
                            $tituloTipoMatricula = $TipoMatricula['titulo'];
                            $descripcionTipoMatricula = $TipoMatricula['descripcion'];
                            

                            $lista_de_TipoMatricula .= utf8_encode(strtolower($tituloTipoMatricula)) . ',';

                            echo '<li  titulo_TipoMatricula="' . utf8_encode(strtolower($tituloTipoMatricula)) . '">
                                    <div class="descripcion">
                                        <div class="items">
                                           <span style="font-weight: bold;">' . $idTipoMatricula . '</span> - ' . htmlentities(substr($tituloTipoMatricula, 0, 64)) .'
                                        </div>
                                        <div class="items">
                                            ' . htmlentities(substr($descripcionTipoMatricula, 0, 70)) . '...
                                        </div>
                                    </div>
                                    <div class="opciones">
                                        <button id="' . $idTipoMatricula . '" class="ui-boton-modificar" onclick="cargarPanelModificacionTipoMatricula(this.id)">Modificar</button>
                                    </div>
                                </li>';
                        }
                        ?>                                                
                    </ul>
                </div>
            </div>            
        </div>
        <div id="tabsTipoMatricula-3">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="radioBtn_filtroActInact" style="max-width: 400px;">Filtra los tipo de matricula que deseas ver:</label>
                        <div id="radioBtn_filtroActInact" name="radioOptions">
                            <label for="radioBtn_filtroActInact1" style="height: 30px;">Tipo De Matriucla Activas</label>
                            <input type="radio" id="radioBtn_filtroActInact1" value="1" name="radioOptionsActDesactTipoMatricula" onclick='filtroDeTipoMatriculaMod(this.value)' />
                            <label for="radioBtn_filtroActInact2" style="height: 30px;">Todos</label>
                            <input type="radio" id="radioBtn_filtroActInact2" value="2" name="radioOptionsActDesactTipoMatricula" onclick='filtroDeTipoMatriculaMod(this.value)' checked="checked"/>
                            <label for="radioBtn_filtroActInact3" style="height: 30px;">Tipo De Matricula Inactivas</label>
                            <input type="radio" id="radioBtn_filtroActInact3" value="0" name="radioOptionsActDesactTipoMatricula" onclick='filtroDeTipoMatriculaMod(this.value)' />
                        </div>
                        <br/>
                    </div>
                </div>
                <div class="listado" id="panelListadoActDesactTipoMatricula" style="height:auto;max-height:600px">
                    <ul id="listadoActDesactTipoMatricula">
                        <?php
                        foreach ($lista_TipoMatricula as $TipoMatricula) {
                         

                            $idTipoMatricula = $TipoMatricula['id'];
                            $tituloTipoMatricula = $TipoMatricula['titulo'];
                            $descripcionTipoMatricula = $TipoMatricula['descripcion'];
                            $esta_activa = $TipoMatricula['activo'];
                            


                            //$lista_de_TipoMatricula .= utf8_encode(strtolower($titulo)) . ',';

                            if ($esta_activa) {
                                echo '<li  titulo_TipoMatricula="' . utf8_encode(strtolower($tituloTipoMatricula)) . '" esta_activa="' . $esta_activa . '">
                                        <div class="descripcion">
                                            <div class="items">
                                                <span style="font-weight: bold;">' . $idTipoMatricula . '</span> - ' . htmlentities(substr($tituloTipoMatricula, 0, 64)) .'
                                            </div>
                                            <div class="items">
                                                ' . htmlentities(substr($descripcionTipoMatricula, 0, 70)) . '...
                                            </div>
                                        </div>
                                        <div class="opciones">
                                            <label class="chkDesactivar"><input name="estatusTipoMatricula" type="checkbox" value="' . $idTipoMatricula . '" onchange="uiActDesact(this)"/>Desactivar</label>
                                        </div>
                                    </li>';
                            } else {
                                echo '<li  titulo_TipoMatricula="' . utf8_encode(strtolower($tituloTipoMatricula)) . '" esta_activa="' . $esta_activa . '">
                                        <div class="descripcion">
                                            <div class="items">
                                                <span style="font-weight: bold;">' . $idTipoMatricula . '</span> - ' . htmlentities(substr($tituloTipoMatricula, 0, 64)) . '
                                            </div>
                                            <div class="items">
                                                ' . htmlentities(substr($descripcionTipoMatricula, 0, 70)) . '...
                                            </div>
                                        </div>
                                        <div class="opciones">
                                            <label class="chkActivar"><input name="estatusTipoMatricula" type="checkbox" value="' . $idTipoMatricula . '" onchange="uiActDesact(this)" />Activar</label>
                                        </div>
                                    </li>';
                            }
                        }
                        ?>                                                
                    </ul>
                </div>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarTipoMatriculaActivarDesactivar()">Guardar Activaciones / Desactivaciones</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        var _data_TipoMatricula = '<?php echo $lista_de_TipoMatricula; ?>'.split(',');
        
        $('#buscadorTipoMatricula').autocomplete({
            source : _data_TipoMatricula
        });
        
        $( "#tabsTipoMatricula" ).tabs();
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
