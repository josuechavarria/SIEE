<?php
include '../phpIncluidos/conexion.php';
$response = array();

if (!ISSET($_POST['id'])){
	$response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acci&otilde;n de nuevo.';
}else{
	$idSubsitio = $_POST['id'];
	
	$stmt_grupos_de_subsitio = $conn->prepare('SELECT id, etiqueta_titulo, titulo_completo FROM siee_grupo_indicadores WHERE subsitio_id = ? and activo = 1 ORDER BY ordenamiento_grupo ASC;');
	$stmt_grupos_de_subsitio->bindParam(1, $idSubsitio);
	$stmt_grupos_de_subsitio->execute();
	$grupos_de_subsitio = $stmt_grupos_de_subsitio->fetchAll(PDO::FETCH_ASSOC);
	$stmt_grupos_de_subsitio->closeCursor();
	
	$response['grupos'] = utf8_encode_mix($grupos_de_subsitio);
	
	echo json_encode($response);
}
?>
