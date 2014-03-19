<?php
// put your code here
?>
<div id="contenedorLogin" class="login-siee" method="POST">
    <div class="panel-izquierdo">
        <p class="encabezado">Inicio de Sesion - SIEE</p>
        <div class="cuerpo">
            <div id="Error" class="ui-widget">
			</div>

			<ul id="errorNombreUsuario" class="errores_por_campo">
			</ul>
			<label for="NombreUsuario">Usuario : </label>
			<input id="NombreUsuario" type="text" placeHolder="Ingrese aqui su nombre de usuario" />

			<ul id="errorContrasenia" class="errores_por_campo"/>
			<label for="ClaveAcceso">Contrase&ntilde;a : </label>
			<input id="ClaveAcceso" type="password" placeHolder="Escriba aqui su contrase&ntilde;a"/>
        </div>
        <p class="controles">
            <button id="SubmitLogin" class="botonLogin">Ingresar al Sistema</button>
            <a href="#">Olvide mi contrase&ntilde;a</a>
        </p>
    </div>
    <div class="panel-derecho">
        <p class="encabezado">No tengo una cuenta</p>
        <p class="cuerpo">
            Si no tienes una cuenta, puedes solicitar una al administrador del SIEE,
            para de esta manera poder comentar/opinar en los diferentes indicadores.
        </p>
        <p class="controles">
			<button id="SolicitarCuenta" class="botonSolicitar">Solicitar Cuenta</button>             
        </p>
    </div>
</div>

<script type="text/javascript">
	$('#NombreUsuario, #ClaveAcceso').keyup(function(e){
		var code = (e.keyCode ? e.keyCode : e.which);
		if(code == 13) {
			$('#SubmitLogin').trigger('click');
		}
	});
	$('#SubmitLogin').click(
	function(){
		var _nombre_usuario = $.trim($('#NombreUsuario').val()); 
		var _clave_acceso = $.trim($('#ClaveAcceso').val()); 
			
		$.ajax({
			type: "POST",
			url: "/SIEE/autenticacion.php",
			cache: false,
			dataType : 'json',
			async : false,
			data: {
				nombre_usuario		:_nombre_usuario,
				clave_acceso		:_clave_acceso
			},
			error: function(){
				$('#Error').html('<div style="padding: 0 .7em;font-size:0.8em;" class="ui-state-error ui-corner-all">' +
					'<p>' +
					'<span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert">' +
					'</span>' +
					'<strong>' +
					'Error:' +
					'</strong>' +
					'No se pudo iniciar sesion en este momento' +
					'</p>' +
					'</div>');
			},
			success: function(response)
			{
				if(response['autenticado'] == true){
					/*$.fancybox.close(true);
					$('#btn_iniciarSesion').attr('id',"btn_perfil").attr("value", "Hola, " + response['usuario']['nombre_usuario']);
					$("#btn_perfil").fancybox({
						'overlayShow'	: true,
						'transitionIn'	: 'elastic',
						'transitionOut'	: 'elastic',
						'overlayColor'  :   '#000',
						'easingIn'      :   'swing',
						'easingOut'     :   'swing',
						'autoDimensions':   true,
						'centerOnScroll':   true,
						'href'          :   'panel_perfil_usuario.php'
					});*/
					window.location.reload();
				}else{
					$('#Error').html('<div style="padding: 0 .7em;font-size:0.8em;" class="ui-state-error ui-corner-all">' +
						'<p>' +
						'<span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert">' +
						'</span>' +
						'<strong>' +
						'Error:' +
						'</strong>' +
						'Nombre de usuario o contrase&ntilde;a incorreta' +
						'</p>' +
						'</div>');
				}
			}
		});

	}
);
</script>