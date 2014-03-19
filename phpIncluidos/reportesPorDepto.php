<?php
//ES  EL REPORTE QUE EN LA APLICACION SALE COMO
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $cantDatosErroneos = 0;
    if (ISSET($_GET['an']) && ISSET($_GET['niv']) && ISSET($_GET['ind']) && ISSET($_GET['gr']) && ISSET($_GET['id'])) {
        $anio = $_GET['an'];
        $nivel = $_GET['niv'];
        $indicador = $_GET['ind'];
        $grado = $_GET['gr'];
        $numero_reporte = $_GET['id'];
        $grado_id = '';
        if ($grado == 'todos' || $grado == '') {
            $grado_id = 0;
        } else {
            $grado_id = (int)$grado;
            $stmt_DescripcionGrado = $conn->query(' SELECT DISTINCT descripcion_grado
                                                    FROM [siee_catalogo-grado]
                                                    WHERE id = ' . $grado_id);           
            
            $descripcion_grado = $stmt_DescripcionGrado->fetchAll();
            $stmt_DescripcionGrado->closeCursor();            
            $grado = $descripcion_grado[0]['descripcion_grado'];
        }
       
        
        $stmt_datos = $conn->prepare('EXEC Recupera_Reporte_Estudiantes_por_Departamento :periodo_id, :tipo_indicador_id, :grado_id, :numero_reporte');
        $stmt_datos->execute(Array(
            'periodo_id' => $anio,
            'numero_reporte' => $numero_reporte,
            'tipo_indicador_id' => $indicador,
            'grado_id' => $grado_id
        ));
        $data_reporte = $stmt_datos->fetchAll();
        $stmt_datos->closeCursor();
        
        
        $stmt_DescripcionIndicador = $conn->query(' SELECT DISTINCT nombre, descripcion
                                                    FROM [siee_catalogo-tipos_indicador]
                                                    WHERE id = ' . $indicador);           

        $descripcion_indicador = $stmt_DescripcionIndicador->fetchAll();
        $stmt_DescripcionIndicador->closeCursor();            
        $indicador = $descripcion_indicador[0]['nombre'];
        
    }//cierre ISSET
    else {
        $data_reporte = null;
    }
}
?>
