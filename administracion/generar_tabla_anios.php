<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		include '../phpIncluidos/conexion.php';
		
		if (ISSET($_POST['anio'])){
			$anio = $_POST['anio'];
		}else{
			//error de datos, alguine trato de violar seguridad, etc etc
		}
	}elseif ($_SERVER['REQUEST_METHOD'] == 'GET'){
		$stmt_anio = $conn->query('SELECT MAX(periodo_id) from siee_parametros_estimar_poblacion;');
		$rs = $stmt_anio->fetch();
		$anio = $rs[0];
		$stmt_anio->closeCursor();		
	}	
	
	$stmt_edades = $conn->query('SELECT * FROM "siee_catalogo-edad" WHERE ordenamiento > 0 ORDER BY ordenamiento ASC;');
	$edades = $stmt_edades->fetchAll();
	$stmt_edades->closeCursor();
	
	$abreviaturas = array('E_1', 'E_2', 'E_3', 'E_4', 'E_5', 'E_6', 'E_7', 'E_8', 'E_9', 'E_10', 'E_11', 'E_12', 'E_13', 'E_14', 'E_15', 'E_16', 'E_17', 'E_18', 'E_19', 'E_20');
	
	foreach($edades as $edad_x){
		$stmt_datos = $conn->prepare('SELECT ' . implode(',',$abreviaturas) . ' FROM siee_parametros_estimar_poblacion WHERE periodo_id = ? AND edad_id = ?;');
		$stmt_datos->bindParam(1, $anio);
		$stmt_datos->bindParam(2, $edad_x['id']);
		$stmt_datos->execute();
		$datos = $stmt_datos->fetch();
		$stmt_datos->closeCursor();
		
		echo '<tr>';
		echo '<td title="' . htmlentities($edad_x['descripcion_edad']) . ' (Edades simples &darr;)">' . sprintf("%02d", $edad_x['ordenamiento']) . '</td>';
		
		foreach($abreviaturas as $abrv){			
			echo '<td>';
			
			echo '<input name="datos" type="checkbox" value="' . $edad_x['id'] . '-' . $abrv . '"' . ($datos[$abrv] == 1 ? 'checked="checked"':'') . '/>';
			
			echo '</td>';
		}
		
		echo '</tr>';
	}
?>
