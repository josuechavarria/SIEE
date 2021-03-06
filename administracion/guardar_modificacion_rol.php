<?php
include '../phpIncluidos/conexion.php';

$patron_titulo = '/^[a-zA-Z0-9áÁéÉíÍóÓúÚ ]+$/';
$patron_titulo_err = 'Solo puedes ingresar caracteres de la a-zA-Z, tildes y caracteres numericos.';
$patron_descripcion = '/^[a-zA-Z0-9,.;áÁéÉíÍóÓúÚ ]+$/';
$patron_descripcion_err = 'Solo puedes ingresar caracteres de la a-zA-Z, puntos, comas, tildes y caracteres numericos.';
$patron_bit = '/^[01]$/';

$response = array();
$errores = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!ISSET($_POST['id']) || !ISSET($_POST['titulo_rol']) || !ISSET($_POST['descripcion_rol']) || !ISSET($_POST['administrador']) || !ISSET($_POST['alertas_de_desviaciones']) || !ISSET($_POST['indicadores_privados']) || !ISSET($_POST['proyecciones']) || !ISSET($_POST['moderador'])){
		$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la página y realiza esta acción de nuevo.';
	}else{
		if (!($titulo_rol = trim($_POST['titulo_rol']))){
			$errores['TituloRol_mod'] = 'Escriba aqui el titulo del rol.';
		}else{
			if (!preg_match($patron_titulo, $titulo_rol)){
				$errores['TituloRol_mod'] = $patron_titulo_err;
			}
		}
		
		if (!($descripcion_rol = trim($_POST['descripcion_rol']))){
			$errores['DescripcionRol_mod'] = 'Escriba aqui la descripcion del rol.';
		}else{
			if (!preg_match($patron_descripcion, $descripcion_rol)){
				$errores['DescripcionRol_mod'] = $patron_descripcion_err;
			}
		}
		
		if (!preg_match($patron_bit, ($administrador = $_POST['administrador']))){
			$administrador = "0";
		}
		
		if (!preg_match($patron_bit, ($alertas_de_desviaciones = $_POST['alertas_de_desviaciones']))){
			$alertas_de_desviaciones = "0";
		}
		
		if (!preg_match($patron_bit, ($indicadores_privados = $_POST['indicadores_privados']))){
			$indicadores_privados = "0";
		}
		
		if (!preg_match($patron_bit, ($proyecciones = $_POST['proyecciones']))){
			$proyecciones = "0";
		}
		
		if (!preg_match($patron_bit, ($moderador = $_POST['moderador']))){
			$moderador = "0";
		}
		
		if (sizeof($errores) == 0){					
			$idRol = $_POST['id'];
			$usuario_modificador_id = $_SESSION['usuario']['id'];
			
			
			
			$stmt_modificar_rol = $conn->prepare("UPDATE siee_rol SET
													titulo_rol			= ?,
													descripcion_rol		= ?,
													es_administrador	= ?,
													ver_alertas_desviaciones	= ?,
													ver_indicadores_privados	= ?,
													ver_proyecciones	= ?,
													es_moderador = ?,
													usuario_modificador_id		= ?,
													fecha_modificacion	= CURRENT_TIMESTAMP
												WHERE id = ?;");
			
			
			$stmt_modificar_rol->bindParam(1, utf8_decode($titulo_rol));
			$stmt_modificar_rol->bindParam(2, utf8_decode($descripcion_rol));
			$stmt_modificar_rol->bindParam(3, $administrador);
			$stmt_modificar_rol->bindParam(4, $alertas_de_desviaciones);
			$stmt_modificar_rol->bindParam(5, $indicadores_privados);
			$stmt_modificar_rol->bindParam(6, $proyecciones);
			$stmt_modificar_rol->bindParam(7, $moderador);
			$stmt_modificar_rol->bindParam(8, $usuario_modificador_id);
			$stmt_modificar_rol->bindParam(9, $idRol);
			
			$conn->exec('BEGIN TRANSACTION');
			
			try {				
				if (!$stmt_modificar_rol->execute()){
					// aqui se detecatron errores al tratar de guardar los datos en la base de datos.
					$conn->exec('ROLLBACK TRANSACTION');
					$response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos está ocupada en este momento. Por favor, intentalo de nuevo en un momento.';
				}else{
					$conn->exec('COMMIT TRANSACTION');
				}
			} catch (PDOException $e) {
				$conn->exec('ROLLBACK TRANSACTION');
				$stmt_modificar_rol->closeCursor();
				// enviar html de errores o js function que ejecute el mensaje de errores
				$response['refresh_error'] = 'Hubo un error al tratar de insertar los datos en la base de datos. Por favor, intentalo de nuevo.';
			}
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
