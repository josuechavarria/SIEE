<?php
include 'conexion.php';

$extension =  $_POST['extension'];
if ($extension == 'todos') {
    
    $stmt_archivos = $conn->query('SELECT * FROM siee_archivo ORDER BY titulo;');
    
}else if ($extension == 'word') {
    $stmt_archivos = $conn->query('SELECT * FROM siee_archivo where extension = \'doc\' OR extension = \'docx\' ORDER BY titulo;');
}else if ($extension == 'excel'){
    $stmt_archivos = $conn->query('SELECT * FROM siee_archivo where extension = \'xls\' OR extension = \'xlsx\' ORDER BY titulo;');
} else if ($extension == 'image') {
    $stmt_archivos = $conn->query('select * from siee_archivo where tipo like \'%image\'  ORDER BY titulo;');
}else if ($extension == 'powerpoint') {
    $stmt_archivos = $conn->query('SELECT * FROM siee_archivo where extension = \'ppt\' OR extension = \'pptx\' ORDER BY titulo;');
}else if ($extension == 'otros') {
    $stmt_archivos = $conn->query('select * from siee_archivo where extension not in (\'doc\',\'docx\',\'xls\',\'xlsx\',\'ppt\',\'pptx\',\'exe\') AND tipo not like \'%image\';');
}else{
    
    $stmt_archivos = $conn->query('SELECT * FROM siee_archivo where extension = \''.$extension. '\' ORDER BY titulo;');
}    


$archivos = $stmt_archivos->fetchAll();
$stmt_archivos->closeCursor();

$archivos = utf8_encode_mix($archivos);

echo json_encode($archivos);


?>  