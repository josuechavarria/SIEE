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
    if (!ISSET($_POST['subsitio_id']) || !ISSET($_POST['etiqueta_titulo']) || !ISSET($_POST['titulo_completo']) || !ISSET($_POST['descripcion']) || !ISSET($_POST['listaIdsIndicadores'])) {
        $response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acci&otilde;n de nuevo.';
    } else {
        if (!($subsitio_id = trim($_POST['subsitio_id']))) {
            $errores['SubsitioGrupoIndicadores'] = 'Seleccione el subsitio al que pertenece el grupo.';
        }

        if (!($etiqueta_titulo = trim($_POST['etiqueta_titulo']))) {
            $errores['EtiquetaTituloGrupoIndicadores'] = 'Escriba aqui la etiqueta del grupo.';
        } else {
            if (!preg_match($patron_etiqueta, $etiqueta_titulo)) {
                $errores['EtiquetaTituloGrupoIndicadores'] = $patron_etiqueta_err;
            }
        }

        if (!($titulo_completo = trim($_POST['titulo_completo']))) {
            $errores['TituloCompletoGrupoIndicadores'] = 'Escriba aqui el titulo completo del grupo.';
        } else {
            if (!preg_match($patron_titulo, $titulo_completo)) {
                $errores['TituloCompletoGrupoIndicadores'] = $patron_titulo_err;
            }
        }

        if (strlen($descripcion = trim($_POST['descripcion'])) > 0) {
            if (!preg_match($patron_descripcion, $descripcion)) {
                $errores['DescripcionGrupoIndicadores'] = $patron_descripcion_err;
            }
        }

        /*if (!preg_match($patron_int, ($ordenamiento_grupo = trim($_POST['ordenamiento_grupo'])))) {
            $errores['OrdenamientoGrupoIndicadores'] = $patron_int_err;
        }*/
        if (sizeof($errores) == 0) {
            $activo = 0;
            $usuario_creador_id = $_SESSION['usuario']['id'];;
            $usuario_modificador_id = $_SESSION['usuario']['id'];;



            $stmt_insertar_grupo_indicador = $conn->prepare("INSERT INTO siee_grupo_indicadores (subsitio_id, etiqueta_titulo, titulo_completo, descripcion, ordenamiento_grupo, activo, usuario_creador_id, fecha_creacion, usuario_modificador_id, fecha_modificacion) VALUES (
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


            $stmt_insertar_grupo_indicador->bindParam(1, $subsitio_id);
            $stmt_insertar_grupo_indicador->bindParam(2, utf8_decode($etiqueta_titulo));
            $stmt_insertar_grupo_indicador->bindParam(3, utf8_decode($titulo_completo));
            $stmt_insertar_grupo_indicador->bindParam(4, utf8_decode($descripcion));
            $stmt_insertar_grupo_indicador->bindParam(5, $ordenamiento_grupo);
            $stmt_insertar_grupo_indicador->bindParam(6, $activo);
            $stmt_insertar_grupo_indicador->bindParam(7, $usuario_creador_id);
            $stmt_insertar_grupo_indicador->bindParam(8, $usuario_modificador_id);

            $conn->exec('BEGIN TRANSACTION');

            try {
                if (!$stmt_insertar_grupo_indicador->execute()) {
                    // aqui se detecatron errores al tratar de guardar los datos en la base de datos.
                    $conn->exec('ROLLBACK TRANSACTION');
                    $response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos estÃƒÂ© ocupada en este momento. Porfavor, intentalo de nuevo.';
                } else {
                    if (($listaIdsIndicadores = trim($_POST['listaIdsIndicadores']))) {
                        $idGrupo = recuperar_identity($conn);
                        $intOrdenamiento = 1;
                        foreach (explode(',', $_POST['listaIdsIndicadores']) as $idIndicador) {
                            $stmt_insertar_relacion = $conn->prepare('INSERT INTO "siee_rel-indicador__grupo_indicadores" (grupo_indicador_id, indicador_id, ordenamiento_indicador) VALUES (?,?,?);');
                            $stmt_insertar_relacion->bindParam(1, $idGrupo);
                            $stmt_insertar_relacion->bindParam(2, $idIndicador);
                            $stmt_insertar_relacion->bindParam(3, $intOrdenamiento);
                            $stmt_insertar_relacion->execute();
                            $intOrdenamiento++;
                        }
                    }

                    if (1 == 1){//sizeof($listaIdsGrupos = ($_POST['listaIdsGrupos'])) > 0) {
                        $listaIdsGrupos = $_POST['listaIdsGrupos'];
                        $listaIdsGrupos[array_search(0, $listaIdsGrupos)] = $idGrupo;
                        $i = 1;
                        foreach ($listaIdsGrupos as $id) {
                            $stmt_ordenar_grupos = $conn->prepare('UPDATE siee_grupo_indicadores SET ordenamiento_grupo = ? WHERE id = ?;');
                            $stmt_ordenar_grupos->bindParam(1, $i);
                            $stmt_ordenar_grupos->bindParam(2, $id);
                            $stmt_ordenar_grupos->execute();
                            $i++;
                        }
                        
                        
                        $idsGruposCSV = implode(',', $listaIdsGrupos);
                        
                        if (!$stmt_ordenar_grupos_inactivos = $conn->query('UPDATE siee_grupo_indicadores SET ordenamiento_grupo = '. $i . ' WHERE id NOT IN ('. $idsGruposCSV . ');')){
                            $response['refresh_error'] = print_r($conn->errorInfo(), true);
                        }
                    }
                    
                    $conn->exec('COMMIT TRANSACTION');
                }
            } catch (PDOException $e) {
                $conn->exec('ROLLBACK TRANSACTION');
                $stmt_insertar_grupo_indicador->closeCursor();
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
