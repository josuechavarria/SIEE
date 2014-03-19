<?php
include '../phpIncluidos/conexion.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    $no_hay_errores = FALSE;
    
    if(ISSET($_GET['id']))
    {
        $querySubsitio_id = $_GET['id'];
        $id_de_Subsitio = -1;
        
        try
        {
            $id_de_subsitio = (int)$querySubsitio_id;
            $no_hay_errores = TRUE;
            
        }catch(Exception $e)
        {
            $no_hay_errores = FALSE;
        }
        
        if($no_hay_errores)
        {
            $stmt_Subsitio_indicadores= $conn->query('SELECT * FROM siee_subsitio WHERE id = '. $id_de_subsitio .' AND activo = 1');
            $querySubsitio = $stmt_Subsitio_indicadores->fetch();
            $stmt_Subsitio_indicadores->closeCursor();
            
            $no_hay_errores = (sizeof($querySubsitio) > 1);     
            
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
<div id="PanelModificacionDeSubsitio" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
    <div class="headerFromularios">
        Panel de modificaci&oacute;n de Subsitios
    </div>
    <div id="CamposFormulario">
        <div class="itemsFormularios">
            <ul class="errores_por_campo" id="errors_TituloSubsitio_mod">
            </ul>
            <label for="TituloSubsitio_mod">Titulo del subsitio:</label>
            <input id="TituloSubsitio_mod" name="TituloSubsitio_mod"  type="text" maxlength="200" value="<?php echo htmlentities($querySubsitio['titulo']) ?>" />
        </div>
      
        <div class="itemsFormularios">
            <ul class="errores_por_campo" id="errors_DescripcionSubsitio_mod">
            </ul>
            <label for="DescripcionSubsitio_mod">Descripci&oacute;n:</label>
            <textarea id="DescripcionSubsitio_mod" name="DescripcionSubsitio_mod" maxlength="1024" ><?php echo htmlentities($querySubsitio['descripcion']) ?></textarea>
        </div>
        
        <div class="itemsFormularios">
            <ul class="errores_por_campo" id="errors_AbreviaturaSubsitio_mod">
            </ul>
            <label for="AbreviaturaSubsitio_mod">Abreviatura del subsitio:</label>
            <input id="AbreviaturaSubsitio_mod" name="AbreviaturaSubsitio_mod"  type="text" maxlength="4" value="<?php echo htmlentities($querySubsitio['abreviatura']) ?>" />
        </div>
        
        <div class="itemsFormularios">
            <ul class="errores_por_campo" id="errors_UrlSubsitio_mod">
            </ul>
            <label for="UrlSubsitio_mod">Url del subsitio:</label>
            <input id="UrlSubsitio_mod" name="UrlSubsitio_mod"  type="text" maxlength="100" value="<?php echo htmlentities($querySubsitio['url']) ?>" />
        </div>
        <input style="display: none;" type="text" id="SubsitioId_mod" value="<?php echo $querySubsitio['id']?>"/>
    </div>
    <div class="itemsFormularios">
        <div class="optionPane">
            <button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionDeSubsitio')">Cerrar sin guardar</button>
            <button class="ui-boton-guardar" onclick="guardarModificacionSubsitio()">Guardar cambios</button>
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
<div id="PanelModificacionDeSubsitio" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
    <div class="headerFromularios">
       No se encontr&oacute; el subsitio
    </div>
    <div id="CamposFormulario">
        <div class="itemsFormularios">
             El subsitio que tratas de modificar no ha sido encontrado en el SIEE,
            refresca la p&aacute;gina, vuelve a entrar a esta secci&oacute;n y realiza la tarea de nuevo.
        </div>
        <div class="itemsFormularios">
        <div class="optionPane">
            <button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionDeSubsitio')">Cerrar panel</button>
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
