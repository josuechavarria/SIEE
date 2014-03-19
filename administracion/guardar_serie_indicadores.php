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
	if (!ISSET($_POST['titulo']) || !ISSET($_POST['descripcion']) || !ISSET($_POST['cantidadIndicadores']) || !ISSET($_POST['observaciones'])){
		$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, por favor refresca la página y realiza esta acción de nuevo.';
	}else{
		if (!($titulo = trim($_POST['titulo']))){
			$errores['TituloSerie'] = 'Escriba aqui el titulo de la serie.';
		}else{
			if (!preg_match($patron_titulo, $titulo)){
				$errores['TituloSerie'] = $patron_titulo_err;
			}
		}
		
		if (!($descripcion = trim($_POST['descripcion']))){
			$errores['DescripcionSerie'] = 'Escriba aqui la descripci&oacute;n de la serie.';
		}else{
			if (!preg_match($patron_descripcion, $descripcion)){
				$errores['DescripcionSerie'] = $patron_descripcion_err;
			}
		}
		
		if (!($cantidadIndicadores = trim($_POST['cantidadIndicadores']))){
			$errores['CantidadDeIndicadores'] = 'Ingrese la cantidad maxima de indicadores que tendra esta serie.';
		}else{
			if (!preg_match($patron_numerico, $cantidadIndicadores)){
				$errores['CantidadDeIndicadores'] = $patron_numerico_err;
			}
		}
		
		if (($observaciones = trim($_POST['observaciones']))){
			if (!preg_match($patron_observaciones, $observaciones)){
				$errores['ObservacionSerie'] = $patron_observaciones_err;
			}
		}
		
		if (sizeof($errores) == 0){
			$codigo = 1;
			$activo = 0;
			$usuario_creador_id = $_SESSION['usuario']['id'];
			$usuario_modificador_id = $_SESSION['usuario']['id'];
			
			$stmt_insertar_serie = $conn->prepare("INSERT INTO siee_serie_indicadores (codigo_serie_indicadores, titulo, descripcion, cantidad_indicadores, observaciones, activo, usuario_creador_id, fecha_creacion, usuario_modificador_id, fecha_modificacion) VALUES (
													?,
													?,
													?,
													?,
													?,
													?,
													?,
													CURRENT_TIMESTAMP,
													?,
													CURRENT_TIMESTAMP);");		
			
			$conn->exec('BEGIN TRANSACTION');
			
			try {				
				if (!$stmt_insertar_serie->execute(array($codigo, utf8_decode($titulo), utf8_decode($descripcion), $cantidadIndicadores, utf8_decode($observaciones), $activo, $usuario_creador_id, $usuario_modificador_id))){
					// aqui se detecatron errores al tratar de guardar los datos en la base de datos.
					$conn->exec('ROLLBACK TRANSACTION');
					$response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos está ocupada en este momento. Por favor, intentalo de nuevo en un momento.';
				}else{
					$idSerieNueva = recuperar_identity($conn);
                    $commit = true;

                    $codigoSerie = "SIND_" . $idSerieNueva;

                    $stmt_insertar_codigo_serie = $conn->prepare("UPDATE siee_serie_indicadores set codigo_serie_indicadores = ? WHERE id = ?;");
                    $stmt_insertar_codigo_serie->bindParam(1, $codigoSerie);
                    $stmt_insertar_codigo_serie->bindParam(2, $idSerieNueva);

                    if (!$stmt_insertar_codigo_serie->execute()) {
                        $conn->exec('ROLLBACK TRANSACTION');
                        $response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos estÃƒÂ© ocupada en este momento. Porfavor, intentalo de nuevo.';
                    }else{
						$conn->exec('COMMIT TRANSACTION');
					}
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
