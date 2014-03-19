<?php
include '../phpIncluidos/conexion.php';

$patron_titulo = '/^[a-zA-Z0-9áÁéÉíÍóÓúÚ ]+$/';
$patron_titulo_err = 'Solo puedes ingresar caracteres de la a-zA-Z, tildes y caracteres numericos.';
$patron_abreviatura = '/^[a-zA-Z0-9 ]+$/';
$patron_abreviatura_err = 'Solo puedes ingresar caracteres de la a-zA-Z y caracteres numericos.';
$patron_descripcion = '/^[a-zA-Z0-9áÁéÉíÍóÓúÚ,.(); ]+$/';
$patron_descripcion_err = 'Solo puedes ingresar caracteres de la a-zA-Z, puntos, comas, tildes, parentesis y caracteres numericos.';

$response = array();
$errores = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!ISSET($_POST['titulo']) || !ISSET($_POST['descripcion']) || !ISSET($_POST['abreviatura']) || !ISSET($_POST['url'])){
		$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acción de nuevo.';
	}else{
		if (!($titulo = trim($_POST['titulo']))){
			$errores['TituloSubsitio'] = 'Escriba aqui el titulo del subsitio.';
		}else{
			if (!preg_match($patron_titulo, $titulo)){
				$errores['TituloSubsitio'] = $patron_titulo_err;
			}
		}
		
		if (!($descripcion = trim($_POST['descripcion']))){
			$errores['DescripcionSubsitio'] = 'Escriba aqui la descripcion del subsitio.';
		}else{
			if (!preg_match($patron_descripcion, $descripcion)){
				$errores['DescripcionSubsitio'] = $patron_descripcion_err;
			}
		}
		
		if (!($abreviatura = strtoupper(trim($_POST['abreviatura'])))){
			$errores['AbreviaturaSubsitio'] = 'Escriba aqui la abreviatura del subsitio.';
		}else{
			if (!preg_match($patron_abreviatura, $abreviatura)){
				$errores['AbreviaturaSubsitio'] = $patron_abreviatura_err;
			}
		}
		
		if (!($url = trim($_POST['url']))){
			$errores['UrlSubsitio'] = 'Escriba aqui el URL del subsitio.';
		}
		
		if (sizeof($errores) == 0){					
			$activo = 0;
			$usuario_creador_id = $_SESSION['usuario']['id'];
			$usuario_modificador_id = $_SESSION['usuario']['id'];
			
			$stmt_insertar_subsitio = $conn->prepare("INSERT INTO siee_subsitio (titulo, abreviatura, descripcion, url, activo, usuario_creador_id, fecha_creacion, usuario_modificador_id, fecha_modificacion) VALUES (
													?,
													?,
													?,
													?,
													?,
													?,
													CURRENT_TIMESTAMP,
													?,
													CURRENT_TIMESTAMP);");
			
			$stmt_insertar_subsitio->bindParam(1, utf8_decode($titulo));
			$stmt_insertar_subsitio->bindParam(2, utf8_decode($abreviatura));
			$stmt_insertar_subsitio->bindParam(3, utf8_decode($descripcion));
			$stmt_insertar_subsitio->bindParam(4, utf8_decode($url));
			$stmt_insertar_subsitio->bindParam(5, $activo);
			$stmt_insertar_subsitio->bindParam(6, $usuario_creador_id);
			$stmt_insertar_subsitio->bindParam(7, $usuario_modificador_id);

			
			$conn->exec('BEGIN TRANSACTION');
			
			try {				
				if (!$stmt_insertar_subsitio->execute()){
					// aqui se detecatron errores al tratar de guardar los datos en la base de datos.
					$conn->exec('ROLLBACK TRANSACTION');
					$response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos está ocupada en este momento. Porfavor, intentalo de nuevo.';
				}else{
					$conn->exec('COMMIT TRANSACTION');
				}
			} catch (PDOException $e) {
				$conn->exec('ROLLBACK TRANSACTION');
				$stmt_insertar_subsitio->closeCursor();
				// enviar html de errores o js function que ejecute el mensaje de errores
				$response['refresh_error'] = 'Hubo un error al tratar de insertar los datos en la base de datos. Porfavor, intentalo de nuevo.';
			}
		}
	}
}else{
	$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la página y realiza esta acción de nuevo.';
}

if (sizeof($errores) > 0){
	$response['errores'] = $errores;
}

echo json_encode($response);
?>
