<?php
include '../phpIncluidos/conexion.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $no_hay_errores = FALSE;

    if (ISSET($_GET['rol_id'])) {
        $rol_id = $_GET['rol_id'];
        $id_de_rol = -1;

        try {
            $id_de_rol = (int) $rol_id;
            $no_hay_errores = TRUE;
        } catch (Exception $e) {
            $no_hay_errores = FALSE;
        }

        if ($no_hay_errores) {
            $stmt_de_rol = $conn->query('SELECT * FROM siee_rol WHERE id = ' . $id_de_rol . ' AND activo = 1');
            $queryRol = $stmt_de_rol->fetch();
            $stmt_de_rol->closeCursor();

            $no_hay_errores = (sizeof($queryRol) > 1);
        }
    } else {
        $no_hay_errores = false;
    }
}

if ($no_hay_errores) {
    ?>
    <div id="PanelModificacionDeRol" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
        <div class="headerFromularios">
            Panel de modificaci&oacute;n de Rol
        </div>
        <div id="CamposFormulario">
			<input style="display: none;" type="text" id="RolId_mod" value="<?php echo $queryRol['id'] ?>"/>
            <div class="itemsFormularios">
                <ul class="errores_por_campo" id="errors_TituloRol_mod">
                </ul>
                <label for="TituloRol_mod">Titulo del rol:</label>
                <input id="TituloRol_mod" name="tituloRol_mod"  type="text" maxlength="128" value="<?php echo htmlentities($queryRol['titulo_rol']) ?>" />
            </div>
            <div class="itemsFormularios">
                <ul class="errores_por_campo" id="errors_DescripcionRol_mod">
                </ul>
                <label for="DescripcionRol_mod">Descripci&oacute;n:</label>
                <textarea id="DescripcionRol_mod" name="descripcionRol_mod" maxlength="1024" ><?php echo htmlentities($queryRol['descripcion_rol']) ?></textarea>
            </div>
            <div class="itemsFormularios">
				<ul class="errores_por_campo" id="errors_Administrador_mod">
				</ul>
				<label>¿Es Administrador?</label>
				<span id="RadioAdministrador_mod">
					<?php
						if ($queryRol['es_administrador']){
					?>
					<input type="radio" id="AdministradorSi_mod" name="administrador_mod" value="1" checked="checked"/><label for="AdministradorSi_mod">Si</label>
					<input type="radio" id="AdministradorNo_mod" name="administrador_mod" value="0"/><label for="AdministradorNo_mod">No</label>
					<?php
						}else{
					?>
					<input type="radio" id="AdministradorSi_mod" name="administrador_mod" value="1"/><label for="AdministradorSi_mod">Si</label>
					<input type="radio" id="AdministradorNo_mod" name="administrador_mod" value="0" checked="checked" /><label for="AdministradorNo_mod">No</label>
					<?php
						}
					?>
				</span>
			</div>
			<div class="itemsFormularios">
				<ul class="errores_por_campo" id="errors_AlertasDeDesviaciones_mod"></ul>
				<label>¿Ver alertas de desviaciones?</label>
				<span id="RadioAlertasDeDesviaciones_mod">
					<?php
						if ($queryRol['ver_alertas_desviaciones']){
					?>
					<input type="radio" id="AlertasDeDesviacionesSi_mod"name="alertas_de_desviaciones_mod" value="1" checked="checked" /><label for="AlertasDeDesviacionesSi_mod">Si</label>
					<input type="radio" id="AlertasDeDesviacionesNo_mod"name="alertas_de_desviaciones_mod" value="0"/><label for="AlertasDeDesviacionesNo_mod">No</label>
					<?php
						}else{
					?>
					<input type="radio" id="AlertasDeDesviacionesSi_mod"name="alertas_de_desviaciones_mod" value="1"/><label for="AlertasDeDesviacionesSi_mod">Si</label>
					<input type="radio" id="AlertasDeDesviacionesNo_mod"name="alertas_de_desviaciones_mod" value="0" checked="checked" /><label for="AlertasDeDesviacionesNo_mod">No</label>
					<?php
						}
					?>
				</span>
			</div>
			<div class="itemsFormularios">
				<ul class="errores_por_campo" id="errors_IndicadoresPrivados_mod"></ul>
				<label>¿Ver indicadores privados?</label>
				<span id="RadioIndicadoresPrivados_mod">
					<?php
						if ($queryRol['ver_indicadores_privados']){
					?>
					<input type="radio" id="IndicadoresPrivadosSi_mod"name="indicadores_privados_mod" value="1" checked="checked"/><label for="IndicadoresPrivadosSi_mod">Si</label>
					<input type="radio" id="IndicadoresPrivadosNo_mod"name="indicadores_privados_mod" value="0"/><label for="IndicadoresPrivadosNo_mod">No</label>
					<?php
						}else{
					?>
					<input type="radio" id="IndicadoresPrivadosSi_mod"name="indicadores_privados_mod" value="1"/><label for="IndicadoresPrivadosSi_mod">Si</label>
					<input type="radio" id="IndicadoresPrivadosNo_mod"name="indicadores_privados_mod" value="0" checked="checked" /><label for="IndicadoresPrivadosNo_mod">No</label>
					<?php
						}
					?>
				</span>
			</div>
			<div class="itemsFormularios">
				<ul class="errores_por_campo" id="errors_Proyecciones_mod"></ul>
				<label>¿Puede aplicar proyecciones?</label>
				<span id="RadioProyecciones_mod">
					<?php
						if ($queryRol['ver_proyecciones']){
					?>
					<input type="radio" id="ProyeccionesSi_mod"name="proyecciones_mod" value="1" checked="checked"/><label for="ProyeccionesSi_mod">Si</label>
					<input type="radio" id="ProyeccionesNo_mod"name="proyecciones_mod" value="0"/><label for="ProyeccionesNo_mod">No</label>
					<?php
						}else{
					?>
					<input type="radio" id="ProyeccionesSi_mod"name="proyecciones_mod" value="1"/><label for="ProyeccionesSi_mod">Si</label>
					<input type="radio" id="ProyeccionesNo_mod"name="proyecciones_mod" value="0" checked="checked" /><label for="ProyeccionesNo_mod">No</label>
					<?php
						}
					?>
				</span>
			</div>
			<div class="itemsFormularios">
				<ul class="errores_por_campo" id="errors_Moderador_mod"></ul>
				<label>¿Moderador de comentarios?</label>
				<span id="RadioModerador_mod">
					<?php
						if ($queryRol['es_moderador']){
					?>
					<input type="radio" id="ModeradorSi_mod"name="moderador_mod" value="1" checked="checked"/><label for="ModeradorSi_mod">Si</label>
					<input type="radio" id="ModeradorNo_mod"name="moderador_mod" value="0"/><label for="ModeradorNo_mod">No</label>
					<?php
						}else{
					?>
					<input type="radio" id="ModeradorSi_mod"name="moderador_mod" value="1"/><label for="ModeradorSi_mod">Si</label>
					<input type="radio" id="ModeradorNo_mod"name="moderador_mod" value="0" checked="checked" /><label for="ModeradorNo_mod">No</label>
					<?php
						}
					?>
				</span>
			</div>
            <div class="itemsFormularios">
                <div class="optionPane">
                    <button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionDeRol')">Cerrar sin guardar</button>
                    <button class="ui-boton-guardar" onclick="guardarModificacionRol()">Guardar cambios</button>
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

		$( "#RadioAdministrador_mod" ).buttonset();
		$( "#RadioAlertasDeDesviaciones_mod" ).buttonset();
		$( "#RadioIndicadoresPrivados_mod" ).buttonset();
		$( "#RadioProyecciones_mod" ).buttonset();
		$( "#RadioModerador_mod" ).buttonset();
	</script>
    <?php
} else {
//si se encontraron errores
    ?>
	<div id="PanelModificacionDeRol" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
		<div class="headerFromularios">
			No se encontr&oacute; el rol
		</div>
		<div id="CamposFormulario">
			<div class="itemsFormularios">
				El rol que tratas de modificar no ha sido encontrada en el SIEE,
				refresca la pagina, vuelve a entrar a esta secci&oacute;n y realiza la tarea de nuevo.
			</div>
			<div class="itemsFormularios">
				<div class="optionPane">
					<button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionDeRol')">Cerrar panel</button>
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
