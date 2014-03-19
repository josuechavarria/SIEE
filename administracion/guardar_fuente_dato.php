<?php
include '../phpIncluidos/conexion.php';

$patron_titulo = '/^[a-zA-Z0-9áÁéÉíÍóÓúÚñÑ.,()"\-_ ]+$/';
$patron_titulo_err = 'El titulo de la fuente de datos contiene caracteres invalidos.';
$patron_descripcion = '/^[a-zA-Z0-9áÁéÉíÍóÓúÚñÑ.,:;%&#()"\-_ ]+$/';
$patron_descripcion_err = 'La descripcion de la fuente de datos contiene caracteres invalidos.';

$response = array();
$errores = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!ISSET($_POST['titulo']) || !ISSET($_POST['descripcion'])){
		$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, por favor refresca la página y realiza esta acción de nuevo.';
	}else{
		if (!($titulo = trim($_POST['titulo']))){
			$errores['TituloFuenteDato'] = 'Escriba aqui el titulo de la fuente de datos.';
		}else{
			if (strlen($titulo) > 128){
				$errores['TituloFuenteDato'] = 'El titulo de la fuente de datos excede el tama&ntilde;o maximo de 128 caracteres.';
			}else{
				if (!preg_match($patron_titulo, $titulo)){
					$errores['TituloFuenteDato'] = $patron_titulo_err;
				}
			}
		}
		
		if (!($descripcion = trim($_POST['descripcion']))){
			$errores['DescripcionFuenteDato'] = 'Escriba aqui la descripcion de la fuente de datos.';
		}else{
			if (strlen($descripcion) > 256){
				$errores['DescripcionFuenteDato'] = 'La descripcion de la fuente de datos excede el tama&ntilde;o maximo de 256 caracteres.';
			}else{
				if (!preg_match($patron_descripcion, $descripcion)){
					$errores['DescripcionFuenteDato'] = $patron_descripcion_err;
				}
			}
		}
		
		if (sizeof($errores) == 0){					
			$activo = 0;
			$usuario_creador_id = $_SESSION['usuario']['id'];
			$usuario_modificador_id = $_SESSION['usuario']['id'];
			
			$stmt_insertar_fuente_dato = $conn->prepare("INSERT INTO siee_fuente_dato (titulo, descripcion, activo, usuario_creador_id, fecha_creacion, usuario_modificador_id, fecha_modificacion) VALUES (
															?,
															?,
															?,
															?,
															CURRENT_TIMESTAMP,
															?,
															CURRENT_TIMESTAMP);");		
			
			$conn->exec('BEGIN TRANSACTION');
			
			try {				
				if (!$stmt_insertar_fuente_dato->execute(array(utf8_decode($titulo), utf8_decode($descripcion), $activo, $usuario_creador_id, $usuario_modificador_id))){
					// aqui se detecatron errores al tratar de guardar los datos en la base de datos.
					$response['refresh_error'] = print_r($stmt_insertar_fuente_dato->errorInfo(),true).'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos está ocupada en este momento. Por favor, intentalo de nuevo en un momento.';
					$conn->exec('ROLLBACK TRANSACTION');
				}else{			
					$conn->exec('COMMIT TRANSACTION');
				}
			} catch (PDOException $e) {
				$conn->exec('ROLLBACK TRANSACTION');
				$stmt_insertar_fuente_dato->closeCursor();
				// enviar html de errores o js function que ejecute el mensaje de errores
				$response['refresh_error'] = 'Hubo un error al tratar de insertar los datos en la base de datos. Porfavor, intentalo de nuevo.';
			}
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
