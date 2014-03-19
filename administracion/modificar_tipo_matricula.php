<?php
include '../phpIncluidos/conexion.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    $no_hay_errores = FALSE;
    
    if(ISSET($_GET['id']))
    {
        $queryTipoMatricula_id = $_GET['id'];
        $id_de_TipoMatricula = -1;
        
        try
        {
            $id_de_tipo_matricula = (int)$queryTipoMatricula_id;
            $no_hay_errores = TRUE;
            
        }catch(Exception $e)
        {
            $no_hay_errores = FALSE;
        }
        
        if($no_hay_errores)
        {
            $stmt_TipoMatricula_indicadores= $conn->query('SELECT * FROM siee_tipo_matricula WHERE id = '. $id_de_tipo_matricula .' AND activo = 1');
            $queryTipoMatricula = $stmt_TipoMatricula_indicadores->fetch();
            $stmt_TipoMatricula_indicadores->closeCursor();
            
            $no_hay_errores = (sizeof($queryTipoMatricula) > 1);     
            
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
<div id="PanelModificacionDeTipoMatricula" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
    <div class="headerFromularios">
        Panel de modificaci&oacute;n de Tipo de Matricula
    </div>
    <div id="CamposFormulario">
        <div class="itemsFormularios">
            <ul class="errores_por_campo" id="errors_TituloTipoMatricula_mod">
            </ul>
            <label for="TituloTipoMatricula_mod">Titulo de tipo de matricula:</label>
            <input id="TituloTipoMatricula_mod" name="TituloTipoMatricula_mod"  type="text" maxlength="100" value="<?php echo htmlentities($queryTipoMatricula['titulo']) ?>" />
        </div>
      
        <div class="itemsFormularios">
            <ul class="errores_por_campo" id="errors_DescripcionTipoMatricula_mod">
            </ul>
            <label for="DescripcionTipoMatricula_mod">Descripci&oacute;n:</label>
            <textarea id="DescripcionTipoMatricula_mod" name="DescripcionTipoMatricula_mod" maxlength="1024" ><?php echo htmlentities($queryTipoMatricula['descripcion']) ?></textarea>
        </div>
        
        <input style="display: none;" type="text" id="TipoMatriculaId_mod" value="<?php echo $queryTipoMatricula['id']?>"/>
    </div>
    <div class="itemsFormularios">
        <div class="optionPane">
            <button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionDeTipoMatricula')">Cerrar sin guardar</button>
            <button class="ui-boton-guardar" onclick="guardarModificacionTipoMatricula()">Guardar cambios</button>
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
<div id="PanelModificacionDeTipoMatricula" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
    <div class="headerFromularios">
       No se encontr&oacute; el Tipo De Matricula
    </div>
    <div id="CamposFormulario">
        <div class="itemsFormularios">
             El tipo de matricula que tratas de modificar no ha sido encontrada en el SIEE,
            refresca la pagina, vuelve a entrar a esta secci&oacute;n y realiza la tarea de nuevo.
        </div>
        <div class="itemsFormularios">
        <div class="optionPane">
            <button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionDeTipoMatricula')">Cerrar panel</button>
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
