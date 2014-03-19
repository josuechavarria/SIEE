<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include 'phpIncluidos/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $no_hay_errores = true;


        $id_indicador = $_POST['id'];

}
//echo "el indicador id: " . $id_indicador;

if ($no_hay_errores) {
    $stmt_lista_indicadores_descripcion = $conn->query('select i2.titulo, case when r.indicador_id = ' . $id_indicador . ' then r.indicador_id2 else r.indicador_id end As indicador
                                                                                From siee_indicador AS i1,"siee_rel-indicador__indicador" AS r,siee_indicador AS i2
                                                                                where ((i1.id = r.indicador_id AND r.indicador_id2 = i2.id) OR (i1.id = r.indicador_id2 AND i2.id = r.indicador_id))
                                                                                and i1.id = ' . $id_indicador);
$indicadores=$lista_indicadores_desc = $stmt_lista_indicadores_descripcion->fetchAll();
//echo print_r($lista_indicadores_desc->errorInfo().true);

$stmt_lista_indicadores_descripcion->closeCursor();

//echo print_r($lista_indicadores_desc);
//echo "<br />";
//foreach ($lista_indicadores_desc as $ind){
//    echo "<br />";
//    echo $ind[0];
//    echo "<br />";
//    echo $ind[1];
//}


    header('Content-Type: application/json');
echo json_encode($indicadores);
exit;




}



?>
