<?php
include '../phpIncluidos/conexion.php';
include '../phpIncluidos/conexion_ee.php';
$response = array();
$errores = array();

$stmt_periodos= $conn_ee->query('SELECT distinct periodo_id 
                                from (
                                        SELECT distinct periodo_id 
                                        from ee_resumen_matricula_inicial
                                        union all
                                        select distinct periodo_id
                                        from ee_resumen_matricula_final
                                ) D
                                order by periodo_id DESC;');
$lista_periodos = $stmt_periodos->fetchAll();
$periodos_aceptados = Array();
foreach($lista_periodos as $periodo){
    array_push($periodos_aceptados, $periodo['periodo_id']);
}
$stmt_periodos->closeCursor();
$iniciales = Array('0','1','2');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       
    if(!ISSET($_POST['opcion'])){
        $response['refresh_error'] = 'El parametro de opcion enviado esta corrupto.';
    }else{
        $opcion = $_POST['opcion'];
        switch($opcion){
            case 1:
                if (!ISSET($_POST['es_inicial']) || !ISSET($_POST['periodos'])) {
                    $response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acción de nuevo.';
                } else {
                    //probando que los datos recibidos sean numericos
                    $es_inicial = trim($_POST['es_inicial']);
                    $periodos = $_POST['periodos'];
                    if (!$es_inicial && !$periodos) {
                        $errores['error'] = 'Los parametros recibidos esta nulos.';
                    } else {
                        if (!in_array($es_inicial, $iniciales) && ( sizeof(array_intersect($periodos_aceptados, $periodos)) === sizeof($periodos)  ) ) {
                            $errores['error'] = 'Los valores recibidos son invalidos';
                        } else {
                            foreach($periodos as $anio){
                                $stmt_datos = $conn->prepare('EXEC MigrarEstadistica :periodo_id, :es_inicial');
                                if (!$stmt_datos->execute(
                                            Array(
                                                'es_inicial'    => $es_inicial,
                                                'periodo_id'    => $anio
                                    ))) {
                                    // aqui se detecatron errores al tratar de guardar los datos en la base de datos.
                                    $errores['error'] = 'Error. ' . print_r($stmt_datos->errorInfo());
                                    break;
                                }
                                $stmt_datos->closeCursor();                    
                            }

                            if (sizeof($errores) === 0) {
                                $response['success'] = 'La nueva estadistica se ha sido incorporada al SIEE con éxito';
                            }                
                        }
                    }
                }
                break;
            case 2:
                $stmt_datos = $conn->prepare('DELETE FROM siee_resumen_data_indicadores;');
                if (!$stmt_datos->execute()) {
                    // aqui se detecatron errores al tratar de guardar los datos en la base de datos.
                    $errores['error'] = 'Error. ' . print_r($stmt_datos->errorInfo());
                    break;
                }else{
                    $response['success'] = 'La tabla de estadísticas de indicadores esta ha sido vaciada con éxito';
                }
                $stmt_datos->closeCursor(); 
                break;
            default:
                    $errores['error'] = 'Opcion incorrecta';
                break;
        }
    }   
	
}else{
	$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, por favor refresca la pagina y realiza esta acción de nuevo.';
}

if (sizeof($errores) > 0){
	$response['errores'] = $errores;
}

echo json_encode($response);
?>
