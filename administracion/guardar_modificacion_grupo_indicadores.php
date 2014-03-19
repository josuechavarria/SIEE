<?php

include '../phpIncluidos/conexion.php';

$patron_etiqueta = '/^[a-zA-Z0-9ÁáÉéÍíÓó.(),"\- ]+$/';
$patron_etiqueta_err = 'Solo puedes ingresar caracteres de la a-z y caracteres numericos.';
$patron_titulo = '/^[a-zA-Z0-9ÁáÉéÍíÓó()"\-,.;: ]+$/';
$patron_titulo_err = 'Solo puedes ingresar caracteres de la a-z y caracteres numericos.';
$patron_descripcion = '/^[a-zA-Z0-9ÁáÉéÍíÓó(),.;:"\- ]+$/';
$patron_descripcion_err = 'Solo puedes ingresar caracteres de la a-z y caracteres numericos.';
$patron_int = '/^[0-9]$/';
$patron_int_err = 'Solo puedes ingrear un digito del 0 al 9.';

$response = array();
$errores = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!ISSET($_POST['id']) || !ISSET($_POST['subsitio_id']) || !ISSET($_POST['etiqueta_titulo']) || !ISSET($_POST['titulo_completo']) || !ISSET($_POST['descripcion']) || !ISSET($_POST['listaIdsIndicadores']) || !ISSET($_POST['listaIdsGrupos'])) {
        $response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acci&otilde;n de nuevo.';
    } else {
        if (!($subsitio_id = trim($_POST['subsitio_id']))) {
            $errores['SubsitioGrupoIndicadores_mod'] = 'Seleccione el subsitio al que pertenece el grupo.';
        }

        if (!($etiqueta_titulo = trim($_POST['etiqueta_titulo']))) {
            $errores['EtiquetaTituloGrupoIndicadores_mod'] = 'Escriba aqui la etiqueta del grupo.';
        } else {
            if (!preg_match($patron_etiqueta, $etiqueta_titulo)) {
                $errores['EtiquetaTituloGrupoIndicadores_mod'] = $patron_etiqueta_err;
            }
        }

        if (!($titulo_completo = trim($_POST['titulo_completo']))) {
            $errores['TituloCompletoGrupoIndicadores_mod'] = 'Escriba aqui el titulo completo del grupo.';
        } else {
            if (!preg_match($patron_titulo, $titulo_completo)) {
                $errores['TituloCompletoGrupoIndicadores_mod'] = $patron_titulo_err;
            }
        }

        if (strlen($descripcion = trim($_POST['descripcion'])) > 0) {
            if (!preg_match($patron_descripcion, $descripcion)) {
                $errores['DescripcionGrupoIndicadores_mod'] = $patron_descripcion_err;
            }
        }

        if (sizeof($errores) == 0) {
            $idGrupoIndicadores = $_POST['id'];
            $usuario_modificador_id = $_SESSION['usuario']['id'];



            $stmt_modificar_grupo_indicador = $conn->prepare("UPDATE siee_grupo_indicadores SET
                                                                                    subsitio_id = ?,
                                                                                    etiqueta_titulo = ?,
                                                                                    titulo_completo = ?,
                                                                                    descripcion = ?,
                                                                                    usuario_modificador_id = ?,
                                                                                    fecha_modificacion = CURRENT_TIMESTAMP
                                                                            WHERE id = ?;");

            $stmt_modificar_grupo_indicador->bindParam(1, $subsitio_id);
            $stmt_modificar_grupo_indicador->bindParam(2, utf8_decode($etiqueta_titulo));
            $stmt_modificar_grupo_indicador->bindParam(3, utf8_decode($titulo_completo));
            $stmt_modificar_grupo_indicador->bindParam(4, utf8_decode($descripcion));
            $stmt_modificar_grupo_indicador->bindParam(5, $usuario_modificador_id);
            $stmt_modificar_grupo_indicador->bindParam(6, $idGrupoIndicadores);

            $conn->exec('BEGIN TRANSACTION');

            try {
                if (!$stmt_modificar_grupo_indicador->execute()) {
                    // aqui se detecatron errores al tratar de guardar los datos en la base de datos.

                    $response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos este ocupada en este momento. Porfavor, intentalo de nuevo. 1';
                    $conn->exec('ROLLBACK TRANSACTION');
                } else {
                    $stmt_eliminar_relaciones = $conn->prepare('DELETE FROM "siee_rel-indicador__grupo_indicadores" WHERE grupo_indicador_id = ?;');
                    $stmt_eliminar_relaciones->bindParam(1, $_POST['id']);
                    $stmt_eliminar_relaciones->execute();

                    if (($listaIdsIndicadores = trim($_POST['listaIdsIndicadores']))) {
                        $idGrupo = $_POST['id'];
                        $intOrdenamiento = 1;
                        $ok = true;
                        foreach (explode(',', $listaIdsIndicadores) as $idIndicador) {
                            $stmt_insertar_relacion = $conn->prepare('INSERT INTO "siee_rel-indicador__grupo_indicadores" (grupo_indicador_id, indicador_id, ordenamiento_indicador) VALUES (?,?,?);');
                            $stmt_insertar_relacion->bindParam(1, $idGrupo);
                            $stmt_insertar_relacion->bindParam(2, $idIndicador);
                            $stmt_insertar_relacion->bindParam(3, $intOrdenamiento);
                            $stmt_insertar_relacion->execute();
                            $intOrdenamiento++;
                        }
                    }

                    if (sizeof($listaIdsGrupos = ($_POST['listaIdsGrupos'])) > 0) {
                        $listaIdsGrupos = $_POST['listaIdsGrupos'];
                        //$listaIdsGrupos[array_search(0, $listaIdsGrupos)] = $idGrupo;
                        $i = 1;
                        foreach ($listaIdsGrupos as $id) {
                            $stmt_ordenar_grupos = $conn->prepare('UPDATE siee_grupo_indicadores SET ordenamiento_grupo = ? WHERE id = ?;');
                            $stmt_ordenar_grupos->bindParam(1, $i);
                            $stmt_ordenar_grupos->bindParam(2, $id);
                            $stmt_ordenar_grupos->execute();
                            $i++;
                        }


                        $idsGruposCSV = implode(',', $listaIdsGrupos);

                        if (!$stmt_ordenar_grupos_inactivos = $conn->query('UPDATE siee_grupo_indicadores SET ordenamiento_grupo = ' . $i . ' WHERE id NOT IN (' . $idsGruposCSV . ');')) {
                            $response['refresh_error'] = print_r($conn->errorInfo(), true);
                        }
                    }

                    $conn->exec('COMMIT TRANSACTION');
                }
            } catch (PDOException $e) {
                $conn->exec('ROLLBACK TRANSACTION');
                $stmt_modificar_grupo_indicador->closeCursor();
                // enviar html de errores o js function que ejecute el mensaje de errores
                $response['refresh_error'] = '2Hubo un error al tratar de insertar los datos en la base de datos. Porfavor, intentalo de nuevo.';
            }
        }
    }
} else {
    $response['refresh_error'] = '3Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acciÃƒÂ³n de nuevo.';
}

if (sizeof($errores) > 0) {
    $response['errores'] = $errores;
}

echo json_encode($response);
?>
