<?php

include '../phpIncluidos/conexion.php';

$patron_titulo = '/^[a-zA-Z0-9ÁáÉéÍiÓóÚúñÑ ]+$/';
$patron_titulo_err = 'Solo puedes ingresar caracteres de la a-z y caracteres numericos.';
$patron_descripcion = '/^[a-zA-Z0-9ÁáÉéÍiÓóÚúñÑ:;.\-()"_%#!?\/\[\]°º\{\}& ]+$/';
$patron_descripcion_err = 'Solo puedes ingresar caracteres de la a-z y caracteres numericos y ;.,()"{}[]%#°&';

$response = array();
$errores = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!ISSET($_POST['id']) || !ISSET($_POST['titulo']) || !ISSET($_POST['descripcion'])) {
        $response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acciÃƒÂ³n de nuevo.';
    } else {
        if (!($titulo = trim($_POST['titulo']))) {
            $errores['TituloGlosario_mod'] = 'Escriba aqui el titulo del glosario.';
        } else {
            if (!preg_match($patron_titulo, $titulo)) {
                $errores['TituloGlosario_mod'] = $patron_titulo_err;
            }
        }

        if (!($descripcion = trim($_POST['descripcion']))) {
            $errores['DescripcionGlosario_mod'] = 'Escriba aqui la descripcion del glosario.';
        } else {
            if (!preg_match($patron_descripcion, $descripcion)) {
                $errores['DescripcionGlosario_mod'] = $patron_descripcion_err;
            }
        }

        if (sizeof($errores) == 0) {
            $idGlosario = $_POST['id'];
            $usuario_modificador_id = $_SESSION['usuario']['id'];



            $stmt_modificar_glosario = $conn->prepare("UPDATE siee_glosario SET
													titulo = ?,
													descripcion = ?,
													usuario_modificador_id = ?,
													fecha_modificacion = CURRENT_TIMESTAMP
												WHERE id = ?;");


            $stmt_modificar_glosario->bindParam(1, utf8_decode($titulo));
            $stmt_modificar_glosario->bindParam(2, utf8_decode($descripcion));
            $stmt_modificar_glosario->bindParam(3, $usuario_modificador_id);
            $stmt_modificar_glosario->bindParam(4, $idGlosario);

            $conn->exec('BEGIN TRANSACTION');
            $commit = true;

            try {
                if (!$stmt_modificar_glosario->execute()) {
                    // aqui se detecatron errores al tratar de guardar los datos en la base de datos.
                    $conn->exec('ROLLBACK TRANSACTION');
                    $response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos esta ocupada en este momento. Porfavor, intentalo de nuevo.';
                } else {

                    if (ISSET($_POST['listaDereferencia'])) {


                        $stmt_eliminar_referencias = $conn->prepare('DELETE FROM siee_glosario_referencias WHERE glosario_id = ?;');
                        $stmt_eliminar_referencias->bindParam(1, $idGlosario);

                        if (!$stmt_eliminar_referencias->execute()) {
                            $response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos está ocupada en este momento. Porfavor, intentalo de nuevo. 2';
                            $conn->exec('ROLLBACK TRANSACTION');
                           
                            $commit = false;
                            break;
                        } else {
                            $commit = true;
                            $listaDeReferencia = $_POST['listaDereferencia'];

                            foreach ($listaDeReferencia as $referencia) {
                                $stmt_insertar_referencia = $conn->prepare('INSERT INTO siee_glosario_referencias (glosario_id,referencia) VALUES (?,?);');
                                if (!($stmt_insertar_referencia->execute(array($idGlosario, htmlentities($referencia))))) {
                                    $response['refresh_error'] = 'Huboss un error al tratar de guardar los datos en la base de datos, es posible que la base de datos este ocupada en este momento. Porfavor, intentalo de nuevo.';
                                     $conn->exec('ROLLBACK TRANSACTION');
                                    

                                    $commit = false;
                                    break;
                                }
                            }
                        }
                    }

                    if ($commit) {
                        $conn->exec('COMMIT TRANSACTION');
                    }
                }
            } catch (PDOException $e) {
                $conn->exec('ROLLBACK TRANSACTION');
                $stmt_modificar_glosario->closeCursor();
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
