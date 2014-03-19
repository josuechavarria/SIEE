<?php
include '../phpIncluidos/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt_listado_Glosario = $conn->query('SELECT * FROM siee_glosario ORDER BY titulo');
    $lista_Glosario = $stmt_listado_Glosario->fetchAll();
    $stmt_listado_Glosario->closeCursor();

    $stmt_listado_Glosario_act = $conn->query('SELECT * FROM siee_glosario WHERE activo = 1');
    $lista_Glosario_act = $stmt_listado_Glosario_act->fetchAll();
    $stmt_listado_Glosario_act->closeCursor();
}
?>
<div class="encabezado" id="seccionEncabezadoReporteria">
    <div class="icono">
        <img src="recursos/iconos/preparaReporteIcon_48px.png">
    </div>
    <div class="lineaVertical">&nbsp;</div>
    <div class="descripcion" id="seccionDescripcionEncabezadoReporteria">
        <div class="titulo">
            Administraci&oacute;n de Glosario
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
    <div id="tabsGlosario">
        <ul>
            <li><a href="#tabsGlosario-1" optionInd="1" >
                    <img class="tabIcons" src="recursos/iconos/plus.png" />
                    Registrar Nueva Palabra
                </a>
            </li>
            <li><a href="#tabsGlosario-2" optionInd="2">
                    <img class="tabIcons" src="recursos/iconos/pencil.png" />
                    Modificar Palabras
                </a>
            </li>
            <li><a href="#tabsGlosario-3" optionInd="3">
                    <img class="tabIcons" src="recursos/iconos/traffic-light.png" />
                    Activar / Desactivar Palabra
                </a>
            </li>
        </ul>
        <div id="tabsGlosario-1">
            <div class="formularios">
                <div id="CamposFormulario">
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_TituloGlosario">
                        </ul>
                        <label for="TituloGlosario">Titulo Palabra:</label>
                        <input id="TituloGlosario" name="TituloGlosario"  type="text" maxlength="512" />
                    </div>
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_DescripcionGlosario">
                        </ul>
                        <label for="DescripcionGlosario">Descripci&oacute;n:</label>
                        <textarea id="DescripcionGlosario" name="DescripcionGlosario" maxlength="2048" ></textarea>
                    </div>
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_Referencia">
                        </ul>
                        <!--
                                                <div id="MathmlDeFormula">
                                                    <label for="CodigoMathml" >Referencia</label>
                                               </div>-->
                    </div>
                    <div id="CampoDeReferencia" style="background-color:#fcfcfc;">
                        <div id="referencias">
                          
                        </div>
                        <div class="itemsFormularios" style="text-align:right;" id="EspacioBotonAgregarReferencia">
                            <input type ="button" class="ui-boton-guardar" onclick="AgregarReferencia()"value ="Agregar nuevo campo de referencia"/>
                        </div>
                    </div>
                    <hr/>

                </div>

                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarAdminGlosario()">Guardar Palabra</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="tabsGlosario-2">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="buscadorGlosario" style="max-width: 400px;">Escriba aqu&iacute; la palabra que desea buscar : </label>
                        <br/>
                        <input id="buscadorGlosario" type="text" onkeyup='filtroDeGlosario(this.value)' style="width:677px;"/>
                    </div>
                </div>
                <div class="listado" id="panelListadoModificarGlosario" style="height:auto;max-height:600px">
                    <ul id="listadoModificarGlosario">
                        <?php
                        $lista_de_Glosario = "";
                        foreach ($lista_Glosario_act as $Glosario) {

                            $idGlosario = $Glosario['id'];
                            $tituloGlosario = $Glosario['titulo'];
                            $descripcionGlosario = $Glosario['descripcion'];


                            $lista_de_Glosario .= utf8_encode(strtolower($tituloGlosario)) . ',';

                            echo '<li  titulo_Glosario="' . utf8_encode(strtolower($tituloGlosario)) . '">
                                    <div class="descripcion">
                                        <div class="items">
                                           <span style="font-weight: bold;">' . $idGlosario . '</span> - ' . htmlentities(substr($tituloGlosario, 0, 64)) . '
                                        </div>
                                        <div class="items">
                                            ' . htmlentities(substr($descripcionGlosario, 0, 70)) . '...
                                        </div>
                                    </div>
                                    <div class="opciones">
                                        <button id="' . $idGlosario . '" class="ui-boton-modificar" onclick="cargarPanelModificacionGlosario(this.id)">Modificar</button>
                                    </div>
                                </li>';
                        }
                        ?>                                                
                    </ul>
                </div>
            </div>            
        </div>
        <div id="tabsGlosario-3">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="radioBtn_filtroActInact" style="max-width: 400px;">Filtra las palabras que deseas ver: </label>
                        <div id="radioBtn_filtroActInact" name="radioOptions">
                            <label for="radioBtn_filtroActInact1" style="height: 30px;">Palabras Activas</label>
                            <input type="radio" id="radioBtn_filtroActInact1" value="1" name="radioOptionsActDesactGlosario" onclick='filtroDeGlosarioMod(this.value)' />
                            <label for="radioBtn_filtroActInact2" style="height: 30px;">Todos</label>
                            <input type="radio" id="radioBtn_filtroActInact2" value="2" name="radioOptionsActDesactGlosario" onclick='filtroDeGlosarioMod(this.value)' checked="checked"/>
                            <label for="radioBtn_filtroActInact3" style="height: 30px;">Palabras Inactivas</label>
                            <input type="radio" id="radioBtn_filtroActInact3" value="0" name="radioOptionsActDesactGlosario" onclick='filtroDeGlosarioMod(this.value)' />
                        </div>
                        <br/>
                    </div>
                </div>
                <div class="listado" id="panelListadoActDesactGlosario" style="height:auto;max-height:600px">
                    <ul id="listadoActDesactGlosario">
                        <?php
                        foreach ($lista_Glosario as $Glosario) {


                            $idGlosario = $Glosario['id'];
                            $tituloGlosario = $Glosario['titulo'];
                            $descripcionGlosario = $Glosario['descripcion'];
                            $esta_activa = $Glosario['activo'];



                            //$lista_de_Glosario .= utf8_encode(strtolower($titulo)) . ',';

                            if ($esta_activa) {
                                echo '<li  titulo_Glosario="' . utf8_encode(strtolower($tituloGlosario)) . '" esta_activa="' . $esta_activa . '">
                                        <div class="descripcion">
                                            <div class="items">
                                                <span style="font-weight: bold;">' . $idGlosario . '</span> - ' . htmlentities(substr($tituloGlosario, 0, 64)) . '
                                            </div>
                                            <div class="items">
                                                ' . htmlentities(substr($descripcionGlosario, 0, 70)) . '...
                                            </div>
                                        </div>
                                        <div class="opciones">
                                            <label class="chkDesactivar"><input name="estatusGlosario" type="checkbox" value="' . $idGlosario . '" onchange="uiActDesact(this)"/>Desactivar</label>
                                        </div>
                                    </li>';
                            } else {
                                echo '<li  titulo_Glosario="' . utf8_encode(strtolower($tituloGlosario)) . '" esta_activa="' . $esta_activa . '">
                                        <div class="descripcion">
                                            <div class="items">
                                                <span style="font-weight: bold;">' . $idGlosario . '</span> - ' . htmlentities(substr($tituloGlosario, 0, 64)) . '
                                            </div>
                                            <div class="items">
                                                ' . htmlentities(substr($descripcionGlosario, 0, 70)) . '...
                                            </div>
                                        </div>
                                        <div class="opciones">
                                            <label class="chkActivar"><input name="estatusGlosario" type="checkbox" value="' . $idGlosario . '" onchange="uiActDesact(this)" />Activar</label>
                                        </div>
                                    </li>';
                            }
                        }
                        ?>                                                
                    </ul>
                </div>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarGlosarioActivarDesactivar()">Guardar Activaciones / Desactivaciones</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        var _data_Glosario = '<?php echo $lista_de_Glosario; ?>'.split(',');
        
        $('#buscadorGlosario').autocomplete({
            source : _data_Glosario
        });
        
        $( "#tabsGlosario" ).tabs();
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
    function AgregarReferencia() {
        var htmlCampoGlosario = '<div class="itemsFormularios"><hr class="punteado"/>'+
            '<label>Referencia:</label>'+
            '<input type="text" name="referencia" maxlength="2048" style="width:464px"/>'+
            '<a name="QuitarFormula" onclick="eliminarEstaReferencia(this)" style="display:inline-block;left:4px;top:2px;height:20px"></a>'+
            '</div>'+
            '</div>';
        var htmlbtn = '<div class="itemsFormularios" style="text-align:right;" id="EspacioBotonAgregarReferencia">'+
            '<input type="button" class="ui-boton-guardar" onclick="AgregarReferencia()"value ="Agregar nuevo campo de referencia"/>'+
            '</div>';
        var divButton ='<div class="itemsFormularios" style="text-align:right;" id="EspacioBotonAgregarReferencia"></div>'
                    
        $('#EspacioBotonAgregarReferencia').slideUp('fast', function(){
            $(this).remove();
            
        
            $('#referencias').append(htmlCampoGlosario);
            $('#CampoDeReferencia').append(divButton);
            $('#EspacioBotonAgregarReferencia').append(htmlbtn);
            
            $( ".ui-boton-guardar" ).button({
                icons: {
                    primary: "ui-icon ui-icon-disk"
                }

            });
            $( ".ui-boton-cerrar" ).button({
                icons: {
                    primary: "ui-icon ui-icon-closethick"
                } 
            });
            $('a[name="QuitarFormula"]').button({
                icons: {
                    primary: "ui-icon ui-icon-trash"
                }
            });
        });
        
    }
    
    function eliminarEstaReferencia(elem){
        $(elem).parent().slideUp('fast', function(){
            $(this).remove();
        });
    }
    
</script>