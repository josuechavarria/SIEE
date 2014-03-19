<?php

include '../phpIncluidos/conexion.php';

$patron_titulo = '/^[a-zA-Z0-9_\-)(áÁéÉíÍóÓúÚñÑ°º%#;:.,"\/ ]+$/';
$patron_titulo_err = 'El titulo del indicador contiene caracteres invalidos.';
$patron_descripcion = '/^[a-zA-Z0-9_\-)(áÁéÉíÍóÓúÚñÑ°º%#;:.,\/\-" ]+$/';
$patron_descripcion_err = 'La descripcion del indicador contiene caracteres invalidos.';
$patron_interpretacion = $patron_descripcion;
$patron_interpretacion_err = 'La interpretacion del indicador contiene caracteres invalidos.';
$patron_observaciones_generales = $patron_titulo;
$patron_observaciones_generales_err = 'Las observaciones generales del indicador contiene caracteres invalidos.';
$patron_observaciones_grafico = $patron_titulo;
$patron_observaciones_grafico_err = 'Las observaciones de la grafica del indicador contiene caracteres invalidos.';
$patron_url_archivo_indicador = '/^[a-zA-Z0-9_]+$/';
$patron_url_archivo_indicador_err = 'Solo puedes ingresar caracteres alfanumericos y guiones bajos.';
$response = array();
$errores = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!ISSET($_POST['titulo']) || !ISSET($_POST['descripcion']) || !ISSET($_POST['interpretacion']) || !ISSET($_POST['CodigoMathml']) || !ISSET($_POST['privado']) || !ISSET($_POST['url_archivo_indicador'])) {
        $response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acciÃƒÂ³n de nuevo.';
    } else {
        if (!($titulo = trim($_POST['titulo']))) {
            $errores['TituloIndicador'] = 'Escriba aqui el titulo del indicador.';
        } else {
            if (strlen($titulo) > 256) {
                $errores['TituloIndicador'] = 'El titulo del indicador excede el tama&ntilde;o maximo de 256 caracteres.';
            } else {
                if (!preg_match($patron_titulo, $titulo)) {
                    $errores['TituloIndicador'] = $patron_titulo_err;
                } else {
                    //si ya existe un nombre de indicador igual al este
                    $stmt_verificarRepetido = $conn->prepare("	SELECT DISTINCT count(id) as cant
                                                                FROM siee_indicador
                                                                WHERE lower(LTRIM(RTRIM(titulo))) = lower(:TituloIndicador)");
                    $stmt_verificarRepetido->bindParam(':TituloIndicador', utf8_decode($titulo));
                    $stmt_verificarRepetido->execute();
                    $datos = $stmt_verificarRepetido->fetch();
                    $stmt_verificarRepetido->closeCursor();
                    $existe = $datos['cant'];
                    if ($existe != '0') {
                        $errores['TituloIndicador'] = "Ya existe un indicador con este mismo titulo.";
                    }
                }
            }
        }

        if (!($descripcion = trim($_POST['descripcion']))) {
            $errores['DescripcionIndicador'] = 'Escriba aqui la descripcion del indicador.';
        } else {
            if (strlen($descripcion) > 2048) {
                $errores['DescripcionIndicador'] = 'La descripcion del indicador excede el tama&ntilde;o maximo de 2048 caracteres.';
            } else {
                if (!preg_match($patron_descripcion, $descripcion)) {
                    $errores['DescripcionIndicador'] = $patron_descripcion_err;
                }
            }
        }

        if (!($interpretacion = trim($_POST['interpretacion']))) {
            $errores['InterpretacionIndicador'] = 'Escriba aqui la interpretacion del indicador.';
        } else {
            if (strlen($interpretacion) > 2048) {
                $errores['InterpretacionIndicador'] = 'La interpretacion del indicador excede el tama&ntilde;o maximo de 2048 caracteres.';
            } else {
                if (!preg_match($patron_interpretacion, $interpretacion)) {
                    $errores['InterpretacionIndicador'] = $patron_interpretacion_err;
                }
            }
        }

        if (!($tipoDeEducacionId = trim($_POST['tipo_educacion_id']))) {
            $errores['TipoDeEducacionIndicador'] = 'Seleccione el tipo de educacion.';
        }

        if (!($tipoDeMatriculaId = trim($_POST['tipo_matricula_id']))) {
            $errores['TipoDeMatriculaIndicador'] = 'Seleccione el tipo de matricula.';
        }

        if (!($observacionesGraficas = trim($_POST['observaciones_graficas']))) {
            $errores['ObservacionGraficos'] = 'Escriba aqui las observaciones graficas.';
        } else {
            if (strlen($observacionesGraficas) > 256) {
                $errores['ObservacionGraficos'] = 'La observacion del grafico excede el tama&ntilde;o maximo de 256 caracteres.';
            } else {
                if (!preg_match($patron_observaciones_grafico, $observacionesGraficas)) {
                    $errores['ObservacionGraficos'] = $patron_observaciones_grafico_err;
                }
            }
        }

        if (!($observacionesGenerales = trim($_POST['observaciones_generales']))) {
            $errores['ObservacionGenerales'] = 'Escriba aqui las observaciones generales.';
        } else {
            if (strlen($observacionesGenerales) > 2048) {
                $errores['ObservacionGenerales'] = 'La observacion general del grafico excede el tama&ntilde;o maximo de 2048 caracteres.';
            } else {
                if (!preg_match($patron_observaciones_generales, $observacionesGenerales)) {
                    $errores['ObservacionGenerales'] = $patron_observaciones_generales_err;
                }
            }
        }

        if (!($formulaMath = trim($_POST['CodigoMathml']))) {
            $errores['CodigoMathml'] = 'Escriba aqui la formula MathMl';
        } else {
            if (strlen($formulaMath) > 4096) {
                $errores['CodigoMathml'] = 'La formula MathML del indicador excede el tama&ntilde;o maximo de 4096 caracteres.';
            }
        }

        if (!($url_archivo_indicador = trim($_POST['url_archivo_indicador']))) {
            $errores['UrlArchivoIndicador'] = 'Escriba aqui el nombre del archivo.';
        } else {
            if (strlen($url_archivo_indicador) > 256) {
                $errores['UrlArchivoIndicador'] = 'El nombre del archivo excede el tama&ntilde;o maximo de 256 caracteres.';
            } else {
                if (!preg_match($patron_url_archivo_indicador, $url_archivo_indicador)) {
                    $errores['UrlArchivoIndicador'] = $patron_url_archivo_indicador_err;
                } else {
                    $stmt_validar_duplicidad = $conn->prepare('SELECT COUNT(*) FROM siee_indicador WHERE url_archivo_indicador = ?;');
                    if (!$stmt_validar_duplicidad->execute(array($url_archivo_indicador))) {
                        $response['refresh_error'] = '1Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos está ocupada en este momento. Porfavor, intentalo de nuevo.';
                        $conn->exec('ROLLBACK TRANSACTION');
                        $stmt_validar_duplicidad->closeCursor();
                    } else {
                        $count = $stmt_validar_duplicidad->fetch();
                        $stmt_validar_duplicidad->closeCursor();

                        if ($count[0] != 0) {
                            $errores['UrlArchivoIndicador'] = 'Ya existe un archivo de indicador con este nombre.';
                        }
                    }
                }
            }
        }

        if (ISSET($_POST['listaDeVariables'])) {
            $listaDeVariables = $_POST['listaDeVariables'];
        }

        if (ISSET($_POST['listaDeVariablesDescripcion'])) {
            $listaDeVariablesDescripcion = $_POST['listaDeVariablesDescripcion'];
        }

        $listaAlias = array();

        if (ISSET($_POST['listaAlias'])) {
            $listaAlias = $_POST['listaAlias'];

            foreach ($listaAlias as $alias) {
                if (strlen($alias) > 256) {
                    $errores['Alias'] = 'Los alias no pueden exceder el tama&ntilde;o maximo de 256 caracteres.';
                } else {
                    if (!preg_match($patron_titulo, $alias)) {
                        $errores['Alias'] = 'Uno o mas de los alias contienen caracteres invalidos.';
                    }
                }
            }
        }

        if (!ISSET($_POST['SeriesIndicadoresIds'])) {
            $errores['SeriesIndicadoresIds'] = 'Debe Seleccionar al menos una serie';
        } else {
            $listaDeIdSeries = $_POST['SeriesIndicadoresIds'];
        }

        if (!ISSET($_POST['NivelesIds'])) {
            $errores['NivelesIds'] = 'Debe Seleccionar al menos un nivel';
        } else {
            $listaDeIdNiveles = $_POST['NivelesIds'];
        }

        if (!ISSET($_POST['DesagregacionIds'])) {
            $errores['DesagregacionIds'] = 'Debe Seleccionar la menos una desagregacion.';
        } else {
            $listaDeIdDesagresacion = $_POST['DesagregacionIds'];
        }
        if (!ISSET($_POST['fuentesDatosIds'])) {
            $errores['FuentesDatosIds'] = 'Debe seleccionar al menos una fuente de datos.';
        } else {
            $fuentesDatosIds = $_POST['fuentesDatosIds'];
        }

        $stmt_nombre_tabla_resumen = $conn->query('select min(periodo_id) as anio_base from ( SELECT DISTINCT periodo_id FROM siee_resumen_data_indicadores WHERE es_inicial = 1 AND tipo_indicador_id = 7 )d;');
        $nombre_tabla_resumen = $stmt_nombre_tabla_resumen->fetch();
        $stmt_nombre_tabla_resumen->closeCursor();


        if (sizeof($nombre_tabla_resumen) > 0) {
            $anio_base = $nombre_tabla_resumen['anio_base'];
        } else {
            $anio_base = date('Y');
        }

        if (sizeof($errores) == 0) {
            $privado = $_POST['privado'];
            $activo = 0;
            $usuario_creador_id = $_SESSION['usuario']['id'];
            $usuario_modificador_id = $_SESSION['usuario']['id'];
            $codigoIndicador = 1;
            $numeroIndicador = 1;
            $anoDeReferenciaIndicador = 1;
            $urlMuestraGrafica = "/Administracion/..";
            $publicado = 0;
            //$formulaMath = "0";
            $formulaUrl = "0";


            $stmt_insertar_indicador = $conn->prepare("INSERT INTO siee_indicador (codigo_indicador,
                                                                                    titulo,
                                                                                    descripcion,
                                                                                    interpretacion,
                                                                                    tipo_educacion_id,
                                                                                    anios_referencia_id,
                                                                                    anio_base,
                                                                                    tipo_matricula_id,
                                                                                    url_muestra_grafica,
                                                                                    observaciones_grafica,
                                                                                    observacion_general,
                                                                                    activo,
                                                                                    publicado,
                                                                                    url_archivo_indicador,
                                                                                    formula_mathml,
                                                                                    formula_urlimagen,
                                                                                    usuario_creador_id,
                                                                                    fecha_creacion, 
                                                                                    usuario_modificador_id, 
                                                                                    fecha_modificacion,
                                                                                    privado) VALUES (
                                                                                    ?,
                                                                                    ?,
                                                                                    ?,
                                                                                    ?,
                                                                                    ?,
                                                                                    ?,
                                                                                    ?,
                                                                                    ?,
                                                                                    ?,
                                                                                    ?,
                                                                                    ?,
                                                                                    ?,
                                                                                    ?,
                                                                                    ?,
                                                                                    ?,
                                                                                    ?,
                                                                                    ?,
                                                                                    CURRENT_TIMESTAMP,
                                                                                    ?,
                                                                                    CURRENT_TIMESTAMP,
                                                                                    ?);");

            $stmt_insertar_indicador->bindParam(1, $codigoIndicador);
            // $stmt_insertar_indicador->bindParam(2, $numeroIndicador);
            $stmt_insertar_indicador->bindParam(2, utf8_decode($titulo));
            $stmt_insertar_indicador->bindParam(3, utf8_decode($descripcion));
            $stmt_insertar_indicador->bindParam(4, utf8_decode($interpretacion));
            $stmt_insertar_indicador->bindParam(5, $tipoDeEducacionId);
            $stmt_insertar_indicador->bindParam(6, $anoDeReferenciaIndicador);
            $stmt_insertar_indicador->bindParam(7, $anio_base);
            $stmt_insertar_indicador->bindParam(8, $tipoDeMatriculaId);
            $stmt_insertar_indicador->bindParam(9, $urlMuestraGrafica);
            $stmt_insertar_indicador->bindParam(10, utf8_decode($observacionesGraficas));
            $stmt_insertar_indicador->bindParam(11, utf8_decode($observacionesGenerales));
            $stmt_insertar_indicador->bindParam(12, $activo);
            $stmt_insertar_indicador->bindParam(13, $publicado);
            $stmt_insertar_indicador->bindParam(14, $url_archivo_indicador);
            $stmt_insertar_indicador->bindParam(15, htmlentities($formulaMath));
            $stmt_insertar_indicador->bindParam(16, $formulaUrl);
            $stmt_insertar_indicador->bindParam(17, $usuario_creador_id);
            $stmt_insertar_indicador->bindParam(18, $usuario_modificador_id);
            $stmt_insertar_indicador->bindParam(19, $privado);

            $conn->exec('BEGIN TRANSACTION');

            try {
                if (!$stmt_insertar_indicador->execute()) {
                    // aqui se detecatron errores al tratar de guardar los datos en la base de datos.
                    $response['refresh_error'] = '1- Error ' . print_r($stmt_insertar_indicador->errorInfo(), true); //$privado . ' - Hubooooooo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos estÃƒÂ© ocupada en este momento. Porfavor, intentalo de nuevo.';
                    $conn->exec('ROLLBACK TRANSACTION');
                } else {

                    $idIndicadorNuevo = recuperar_identity($conn);
                    $commit = true;

                    $codigoIndicador = "IND_" . $idIndicadorNuevo;

                    $stmt_insertar_codigo_indicador = $conn->prepare("UPDATE siee_indicador set codigo_indicador = ? WHERE id = ?;");
                    $stmt_insertar_codigo_indicador->bindParam(1, $codigoIndicador);
                    $stmt_insertar_codigo_indicador->bindParam(2, $idIndicadorNuevo);

                    if (!$stmt_insertar_codigo_indicador->execute()) {
                        $conn->exec('ROLLBACK TRANSACTION');
                        $response['refresh_error'] = '2Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos estÃƒÂ© ocupada en este momento. Porfavor, intentalo de nuevo.';
                        $commit = false;
                        break;
                    }


                    if ($listaDeIdSeries) {
                        foreach ($listaDeIdSeries as $idSerie) {

                            $stmt_serie_count = $conn->query('SELECT  max(numero)
                                                                FROM [siee_rel-indicador__serie_indicadores]
                                                                where serie_indicadores_id =' . $idSerie);
                            $lista_serie_count = $stmt_serie_count->fetchAll();
                            $stmt_serie_count->closeCursor();
                            $maxSerie = $lista_serie_count[0][0];

                            if ($maxSerie == null) {
                                $numeroIndicador = 1;
                            } else {
                                $numeroIndicador = $maxSerie + 1;
                            }


                            $stmt_insertar_relacion = $conn->prepare('INSERT INTO "siee_rel-indicador__serie_indicadores" VALUES (?,?,?);');
                            $stmt_insertar_relacion->bindParam(1, $idSerie);
                            $stmt_insertar_relacion->bindParam(2, $idIndicadorNuevo);
                            $stmt_insertar_relacion->bindParam(3, $numeroIndicador);

                            if (!$stmt_insertar_relacion->execute()) {
                                $conn->exec('ROLLBACK TRANSACTION');
                                $response['refresh_error'] = '3Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos estÃƒÂ© ocupada en este momento. Porfavor, intentalo de nuevo.';
                                $commit = false;
                                break;
                            }
                        }
                    }
                    if ($listaDeIdNiveles) {
                        foreach ($listaDeIdNiveles as $idNivel) {
                            $stmt_insertar_relacion = $conn->prepare('INSERT INTO "siee_rel-indicador__nivel_educativo" VALUES (?,?);');
                            $stmt_insertar_relacion->bindParam(1, $idIndicadorNuevo);
                            $stmt_insertar_relacion->bindParam(2, $idNivel);



                            if (!$stmt_insertar_relacion->execute()) {
                                $conn->exec('ROLLBACK TRANSACTION');
                                $response['refresh_error'] = '4Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos estÃƒÂ© ocupada en este momento. Porfavor, intentalo de nuevo.';
                                $commit = false;
                                break;
                            }
                        }
                    }
                    if ($listaDeIdDesagresacion) {
                        foreach ($listaDeIdDesagresacion as $idDesagregacion) {
                            $stmt_insertar_relacion = $conn->prepare('INSERT INTO "siee_rel-indicador__tipo_desagregacion" VALUES (?,?);');
                            $stmt_insertar_relacion->bindParam(1, $idIndicadorNuevo);
                            $stmt_insertar_relacion->bindParam(2, $idDesagregacion);

                            if (!$stmt_insertar_relacion->execute()) {
                                $conn->exec('ROLLBACK TRANSACTION');
                                $response['refresh_error'] = '5Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos estÃƒÂ© ocupada en este momento. Porfavor, intentalo de nuevo.';
                                $commit = false;
                                break;
                            }
                        }
                    }

                    if ($fuentesDatosIds) {
                        foreach ($fuentesDatosIds as $idFuenteDato) {
                            $stmt_insertar_relacion = $conn->prepare('INSERT INTO "siee_rel-indicador__fuente_dato" VALUES (?,?);');

                            if (!($stmt_insertar_relacion->execute(array($idFuenteDato, $idIndicadorNuevo)))) {
                                $response['refresh_error'] = '5.5Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos est&aacute; ocupada en este momento. Porfavor, intentalo de nuevo.';
                                $conn - exec('ROLLBACK TRANSACTION');
                                $commit = false;
                                break;
                            }
                        }
                    }

                    if ($listaDeVariables) {
                        $i = 0;
                        while ($i < count($listaDeVariables)) {
                            $mathmlvariable = htmlentities($listaDeVariables[$i]);

                            $stmt_insertar_variables = $conn->prepare('INSERT INTO "siee_variables_indicador" VALUES (?,?,?);');
                            $stmt_insertar_variables->bindParam(1, $idIndicadorNuevo);
                            $stmt_insertar_variables->bindParam(2, $mathmlvariable);
                            $stmt_insertar_variables->bindParam(3, utf8_decode($listaDeVariablesDescripcion[$i]));

                            if (!$stmt_insertar_variables->execute()) {
                                $response['refresh_error'] = '2- Error ' . print_r($stmt_insertar_variables->errorInfo(), true) . 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos está ocupada en este momento. Porfavor, intentalo de nuevo. er-var';
                                $conn->exec('ROLLBACK TRANSACTION');
                                $commit = false;
                                break;
                            }
                            $i++;
                        }
                    }

                    if ($listaAlias) {
                        foreach ($listaAlias as $alias) {
                            $stmt_insertar_alias = $conn->prepare('INSERT INTO siee_alias (titulo, indicador_id) VALUES (?,?);');
                            $stmt_insertar_alias->bindParam(1, $alias);
                            $stmt_insertar_alias->bindParam(2, $idIndicadorNuevo);

                            if (!$stmt_insertar_alias->execute()) {
                                $response['refresh_error'] = '3- Error ' . print_r($stmt_insertar_alias->errorInfo(), true) . 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos está ocupada en este momento. Porfavor, intentalo de nuevo.';
                                $conn->exec('ROLLBACK TRANSACTION');
                                $commit = false;
                                break;
                            }
                        }
                    }

                    if ($commit) {
                        //generar el procedimiento almacenado del indicadore nuevo
                        //crearProcedimientoAlmacenado($titulo, $descripcion, str_replace(' ', '_', $titulo), $conn);
                        //crear el archivo del indicador

                        $stmt_generar_procedimiento_almacenado = $conn->prepare(
                                'DECLARE	@return_value int

								EXEC	@return_value = [dbo].[GenerarProcedimientoAlmacenado]
										@titulo = N\'' . utf8_decode($titulo) . '\',
										@descripcion = N\'' . utf8_decode($descripcion) . '\',
										@nombreDeArchivo = N\'' . $url_archivo_indicador . '\'

								SELECT	\'Return Value\' = @return_value');

                        if (!$stmt_generar_procedimiento_almacenado->execute(array($titulo, $descripcion, $titulo))) {
                            $response['refresh_error'] = '6Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos estÃƒÂ© ocupada en este momento. Porfavor, intentalo de nuevo.';
                            $stmt_generar_procedimiento_almacenado->closeCursor();
                            $conn->exec('ROLLBACK TRANSACTION');
                        } else {
                            $return_value = $stmt_generar_procedimiento_almacenado->fetch();
                            $stmt_generar_procedimiento_almacenado->closeCursor();

                            if ($return_value[0] == 1) {
                                include '../phpIncluidos/generarArchivoIndicador.php';
                                generarArchivoIndicador($idIndicadorNuevo, $url_archivo_indicador);
                                $conn->exec('COMMIT TRANSACTION');
                            } else {
                                $response['refresh_error'] = '7Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos estÃƒÂ© ocupada en este momento. Porfavor, intentalo de nuevo.';
                                $conn->exec('ROLLBACK TRANSACTION');
                            }
                        }
                    }
                }
            } catch (PDOException $e) {
                $conn->exec('ROLLBACK TRANSACTION');
                $stmt_insertar_indicador->closeCursor();
                // enviar html de errores o js function que ejecute el mensaje de errores

                $response['refresh_error'] = '4- ' . $e;
                $response['refresh_error'] = '8Hubo un error al tratar de insertar los datos en la base de datos. Porfavor, intentalo de nuevo.';
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
