<?php
include '../phpIncluidos/conexion.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    $no_hay_errores = FALSE;
    
    if(ISSET($_GET['id']))
    {
        $queryTipoDesagregacion_id = $_GET['id'];
        $id_de_TipoDesagregacion = -1;
        
        try
        {
            $id_de_tipo_desagregacion = (int)$queryTipoDesagregacion_id;
            $no_hay_errores = TRUE;
            
        }catch(Exception $e)
        {
            $no_hay_errores = FALSE;
        }
        
        if($no_hay_errores)
        {
            $stmt_TipoDesagregacion_indicadores= $conn->query('SELECT * FROM siee_tipo_desagregacion WHERE id = '. $id_de_tipo_desagregacion .' AND activo = 1');
            $queryTipoDesagregacion = $stmt_TipoDesagregacion_indicadores->fetch();
            $stmt_TipoDesagregacion_indicadores->closeCursor();
            
            $no_hay_errores = (sizeof($queryTipoDesagregacion) > 1);     
            
        }
        
    }
    else
    {
        $no_hay_errores = false;
    }
}

if($no_hay_errores)
{
?>
<div id="PanelModificacionDeTipoDesagregacion" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
    <div class="headerFromularios">
        Panel de modificaci&oacute;n de tipo de Desagregaci&oacute;n
    </div>
    <div id="CamposFormulario">
        <div class="itemsFormularios">
            <ul class="errores_por_campo" id="errors_TituloTipoDesagregacion_mod">
            </ul>
            <label for="TituloTipoDesagregacion_mod">Titulo:</label>
            <input id="TituloTipoDesagregacion_mod" name="TituloTipoDesagregacion_mod"  type="text" maxlength="200" value="<?php echo htmlentities($queryTipoDesagregacion['titulo']) ?>" />
        </div>
      
        <div class="itemsFormularios">
            <ul class="errores_por_campo" id="errors_DescripcionTipoDesagregacion_mod">
            </ul>
            <label for="DescripcionTipoDesagregacion_mod">Descripci&oacute;n:</label>
            <textarea id="DescripcionTipoDesagregacion_mod" name="DescripcionTipoDesagregacion_mod" maxlength="1024" ><?php echo htmlentities($queryTipoDesagregacion['descripcion']) ?></textarea>
        </div>
        
        <input style="display: none;" type="text" id="TipoDesagregacionId_mod" value="<?php echo $queryTipoDesagregacion['id']?>"/>
    </div>
    <div class="itemsFormularios">
        <div class="optionPane">
            <button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionDeTipoDesagregacion')">Cerrar sin guardar</button>
            <button class="ui-boton-guardar" onclick="guardarModificacionTipoDesagregacion()">Guardar cambios</button>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
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
}
else
{
//si se encontraron errores
?>
<div id="PanelModificacionDeTipoDesagregacion" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
    <div class="headerFromularios">
        No se encontr&oacute; el Tipo de desagregaci&oacute;n
    </div>
    <div id="CamposFormulario">
        <div class="itemsFormularios">
            El tipo de desagregaci&oacute;n que tratas de modificar no ha sido encontrada en el SIEE,
            refresca la pagina, vuelve a entrar a esta secci&oacute;n y realiza la tarea de nuevo.
        </div>
        <div class="itemsFormularios">
        <div class="optionPane">
            <button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionDeTipoDesagregacion')">Cerrar panel</button>
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
