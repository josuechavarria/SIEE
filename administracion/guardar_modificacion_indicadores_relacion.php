<?php

include '../phpIncluidos/conexion.php';



$response = array();
$errores = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!ISSET($_POST['id']) || !ISSET($_POST['listaIds'])) {
        $response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acciÃƒÂ³n de nuevo.';
    } else {
		
        if (sizeof($errores) == 0) {
            $id = $_POST['id'];
            $lista = $_POST['listaIds'];

            

            $stmt_eliminar_relaciones = $conn->prepare('DELETE FROM "siee_rel-indicador__indicador" WHERE indicador_id2 = ? or indicador_id = ? ');
            
            $stmt_eliminar_relaciones->bindParam(1, $id);
            $stmt_eliminar_relaciones->bindParam(2, $id);
            
            $conn->exec('BEGIN TRANSACTION');
            
            try {
                if (!($stmt_eliminar_relaciones->execute())) {
                    // aqui se detecatron errores al tratar de guardar los datos en la base de datos.
                    
                    $response['refresh_error'] =' Huboi un error al tratar de guardar los datos en la base de datos, es posible que la base de datos estÃƒÂ© ocupada en este momento. Porfavor, intentalo de nuevo.';
                    $conn->exec('ROLLBACK TRANSACTION');
                } else {
                    $commit = TRUE;
					
					if (strlen($lista) > 0){
						foreach ((explode(',',$lista)) as $id2) {
							$stmt_insertar_relacion = $conn->prepare('INSERT INTO "siee_rel-indicador__indicador" (indicador_id, indicador_id2) VALUES (?,?);');
							$stmt_insertar_relacion->bindParam(1, $id);
							$stmt_insertar_relacion->bindParam(2, $id2);

							if(!$stmt_insertar_relacion->execute()){
								$conn->exec('ROLLBACK TRANSACTION');
								$response['refresh_error'] = 'Hubor un error al tratar de guardar los datos en la base de datos, es posible que la base de datos está ocupada en este momento. Porfavor, intentalo de nuevo.';
								$commit = FALSE;
							}else{
								$commit = TRUE;
							}
						}
                    }
                    if ($commit) {
                        $conn->exec('COMMIT TRANSACTION');
                    }
                    
                }
            } catch (PDOException $e) {
                $conn->exec('ROLLBACK TRANSACTION');
                $stmt_eliminar_relaciones->closeCursor();
                // enviar html de errores o js function que ejecute el mensaje de errores
                $response['refresh_error'] = 'Hubot un error al tratar de insertar los datos en la base de datos. Por favor, intentalo de nuevo.';
            }
        }
    }
} else {
    $response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acciÃƒÂ³n de nuevo.';
}

if (sizeof($errores) > 0) {
    $response['errores'] = $errores;
}

echo json_encode($response);
?>
