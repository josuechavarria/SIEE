<?php
include '../phpIncluidos/conexion.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!ISSET($_POST['anio']) || !ISSET($_POST['datos'])){
		$response['refresh_error'] = htmlentities('Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acciÃƒÂ³n de nuevo.');
	}else{
		$anio = $_POST['anio'];
		$datos = $_POST['datos'];
		
		$stmt_edades = $conn->query('SELECT * FROM "siee_catalogo-edad" WHERE ordenamiento > 0 ORDER BY ordenamiento ASC;');
		$edades = $stmt_edades->fetchAll();
		$stmt_edades->closeCursor();
	
		$conn->exec('BEGIN TRANSACTION');
		
		try {
			$stmt_eliminar_filas = $conn->prepare('DELETE FROM siee_parametros_estimar_poblacion WHERE periodo_id = ?;');
			$stmt_eliminar_filas->bindParam(1, $anio);
			$ok = $stmt_eliminar_filas->execute();
			
			if (!$ok){
				$conn->exec('ROLLBACK TRANSACTION');
				$response['refresh_error'] = htmlentities('1Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos est&aacute; ocupada en este momento. Porfavor, intentalo de nuevo.');
			}else{
				//se eliminaron las filas del anio. ahora ahy que insertarlas de nuevo...
				$commit = true;

				foreach($edades as $edad){
					$divisor = 0;
					foreach($datos as $dato){
						if (current(explode('-', $dato)) == $edad['id']){
							$divisor += 1;
						}
					}
					
					if ($divisor == 0){
						$divisor = 1;
					}
					
					$stmt_insertar_filas = $conn->prepare('INSERT INTO siee_parametros_estimar_poblacion (
																periodo_id,
																edad_id,
																divisor,
																E_0,
																E_1,
																E_2,
																E_3,
																E_4,
																E_5,
																E_6,
																E_7,
																E_8,
																E_9,
																E_10,
																E_11,
																E_12,
																E_13,
																E_14,
																E_15,
																E_16,
																E_17,
																E_18,
																E_19,
																E_20,
																activo)
															VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);');
					
					$stmt_insertar_filas->bindParam(1, $anio);
					$stmt_insertar_filas->bindParam(2, $edad['id']);
					$stmt_insertar_filas->bindParam(3, $divisor);					
					$stmt_insertar_filas->bindValue(4, (in_array(($edad['id'] . '-' . 'E_0'), $datos) ? 1:0));
					$stmt_insertar_filas->bindValue(5, (in_array(($edad['id'] . '-' . 'E_1'), $datos) ? 1:0));
					$stmt_insertar_filas->bindValue(6, (in_array(($edad['id'] . '-' . 'E_2'), $datos) ? 1:0));
					$stmt_insertar_filas->bindValue(7, (in_array(($edad['id'] . '-' . 'E_3'), $datos) ? 1:0));
					$stmt_insertar_filas->bindValue(8, (in_array(($edad['id'] . '-' . 'E_4'), $datos) ? 1:0));
					$stmt_insertar_filas->bindValue(9, (in_array(($edad['id'] . '-' . 'E_5'), $datos) ? 1:0));
					$stmt_insertar_filas->bindValue(10, (in_array(($edad['id'] . '-' . 'E_6'), $datos) ? 1:0));
					$stmt_insertar_filas->bindValue(11, (in_array(($edad['id'] . '-' . 'E_7'), $datos) ? 1:0));
					$stmt_insertar_filas->bindValue(12, (in_array(($edad['id'] . '-' . 'E_8'), $datos) ? 1:0));
					$stmt_insertar_filas->bindValue(13, (in_array(($edad['id'] . '-' . 'E_9'), $datos) ? 1:0));
					$stmt_insertar_filas->bindValue(14, (in_array(($edad['id'] . '-' . 'E_10'), $datos) ? 1:0));
					$stmt_insertar_filas->bindValue(15, (in_array(($edad['id'] . '-' . 'E_11'), $datos) ? 1:0));
					$stmt_insertar_filas->bindValue(16, (in_array(($edad['id'] . '-' . 'E_12'), $datos) ? 1:0));
					$stmt_insertar_filas->bindValue(17, (in_array(($edad['id'] . '-' . 'E_13'), $datos) ? 1:0));
					$stmt_insertar_filas->bindValue(18, (in_array(($edad['id'] . '-' . 'E_14'), $datos) ? 1:0));
					$stmt_insertar_filas->bindValue(19, (in_array(($edad['id'] . '-' . 'E_15'), $datos) ? 1:0));
					$stmt_insertar_filas->bindValue(20, (in_array(($edad['id'] . '-' . 'E_16'), $datos) ? 1:0));
					$stmt_insertar_filas->bindValue(21, (in_array(($edad['id'] . '-' . 'E_17'), $datos) ? 1:0));
					$stmt_insertar_filas->bindValue(22, (in_array(($edad['id'] . '-' . 'E_18'), $datos) ? 1:0));
					$stmt_insertar_filas->bindValue(23, (in_array(($edad['id'] . '-' . 'E_19'), $datos) ? 1:0));
					$stmt_insertar_filas->bindValue(24, (in_array(($edad['id'] . '-' . 'E_20'), $datos) ? 1:0));
					$stmt_insertar_filas->bindValue(25, 1);
					
					if (!$stmt_insertar_filas->execute()){
						$commit = false;
						break;
					}
				}
				
				if ($commit){
					$conn->exec('COMMIT TRANSACTION');
				}else{
					$conn->exec('ROLLBACK TRANSACTION');
					$response['refresh_error'] = htmlentities('2Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos est&aacute; ocupada en este momento. Porfavor, intentalo de nuevo.');
				}
			}
		} catch (PDOException $e) {
			$conn->exec('ROLLBACK TRANSACTION');
			$stmt_insertar_filas->closeCursor();
			$stmt_eliminar_filas->closeCursor();
			// enviar html de errores o js function que ejecute el mensaje de errores
			$response['refresh_error'] = '3Hubo un error al tratar de insertar los datos en la base de datos. Porfavor, intentalo de nuevo.';
		}
	}
}else{
	$response['refresh_error'] = htmlentities('Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acci&oacute;n de nuevo.');
}

echo json_encode($response);
?>
