<?php
include '../phpIncluidos/conexion.php';

$patron_nombres = '/^[a-zA-ZáÁéÉíÍóÓúÚ]+$/';
$patron_usuario = '/^[a-zA-Z0-9áÁéÉíÍóÓúÚ._-]+$/';
$patron_telefono = '/^[0-9]+$/';
$patron_correo = '/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9_.-]+.[a-zA-Z0-9_.-]+$/';
$patron_nombres_err = 'Solo puedes ingresar caracteres a-z, A-Z y letras acentuadas.';
$patron_usuario_err = 'Solo puedes ingresar caracteres de la a-z, letras acentuadas mayusculas y/o minusculas, ., -, _';
$patron_telefono_err = 'Solo puedes ingresar caracteres numericos (0-9).';
$patron_correo_err = 'El formato del correo electronico debe ser \'nombre@ejemplo.com\'.';

$response = array();
$errores = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!ISSET($_POST['id']) || !ISSET($_POST['primer_nombre']) || !ISSET($_POST['segundo_nombre']) || !ISSET($_POST['primer_apellido']) || !ISSET($_POST['segundo_apellido']) || !ISSET($_POST['nombre_usuario']) || !ISSET($_POST['telefono_fijo']) || !ISSET($_POST['telefono_movil']) || !ISSET($_POST['correo_electronico'])){
		$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, por favor refresca la pagina y realiza esta acción de nuevo.';
	}else{
		if (!($primer_nombre = trim($_POST['primer_nombre']))){
			$errores['PrimerNombreUsuario_mod'] = 'Escriba aqui el primer nombre de este usuario.';
		}else{
			if (!preg_match($patron_nombres, $primer_nombre)){
				$errores['PrimerNombreUsuario_mod'] = $patron_nombres_err;
			}
		}
		
		if (($segundo_nombre = trim($_POST['segundo_nombre']))){
			if (!preg_match($patron_nombres, $segundo_nombre)){
				$errores['SegundoNombreUsuario_mod'] = $patron_nombres_err;
			}
		}
		
		if (!($primer_apellido = trim($_POST['primer_apellido']))){
			$errores['PrimerApellidoUsuario_mod'] = 'Escriba aqui el primer apellido de este usuario.';
		}else{
			if (!preg_match($patron_nombres, $primer_apellido)){
				$errores['PrimerApellidoUsuario_mod'] = $patron_nombres_err;
			}
		}
		
		if (($segundo_apellido = trim($_POST['segundo_apellido']))){
			if (!preg_match($patron_nombres, $segundo_apellido)){
				$errores['SegundoApellidoUsuario_mod'] = 'Solo puedes ingresar caracteres a-z, A-Z y letras acentuadas.';
			}
		}
		
		if (!($nombre_usuario = trim($_POST['nombre_usuario']))){
			$errores['NombreUsuario_mod'] = 'Escriba aqui el nombre de usuario.';
		}else{
			if (!preg_match($patron_usuario, $nombre_usuario)){
				$errores['NombreUsuario_mod'] = $patron_usuario_err;
			}else{
				if (strlen($nombre_usuario) < 3){
					$errores['NombreUsuario_mod'] = 'El nombre de usuario debe tener al menos 3 caracteres.';
				}
			}
		}
		
		if (($telefono_fijo = trim($_POST['telefono_fijo']))){
			if (strlen($telefono_fijo) < 8){
				$errores['TelefonoFijoUsuario_mod'] = 'El teléfono fijo debe tener al menos 8 caracteres.';
			}else{
				if (!preg_match($patron_telefono, $telefono_fijo)){
					$errores['TelefonoFijoUsuario_mod'] = $patron_telefono_err;
				}
			}
		}
		
		if (($telefono_movil = trim($_POST['telefono_movil']))){
			if (strlen($telefono_movil) < 8){
				$errores['TelefonoMovilUsuario_mod'] = 'El teléfono móvil debe tener al menos 8 caracteres.';
			}else{
				if (!preg_match($patron_telefono, $telefono_movil)){
					$errores['TelefonoMovilUsuario_mod'] = $patron_telefono_err;
				}
			}
		}
		
		if (!($correo_electronico = trim($_POST['correo_electronico']))){
			$errores['CorreoElectronicoUsuario_mod'] = 'Escriba aqui el correo electrónico del usuario.';
		}else{
			if (!preg_match($patron_correo, $correo_electronico)){
				$errores['CorreoElectronicoUsuario_mod'] = $patron_correo_err;
			}
		}
		
		
		//FALTA VALIDACION DE LA IMAGEN QUE VA AQUI!//
		//FALTA VALIDACION DE LA IMAGEN QUE VA AQUI!//
		//FALTA VALIDACION DE LA IMAGEN QUE VA AQUI!//
		$imagen_perfil_url = 'path/de/imagen.jpg';
		//FALTA VALIDACION DE LA IMAGEN QUE VA AQUI!//
		//FALTA VALIDACION DE LA IMAGEN QUE VA AQUI!//
		//FALTA VALIDACION DE LA IMAGEN QUE VA AQUI!//
		
		if (sizeof($errores) == 0){
			$idUsuario = $_POST['id'];
			$rol_id = $_POST['rol_id'];
			$usuario_modificador = $_SESSION['usuario']['id'];
			
			$stmt_modificar_usuario = $conn->prepare("UPDATE siee_usuario SET 
														primer_nombre = ?,
														segundo_nombre = ?,
														primer_apellido = ?,
														segundo_apellido = ?,
														nombre_usuario = ?,
														rol_id = ?,
														telefono_fijo = ?,
														telefono_movil = ?,
														correo_electronico = ?,
														imagen_perfil_url = ?,
														usuario_modificador_id = ?,
														fecha_modificacion = CURRENT_TIMESTAMP
													WHERE id = ?;");
			
			$stmt_modificar_usuario->bindParam(1, utf8_decode($primer_nombre));
			$stmt_modificar_usuario->bindParam(2, utf8_decode($segundo_nombre));
			//$stmt_modificar_usuario->bindValue(2, ($segundo_nombre == null ? 'NULL':utf8_encode($segundo_nombre)));
			$stmt_modificar_usuario->bindParam(3, utf8_decode($primer_apellido));
			$stmt_modificar_usuario->bindParam(4, utf8_decode($segundo_apellido));
			$stmt_modificar_usuario->bindParam(5, utf8_decode($nombre_usuario));
			$stmt_modificar_usuario->bindParam(6, $rol_id);
			$stmt_modificar_usuario->bindParam(7, utf8_decode($telefono_fijo));
			$stmt_modificar_usuario->bindParam(8, utf8_decode($telefono_movil));
			$stmt_modificar_usuario->bindParam(9, utf8_decode($correo_electronico));
			$stmt_modificar_usuario->bindParam(10, utf8_decode($imagen_perfil_url));
			$stmt_modificar_usuario->bindParam(11, $usuario_modificador);
			$stmt_modificar_usuario->bindParam(12, $idUsuario);
			
			$conn->exec('BEGIN TRANSACTION');
			
			try {				
				if (!$stmt_modificar_usuario->execute()){
					// aqui se detecatron errores al tratar de guardar los datos en la base de datos.
					$conn->exec('ROLLBACK TRANSACTION');
					$response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos este ocupada en este momento. Por favor, intentalo de nuevo en un momento.';
				}else{
					$conn->exec('COMMIT TRANSACTION');
				}
			} catch (PDOException $e) {
				$conn->exec('ROLLBACK TRANSACTION');
				$stmt_modificar_usuario->closeCursor();
				// enviar html de errores o js function que ejecute el mensaje de errores
				$response['refresh_error'] = 'Hubo un error al tratar de insertar los datos en la base de datos. Por favor, intentalo de nuevo.';
			}
		}
	}
}else{
	$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, por favor refresca la página y realiza esta acción de nuevo.';
}

if (sizeof($errores) > 0){
	$response['errores'] = $errores;
}

echo json_encode($response);
?>
