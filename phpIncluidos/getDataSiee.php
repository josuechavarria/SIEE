<?php

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
                    //Obtiene listado centros educativos que se asimilan a lo que el usuario esta escribiendo
                    if ( ISSET($_GET['str_actual']) && ISSET($_GET['anio_global']) && ISSET($_GET['departamento']) && ISSET($_GET['municipio'])) {
                        $str_actual = trim($_GET['str_actual']);
                        $departamento_id = trim($_GET['departamento']);
                        $municipio_id = trim($_GET['municipio']);
                        $anio = trim($_GET['anio_global']);
                        $consulta = " SELECT  TOP 20 C.id as id, C.codigo_centro as codigo,
                                                UPPER(LTRIM(RTRIM(coalesce(C.nombre_centro, '')))) as nombre
                                    FROM (
                                                SELECT DISTINCT periodo_id as anio, centro_id, departamento_id, municipio_id
                                                FROM siee_resumen_data_indicadores
                                                WHERE es_inicial = 1
                                        ) as A
                                    INNER JOIN [BD_ESTADISTICAS_PUBLICA].[dbo].[ee_centros] C ON C.id = A.centro_id
                                    WHERE   A.anio = :Anio ";
                        
                        if (is_numeric($str_actual)) {
                            $consulta .= " AND convert(varchar, C.codigo_centro) LIKE :CodigoCentro ";
                        } else {
                            $consulta .= " AND C.nombre_centro LIKE :NombreCentro ";
                        }
                        
                        if( $departamento_id != '0'){
                            $consulta .= " AND A.departamento_id LIKE :Departamento_id ";
                        }
                        if( $municipio_id != '0'){
                            $consulta .= " AND A.municipio_id LIKE :Municipio_id ";
                        }
                        $consulta .= " ORDER BY C.nombre_centro ";
                        //preparando el statement
                        $stmt_datos_centro = $conn->prepare($consulta);
                        //enviando los parametros
                         if (is_numeric($str_actual)) {
                             $str_actual = $str_actual . '%';
                            $stmt_datos_centro->bindParam(':CodigoCentro', $str_actual);
                        } else {
                            $str_actual = '%' . $str_actual . '%';
                            $stmt_datos_centro->bindParam(':NombreCentro', $str_actual);
                        }
                        
                        $res = $stmt_datos_centro->bindParam(':Anio', $anio);
                        if( $departamento_id != '0'){
                            $stmt_datos_centro->bindParam(':Departamento_id', $departamento_id);
                        }
                        if( $municipio_id != '0'){
                            $stmt_datos_centro->bindParam(':Municipio_id', $municipio_id);
                        }
                        $stmt_datos_centro->execute();
                        $lista_centros = $stmt_datos_centro->fetchAll(PDO::FETCH_ASSOC);
                        $stmt_datos_centro->closeCursor();
                        
                        $response['centros'] = $lista_centros;
                        
                    } else {
                        $response['error'] = "No existe una consulta para los parametros enviados";
                    }
                    break;
                case 2:
                    //Obtiene listado de los numeros patronales que se parecen al que el usuario actualemtenesta digitando
                    if (ISSET($_GET['codigo_centro'])) {
                        $str_actual = $_GET['str_actual'];
                        $stmt_datos_centro = $conn->query("  SELECT	C.id as centro_id, C.codigo_centro, 
                                                                        UPPER(LTRIM(RTRIM(C.nombre_centro))) as nombre_centro
                                                        FROM (
                                                                        SELECT DISTINCT centro_id
                                                                        FROM siee_resumen_data_indicadores
                                                                        WHERE periodo_id = 2011
                                                                ) as A
                                                        INNER JOIN ee_centros C ON C.id = A.centro_id
                                                        WHERE C.codigo_centro LIKE '0801%'
                                                                        --OR C.nombre_centro LIKE '%%'
                                                        ORDER BY C.nombre_centro");
                        $lista_centros = $stmt_datos_centro->fetchAll();
                        $stmt_datos_centro->closeCursor();

                        if (sizeOf($lista_centros) > 0) {
                            $response['datos_centro'] = $lista_centros;
                        }
                    } else {
                        $response['error'] = "No existe una consulta para los parametros enviados";
                    }
                    break;
                default:
                    $response['error'] = "No existe una consulta para los parametros enviados";
            }
        } else {
            $response['error'] = "Los parametros enviados son invalidos";
        }
    } else {
        $response['error'] = "No existe peticion de este tipo.";
    }
}
echo json_encode($response);
?>
