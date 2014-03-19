<?php
include '../phpIncluidos/conexion.php';

$patron_nombres = '/^[a-zA-ZáÁéÉíÍóÓúÚ]+$/';
$patron_usuario = '/^[a-zA-Z0-9áÁéÉíÍóÓúÚ._-]+$/';
$patron_telefono = '/^[0-9]+$/';
$patron_correo = '/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9_.-]+.[a-zA-Z0-9_.-]+$/';

$response = array();
$errores = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (!ISSET($_POST['primer_nombre'])){
		$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, por favor refresca la página y realiza esta acción de nuevo.';
		echo json_encode($response);
		return;
	}else{
		if ($_POST['primer_nombre'] == ''){
			$errores['PrimerNombreUsuario'] = 'Escriba aqui el primer nombre de la persona.';
		}else{
			$primer_nombre = trim($_POST['primer_nombre']);
			
			if (!preg_match($patron_nombres, $primer_nombre)){
				$errores['PrimerNombreUsuario'] = 'Solo puedes ingresar caracteres a-z, A-Z y letras acentuadas';
			}else{
				// ok
			}
		}
	}
	
	if (!ISSET($_POST['segundo_nombre'])){
		$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, por favor refresca la página y realiza esta acción de nuevo.';
		echo json_encode($response);
		return;
	}else{
		if (!$_POST['segundo_nombre'] == ''){
			$segundo_nombre = trim($_POST['segundo_nombre']);
			
			if (!preg_match($patron_nombres, $segundo_nombre)){
				$errores['SegundoNombreUsuario'] = 'Solo puedes ingresar caracteres a-z, A-Z y letras acentuadas';
			}
		}else{
			$segundo_nombre = '';
		}
	}
	
	if (!ISSET($_POST['primer_apellido'])){
		$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, por favor refresca la pagina y realiza esta acción de nuevo.';
		echo json_encode($response);
		return;
	}else{
		if ($_POST['primer_apellido'] == ''){
			$errores['PrimerApellidoUsuario'] = 'Escriba aqui el primer apellido de la persona.';
		}else{
			$primer_apellido = trim($_POST['primer_apellido']);
			
			if (!preg_match($patron_nombres, $primer_apellido)){
				$errores['PrimerApellidoUsuario'] = 'Solo puedes ingresar caracteres a-z, A-Z y letras acentuadas';
			}else{
				// ok	
			}
		}
	}
	
	if (!ISSET($_POST['segundo_apellido'])){
		$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, por favor refresca la pagina y realiza esta acción de nuevo.';
		echo json_encode($response);
		return;
	}else{
		if (!$_POST['segundo_apellido'] == ''){
			$segundo_apellido = trim($_POST['segundo_apellido']);
			
			if (!preg_match($patron_nombres, $segundo_apellido)){
				$errores['SegundoApellidoUsuario'] = 'Solo puedes ingresar caracteres a-z, A-Z y letras acentuadas';
			}
		}else{
			$segundo_apellido = '';
		}
	}
	
	if (!ISSET($_POST['nombre_usuario'])){
		$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, por favor refresca la pagina y realiza esta acción de nuevo.';
		echo json_encode($response);
		return;
	}else{
		if ($_POST['nombre_usuario'] == ''){
			$errores['NombreUsuario'] = 'Escriba aqui el nombre de usuario del sistema para esta persona.';
		}else{
			$nombre_usuario = trim($_POST['nombre_usuario']);
			
			if (strlen($nombre_usuario) < 3){
				$errores['NombreUsuario'] = 'El nombre de usuario debe tener al menos 3 caracteres.';
			}else{
				if (!preg_match($patron_usuario, $nombre_usuario)){
					$errores['NombreUsuario'] = 'Solo puedes ingresar caracteres de la a-z, letras acentuadas mayusculas y/o minusculas, ., -, _';
				}else{
					//	ok
				}
			}
		}
	}
	
	if (!ISSET($_POST['rol_id'])){
		$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, por favor refresca la pagina y realiza esta acción de nuevo.';
		echo json_encode($response);
		return;
	}else{
		if ($_POST['rol_id'] == '' || $_POST['rol_id'] == '-1'){
			$errores['RolUsuario'] = 'Seleccione un rol.';
		}else{
			$rol_id = $_POST['rol_id'];
		}
	}
	
	if (!ISSET($_POST['telefono_fijo'])){
		$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, por favor refresca la pagina y realiza esta acción de nuevo.';
		echo json_encode($response);
		return;
	}else{
		if (!$_POST['telefono_fijo'] == ''){
			$telefono_fijo = trim($_POST['telefono_fijo']);
			
			if (strlen($telefono_fijo) < 8){
				$errores['TelefonoFijoUsuario'] = 'El teléfono fijo debe tener al menos 8 caracteres.';
			}else{
				if (!preg_match($patron_telefono, $telefono_fijo)){
					$errores['TelefonoFijoUsuario'] = 'Solo puedes ingresar caracteres numericos (0-9).';
				}else{
					// ok
				}
			}
		}else{
			$telefono_fijo = '';
		}
	}
	
	if (!ISSET($_POST['telefono_movil'])){
		$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, por favor refresca la página y realiza esta acción de nuevo.';
		echo json_encode($response);
		return;
	}else{
		if (!$_POST['telefono_movil'] == ''){
			$telefono_movil = trim($_POST['telefono_movil']);
			
			if (strlen($telefono_movil) < 8){
				$errores['TelefonoMovilUsuario'] = 'El teléfono móvil debe tener al menos 8 caracteres.';
			}else{
				if (!preg_match($patron_telefono, $telefono_movil)){
					$errores['TelefonoMovilUsuario'] = 'Solo puedes ingresar caracteres numericos (0-9).';
				}else{
					// ok
				}
			}
		}else{
			$telefono_movil = '';
		}
	}
	
	if (!ISSET($_POST['correo_electronico'])){
		$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, por favor refresca la página y realiza esta acción de nuevo.';
		echo json_encode($response);
		return;
	}else{
		if ($_POST['correo_electronico'] == ''){
			$errores['CorreoElectronicoUsuario'] = 'Escriba aqui el correo electronico del usuario.';
		}else{
			$correo_electronico = trim($_POST['correo_electronico']);
			
			if (!preg_match($patron_correo, $correo_electronico)){
				$errores['CorreoElectronicoUsuario'] = 'El formato del correo electronico debe ser \'nombre@ejemplo.com\'.';
			}else{
				//	ok
			}
		}
	}
	
	if (sizeof($errores) == 0){
		$activo = 0;
		$oculto = 0;
		$usuario_creador_id = $_SESSION['usuario']['id'];
        $usuario_modificador_id = $_SESSION['usuario']['id'];
        $path_imagen = 'path/de/imagen.jpg';
		
		$stmt_insertar_usuario = $conn->prepare("INSERT INTO siee_usuario (primer_nombre
																			,segundo_nombre
																			,primer_apellido
																			,segundo_apellido
																			,nombre_usuario
																			,clave_acceso
																			,rol_id
																			,telefono_fijo
																			,telefono_movil
																			,correo_electronico
																			,imagen_perfil_url
																			,activo
																			,oculto
																			,usuario_creador_id
																			,fecha_creacion
																			,usuario_modificador_id
																			,fecha_modificacion)
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '2012', ?, '2012');");
		
		$stmt_insertar_usuario->bindParam(1, utf8_decode($primer_nombre));
		$stmt_insertar_usuario->bindParam(2, utf8_decode($segundo_nombre));
		$stmt_insertar_usuario->bindParam(3, utf8_decode($primer_apellido));
		$stmt_insertar_usuario->bindParam(4, utf8_decode($segundo_apellido));
		$stmt_insertar_usuario->bindParam(5, utf8_decode($nombre_usuario));
		$stmt_insertar_usuario->bindParam(6, md5(utf8_decode($nombre_usuario)));	//contrasena por default cuando se registra por primera vez, mismo que el username
		$stmt_insertar_usuario->bindParam(7, $rol_id);
		$stmt_insertar_usuario->bindParam(8, $telefono_fijo);
		$stmt_insertar_usuario->bindParam(9, $telefono_movil);
		$stmt_insertar_usuario->bindParam(10, utf8_decode($correo_electronico));
		$stmt_insertar_usuario->bindParam(11, $path_imagen);
		$stmt_insertar_usuario->bindParam(12, $activo);
		$stmt_insertar_usuario->bindParam(13, $oculto);
		$stmt_insertar_usuario->bindParam(14, $usuario_creador_id);
		$stmt_insertar_usuario->bindParam(15, $usuario_modificador_id);
        
		$conn->exec('BEGIN TRANSACTION');
		
		try {				
            if (!$stmt_insertar_usuario->execute()){
                // aqui se detecatron errores al tratar de guardar los datos en la base de datos.
                $conn->exec('ROLLBACK TRANSACTION');
				$response['refresh_error'] =  'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos este ocupada en este momento. Por favor, intentalo de nuevo en un momento.';
            }else{
				$conn->exec('COMMIT TRANSACTION');
			}
        } catch (PDOException $e) {
            $conn->exec('ROLLBACK TRANSACTION');
            $stmt_insertar_usuario->closeCursor();
            // enviar html de errores o js function que ejecute el mensaje de errores
            $response['refresh_error'] = 'Hubo un error al tratar de insertar los datos en la base de datos. Por favor, intentalo de nuevo.';
        }
	}
}else{
	$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, por favor refresca la pagina y realiza esta acción de nuevo.';
}

if (sizeof($errores) > 0){
    $response['errores'] = $errores;
}

echo json_encode($response);
?>
