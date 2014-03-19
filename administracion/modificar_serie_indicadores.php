<?php
include '../phpIncluidos/conexion.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    $no_hay_errores = FALSE;
    
    if(ISSET($_GET['serie_indicadores_id']))
    {
        $serie_indicadores_id = $_GET['serie_indicadores_id'];
        $id_de_serie = -1;
        
        try
        {
            $id_de_serie = (int)$serie_indicadores_id;
            $no_hay_errores = TRUE;
            
        }catch(Exception $e)
        {
            $no_hay_errores = FALSE;
        }
        
        if($no_hay_errores)
        {
            $stmt_serie_indicadores= $conn->query('SELECT * FROM siee_serie_indicadores WHERE id = '. $id_de_serie .' AND activo = 1');
            $serie_indicadores = $stmt_serie_indicadores->fetch();
            $stmt_serie_indicadores->closeCursor();
            
            $no_hay_errores = (sizeof($serie_indicadores) > 1);     
            
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
<div id="PanelModificacionDeSeries" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
    <div class="headerFromularios">
        Panel de modificaci&oacute;n de Series de indicadores
    </div>
    <div id="CamposFormulario">
        <div class="itemsFormularios">
            <ul class="errores_por_campo" id="errors_TituloSerie_mod">
            </ul>
            <label for="TituloSerie_mod">Titulo de la Serie:</label>
            <input id="TituloSerie_mod" name="tituloSerie_mod"  type="text" maxlength="128" value="<?php echo htmlentities($serie_indicadores['titulo']) ?>" />
        </div>
        <div class="itemsFormularios">
            <ul class="errores_por_campo" id="errors_CantidadDeIndicadores_mod">
            </ul>
            <label for="CantidadDeIndicadores_mod">Cantidad de Indicadores:</label>
            <input id="CantidadDeIndicadores_mod" name="cantidadDeIndicadores_mod" maxlength="4" placeholder="0" type="text" value="<?php echo $serie_indicadores['cantidad_indicadores'] ?>" onkeyup='$(this).val($(this).val().replace(/[^0-9]/g, ""))' onblur='$(this).val($(this).val().replace(/[^0-9]/g, ""))' style="text-align: center; width: 40px;"/>
        </div>
        <div class="itemsFormularios">
            <ul class="errores_por_campo" id="errors_DescripcionSerie_mod">
            </ul>
            <label for="DescripcionSerie_mod">Descripci&oacute;n:</label>
            <textarea id="DescripcionSerie_mod" name="descripcionSerie_mod" maxlength="1024" ><?php echo htmlentities($serie_indicadores['descripcion']) ?></textarea>
        </div>
        <div class="itemsFormularios">
            <label for="ObservacionSerie_mod" >Observaciones:</label>
            <textarea id="ObservacionSerie_mod" name="observacionSerie_mod" placeholder="Ninguna" maxlength="512" ><?php echo htmlentities($serie_indicadores['observaciones']) ?></textarea>
        </div>
        <input style="display: none;" type="text" id="SerieIndicadorId_mod" value="<?php echo $serie_indicadores['id']?>"/>
    </div>
    <div class="itemsFormularios">
        <div class="optionPane">
            <button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionDeSeries')">Cerrar sin guardar</button>
            <button class="ui-boton-guardar" onclick="guardarModificacionSerieIndicadores()">Guardar cambios</button>
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
<div id="PanelModificacionDeSeries" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
    <div class="headerFromularios">
       No se encontr&oacute; la serie
    </div>
    <div id="CamposFormulario">
        <div class="itemsFormularios">
             La serie que tratas de modificar no ha sido encontrada en el SIEE,
            refresca la pagina, vuelve a entrar a esta secci&oacute;n y realiza la tarea de nuevo.
        </div>
        <div class="itemsFormularios">
        <div class="optionPane">
            <button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionDeSeries')">Cerrar panel</button>
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
