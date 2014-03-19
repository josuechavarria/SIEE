<?php
include '../phpIncluidos/conexion.php';

$patron_titulo = '/^[a-zA-Z0-9áÁéÉíÍóÓúÚ ]+$/';
$patron_titulo_err = 'Solo puedes ingresar caracteres de la a-zA-Z, tildes y caracteres numericos.';
$patron_abreviatura = '/^[a-zA-Z0-9 ]+$/';
$patron_abreviatura_err = 'Solo puedes ingresar caracteres de la a-zA-Z y caracteres numericos.';
$patron_descripcion = '/^[a-zA-Z0-9áÁéÉíÍóÓúÚ,.(); ]+$/';
$patron_descripcion_err = 'Solo puedes ingresar caracteres de la a-zA-Z, puntos, comas, tildes y caracteres numericos.';

$response = array();
$errores = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!ISSET($_POST['id']) || !ISSET($_POST['titulo']) || !ISSET($_POST['abreviatura']) || !ISSET($_POST['descripcion']) || !ISSET($_POST['url'])){
		$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acciÃƒÂ³n de nuevo.';
	}else{
		if (!($titulo = trim($_POST['titulo']))){
			$errores['TituloSubsitio_mod'] = 'Escriba aqui el titulo del subsitio.';
		}else{
			if (!preg_match($patron_titulo, $titulo)){
				$errores['TituloSubsitio_mod'] = $patron_titulo_err;
			}
		}
		
		if (!($descripcion = trim($_POST['descripcion']))){
			$errores['DescripcionSubsitio_mod'] = 'Escriba aqui la descripcion del subsitio.';
		}else{
			if (!preg_match($patron_descripcion, $descripcion)){
				$errores['DescripcionSubsitio_mod'] = $patron_descripcion_err;
			}
		}
		
		if (!($abreviatura = strtoupper(trim($_POST['abreviatura'])))){
			$errores['AbreviaturaSubsitio_mod'] = 'Escriba aqui la abreviatura del subsitio.';
		}else{
			if (!preg_match($patron_abreviatura, $abreviatura)){
				$errores['AbreviaturaSubsitio_mod'] = $patron_abreviatura_err;
			}
		}
		
		if (!($url = trim($_POST['url']))){
			$errores['UrlSubsitio_mod'] = 'Escriba aqui el URL del subsitio.';
		}
		
		if (sizeof($errores) == 0){					
			$idSubsitio = $_POST['id'];
			$usuario_modificador_id = $_SESSION['usuario']['id'];
			
			
			
			$stmt_modificar_subsitio = $conn->prepare("UPDATE siee_subsitio SET
													titulo = ?,
													abreviatura = ?,
													descripcion = ?,
													url = ?,
													usuario_modificador_id = ?,
													fecha_modificacion = CURRENT_TIMESTAMP
												WHERE id = ?;");
			
			
			$stmt_modificar_subsitio->bindParam(1, utf8_decode($titulo));
			$stmt_modificar_subsitio->bindParam(2, utf8_decode($abreviatura));
			$stmt_modificar_subsitio->bindParam(3, utf8_decode($descripcion));
			$stmt_modificar_subsitio->bindParam(4, utf8_decode($url));
			$stmt_modificar_subsitio->bindParam(5, $usuario_modificador_id);
			$stmt_modificar_subsitio->bindParam(6, $idSubsitio);
			
			$conn->exec('BEGIN TRANSACTION');
			
			try {				
				if (!$stmt_modificar_subsitio->execute()){
					// aqui se detecatron errores al tratar de guardar los datos en la base de datos.
					$conn->exec('ROLLBACK TRANSACTION');
					$response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos estÃƒÂ© ocupada en este momento. Porfavor, intentalo de nuevo.';
				}else{
					$conn->exec('COMMIT TRANSACTION');
				}
			} catch (PDOException $e) {
				$conn->exec('ROLLBACK TRANSACTION');
				$stmt_modificar_subsitio->closeCursor();
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
