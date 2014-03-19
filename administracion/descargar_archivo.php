<?PHP

// Define the path to file


if (!ISSET($_GET['id'])){
	// File doesn't exist, output error
	die('no viene id');
} else {
	include '../phpIncluidos/conexion.php';
	
	$id = $_GET['id'];
	
	$stmt_archivo = $conn->prepare('SELECT titulo,nombre,tipo FROM siee_archivo WHERE id = ?;');
	$stmt_archivo->bindParam(1, $id);
	$stmt_archivo->execute();
	$archivo = $stmt_archivo->fetchAll();
	$stmt_archivo->closeCursor();
	
	header("Cache-Control: public");
	header("Content-Description: File Transfer");
	header("Content-Disposition: attachment; filename=" .  $archivo[0]['titulo']);
	header("Content-Type: " . $archivo[0]['tipo']);
	header("Content-Transfer-Encoding: binary");

	// Read the file from disk
	readfile('C:\\wamp\\www\\SIEE\\archivos\\' . $archivo[0]['nombre']);
}
?>