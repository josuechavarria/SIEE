<?php
include '../phpIncluidos/conexion.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $no_hay_errores = FALSE;

    if (ISSET($_GET['id'])) {
        $queryIndicadores_id = $_GET['id'];
        $no_hay_errores = TRUE;
        
    } else {
        $no_hay_errores = false;
    }
}
if ($no_hay_errores) {

    $stmt_listado_indicadores_rel = $conn->query('Select * from siee_indicador where id != ' . $queryIndicadores_id . ' AND activo = 1');
    $lista_de_indicadores = $stmt_listado_indicadores_rel->fetchAll();
    $stmt_listado_indicadores_rel->closeCursor();

    $stmt_listado_indicadores_rel_mod = $conn->query('select case when r.indicador_id = ' . $queryIndicadores_id . ' then r.indicador_id2 else r.indicador_id end As indicador
                                                    From siee_indicador AS i1,"siee_rel-indicador__indicador" AS r
                                                    where (i1.id = r.indicador_id OR i1.id = r.indicador_id2)
                                                    and i1.id = ' . $queryIndicadores_id);
    $lista_de_indicadores_rel = $stmt_listado_indicadores_rel_mod->fetchAll(PDO::FETCH_COLUMN, 0);
    $stmt_listado_indicadores_rel_mod->closeCursor();
    
   // print_r($lista_de_indicadores_rel)
    ?>
    <div id="PanelModificacionDeIndicadores" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
        <div class="headerFromularios">
            Panel de modificaci&oacute;n de Relaciones de Indicadores
        </div>
        <div id="CamposFormulario">

            <div class="itemsFormularios">
                <ul class="errores_por_campo" id="errors_IndicadorGrupoIndicador_mod">
                </ul>
                <label style="max-width:none;" for="IndicadorGrupoIndicador_mod">Seleccione los indicadores que est&aacute;n relacionados:</label>
            </div>
            <select id="IndicadorGrupoIndicador_mod" class="multiselect" multiple="multiple" name="Indicadores_mod_rel[]" style="width:706px;height:300px;">
            <?php
                foreach ($lista_de_indicadores as $indicador_mod_rel) {

                    $id_indicador_mod = $indicador_mod_rel['id'];
                    $titulo_indicador_mod = $indicador_mod_rel['titulo'];

                    if (in_array($id_indicador_mod, $lista_de_indicadores_rel)) {
                        echo '<option value="' . $id_indicador_mod . '"  selected="selected">' . htmlentities($titulo_indicador_mod) . '</option>';
                    }else{
                        echo '<option value="' . $id_indicador_mod . '" >' . htmlentities($titulo_indicador_mod) . '</option>';

                    }
                }
            ?>
            </select>  
            <input style="display: none;" type="text" id="IndicadoresId_mod_rel" value="<?php echo $queryIndicadores_id ?>"/>
        </div>
        <div class="itemsFormularios">
            <div class="optionPane">
                <button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionDeIndicadores')">Cerrar sin guardar</button>
                <button class="ui-boton-guardar" onclick="guardarModificacionIndicadoresRelacion()">Guardar cambios</button>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $.localise('ui-multiselect', {/*language: 'es',*/ path: 'jqueryLib/multiselect/js/locale/'});
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
        });
    </script>
    <?php
} else {
//si se encontraron errores
    ?>
    <div id="PanelModificacionDeIndicadores" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
        <div class="headerFromularios">
            No se encontr&oacute; las relaciones del indicador
        </div>
        <div id="CamposFormulario">
            <div class="itemsFormularios">
                Las Relaciones del indicador que tratas de modificar no ha sido encontrada en el SIEE,
                refresca la pagina, vuelve a entrar a esta secci&oacute;n y realiza la tarea de nuevo.
            </div>
            <div class="itemsFormularios">
                <div class="optionPane">
                    <button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionDeIndicadores')">Cerrar panel</button>
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
