<?php
include '../phpIncluidos/conexion.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    $no_hay_errores = FALSE;
    
    if(ISSET($_GET['id']))
    {
        $queryNivelEducativo_id = $_GET['id'];
        $id_de_NivelEducativo = -1;
        
        try
        {
            $id_de_nivel_educativo = (int)$queryNivelEducativo_id;
            $no_hay_errores = TRUE;
            
        }catch(Exception $e)
        {
            $no_hay_errores = FALSE;
        }
        
        if($no_hay_errores)
        {
            $stmt_NivelEducativo_indicadores= $conn->query('SELECT * FROM siee_nivel_educativo WHERE id = '. $id_de_nivel_educativo .' AND activo = 1');
            $queryNivelEducativo = $stmt_NivelEducativo_indicadores->fetch();
            $stmt_NivelEducativo_indicadores->closeCursor();
            
            $no_hay_errores = (sizeof($queryNivelEducativo) > 1);     
            
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
<div id="PanelModificacionDeNivelEducativo" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
    <div class="headerFromularios">
        Panel de modificaci&oacute;n de Niveles Educativos
    </div>
    <div id="CamposFormulario">
        <div class="itemsFormularios">
            <ul class="errores_por_campo" id="errors_TituloNivelEducativo_mod">
            </ul>
            <label for="TituloNivelEducativo_mod">Titulo del nivel educativo:</label>
            <input id="TituloNivelEducativo_mod" name="TituloNivelEducativo_mod"  type="text" maxlength="200" value="<?php echo htmlentities($queryNivelEducativo['titulo']) ?>" />
        </div>
      
        <div class="itemsFormularios">
            <ul class="errores_por_campo" id="errors_DescripcionNivelEducativo_mod">
            </ul>
            <label for="DescripcionNivelEducativo_mod">Descripci&oacute;n:</label>
            <textarea id="DescripcionNivelEducativo_mod" name="DescripcionNivelEducativo_mod" maxlength="1024" ><?php echo htmlentities($queryNivelEducativo['descripcion']) ?></textarea>
        </div>
        
        <input style="display: none;" type="text" id="NivelEducativoId_mod" value="<?php echo $queryNivelEducativo['id']?>"/>
    </div>
    <div class="itemsFormularios">
        <div class="optionPane">
            <button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionDeNivelEducativo')">Cerrar sin guardar</button>
            <button class="ui-boton-guardar" onclick="guardarModificacionNivelEducativo()">Guardar cambios</button>
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
<div id="PanelModificacionDeNivelEducativo" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
    <div class="headerFromularios">
       No se encontr&oacute; el nivel educativo
    </div>
    <div id="CamposFormulario">
        <div class="itemsFormularios">
             El nivel educativo que tratas de modificar no ha sido encontrada en el SIEE,
            refresca la pagina, vuelve a entrar a esta secci&oacute;n y realiza la tarea de nuevo.
        </div>
        <div class="itemsFormularios">
        <div class="optionPane">
            <button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionDeNivelEducativo')">Cerrar panel</button>
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
