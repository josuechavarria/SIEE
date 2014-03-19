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
    if (!ISSET($_POST['titulo']) || !ISSET($_POST['descripcion']) || !ISSET($_POST['interpretacion'])) {
        $response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acciÃƒÂ³n de nuevo.';
    } else {
        if (!($titulo = trim($_POST['titulo']))) {
            $errores['TituloIndicador_mod'] = 'Escriba aqui el titulo del indicador.';
        } else {
            if (!preg_match($patron_titulo, $titulo)) {
                $errores['TituloIndicador_mod'] = $patron_titulo_err;
            }
        }

        if (!($descripcion = trim($_POST['descripcion']))) {
            $errores['DescripcionIndicador_mod'] = 'Escriba aqui la descripcion del indicador.';
        } else {
            if (!preg_match($patron_descripcion, $descripcion)) {
                $errores['DescripcionIndicador_mod'] = $patron_descripcion_err;
            }
        }

        if (!($interpretacion = trim($_POST['interpretacion']))) {
            $errores['InterpretacionIndicador_mod'] = 'Escriba aqui la interpretacion del indicador.';
        } else {
            if (!preg_match($patron_interpretacion, $interpretacion)) {
                $errores['InterpretacionIndicador_mod'] = $patron_interpretacion_err;
            }
        }

        if (!($tipoDeEducacionId = trim($_POST['tipo_educacion_id']))) {
            $errores['TipoDeEducacionIndicador_mod'] = 'Seleccione el tipo de educacion.';
        }

        if (!($tipoDeMatriculaId = trim($_POST['tipo_matricula_id']))) {
            $errores['TipoDeMatriculaIndicador_mod'] = 'Seleccione el tipo de matricula.';
        }

        if (!($observacionesGraficas = trim($_POST['observaciones_graficas']))) {
            $errores['ObservacionGraficos_mod'] = 'Escriba aqui las observaciones graficas.';
        } else {
            if (!preg_match($patron_observaciones_grafico, $observacionesGraficas)) {
                $errores['ObservacionGraficos_mod'] = $patron_observaciones_grafico_err;
            }
        }
        if (!($observacionesGenerales = trim($_POST['observaciones_generales']))) {
            $errores['ObservacionGenerales_mod'] = 'Escriba aqui las observaciones generales.';
        } else {
            if (!preg_match($patron_observaciones_generales, $observacionesGenerales)) {
                $errores['TipoDeMatriculaIndicador_mod'] = $patron_observaciones_generales_err;
            }
        }


        if (!ISSET($_POST['SeriesIndicadoresIds'])) {
            $errores['SeriesIndicadoresIds_mod'] = 'Debe Seleccionar al menos una serie';
        } else {
            $listaDeIdSeries = $_POST['SeriesIndicadoresIds'];
        }

        if (!ISSET($_POST['NivelesIds'])) {
            $errores['NivelesIds_mod'] = 'Debe Seleccionar al menos un nivel';
        } else {
            $listaDeIdNiveles = $_POST['NivelesIds'];
        }

        if (!ISSET($_POST['DesagregacionIds'])) {
            $errores['DesagregacionIds_mod'] = 'Debe Seleccionar la menos una desagregacion.';
        } else {
            $listaDeIdDesagresacion = $_POST['DesagregacionIds'];
        }

		if (!ISSET($_POST['fuentesDatosIds'])){
			$errores['FuentesDatosIds_mod'] = 'Debe seleccionar al menos una fuente de datos.';
		}else{
			$fuentesDatosIds = $_POST['fuentesDatosIds'];
		}
		
        if (!ISSET($_POST['listaDeVariables'])) {
            $errores['listaDeVariables_mod'] = 'Debe Agregar variables.';
        } else {
            $listaDeVariables = $_POST['listaDeVariables'];
        }


        if (!ISSET($_POST['listaDeVariablesDescripcion'])) {
            $errores['listaDeVariablesDescripcion_mod'] = 'Debe Ingresar la descrupcion de la variable.';
        } else {
            $listaDeVariablesDescripcion = $_POST['listaDeVariablesDescripcion'];
        }

		$listaAlias = array();
		
		if (ISSET($_POST['listaAlias'])) {
			$listaAlias = $_POST['listaAlias'];
			
			foreach($listaAlias as $alias){
				if (strlen($alias) > 256){
					$errores['Alias_mod'] = 'Los alias no pueden exceder el tama&ntilde;o maximo de 256 caracteres.';
				}else{
					if (!preg_match($patron_titulo, $alias)) {
						$errores['Alias_mod'] = 'Uno o mas de los alias contienen caracteres invalidos.';
					}
				}
			}
		}
		
        if (!ISSET($_POST['privado'])) {
            $errores['PrivadoIndicador_mod'] = 'Seleccione si es privado o no';
        } else {
            $privado = $_POST['privado'];
        }
        if (!ISSET($_POST['CodigoMathml'])) {
            $errores['CodigoMathml_mod'] = 'Escriba aqui la formula MathMl';
        } else {
            $formulaMath = $_POST['CodigoMathml'];
        }



        if (sizeof($errores) == 0) {
            $idIndicador = $_POST['id'];
            //$usuario_creador_id = 3;
            $usuario_modificador_id = $_SESSION['usuario']['id'];
            $codigoIndicador = 1;
            $numeroIndicador = 1;
            $anoDeReferenciaIndicador = 1;
            $urlMuestraGrafica = "/Administracion/..";
            //$formulaMath = "0";
            $formulaUrl = "0";


            $stmt_modificar_indicador = $conn->prepare("UPDATE siee_indicador SET  titulo = ?,
                                                                            descripcion= ?,
                                                                            interpretacion= ?,
                                                                            tipo_educacion_id= ?,
                                                                            anios_referencia_id= ?,
                                                                            tipo_matricula_id= ?,
                                                                            url_muestra_grafica= ?,
                                                                            observaciones_grafica= ?,
                                                                            observacion_general= ?,
                                                                            formula_mathml= ?,
                                                                            formula_urlimagen= ?,
                                                                            usuario_modificador_id= ?,
                                                                            privado = ?,
                                                                            fecha_modificacion = CURRENT_TIMESTAMP
                                                                            WHERE id = ?;");

            //$stmt_modificar_indicador->bindParam(1, $codigoIndicador);
            // $stmt_modificar_indicador->bindParam(2, $numeroIndicador);
            $stmt_modificar_indicador->bindParam(1, utf8_decode($titulo));
            $stmt_modificar_indicador->bindParam(2, utf8_decode($descripcion));
            $stmt_modificar_indicador->bindParam(3, utf8_decode($interpretacion));
            $stmt_modificar_indicador->bindParam(4, $tipoDeEducacionId);
            $stmt_modificar_indicador->bindParam(5, $anoDeReferenciaIndicador);
            $stmt_modificar_indicador->bindParam(6, $tipoDeMatriculaId);
            $stmt_modificar_indicador->bindParam(7, $urlMuestraGrafica);
            $stmt_modificar_indicador->bindParam(8, utf8_decode($observacionesGraficas));
            $stmt_modificar_indicador->bindParam(9, utf8_decode($observacionesGenerales));
            $stmt_modificar_indicador->bindParam(10, htmlentities($formulaMath));
            $stmt_modificar_indicador->bindParam(11, $formulaUrl);
            $stmt_modificar_indicador->bindParam(12, $usuario_modificador_id);
            $stmt_modificar_indicador->bindParam(13, $privado);
            $stmt_modificar_indicador->bindParam(14, $idIndicador);

            $conn->exec('BEGIN TRANSACTION');

            try {
                if (!$stmt_modificar_indicador->execute()) {
                    // aqui se detecatron errores al tratar de guardar los datos en la base de datos.
                    $response['refresh_error'] = print_r($stmt_modificar_indicador->errorInfo()) . 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos está ocupada en este momento. Porfavor, intentalo de nuevo. 1';

                    $conn->exec('ROLLBACK TRANSACTION');
                } else {


                    $stmt_eliminar_series_indicador = $conn->prepare('DELETE FROM "siee_rel-indicador__serie_indicadores" WHERE indicador_id = ?;');
                    $stmt_eliminar_series_indicador->bindParam(1, $idIndicador);

                    if (!$stmt_eliminar_series_indicador->execute()) {
                        $conn->exec('ROLLBACK TRANSACTION');
                        $response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos está ocupada en este momento. Porfavor, intentalo de nuevo. 2';
                    } else {

                        $commit = true;

                        if ($listaDeIdSeries) {
                            foreach ($listaDeIdSeries as $idSerie) {
                                $stmt_insertar_relacion = $conn->prepare('INSERT INTO "siee_rel-indicador__serie_indicadores" VALUES (?,?,?);');
                                $stmt_insertar_relacion->bindParam(1, $idSerie);
                                $stmt_insertar_relacion->bindParam(2, $idIndicador);
                                $stmt_insertar_relacion->bindParam(3, $numeroIndicador);

                                if (!$stmt_insertar_relacion->execute()) {
                                    $conn->exec('ROLLBACK TRANSACTION');
                                    $response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos está ocupada en este momento. Porfavor, intentalo de nuevo. 3';
                                    $commit = false;
                                    break;
                                }
                            }
                        }
                    }


                    $stmt_eliminar_niveles = $conn->prepare('DELETE FROM "siee_rel-indicador__nivel_educativo" WHERE indicador_id = ?;');
                    $stmt_eliminar_niveles->bindParam(1, $idIndicador);

                    if (!$stmt_eliminar_niveles->execute()) {
                        $conn->exec('ROLLBACK TRANSACTION');
                        $response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos está ocupada en este momento. Porfavor, intentalo de nuevo. 4';
                    } else {

                        $commit = true;

                        if ($listaDeIdNiveles) {
                            foreach ($listaDeIdNiveles as $idNivel) {
                                $stmt_insertar_relacion = $conn->prepare('INSERT INTO "siee_rel-indicador__nivel_educativo" VALUES (?,?);');
                                $stmt_insertar_relacion->bindParam(1, $idIndicador);
                                $stmt_insertar_relacion->bindParam(2, $idNivel);



                                if (!$stmt_insertar_relacion->execute()) {
                                    $conn->exec('ROLLBACK TRANSACTION');
                                    $response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos está ocupada en este momento. Porfavor, intentalo de nuevo. 5';
                                    $commit = false;
                                    break;
                                }
                            }
                        }
                    }

                    $stmt_eliminar_desagregacion = $conn->prepare('DELETE FROM "siee_rel-indicador__tipo_desagregacion" WHERE indicador_id = ?;');
                    $stmt_eliminar_desagregacion->bindParam(1, $idIndicador);

                    if (!$stmt_eliminar_desagregacion->execute()) {
                        $conn->exec('ROLLBACK TRANSACTION');
                        $response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos está ocupada en este momento. Porfavor, intentalo de nuevo. 6';
                    } else {
                        $commit = true;

                        if ($listaDeIdDesagresacion) {
                            foreach ($listaDeIdDesagresacion as $idDesagregacion) {
                                $stmt_insertar_relacion = $conn->prepare('INSERT INTO "siee_rel-indicador__tipo_desagregacion" VALUES (?,?);');
                                $stmt_insertar_relacion->bindParam(1, $idIndicador);
                                $stmt_insertar_relacion->bindParam(2, $idDesagregacion);

                                if (!$stmt_insertar_relacion->execute()) {
                                    $conn->exec('ROLLBACK TRANSACTION');
                                    $response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos está ocupada en este momento. Porfavor, intentalo de nuevo. 7';
                                    $commit = false;
                                    break;
                                }
                            }
                        }
                    }
					
					$stmt_eliminar_fuentes = $conn->prepare('DELETE FROM "siee_rel-indicador__fuente_dato" WHERE indicador_id = ?;');
					
					if (!($stmt_eliminar_fuentes->execute(array($idIndicador)))){
						$conn->exec('ROLLBACK TRANSACTION');
						$response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos est&aacute; ocupada en este momento. Porfavor, intentalo de nuevo. 8';
					}else{
						$commit = true;
						
						if ($fuentesDatosIds){
							foreach($fuentesDatosIds as $id){
								$stmt_insertar_relacion = $conn->prepare('INSERT INTO "siee_rel-indicador__fuente_dato" VALUES (?,?);');
								
								if (!($stmt_insertar_relacion->execute(array($id, $idIndicador)))){
									$conn->exec('ROLLBACK TRANSACTION');
									$response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos est&aacute; ocupada en este momento. Porfavor, intentalo de nuevo. 9';
									$commit = false;
									break;
								}
							}
						}
					}
                    
					$stmt_eliminar_variables = $conn->prepare('DELETE FROM siee_variables_indicador WHERE indicador_id = ?;');
                    $stmt_eliminar_variables->bindParam(1, $idIndicador);

                    if (!$stmt_eliminar_variables->execute()) {
                        $conn->exec('ROLLBACK TRANSACTION');
                        $response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos estÃƒÂ© ocupada en este momento. Porfavor, intentalo de nuevo. 10';
                    } else {

                        $commit = true;

                        if ($listaDeVariables) {

                            $i = 0;
                            while ($i < count($listaDeVariables)) {
                                $stmt_insertar_variables = $conn->prepare('INSERT INTO "siee_variables_indicador" VALUES (?,?,?);');
                                $stmt_insertar_variables->bindParam(1, $idIndicador);
                                $stmt_insertar_variables->bindParam(2, htmlentities($listaDeVariables[$i]));
                                $stmt_insertar_variables->bindParam(3, utf8_decode(trim($listaDeVariablesDescripcion[$i])));

                                if (!$stmt_insertar_variables->execute()) {
                                    $conn->exec('ROLLBACK TRANSACTION');
                                    $response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos está ocupada en este momento. Porfavor, intentalo de nuevo. 11';
                                    $commit = false;
                                    break;
                                }


                                $i++;
                            }
                        }
                    }
					
					$stmt_eliminar_alias = $conn->prepare('DELETE FROM siee_alias WHERE indicador_id = ?;');
					
					if (!$stmt_eliminar_alias->execute(array($idIndicador))){
						$conn->exec('ROLLBACK TRANSACTION');
						$response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos est&aacute; ocupada en este momento. Porfavor, intentalo de nuevo. 10';
					}else{
						$commit = true;
						
						if ($listaAlias){
							foreach($listaAlias as $alias){
								$stmt_insertar_alias = $conn->prepare('INSERT INTO siee_alias (titulo, indicador_id) VALUES (?,?);');
								$stmt_insertar_alias->bindParam(1, utf8_decode($alias));
								$stmt_insertar_alias->bindParam(2, $idIndicador);

								if (!$stmt_insertar_alias->execute()){
									$response['refresh_error'] = print_r($stmt_insertar_alias->errorInfo(), true) . 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos está ocupada en este momento. Porfavor, intentalo de nuevo.';
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
                //echo $e;
                $conn->exec('ROLLBACK TRANSACTION');
                $stmt_modificar_indicador->closeCursor();
                // enviar html de errores o js function que ejecute el mensaje de errores
                $response['refresh_error'] = 'Hubo un error al tratar de insertar los datos en la base de datos. Porfavor, intentalo de nuevo. 12';
            }
        }
    }
} else {
    $response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acción de nuevo.';
}

if (sizeof($errores) > 0) {
    $response['errores'] = $errores;
}

echo json_encode($response);
?>
