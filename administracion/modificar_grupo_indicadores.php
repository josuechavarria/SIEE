<?php
include '../phpIncluidos/conexion.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $no_hay_errores = FALSE;

    if (ISSET($_GET['id'])) {
        $queryGrupoIndicadores_id = $_GET['id'];
        $id_de_GrupoIndicadores = -1;

        try {
            $id_de_grupo_indicadores = (int) $queryGrupoIndicadores_id;
            $no_hay_errores = TRUE;
        } catch (Exception $e) {
            $no_hay_errores = FALSE;
        }

        if ($no_hay_errores) {

            $stmt_GrupoIndicadores_indicadores = $conn->query('SELECT * FROM siee_grupo_indicadores WHERE id = ' . $id_de_grupo_indicadores . ' AND activo = 1');
            $queryGrupoIndicadores = $stmt_GrupoIndicadores_indicadores->fetch();
            $stmt_GrupoIndicadores_indicadores->closeCursor();

            $stmt_lista_subsitios = $conn->query('SELECT id,titulo FROM siee_subsitio WHERE  activo = 1');
            $queryListaDeSubsitio = $stmt_lista_subsitios->fetchall();
            $stmt_lista_subsitios->closeCursor();

            $stmt_listado_indicadores = $conn->query('SELECT id,titulo FROM siee_indicador WHERE activo = 1');
            $lista_indicadores_mod = $stmt_listado_indicadores->fetchAll(PDO::FETCH_NUM);
            $stmt_listado_indicadores->closeCursor();

            $stmt_listado_indicadores_ids = $conn->query('Select r.indicador_id AS indicador_id, i.titulo AS titulo from "siee_rel-indicador__grupo_indicadores" AS r, siee_indicador AS i where r.indicador_id = i.id AND r.grupo_indicador_id = ' . $id_de_grupo_indicadores . ' ORDER BY r.ordenamiento_indicador ASC;');
            $lista_indicadores_ids = $stmt_listado_indicadores_ids->fetchAll(PDO::FETCH_NUM);
            $stmt_listado_indicadores_ids->closeCursor();

            $no_hay_errores = (sizeof($queryGrupoIndicadores) > 1);
        }
    } else {
        $no_hay_errores = false;
    }
}

if ($no_hay_errores) {
    ?>
    <div id="PanelModificacionDeGrupoIndicadores" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
        <div class="headerFromularios">
            Panel de modificaci&oacute;n de Grupo Indicadores
        </div>
        <div id="CamposFormulario">



            <div class="itemsFormularios">
                <ul class="errores_por_campo" id="errors_EtiquetaTituloGrupoIndicadores_mod">
                </ul>
                <label for="EtiquetaTituloGrupoIndicadores_mod">Etiq De Grup De Indicadores:</label>
                <input id="EtiquetaTituloGrupoIndicadores_mod" name="EtiquetaTituloGrupoIndicadores_mod"  type="text" maxlength="30" value="<?php echo htmlentities($queryGrupoIndicadores['etiqueta_titulo']) ?>" />
            </div>

            <div class="itemsFormularios">
                <ul class="errores_por_campo" id="errors_TituloCompletoGrupoIndicadores_mod">
                </ul>
                <label for="TituloGrupoIndicadores_mod">Titulo Completo:</label>
                <input id="TituloGrupoIndicadores_mod" name="TituloGrupoIndicadores_mod"  type="text" maxlength="128" value="<?php echo htmlentities($queryGrupoIndicadores['titulo_completo']) ?>" />
            </div>

            <div class="itemsFormularios">
                <ul class="errores_por_campo" id="errors_DescripcionGrupoIndicadores_mod">
                </ul>
                <label for="DescripcionGrupoIndicadores_mod">Descripci&oacute;n:</label>
                <textarea id="DescripcionGrupoIndicadores_mod" name="DescripcionGrupoIndicadores_mod" maxlength="512" ><?php echo htmlentities($queryGrupoIndicadores['descripcion']) ?></textarea>
            </div>
            <div class="itemsFormularios">
                <ul class="errores_por_campo" id="errors_IndicadorGrupoIndicador_mod">
                </ul>
                <label style="max-width:none;" for="IndicadorGrupoIndicador_mod">Seleccione los indicadores que pertenecen a este grupo:</label>
            </div>
            <select id="IndicadorGrupoIndicador_mod" class="multiselect" multiple="multiple" name="Indicadores_mod[]" style="width:706px;height:300px;">
                <?php
                foreach ($lista_indicadores_ids as $indic) {
                    echo '<option value="' . $indic[0] . '"  selected="selected">' . htmlentities( $indic[1] ) . '</option>';
                }

                foreach ($lista_indicadores_mod as $indicador_mod) {
                    //$id_indicador_mod = $indicador_mod['id'];
                    //$titulo_indicador_mod = $indicador_mod['titulo'];

                    if (!in_array($indicador_mod, $lista_indicadores_ids)) {
                        echo '<option value="' . $indicador_mod[0] . '" >' . htmlentities( $indicador_mod[1] ) . '</option>';
                    }
                }
                ?>
            </select> 

            <div class="itemsFormularios">
                <ul class="errores_por_campo" id="errors_SubsitioGrupoIndicadores_mod">
                </ul>
                <label for="" >Seleccione el subsitio:</label>
                <select id="SubsitioGrupoIndicadores_mod">
                    <?php
                    foreach ($queryListaDeSubsitio as $subsitio) {
                        $id_subsitio = $subsitio['id'];

                        if ($id_subsitio == $queryGrupoIndicadores['subsitio_id']) {
                            $id_sub = $id_subsitio;
                            echo '<option value="' . $id_subsitio . '"  selected="selected">' . $subsitio['titulo'] . '</option>';
                        } else {
                            echo '<option value="' . $id_subsitio . '">' . $subsitio['titulo'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="itemsFormularios">
                <ul class="errores_por_campo" id="errors_ListaSubsitiosGrupoIndicador_mod">
                </ul>
                <label style="max-width:none;" for="ListaSubsitiosGrupoIndicador">Ordene los Grupos a Coveniencia:</label>
            </div>
			<div style="padding:10px; border:1px solid #ccc; background-color: #fff;">
				<ul id="ListaDeGrupoSortable_mod">
					<?php
					$stmt_grupos_en_subsitio = $conn->query('SELECT id,etiqueta_titulo,titulo_completo FROM siee_grupo_indicadores WHERE subsitio_id = ' . $queryGrupoIndicadores['subsitio_id'] . ' AND activo = 1 ORDER BY ordenamiento_grupo ASC;');
					$queryGruposEnSubsitio = $stmt_grupos_en_subsitio->fetchall();
					$stmt_grupos_en_subsitio->closeCursor();

					foreach ($queryGruposEnSubsitio as $grupo) {
						echo '<li style="padding:4px;" title="' . htmlentities($grupo['titulo_completo']) . '" value ="' . $grupo['id'] . '" name="idsGrupoIndicadores_mod" class="ui-state-default"><span style="display:inline-block;" class="ui-icon ui-icon-arrowthick-2-n-s"></span>' . htmlentities($grupo['etiqueta_titulo']) . '</li>';
					}
					?>
				</ul>
				<input style="display: none;" type="text" id="GrupoIndicadoresId_mod" value="<?php echo $queryGrupoIndicadores['id'] ?>"/>
			</div>
        </div>
        <div class="itemsFormularios">
            <div class="optionPane">
                <button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionDeGrupoIndicadores')">Cerrar sin guardar</button>
                <button class="ui-boton-guardar" onclick="guardarModificacionGrupoIndicadores()">Guardar cambios</button>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $.localise('ui-multiselect', {language: 'es', path: 'jqueryLib/multiselect/js/locale/'});
            $(".multiselect").multiselect();
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
                        
            $( "#ListaDeGrupoSortable_mod" ).sortable();
            $( "#ListaDeGrupoSortable_mod" ).disableSelection();
        });
                    
        $("#SubsitioGrupoIndicadores_mod").change(function(){
            var idSubsitio  = $(this).val();
            if (idSubsitio != 0) {
                $.ajax({
                    type: "POST",
                    url: "administracion/select_grupos_de_subsitio.php",
                    dataType:   'json',
                    data: {
                        id    :   idSubsitio
                    },
                    error: function(){
                        _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, intentalo de nuevo.</p>";
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
                        $( "#ListaDeGrupoSortable_mod" ).html('');
                        var esta = false;
                        for (var key in resp.grupos) {
                            if (resp.grupos[key].id == <?php echo $queryGrupoIndicadores['id']; ?>) {
                                esta = true;
                            }
                            //ListaDeGrupoSortable
                            //<li value ="0" name ="idsGrupoIndicadores" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Nuevo Grupo a crear</li>
                            $( "#ListaDeGrupoSortable_mod" ).append('<li title="'+ resp.grupos[key].titulo_completo +'" value ="' + resp.grupos[key].id + '" name ="idsGrupoIndicadores_mod" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>'+resp.grupos[key].etiqueta_titulo + '</li>');
                            //$( "#ListaDeGrupoSortable_mod" ).fadeIn('fast');
                        }
               
                        if (!esta) {
                            $( "#ListaDeGrupoSortable_mod" ).append('<li title="<?php echo $queryGrupoIndicadores['titulo_completo']; ?>" value ="<?php echo $queryGrupoIndicadores['id']; ?>" name ="idsGrupoIndicadores_mod" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $queryGrupoIndicadores['etiqueta_titulo']; ?></li>');
                        }
         
                    }
                });
            }
        });
                
    </script>
    <?php
} else {
//si se encontraron errores
    ?>
    <div id="PanelModificacionDeGrupoIndicadores" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
        <div class="headerFromularios">
            No se encontr&oacute; el grupo de indicador
        </div>
        <div id="CamposFormulario">
            <div class="itemsFormularios">
                El grupo de indicador que tratas de modificar no ha sido encontrada en el SIEE,
                refresca la pagina, vuelve a entrar a esta secci&oacute;n y realiza la tarea de nuevo.
            </div>
            <div class="itemsFormularios">
                <div class="optionPane">
                    <button class="ui-boton-cerrar" onclick="cerrarPanelModifcaciones('PanelModificacionDeGrupoIndicadores')">Cerrar panel</button>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(function() {
            $( ".ui-boton-cerrar" ).button({
                icons: {
                    primary: "ui-icon ui-icon-closethick"
                } 
            });
                            
        });
                        
    </script>
    <?php
}
?>
