<?php
include '../phpIncluidos/conexion.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    $no_hay_errores = FALSE;
    
    if(ISSET($_GET['id']))
    {
        $queryTipoEducacion_id = $_GET['id'];
        $id_de_TipoEducacion = -1;
        
        try
        {
            $id_de_tipo_educacion = (int)$queryTipoEducacion_id;
            $no_hay_errores = TRUE;
            
        }catch(Exception $e)
        {
            $no_hay_errores = FALSE;
        }
        
        if($no_hay_errores)
        {
            $stmt_TipoEducacion_indicadores= $conn->query('SELECT * FROM siee_tipo_educacion WHERE id = '. $id_de_tipo_educacion .' AND activo = 1');
            $queryTipoEducacion = $stmt_TipoEducacion_indicadores->fetch();
            $stmt_TipoEducacion_indicadores->closeCursor();
            
            $no_hay_errores = (sizeof($queryTipoEducacion) > 1);     
            
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
<div id="PanelModificacionDeTipoEducacion" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
    <div class="headerFromularios">
        Panel de modificaci&oacute;n de Niveles Educativos
    </div>
    <div id="CamposFormulario">
        <div class="itemsFormularios">
            <ul class="errores_por_campo" id="errors_TituloTipoEducacion_mod">
            </ul>
            <label for="TituloTipoEducacion_mod">Titulo del nivel educativo:</label>
            <input id="TituloTipoEducacion_mod" name="TituloTipoEducacion_mod"  type="text" maxlength="200" value="<?php echo htmlentities($queryTipoEducacion['titulo']) ?>" />
        </div>
      
        <div class="itemsFormularios">
            <ul class="errores_por_campo" id="errors_DescripcionTipoEducacion_mod">
            </ul>
            <label for="DescripcionTipoEducacion_mod">Descripci&oacute;n:</label>
            <textarea id="DescripcionTipoEducacion_mod" name="DescripcionTipoEducacion_mod" maxlength="1024" ><?php echo htmlentities($queryTipoEducacion['descripcion']) ?></textarea>
        </div>
        
        <input style="display: none;" type="text" id="TipoEducacionId_mod" value="<?php echo $queryTipoEducacion['id']?>"/>
    </div>
    <div class="itemsFormularios">
        <div class="optionPane">
            <button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionDeTipoEducacion')">Cerrar sin guardar</button>
            <button class="ui-boton-guardar" onclick="guardarModificacionTipoEducacion()">Guardar cambios</button>
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
<div id="PanelModificacionDeTipoEducacion" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
    <div class="headerFromularios">
        No se encontr&oacute; el tipo de educaci&oacute;n
    </div>
    <div id="CamposFormulario">
        <div class="itemsFormularios">
             El tipo de educaci&oacute;n que tratas de modificar no ha sido encontrada en el SIEE,
            refresca la pagina, vuelve a entrar a esta secci&oacute;n y realiza la tarea de nuevo.
        </div>
        <div class="itemsFormularios">
        <div class="optionPane">
            <button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionDeTipoEducacion')">Cerrar panel</button>
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
