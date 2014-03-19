<?php
include '../phpIncluidos/conexion.php';

$patron_titulo = '/^[a-zA-Z0-9ÁáÉéÍíÓóÚúñÑ()\-.,:" ]+$/';
$patron_titulo_err = 'Solo puedes ingresar caracteres de la a-z y caracteres numericos.';
$patron_descripcion = $patron_titulo;
$patron_descripcion_err = 'Solo puedes ingresar caracteres de la a-z y caracteres numericos.';

$response = array();
$errores = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!ISSET($_POST['id']) || !ISSET($_POST['titulo']) || !ISSET($_POST['descripcion'])){
		$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acciÃƒÂ³n de nuevo.';
	}else{
		if (!($titulo = trim($_POST['titulo']))){
			$errores['TituloTipoEducacion_mod'] = 'Escriba aqui el titulo del tipo de educacion.';
		}else{
			if (!preg_match($patron_titulo, $titulo)){
				$errores['TituloTipoEducacion_mod'] = $patron_titulo_err;
			}
		}
		
		if (!($descripcion = trim($_POST['descripcion']))){
			$errores['DescripcionTipoEducacion_mod'] = 'Escriba aqui la descripcion del tipo de educacion.';
		}else{
			if (!preg_match($patron_descripcion, $descripcion)){
				$errores['DescripcionTipoEducacion_mod'] = $patron_descripcion_err;
			}
		}
		
		if (sizeof($errores) == 0){					
			$idTipoEducacion = $_POST['id'];
			$usuario_modificador_id = $_SESSION['usuario']['id'];
			
			
			
			$stmt_modificar_tipo_educacion = $conn->prepare("UPDATE siee_tipo_educacion SET
													titulo = ?,
													descripcion = ?,
													usuario_modificador_id = ?,
													fecha_modificacion = CURRENT_TIMESTAMP
												WHERE id = ?;");
			
			
			$stmt_modificar_tipo_educacion->bindParam(1, utf8_decode($titulo));
			$stmt_modificar_tipo_educacion->bindParam(2, utf8_decode($descripcion));
			$stmt_modificar_tipo_educacion->bindParam(3, $usuario_modificador_id);
			$stmt_modificar_tipo_educacion->bindParam(4, $idTipoEducacion);
			
			$conn->exec('BEGIN TRANSACTION');
			
			try {				
				if (!$stmt_modificar_tipo_educacion->execute()){
					// aqui se detecatron errores al tratar de guardar los datos en la base de datos.
					$conn->exec('ROLLBACK TRANSACTION');
					$response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos estÃƒÂ© ocupada en este momento. Porfavor, intentalo de nuevo.';
				}else{
					$conn->exec('COMMIT TRANSACTION');
				}
			} catch (PDOException $e) {
				$conn->exec('ROLLBACK TRANSACTION');
				$stmt_modificar_tipo_educacion->closeCursor();
				// enviar html de errores o js function que ejecute el mensaje de errores
				$response['refresh_error'] = 'Hubo un error al tratar de insertar los datos en la base de datos. Porfavor, intentalo de nuevo.';
			}
		}
	}
}else{
	$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acciÃƒÂ³n de nuevo.';
}

if (sizeof($errores) > 0){
	$response['errores'] = $errores;
}

echo json_encode($response);
?>
