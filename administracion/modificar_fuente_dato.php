<?php
include '../phpIncluidos/conexion.php';
$patron_numerico = '/^[123456789][0-9]*$/';
$error = false;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (ISSET($_GET['id'])) {
		if (!preg_match($patron_numerico, $_GET['id'])){
			$error = true;
		} else {
			$error = false;
			$id = $_GET['id'];
		}
        
        if (!$error) {
            $stmt_fuente_de_datos = $conn->query('SELECT * FROM siee_fuente_dato WHERE id = ' . $id . ' AND activo = 1');
            $fuente_de_datos = $stmt_fuente_de_datos->fetch();
            $stmt_fuente_de_datos->closeCursor();
			
			if (!(sizeof($fuente_de_datos) > 0)){
				$error = true;
			}
        }
    } else {
        $error = true;
    }
}

if (!$error) {
    ?>
    <div id="PanelModificacionDeFuenteDato" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
        <div class="headerFromularios">
            Panel de modificaci&oacute;n de Fuente De Dato
        </div>
        <div id="CamposFormulario">
			<input style="display: none;" type="text" id="FuenteDatoId_mod" value="<?php echo $id ?>"/>
            
			<div class="itemsFormularios">
                <ul class="errores_por_campo" id="errors_TituloFuenteDato_mod">
                </ul>
                <label for="TituloFuenteDato_mod">Titulo de la Fuente:</label>
                <input id="TituloFuenteDato_mod" name="tituloFuenteDato_mod"  type="text" maxlength="128" value="<?php echo htmlentities($fuente_de_datos['titulo']) ?>" />
            </div>
            <div class="itemsFormularios">
                <ul class="errores_por_campo" id="errors_DescripcionFuenteDato_mod">
                </ul>
                <label for="DescripcionFuenteDato_mod">Descripci&oacute;n:</label>
                <textarea id="DescripcionFuenteDato_mod" name="descripcionFuenteDato_mod" maxlength="265" ><?php echo htmlentities($fuente_de_datos['descripcion']) ?></textarea>
            </div>
            
            <div class="itemsFormularios">
                <div class="optionPane">
                    <button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionDeFuenteDato')">Cerrar sin guardar</button>
                    <button class="ui-boton-guardar" onclick="guardarModificacionFuenteDato()">Guardar cambios</button>
                </div>
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
} else {
//si se encontraron errores
    ?>
	<div id="PanelModificacionDeFuenteDato" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
		<div class="headerFromularios">
			No se encontr&oacute; la fuente de dato
		</div>
		<div id="CamposFormulario">
			<div class="itemsFormularios">
				La fuente de datos que tratas de modificar no ha sido encontrada en el SIEE,
				refresca la pagina, vuelve a entrar a esta secci&oacute;n y realiza la tarea de nuevo.
			</div>
			<div class="itemsFormularios">
				<div class="optionPane">
					<button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionDeFuenteDato')">Cerrar panel</button>
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
