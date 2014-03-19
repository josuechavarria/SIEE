<?php
	include "phpIncluidos/conexion.php";
	$usuario = $_SESSION['usuario'];
?>
<div id="PanelPerfilUsuario" class="PanelPerfilUsuario">
	<ul>
		<li><a href="#panelUsuariotabs-1">&quot;Bienvenido <?php echo $usuario['nombre_usuario']; ?>&quot;</a></li>
		<li><a href="#panelUsuariotabs-2">Cambiar mi clave</a></li>
		<li><a href="#panelUsuariotabs-3">Editar mi perfil</a></li>
	</ul>
	<div id="panelUsuariotabs-1">
		<div class="items">
			<label class="etiquetas">
				Nombre:
			</label>
			<label class="campo-no-editable">
				<?php echo htmlentities( utf8_decode( $usuario['primer_nombre'] . " " . $usuario['segundo_nombre'] . " " . $usuario['primer_apellido'] . " " . $usuario['segundo_apellido']) ); ?>
			</label>
		</div>
		<div class="items">
			<label class="etiquetas">
				Rol:
			</label>
			<label class="campo-no-editable">
				<?php echo $usuario['rol']['titulo_rol'];
					if($usuario['rol']['es_administrador'] === '1'){
						echo '<a style="color: #004F84;display: inline-block;font-size: 0.8em;margin-left: 20px;position: relative;top: -1px;" href="/SIEE/Administracion.php">Ir a la secci&oacute;n administrativa.</a>';
					}
				?>
			</label>
		</div>
		<div class="items">
			<label class="etiquetas">
				Correo Electr&oacute;nico:
			</label>
			<label class="campo-no-editable">
				<?php echo $usuario['correo_electronico']; ?>
			</label>
		</div>
		<div class="items">
			<label class="etiquetas">
				Telefono Fijo:
			</label>
			<label class="campo-no-editable">
				<?php echo $usuario['telefono_fijo']; ?>
			</label>
		</div>
		<div class="items">
			<label class="etiquetas">
				Telefono M&oacute;vil:
			</label>
			<label class="campo-no-editable">
				<?php echo $usuario['telefono_movil']; ?>
			</label>
		</div>
		<div class="grupo-control contenido-izquierda">
			<button id="btn_logout">Salir del sistema</button>
		</div>
	</div>
	<div id="panelUsuariotabs-2">
		<div class="items">
			<label for="ClaveActual" class="etiquetas">
				Clave actual:
			</label>
			<input class="input-grande" type="password" id="ClaveActual"/>
		</div>
		<div class="items" >
			<label for="NuevaClave" class="etiquetas">
				Nueva clave:
			</label>			
			<input class="input-grande" type="password" id="NuevaClave"/>
		</div>
		<div class="items">
			<label for="Confirmar" class="etiquetas">
				Confirmar:
			</label>			
			<input class="input-grande" type="password" id="Confirmar"/>
		</div>
		<div class="grupo-control contenido-izquierda">
			<button id="btn_cambiar_clave">Realizar cambio</button>
		</div>
	</div>
	<div id="panelUsuariotabs-3">
        <div class="items">
            <label for="PrimerNombre" class="etiquetas">
                Primer Nombre:
            </label>
            <input class="input-xxgrande" type="text" id="PrimerNombre" value="<?php echo htmlentities( utf8_decode($usuario['primer_nombre']) ); ?>"/>
            <div id="error_PrimerNombreUsuario_mod" class="ui-state-error ui-corner-all" style="display: inline-block;margin-top:4px;">
            </div>
        </div> 
        <div class="items">
            <label for="SegundoNombre" class="etiquetas">
                Segundo Nombre:
            </label>
            <input class="input-xxgrande" type="text" id="SegundoNombre" value="<?php echo htmlentities( utf8_decode($usuario['segundo_nombre']) ); ?>"/>
            <div id="error_SegundoNombreUsuario_mod" class="ui-state-error ui-corner-all" style="display: inline-block;margin-top:4px;">
            </div>
        </div> 
        <div class="items">
            <label for="PrimerApellido" class="etiquetas">
                Primer Apellido:
            </label>
            <input class="input-xxgrande" type="text" id="PrimerApellido" value="<?php echo htmlentities( utf8_decode($usuario['primer_apellido']) ); ?>"/>
            <div id="error_PrimerApellidoUsuario_mod" class="ui-state-error ui-corner-all" style="display: inline-block;margin-top:4px;">
            </div>
        </div>
        <div class="items">
            <label for="SegundoApellido" class="etiquetas">
                SegundoApellido:
            </label>
            <input class="input-xxgrande" type="text" id="SegundoApellido" value="<?php echo htmlentities( utf8_decode($usuario['segundo_apellido']) ); ?>"/>
            <div id="error_SegundoApellidoUsuario_mod" class="ui-state-error ui-corner-all" style="display: inline-block;margin-top:4px;">
            </div>
        </div>
        <div class="items">
            <label for="CorreoElectronico" class="etiquetas">
                Correo Electronico:
            </label>
            <input class="input-xxgrande" type="text" id="CorreoElectronico" value="<?php echo $usuario['correo_electronico']; ?>"/>
            <div id="error_CorreoElectronicoUsuario_mod" class="ui-state-error ui-corner-all" style="display: inline-block;margin-top:4px;">
            </div>
        </div>
        <div class="items">
            <label for="TelefonoFijo" class="etiquetas">
                Telefono Fijo:
            </label>
            <input class="input-grande" type="text" id="TelefonoFijo" value="<?php echo $usuario['telefono_fijo'];?>"/>
            <br/>
            <div id="error_TelefonoFijoUsuario_mod" class="ui-state-error ui-corner-all" style="display: inline-block;margin-top:4px;">
            </div>
        </div>
        <div class="items">
            <label for="TelefonoMovil" class="etiquetas">
                Telefono Movil:
            </label>
            <input class="input-grande" type="text" id="TelefonoMovil" value="<?php echo $usuario['telefono_movil']; ?>"/>
            <br/>
            <div id="error_TelefonoMovilUsuario_mod" class="ui-state-error ui-corner-all" style="display: inline-block;margin-top:4px;">
            </div>
        </div>
        <div class="grupo-control contenido-izquierda">
            <button id="btn_guardar_mi_perfil">Guardar cambio(s)</button>
        </div>
    </div>

    <script type="text/javascript">
        $( "#PanelPerfilUsuario" ).tabs();
       
        $('#btn_logout').click(function(){
            $.ajax({
                type: "POST",
                url: "cerrar_sesion.php",
                success: function(){
                    window.location.reload();
                }
            });
        });
       
        $('#btn_guardar_mi_perfil').click(function(){
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "modificar_perfil_usuario.php",
                data: {
                    primer_nombre			: $.trim($('#PrimerNombre').val()),
                    segundo_nombre			: $.trim($('#SegundoNombre').val()),
                    primer_apellido			: $.trim($('#PrimerApellido').val()),
                    segundo_apellido		: $.trim($('#SegundoApellido').val()),
                    correo_electronico		: $.trim($('#CorreoElectronico').val()),
                    telefono_fijo			: $.trim($('#TelefonoFijo').val()),
                    telefono_movil			: $.trim($('#TelefonoMovil').val())
                },
                error: function(){
					$.fancybox.close(true);
                    var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu coneccion este fallando. Porfavor, intentalo de nuevo.</p>";
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
                success: function(response){
                    if (response.refresh_error){
						$.fancybox.close(true);
                        $( "#dialogWindow" ).html(response.refresh_error);
						$( "#dialogWindow" ).dialog({
							title   : 'Problemas',
							modal   : true,
							buttons : {
								"Ok": function() {
									window.location.reload();
								}
							},
							minWidth: 600,
							resizable: false
						});						
                    }else if (response.errores){
                        $('div[id^="error_"]').html('');
                        for(var key in response.errores){
                            $('#error_' + key).html('<p>' + response.errores[key] + '</p>');               
                        }
                    }else{
                        $('div[id^="error_"]').html('');
                        $.fancybox.close(true);
						$( "#dialogWindow" ).html("Cambios realizados con éxito.");
						$( "#dialogWindow" ).dialog({
							title   : 'Éxito',
							modal   : true,
							buttons : {
								"Ok": function() {
									$(this).dialog("close");
								}
							},
							minWidth: 600,
							resizable: false
						});
                    }
                }
            });
        });
       
        $(function(){
            $('#btn_logout').button({
                icons: {
                    primary: "ui-icon-locked"
                }
            });
            $('#btn_cambiar_clave, #btn_guardar_mi_perfil').button({
                icons: {
                    primary: "ui-icon-check"
                }
            });
        });
    </script>
</div>