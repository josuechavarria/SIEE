<?php

//ESTE ARCHIVO ES SOLO PARA MANEJAR LOS GET DEL AJAX DEL SIEE
include 'conexion.php';
include 'conexion_ee.php';
$response = Array();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (ISSET($_GET['opcion'])) {
        $opcion = $_GET['opcion'];
        $patron = '/^[[:digit:]]+$/';
        if (preg_match($patron, $opcion)) {
            switch ($opcion) {
                case 1:
                    //obtiene la lista de municipios por departamento, dado el id de un departamento.
                    //asi como la lista de Centros educativos para ese departamento dado.
                    if (ISSET($_GET['departamento_id'])) {
                        $departamento_id = $_GET['departamento_id'];
                        if (preg_match($patron, $departamento_id) && ( (0 <= $departamento_id) && ($departamento_id <= 18) )) {
                            $stmt_municipios = $conn_ee->prepare('	SELECT id, LOWER(LTRIM(RTRIM(descripcion_municipio))) descripcion_municipio
                                                                        FROM ee_municipios
                                                                        WHERE departamento_id = :DepartamentoId
                                                                        ORDER BY descripcion_municipio');
                            $stmt_municipios->bindParam(':DepartamentoId', $departamento_id);
                            $stmt_municipios->execute();
                            $lista_municipios = $stmt_municipios->fetchAll();
                            $stmt_municipios->closeCursor();

                            if (sizeOf($lista_municipios) > 0) {
                                $response['municipios'] = utf8_encode_mix($lista_municipios, false, true);
                            } else {
                                $response['error'] = "";
                            }
                        } else {
                            $response['error'] = "No se encontraron municipios para este departamento, o es posible que el codigo de departamento este corrupto";
                        }
                    } else {
                        $response['error'] = "No existe una consulta para los parametros enviados";
                    }
                    break;
                case 2:
                    //obtiene la lista de Centros Educativos de un departamentos y municipio dado.
                    if (ISSET($_GET['departamento_id']) && ISSET($_GET['municipio_id'])) {
                        $departamento_id = $_GET['departamento_id'];
                        $municipio_id = $_GET['municipio_id'];
                        if (preg_match($patron, $departamento_id) && ( (1 <= $departamento_id) && ($departamento_id <= 18) )
                                && preg_match($patron, $municipio_id) && ( (1 <= $municipio_id) && ($municipio_id <= 300) )) {
                            $stmt_existeCombinacion = $conn_ee->prepare('	SELECT DISTINCT count(*)
                                                                                FROM ee_municipios
                                                                                WHERE	departamento_id = :DepartamentoId
                                                                                AND id = :MunicipioId ');

                            $stmt_existeCombinacion->bindParam(':DepartamentoId', $departamento_id);
                            $stmt_existeCombinacion->bindParam(':MunicipioId', $municipio_id);
                            $stmt_existeCombinacion->execute();
                            $existeCombinacion = $stmt_existeCombinacion->fetchAll();
                            $stmt_existeCombinacion->closeCursor();

                            if (sizeOf($existeCombinacion) > 0) {
                                $response['existe'] = '1';
                            } else {
                                $response['error'] = "Parece que el municipio enviado no pertenece al departamento seleccionado, por favor refresque la página e intente esta acción de nuevo.";
                            }
                        } else {
                            $response['error'] = "No se encontraron datos para los parametros de Municipio y Departamento enviados.";
                        }
                    } else {
                        $response['error'] = "La informaci&oacute;n parece estar corrupta, refresca la p&aacute;gina y realiza esta acci&oacute;n de nuevo.";
                    }
                    break;
                case 3:
                    //obtiene varios datos de un determinado indicador conociendo su codigo.
                    if (ISSET($_GET['codigo_indicador'])) {
                        $codigo_indicador = $_GET['codigo_indicador'];

                        $stmt_datos_indicador = $conn->prepare("SELECT id, url_archivo_indicador
																FROM siee_indicador
																WHERE codigo_indicador = :CodigoIndicador");
                        $stmt_datos_indicador->bindParam(':CodigoIndicador', $codigo_indicador);
                        $stmt_datos_indicador->execute();
                        $datos_indicador = $stmt_datos_indicador->fetchAll();
                        $stmt_datos_indicador->closeCursor();

                        if (sizeOf($datos_indicador) > 0) {
                            $response['datos_indicador'] = array(
                                "id" => $datos_indicador[0]['id'],
                                "codigo" => $codigo_indicador,
                                "archivo" => 'indicadores/' . $datos_indicador[0]['url_archivo_indicador'] . '.php'
                            );
                        } else {
                            $response['error'] = "El indicador al que ha hecho referencia no fue encontrado en el Sistema, por favor, refresque la pagina, si el problema persiste envie un correo a la unidad de infotecnologia.";
                        }
                    } else {
                        $response['error'] = "La informaci&oacute;n parece estar corrupta, refresca la p&aacute;gina y realiza esta acci&oacute;n de nuevo.";
                    }
                    break;
                case 4:
                    //para poner la cookie del TOUR
                    if (ISSET($_GET['tipo'])) {
                        $operaRealizar = $_GET['tipo'];
                        if ($operaRealizar == '1') {
                            $expire = time() + 60 * 60 * 24 * 30; //1 mes
                            $_SESSION["correr_tour"] = false;
                            setcookie('siee_tour');
                            setcookie('siee_tour', '0', $expire, '/SIEE/');
                            $str_retorno = '$("#canceltour").trigger("click");';
                        }
                        if ($operaRealizar == '2') {
                            $_SESSION["correr_tour"] = false;
                        }
                    } else {
                        $str_retorno = '_html = "<p>Hubo un problema al realizar esta accion, porfavor intentalo de nuevo.</p>";
                                        $( "#dialogWindow" ).html(_html);
                                        $( "#dialogWindow" ).dialog({
                                            title   : \'Error.\',
                                            modal   : true,
                                            buttons : { "Ok": function() { $(this).dialog("close"); } },
                                            minWidth: 600,
                                            resizable: false
                                        });
                                        $( ".ui-boton-guardar" ).button({               
                                            disabled: true
                                        });';
                    }
                    break;
                case 5:
                    //Obtiene las coordenadas del centro para el Mapa educativo
                    if (ISSET($_GET['codigo_centro'])) {
                        $codigo_centro = $_GET['codigo_centro'];
                        if ((strlen($codigo_centro) == 9) && preg_match($patron, $codigo_centro)) {
                            $stmt_coordenadas = $conn->query("  SELECT X as lon, Y as lat
                                                                        FROM siee_coord_centros_mapa
                                                                        WHERE codigo_centro = '" . $codigo_centro . "'
                                                                    ");
                            $datos_coordenadas = $stmt_coordenadas->fetch();
                            $stmt_coordenadas->closeCursor();
                            $str_retorno = json_encode($datos_coordenadas);
                        } else {
                            $str_retorno = "";
                        }
                    } else {
                        $str_retorno = "";
                    }
                    break;
                case 6:
                    //obtiene la lista de un indicador buscado en todo el sistema
                    if (ISSET($_GET['substr_titulo']) && ISSET($_GET['subsitio_id'])) {
                        $substr = trim($_GET['substr_titulo']);
                        $subsitio_id = $_GET['subsitio_id'];

                        if ($substr != '') {
                            $substr = '%' . utf8_decode($_GET['substr_titulo']) . '%';
                            $stmt_subsitios = $conn->prepare("  SELECT id, titulo, url
                                                                FROM siee_subsitio
                                                                WHERE activo = 1
                                                                        AND id <> :SubsitioActual_id");
                            $stmt_subsitios->bindParam(':SubsitioActual_id', $subsitio_id);
                            $stmt_subsitios->execute();
                            $arr_subsitios = $stmt_subsitios->fetchAll();
                            $stmt_subsitios->closeCursor();
                            $arr_subsitios = utf8_encode_mix($arr_subsitios);
                            $html = '';
                            foreach ($arr_subsitios as $subsitio) {
                                $stmt_indicadores = $conn->prepare(" SELECT G.etiqueta_titulo, I.id as indicador_id, 
                                                                            I.codigo_indicador, I.titulo, I.url_archivo_indicador as archivo
                                                                    FROM siee_grupo_indicadores G
                                                                    INNER JOIN [siee_rel-indicador__grupo_indicadores] rel ON rel.grupo_indicador_id = G.id
                                                                    INNER JOIN siee_indicador I ON I.id = rel.indicador_id
                                                                    WHERE   G.activo = 1
                                                                            AND I.activo = 1
                                                                            AND I.publicado = 1
                                                                            AND I.titulo LIKE :Substr
                                                                            AND G.subsitio_id = :Subsitio_id
                                                                    ORDER BY G.ordenamiento_grupo, rel.ordenamiento_indicador ");
                                $stmt_indicadores->bindParam(':Subsitio_id',  $subsitio['id']);
                                $stmt_indicadores->bindParam(':Substr', $substr);                             
                                $stmt_indicadores->execute();
                                $arr_indicadores = $stmt_indicadores->fetchAll();
                                $stmt_indicadores->closeCursor();
                                $arr_indicadores = utf8_encode_mix($arr_indicadores);
                                
                                if (sizeof($arr_indicadores)) {
                                    $html .= '<li class="sitios">
                                            <a href="' . $subsitio['url'] . '" class="link">' . strtoupper($subsitio['titulo']) . '</a>
                                            <ul class="indicadores">';
                                    foreach ($arr_indicadores as $indicador) {
                                        $html .= '<li><span class="indicador" onclick="cargarIndicador(\'' . $indicador['archivo'] . '\', \'0\')">' . $indicador['titulo'] . '</span> <span class="tituloGrupo">(grupo : ' . htmlentities($indicador['etiqueta_titulo']) . ')</span><div class="loadingInfo" for="' . $indicador['archivo'] . '" style="display:none;">Cargando ...</div></li>';
                                    }
                                    $html .= '</ul></li>';
                                }
                            }
                            if( strlen($html) == 0){
                                $html = "No se econtro nada";
                            }else{
                                $html = '<ul>' . $html . '</ul>';
                            }
                            $response['ListaIndicadores'] = $html;
                        } else {
                            $response['error'] = 'La cadena enviada esta vacia.';
                        }
                    }
                    break;
                case 7:
                    //obtiene la lista de un indicador buscado en todo el sistema
                    if (ISSET($_GET['codigo_indicador'])) {
                        $codigo_indicador = $_GET['codigo_indicador'];
                        if (trim($codigo_indicador) != '') {
                            $stmt_indicadores_relacionados = $conn->query("	DECLARE @indicador_id INT
                                                                                SET @indicador_id = (SELECT id FROM siee_indicador WHERE codigo_indicador = '" . $codigo_indicador . "');

                                                                                SELECT id, codigo_indicador as codigo, titulo, url_archivo_indicador
                                                                                FROM siee_indicador
                                                                                WHERE id IN (
                                                                                select case when r.indicador_id = @indicador_id then r.indicador_id2 else r.indicador_id end As indicador_id
                                                                                From siee_indicador AS i1, [siee_rel-indicador__indicador] AS r
                                                                                where (i1.id = r.indicador_id OR i1.id = r.indicador_id2)
                                                                                and i1.id = @indicador_id
                                                                                AND i1.activo = 1 AND i1.publicado = 1
                                                                        )");
                            $stmt_indicadores_relacionados->execute();
                            $arr_indicadores_relacionados = $stmt_indicadores_relacionados->fetchAll(PDO::FETCH_ASSOC);
                            $stmt_indicadores_relacionados->closeCursor();
                            
                            $stmt_titulo = $conn->query("SELECT titulo FROM siee_indicador WHERE codigo_indicador = '" . $codigo_indicador . "'");
                            $stmt_titulo->execute();
                            $titulo = $stmt_titulo->fetch(PDO::FETCH_ASSOC);
                            $stmt_titulo->closeCursor();
                            
                            $response['TituloPadre'] = utf8_encode_mix($titulo);
                            $response['IndicadoresRelacionados'] = utf8_encode_mix($arr_indicadores_relacionados);
                        } else {
                            $response['error'] = 'No se encontraron resultados...';
                        }
                    }
                break;
                case 8:
                    //obtiene la lista de los aliases de cada indicador
                    if (ISSET($_GET['codigo_indicador'])) {
                        $codigo_indicador = $_GET['codigo_indicador'];
                        if (trim($codigo_indicador) != '') {
                            $stmt_aliases = $conn->query(" SELECT titulo FROM siee_alias WHERE indicador_id = ( SELECT id from siee_indicador WHERE codigo_indicador = '" . $codigo_indicador . "' ) ORDER BY titulo;");
                            $aliases = $stmt_aliases->fetchAll(PDO::FETCH_ASSOC);
                            $stmt_aliases->closeCursor();
                            $response['titulos'] = utf8_encode_mix($aliases);
                        } else {
                            $response['error'] = 'No se encontraron resultados...';
                        }
                    }
                break;
                case 9:
                    //obtiene el glosario de palabras
                    $stmt_glosario = $conn->query(" select * from siee_glosario where activo = 1 order by titulo;");
                    $palabras = $stmt_glosario->fetchAll(PDO::FETCH_ASSOC);
                    $stmt_glosario->closeCursor();
                    $response['ListaPalabras'] = utf8_encode_mix($palabras);
                break;
                default:
                    $str_retorno = '_html = "<p>No existe esa opcion.</p>";
                                        $( "#dialogWindow" ).html(_html);
                                        $( "#dialogWindow" ).dialog({
                                            title   : \'Error.\',
                                            modal   : true,
                                            buttons : { "Ok": function() { $(this).dialog("close"); } },
                                            minWidth: 600,
                                            resizable: false
                                        });
                                        $( ".ui-boton-guardar" ).button({               
                                            disabled: true
                                        });';
            }
        } else {
            $str_retorno = '_html = "<p>La información parece estar corrupta, refresca la pagina y realiza esta accion de nuevo.</p>";
                                        $( "#dialogWindow" ).html(_html);
                                        $( "#dialogWindow" ).dialog({
                                            title   : \'Error.\',
                                            modal   : true,
                                            buttons : { "Ok": function() { $(this).dialog("close"); } },
                                            minWidth: 600,
                                            resizable: false
                                        });
                                        $( ".ui-boton-guardar" ).button({               
                                            disabled: true
                                        });';
        }
    } else {
        $str_retorno = '_html = "<p>La información parece estar corrupta, refresca la pagina y realiza esta accion de nuevo.</p>";
                        $( "#dialogWindow" ).html(_html);
                        $( "#dialogWindow" ).dialog({
                            title   : \'Error.\',
                            modal   : true,
                            buttons : { "Ok": function() { $(this).dialog("close"); } },
                            minWidth: 600,
                            resizable: false
                        });
                        $( ".ui-boton-guardar" ).button({               
                            disabled: true
                        });';
    }
}

header('Content-Type: application/json');
echo json_encode($response);
exit;
?>
