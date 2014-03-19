<?php
include '../phpIncluidos/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt_listado_GrupoIndicadores = $conn->query('SELECT * FROM siee_grupo_indicadores ORDER BY etiqueta_titulo');
    $lista_GrupoIndicadores = $stmt_listado_GrupoIndicadores->fetchAll();
    $stmt_listado_GrupoIndicadores->closeCursor();

    $stmt_listado_subsitio = $conn->query('SELECT * FROM siee_subsitio Where activo = 1');
    $lista_subsitios = $stmt_listado_subsitio->fetchAll();
    $stmt_listado_subsitio->closeCursor();

    $stmt_listado_indicadores = $conn->query('SELECT id,titulo FROM siee_indicador Where activo = 1');
    $lista_indicadores = $stmt_listado_indicadores->fetchAll();
    $stmt_listado_indicadores->closeCursor();
}
?>
<div class="encabezado" id="seccionEncabezadoReporteria">
    <div class="icono">
        <img src="recursos/iconos/preparaReporteIcon_48px.png">
    </div>
    <div class="lineaVertical">&nbsp;</div>
    <div class="descripcion" id="seccionDescripcionEncabezadoReporteria">
        <div class="titulo">
            Administraci&oacute;n de Grupo De Indicadores
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
    <div id="tabsGrupoIndicadores">
        <ul>
            <li><a href="#tabsGrupoIndicadores-1" optionInd="1" >
                    <img class="tabIcons" src="recursos/iconos/plus.png" />
                    Registrar Nue. Grup De Indicadores
                </a>
            </li>
            <li><a href="#tabsGrupoIndicadores-2" optionInd="2">
                    <img class="tabIcons" src="recursos/iconos/pencil.png" />
                    Mod. Grup De Indicadores
                </a>
            </li>
            <li><a href="#tabsGrupoIndicadores-3" optionInd="3">
                    <img class="tabIcons" src="recursos/iconos/traffic-light.png" />
                    Act / Desac Grup De Indicadores
                </a>
            </li>
        </ul>
        <div id="tabsGrupoIndicadores-1">
            <div class="formularios">
                <div id="CamposFormulario">



                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_EtiquetaTituloGrupoIndicadores">
                        </ul>
                        <label for="EtiquetaTituloGrupoIndicadores">Etiq De Grup De Indicadores:</label>
                        <input id="EtiquetaTituloGrupoIndicadores" name="EtiquetaTituloGrupoIndicadores"  type="text" maxlength="30" />
                    </div>

                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_TituloCompletoGrupoIndicadores">
                        </ul>
                        <label for="TituloGrupoIndicadores">Titulo Grup De Indicadores:</label>
                        <input id="TituloGrupoIndicadores" name="TituloGrupoIndicadores"  type="text" maxlength="128" />
                    </div>

                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_DescripcionGrupoIndicadores">
                        </ul>
                        <label for="DescripcionGrupoIndicadores">Descripci&oacute;n:</label>
                        <textarea id="DescripcionGrupoIndicadores" name="DescripcionGrupoIndicadores" maxlength="512" ></textarea>
                    </div>                   
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_IndicadorGrupoIndicador">
                        </ul>
                        <label style="max-width:none;" for="IndicadorGrupoIndicador">Seleccione los indicadores que en este grupo:</label>
                    </div>
                    <select id="IndicadorGrupoIndicador" class="multiselect" multiple="multiple" name="Indicadores[]" style="width:706px;height:300px;">
                        <?php
                        foreach ($lista_indicadores as $indicador) {
                            $id_indicador = $indicador['id'];
                            $titulo_indicador = $indicador['titulo'];
                            echo '<option value="' . $id_indicador . '">' . htmlentities($titulo_indicador) . '</option>';
                        }
                        ?>
                    </select> 
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_SubsitioGrupoIndicadores">
                        </ul>
                        <label for="" >Seleccione el subsitio:</label>
                        <select id="SubsitioGrupoIndicadores">
                            <option value="0">- - -</option>
                            <?php
                            foreach ($lista_subsitios as $subsitio) {
                                echo '<option value="' . $subsitio['id'] . '">' . htmlentities($subsitio['titulo'] ) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_ListaSubsitiosGrupoIndicador">
                        </ul>
                        <label style="max-width:none;" for="ListaSubsitiosGrupoIndicador">Ordene los Grupos a Conveniencia:</label>
                    </div>
					<div style="padding:10px; border:1px solid #ccc; background-color: #fff;">
						<ul id="ListaDeGrupoSortable"></ul>
					</div>
                </div>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarAdminGrupoIndicadores()">Guardar Grupo De Indicadores</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="tabsGrupoIndicadores-2">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="buscadorGrupoIndicadores" style="max-width: 400px;">Escribe aqu&iacute; el Grupo De Indicadores que quieres encontrar:</label>
                        <br/>
                        <br/>
                        <input id="buscadorGrupoIndicadores" type="text" onkeyup='filtroDeGrupoIndicadores(this.value)' />
                    </div>
                </div>
                <div class="listado" id="panelListadoModificarGrupoIndicadores" style="height:auto;max-height:600px">
                    <ul id="listadoModificarGrupoIndicadores">
                        <?php
                        $lista_de_GrupoIndicadores = "";
                        foreach ($lista_GrupoIndicadores as $GrupoIndicadores) {

                            $idGrupoIndicadores = $GrupoIndicadores['id'];
                            $tituloGrupoIndicadores = $GrupoIndicadores['titulo_completo'];
                            $descripcionGrupoIndicadores = $GrupoIndicadores['descripcion'];
                            $activo = $GrupoIndicadores ['activo'];

                            if ($activo) {


                                $lista_de_GrupoIndicadores .= utf8_encode(strtolower($tituloGrupoIndicadores)) . ',';

                                echo '<li  titulo_GrupoIndicadores="' . utf8_encode(strtolower($tituloGrupoIndicadores)) . '">
                                    <div class="descripcion">
                                        <div class="items">
                                           <span style="font-weight: bold;">' . $idGrupoIndicadores . '</span> - ' . htmlentities(substr($tituloGrupoIndicadores, 0, 64)) . '
                                        </div>
                                        <div class="items">
                                            ' . htmlentities(substr($descripcionGrupoIndicadores, 0, 70)) . '...
                                        </div>
                                    </div>
                                    <div class="opciones">
                                        <button id="' . $idGrupoIndicadores . '" class="ui-boton-modificar" onclick="cargarPanelModificacionGrupoIndicadores(this.id)">Modificar</button>
                                    </div>
                                </li>';
                            }
                        }
                        ?>                                                
                    </ul>
                </div>
            </div>            
        </div>
        <div id="tabsGrupoIndicadores-3">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="radioBtn_filtroActInact" style="max-width: 400px;">Filtra los grupo de indicadores que deseas ver:</label>
                        <div id="radioBtn_filtroActInact" name="radioOptions">
                            <label for="radioBtn_filtroActInact1" style="height: 30px;">Grupo De Indicadores Activos</label>
                            <input type="radio" id="radioBtn_filtroActInact1" value="1" name="radioOptionsActDesactGrupoIndicadores" onclick='filtroDeGrupoIndicadoresMod(this.value)' />
                            <label for="radioBtn_filtroActInact2" style="height: 30px;">Todos</label>
                            <input type="radio" id="radioBtn_filtroActInact2" value="2" name="radioOptionsActDesactGrupoIndicadores" onclick='filtroDeGrupoIndicadoresMod(this.value)' checked="checked"/>
                            <label for="radioBtn_filtroActInact3" style="height: 30px;">Grupo De Indicadores Inactivos</label>
                            <input type="radio" id="radioBtn_filtroActInact3" value="0" name="radioOptionsActDesactGrupoIndicadores" onclick='filtroDeGrupoIndicadoresMod(this.value)' />
                        </div>
                        <br/>
                    </div>
                </div>
                <div class="listado" id="panelListadoActDesactGrupoIndicadores" style="height:auto;max-height:600px">
                    <ul id="listadoActDesactGrupoIndicadores">
                        <?php
                        foreach ($lista_GrupoIndicadores as $GrupoIndicadores) {


                            $idGrupoIndicadores = $GrupoIndicadores['id'];
                            $tituloGrupoIndicadores = $GrupoIndicadores['titulo_completo'];
                            $descripcionGrupoIndicadores = $GrupoIndicadores['descripcion'];
                            $esta_activa = $GrupoIndicadores['activo'];



                            //$lista_de_GrupoIndicadores .= utf8_encode(strtolower($titulo)) . ',';

                            if ($esta_activa) {
                                echo '<li  titulo_GrupoIndicadores="' . utf8_encode(strtolower($tituloGrupoIndicadores)) . '" esta_activa="' . $esta_activa . '">
                                        <div class="descripcion">
                                            <div class="items">
                                                <span style="font-weight: bold;">' . $idGrupoIndicadores . '</span> - ' . htmlentities(substr($tituloGrupoIndicadores, 0, 64)) . '
                                            </div>
                                            <div class="items">
                                                ' . htmlentities(substr($descripcionGrupoIndicadores, 0, 70)) . '...
                                            </div>
                                        </div>
                                        <div class="opciones">
                                            <label class="chkDesactivar"><input name="estatusGrupoIndicadores" type="checkbox" value="' . $idGrupoIndicadores . '" onchange="uiActDesact(this)"/>Desactivar</label>
                                        </div>
                                    </li>';
                            } else {
                                echo '<li  titulo_GrupoIndicadores="' . utf8_encode(strtolower($tituloGrupoIndicadores)) . '" esta_activa="' . $esta_activa . '">
                                        <div class="descripcion">
                                            <div class="items">
                                                <span style="font-weight: bold;">' . $idGrupoIndicadores . '</span> - ' . htmlentities(substr($tituloGrupoIndicadores, 0, 64)) . '
                                            </div>
                                            <div class="items">
                                                ' . htmlentities(substr($descripcionGrupoIndicadores, 0, 70)) . '...
                                            </div>
                                        </div>
                                        <div class="opciones">
                                            <label class="chkActivar"><input name="estatusGrupoIndicadores" type="checkbox" value="' . $idGrupoIndicadores . '" onchange="uiActDesact(this)" />Activar</label>
                                        </div>
                                    </li>';
                            }
                        }
                        ?>                                                
                    </ul>
                </div>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarGrupoIndicadoresActivarDesactivar()">Guardar Activaciones / Desactivaciones</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
    #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
    #sortable li span { position: absolute; margin-left: -1.3em; }
</style>

<script type="text/javascript">
    $(function() {
        var _data_GrupoIndicadores = '<?php echo $lista_de_GrupoIndicadores; ?>'.split(',');
        
        $('#buscadorGrupoIndicadores').autocomplete({
            source : _data_GrupoIndicadores
        });
        
        $( "#tabsGrupoIndicadores" ).tabs();
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
        $.localise('ui-multiselect', {language: 'es', path: 'jqueryLib/multiselect/js/locale/'});
        $(".multiselect").multiselect();
        
        $( "#ListaDeGrupoSortable" ).sortable();
        $( "#ListaDeGrupoSortable" ).disableSelection();
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
    /**
     * cargar los grupos que estan relacionados con el subsitio
     */
    $("#SubsitioGrupoIndicadores").change(function(){
        var idSubsitio  = $("#SubsitioGrupoIndicadores").val();
        if (idSubsitio != 0) {
            $.ajax({
                type: "POST",
                url: "administracion/select_grupos_de_subsitio.php",
                dataType:   'json',
                data: {
                    id    :   idSubsitio
                },
                error: function(){
                    _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Porfavor, intentalo de nuevo.</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                },
                success: function(resp)
                {
                    $("#ListaDeGrupoSortable" ).html('<li style="padding:4px;" value="0" name="idsGrupoIndicadores" class="ui-state-default"><span style="display:inline-block;" class="ui-icon ui-icon-arrowthick-2-n-s"></span>Grupo actual en creación</li>');
                    for (var key in resp.grupos) {                        
                        $( "#ListaDeGrupoSortable" ).append('<li style="padding:4px;" title="'+ resp.grupos[key].titulo_completo +'" value ="' + resp.grupos[key].id + '" name ="idsGrupoIndicadores" class="ui-state-default"><span style="display:inline-block;" class="ui-icon ui-icon-arrowthick-2-n-s"></span>'+resp.grupos[key].etiqueta_titulo + '</li>');
                        $( "#ListaDeGrupoSortable" ).fadeIn('fast');
                    }

                }
            });
        }
    });

</script>
