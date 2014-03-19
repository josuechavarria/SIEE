<?php

include '../phpIncluidos/conexion.php';

$patron_titulo = '/^[a-zA-Z0-9ÁáÉéÍiÓóÚúñÑ ]+$/';
$patron_titulo_err = 'Solo puedes ingresar caracteres de la a-z y caracteres numericos.';
$patron_descripcion = '/^[a-zA-Z0-9ÁáÉéÍiÓóÚúñÑ:;.\-()"_%#!?\/\[\]°º\{\}& ]+$/';
$patron_descripcion_err = 'Solo puedes ingresar caracteres de la a-z y caracteres numericos y ;.,()"{}[]%#°&';

$response = array();
$errores = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!ISSET($_POST['titulo']) || !ISSET($_POST['descripcion'])) {
        $response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acciÃƒÂ³n de nuevo.';
    } else {
        if (!($titulo = trim($_POST['titulo']))) {
            $errores['TituloGlosario'] = 'Escriba aqu&iacute el titulo del glosario.';
        } else {
            if (!preg_match($patron_titulo, $titulo)) {
                $errores['TituloGlosario'] = $patron_titulo_err;
            }
        }

        if (!($descripcion = trim($_POST['descripcion']))) {
            $errores['DescripcionGlosario'] = 'Escriba aqu&iacute la descripcion del glosario.';
        } else {
            if (!preg_match($patron_descripcion, $descripcion)) {
                $errores['DescripcionGlosario'] = $patron_descripcion_err;
            }
        }

        if (sizeof($errores) == 0) {
            $activo = 0;
            $usuario_creador_id = $_SESSION['usuario']['id'];
            $usuario_modificador_id = $_SESSION['usuario']['id'];

            $stmt_insertar_glosario = $conn->prepare("INSERT INTO siee_glosario (titulo, descripcion, activo, usuario_creador_id, fecha_creacion, usuario_modificador_id, fecha_modificacion) VALUES (
													?,
													?,
													?,
													?,
													CURRENT_TIMESTAMP,
													?,
													CURRENT_TIMESTAMP);");

            $stmt_insertar_glosario->bindParam(1, utf8_decode($titulo));
            $stmt_insertar_glosario->bindParam(2, utf8_decode($descripcion));
            $stmt_insertar_glosario->bindParam(3, $activo);
            $stmt_insertar_glosario->bindParam(4, $usuario_creador_id);
            $stmt_insertar_glosario->bindParam(5, $usuario_modificador_id);

            $conn->exec('BEGIN TRANSACTION');
            $commit = true;
            try {
                if (!$stmt_insertar_glosario->execute()) {
                    // aqui se detecatron errores al tratar de guardar los datos en la base de datos.
                    
                    $conn->exec('ROLLBACK TRANSACTION');
                    $response['refresh_error'] = 'Huboo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos estÃƒÂ© ocupada en este momento. Porfavor, intentalo de nuevo.';
                } else {

                    $commit = true;
                    $idGlosarioNuevo = recuperar_identity($conn);

                    if (ISSET($_POST['listaDeReferencia'])) {
                        $listaDeReferencia = $_POST['listaDeReferencia'];
                        foreach ($listaDeReferencia as $referencia) {
                            
                            $stmt_insertar_referencia = $conn->prepare('INSERT INTO siee_glosario_referencias (glosario_id,referencia) VALUES (?,?);');
                            
                            if (!($stmt_insertar_referencia->execute(array($idGlosarioNuevo,  htmlentities($referencia))))) {
                                
                                $conn->exec('ROLLBACK TRANSACTION');
                                $response['refresh_error'] = 'Huboss un error al tratar de guardar los datos en la base de datos, es posible que la base de datos este ocupada en este momento. Porfavor, intentalo de nuevo.';
                                
                                $commit = false;
                                break;
                            }
                        }
                    }
                    
                    if ($commit) {
                        $conn->exec('COMMIT TRANSACTION');
                    }
                }
            } catch (PDOException $e) {
                $conn->exec('ROLLBACK TRANSACTION');
                $stmt_insertar_glosario->closeCursor();
                // enviar html de errores o js function que ejecute el mensaje de errores
                $response['refresh_error'] = 'Hubo un error al tratar de insertar los datos en la base de datos. Porfavor, intentalo de nuevo.';
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
