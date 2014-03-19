<?php
include '../phpIncluidos/conexion.php';

$response = array();
$errores = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!ISSET($_POST['listaIdsArchivos'])){
		$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acción de nuevo.';
	}else{
		if (!($listaIdsArchivos = $_POST['listaIdsArchivos'])){
			$response['refresh_error'] = 'Debes seleccionar almenos un archivo para realizar esta acción.';
		}else{
			$query = 'UPDATE siee_archivo SET activo = CASE activo WHEN 1 THEN 0 ELSE 1 END WHERE id IN(';
			foreach($listaIdsArchivos as $id){
				$query .= $id . ',';
			}
			$query = substr($query, 0, strlen($query) - 1) . ');';
			
			$stmt_cambiar_estado_archivo = $conn->prepare($query);
			
			$conn->exec('BEGIN TRANSACTION');
			
			try {				
				if (!$stmt_cambiar_estado_archivo->execute()){
					// aqui se detecatron errores al tratar de guardar los datos en la base de datos.
					$conn->exec('ROLLBACK TRANSACTION');
					$response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos esté ocupada en este momento. Porfavor, intentalo de nuevo.';
				}else{
					$conn->exec('COMMIT TRANSACTION');
				}
			} catch (PDOException $e) {
				$conn->exec('ROLLBACK TRANSACTION');
				$stmt_cambiar_estado_archivo->closeCursor();
				// enviar html de errores o js function que ejecute el mensaje de errores
				$response['refresh_error'] = 'Hubo un error al tratar de insertar los datos en la base de datos. Porfavor, intentalo de nuevo.';
			}
		}
	}
}else{
	
}

echo json_encode($response);
?>
