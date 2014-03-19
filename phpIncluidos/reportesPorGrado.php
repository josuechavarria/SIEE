<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $cantDatosErroneos = 0;

    if (ISSET($_GET['an']) && ISSET($_GET['niv']) && ISSET($_GET['ind']) && ISSET($_GET['dpt']) && ISSET($_GET['id'])) {

        $anio = $_GET['an'];
        $nivel = $_GET['niv'];
        $indicador = $_GET['ind'];
        $departamento_id = $_GET['dpt'];
        $numero_reporte = $_GET['id'];


        if ($departamento_id != 'todos') {
            $stmt_deptos = $conn->prepare('SELECT descripcion_departamento FROM ee_departamentos WHERE id = :departamento_id');
            $stmt_deptos->execute(Array(
                'departamento_id' => $departamento_id
            ));
            $nombre_departamento = $stmt_deptos->fetch();
            $nombre_departamento = $nombre_departamento['descripcion_departamento'];
            $stmt_deptos->closeCursor();
        } else {
            $departamento_id = null;
            $nombre_departamento = 'todos';
        }

        $stmt_datos = $conn->prepare('EXEC Recupera_Reporte_Estudiantes_por_Grado :periodo_id, :tipo_indicador_id, :departamento_id, :numero_reporte');
        $stmt_datos->execute(Array(
            'periodo_id' => $anio,
            'numero_reporte' => $numero_reporte,
            'tipo_indicador_id' => $indicador,
            'departamento_id' => $departamento_id
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
