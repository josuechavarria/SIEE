<?php
include '../phpIncluidos/conexion.php';
$response = array();
$errores = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!ISSET($_POST['cambios'])){
		$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la página y realiza esta acción de nuevo.';
	}else{
		$cambios = $_POST['cambios'];
		$commit = true;
		
		$conn->exec('BEGIN TRANSACTION');
		
		foreach($cambios as $key => $value){
			if (strlen($value) > 0) {
				$stmt_update_indicador = $conn->prepare('UPDATE siee_indicador SET anio_base = ? WHERE id = ?');

				if (!$stmt_update_indicador->execute(array($value, $key))) {
					$response['refresh_error'] = var_export($cambios, true) . print_r($stmt_update_indicador->errorInfo(), true) . 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos está ocupada en este momento. Por favor, intentalo de nuevo en un momento.';
					$conn->exec('ROLLBACK TRANSACTION');
					$commit = false;
					break;
				}

				$stmt_update_indicador->closeCursor();
			}
		}
		
		if ($commit){
			$conn->exec('COMMIT TRANSACTION');
		}
	}
}else{
	$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acción de nuevo.';
}

if (sizeof($errores) > 0){
	$response['errores'] = $errores;
}

echo json_encode($response);
?>
