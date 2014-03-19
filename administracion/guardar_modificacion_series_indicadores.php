<?php
include '../phpIncluidos/conexion.php';

$patron_titulo = '/^[a-zA-Z0-9áÁéÉíÍóÓúÚñÑ.,()"\- ]+$/';
$patron_titulo_err = 'Solo puedes ingresar caracteres de la a-zA-Z, tildes y caracteres numericos.';
$patron_descripcion = '/^[a-zA-Z0-9áÁéÉíÍóÓúÚñÑ.,()"\-:; ]+$/';
$patron_descripcion_err = 'Solo puedes ingresar caracteres de la a-zA-Z, puntos, comas, tildes y caracteres numericos.';
$patron_observaciones = $patron_descripcion;
$patron_observaciones_err = $patron_descripcion_err;
$patron_numerico = '/^[123456789][0-9]*$/';
$patron_numerico_err = 'Debes ingresar un valor numerico mayor que cero.';

$response = array();
$errores = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!ISSET($_POST['serie_id']) || !ISSET($_POST['titulo']) || !ISSET($_POST['descripcion']) || !ISSET($_POST['cantidadIndicadores']) || !ISSET($_POST['observaciones'])){
		$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, por favor refresca la página y realiza esta acción de nuevo.';
	}else{
		if (!($titulo = trim($_POST['titulo']))){
			$errores['TituloSerie_mod'] = 'Escriba aqui el titulo de la serie.';
		}else{
			if (!preg_match($patron_titulo, $titulo)){
				$errores['TituloSerie_mod'] = $patron_titulo_err;
			}
		}
		
		if (!($descripcion = trim($_POST['descripcion']))){
			$errores['DescripcionSerie_mod'] = 'Escriba aqui la descripci&oacute;n de la serie.';
		}else{
			if (!preg_match($patron_descripcion, $descripcion)){
				$errores['DescripcionSerie_mod'] = $patron_descripcion_err;
			}
		}
		
		if (!($cantidadIndicadores = trim($_POST['cantidadIndicadores']))){
			$errores['CantidadDeIndicadores_mod'] = 'Ingrese la cantidad maxima de indicadores que tendra esta serie.';
		}else{
			if (!preg_match($patron_numerico, $cantidadIndicadores)){
				$errores['CantidadDeIndicadores_mod'] = $patron_numerico_err;
			}
		}
		
		if (($observaciones = trim($_POST['observaciones']))){
			if (!preg_match($patron_observaciones, $observaciones)){
				$errores['ObservacionSerie_mod'] = $patron_observaciones_err;
			}
		}
		
		if (sizeof($errores) == 0){
			$idSerie = $_POST['serie_id'];
			$usuario_modificador_id = $_SESSION['usuario']['id'];
			
			$stmt_modificar_serie = $conn->prepare("UPDATE siee_serie_indicadores SET
													titulo = ?,
													descripcion = ?,
													cantidad_indicadores = ?,
													observaciones = ?,
													usuario_modificador_id = ?,
													fecha_modificacion = CURRENT_TIMESTAMP
												WHERE id = ?;");		
			
			$conn->exec('BEGIN TRANSACTION');
			
			try {				
				if (!$stmt_modificar_serie->execute(array(utf8_decode($titulo), utf8_decode($descripcion), $cantidadIndicadores, utf8_decode($observaciones), $usuario_modificador_id, $idSerie))){
					// aqui se detecatron errores al tratar de guardar los datos en la base de datos.
					
					$response['refresh_error'] = print_r($stmt_modificar_serie->errorInfo(),true).'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos está ocupada en este momento. Por favor, intentalo de nuevo en un momento.';
					$conn->exec('ROLLBACK TRANSACTION');
				}else{
					$conn->exec('COMMIT TRANSACTION');
				}
			} catch (PDOException $e) {
				$conn->exec('ROLLBACK TRANSACTION');
				$stmt_insertar_serie->closeCursor();
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
