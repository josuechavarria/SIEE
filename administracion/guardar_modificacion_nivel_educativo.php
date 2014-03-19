<?php
include '../phpIncluidos/conexion.php';

$patron_titulo = '/^[a-zA-Z0-9 ]+$/';
$patron_titulo_err = 'Solo puedes ingresar caracteres de la a-z y caracteres numericos.';
$patron_descripcion = '/^[a-zA-Z0-9 ]+$/';
$patron_descripcion_err = 'Solo puedes ingresar caracteres de la a-z y caracteres numericos.';

$response = array();
$errores = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!ISSET($_POST['id']) || !ISSET($_POST['titulo']) || !ISSET($_POST['descripcion'])){
		$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acciÃƒÂ³n de nuevo.';
	}else{
		if (!($titulo = trim($_POST['titulo']))){
			$errores['TituloNivelEducativo_mod'] = 'Escriba aqui el titulo del nivel educativo.';
		}else{
			if (!preg_match($patron_titulo, $titulo)){
				$errores['TituloNivelEducativo_mod'] = $patron_titulo_err;
			}
		}
		
		if (!($descripcion = trim($_POST['descripcion']))){
			$errores['DescripcionNivelEducativo_mod'] = 'Escriba aqui la descripcion del nivel educativo.';
		}else{
			if (!preg_match($patron_descripcion, $descripcion)){
				$errores['DescripcionNivelEducativo_mod'] = $patron_descripcion_err;
			}
		}
		
		if (sizeof($errores) == 0){					
			$idNivelEducativo = $_POST['id'];
			$usuario_modificador_id = $_SESSION['usuario']['id'];
			
			
			
			$stmt_modificar_nivel_educativo = $conn->prepare("UPDATE siee_nivel_educativo SET
													titulo = ?,
													descripcion = ?,
													usuario_modificador_id = ?,
													fecha_modificacion = CURRENT_TIMESTAMP
												WHERE id = ?;");
			
			
			$stmt_modificar_nivel_educativo->bindParam(1, utf8_encode($titulo));
			$stmt_modificar_nivel_educativo->bindParam(2, utf8_encode($descripcion));
			$stmt_modificar_nivel_educativo->bindParam(3, $usuario_modificador_id);
			$stmt_modificar_nivel_educativo->bindParam(4, $idNivelEducativo);
			
			$conn->exec('BEGIN TRANSACTION');
			
			try {				
				if (!$stmt_modificar_nivel_educativo->execute()){
					// aqui se detecatron errores al tratar de guardar los datos en la base de datos.
					$conn->exec('ROLLBACK TRANSACTION');
					$response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos estÃƒÂ© ocupada en este momento. Porfavor, intentalo de nuevo.';
				}else{
					$conn->exec('COMMIT TRANSACTION');
				}
			} catch (PDOException $e) {
				$conn->exec('ROLLBACK TRANSACTION');
				$stmt_modificar_nivel_educativo->closeCursor();
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
