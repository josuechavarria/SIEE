<?php
include 'conexion.php';

if(ISSET($_POST['solicitud']) && !empty($_POST['solicitud'])) {
    $solicitud = $_POST['solicitud'];
	
    switch($solicitud) {
		case 'panelDeComentarios':
			panelDeComentarios();
			break;
		case 'respuestas':
			respuestas();
			break;
		case 'guardarComentario':
			guardarComentario();
			break;
		case 'guardarNuevaRespuesta':
			guardarNuevaRespuesta();
			break;
		case 'guardarModificacion':
			guardarModificacion();
			break;
		case 'eliminarComentario':
			eliminarComentario();
			break;
    }
}

function panelDeComentarios(){
	$response = crearResponseObject();
	$response['success'] = true;
	$response['html'] =
	'<div class="PanelDeComentarios">';
	
	if (ISSET($_POST['idIndicador'])){
		$idIndicador = $_POST['idIndicador'];
		if (is_numeric($idIndicador) && ctype_digit($idIndicador)){
			$comentariosRoot = comentariosRoot($idIndicador);
			
			$response['html'] .=
                        '<div class="titulo"><span style="font-size:1.2em;">Comentarios realizados a este indicador</span> (' . sizeof($comentariosRoot) . ' comentarios mostrados):
				<div class="esconderDatos" name="EsconderInformacionIndicador">
					<img src="recursos/iconos/eraser.png">
				</div>
			</div>';
			$response['html'] .=
			'<div class="Comentarios">';
			
			if (sizeof($comentariosRoot) > 0){				
				foreach($comentariosRoot as $comentario){
					$response['html'] .= renderizarComentario($comentario);
				}
			}else{
				$response['html'] .=
				'<div class="Notificacion">' .
					'Este indicador no ha sido comentado por los demas usuarios ni usted.' . 
				'</div>';
			}
			
			$response['html'] .=
			'</div>';

			$response['html'] .=
			'<div class="EspacioComentarIndicador">' .
				'<label for="NuevoComentario">' .
					'Escribe aqui para comentar este indicador o preguntar algo a los demas usuarios:' .
				'</label>' .

				'<br/>' .
				
				'<div class="Error"></div>'.
					
				'<textarea id="NuevoComentario" name="NuevoComentario" maxlength="500" rows="8" cols="50"></textarea>' .

				'<br/>' .

				'<input type="button" class="botonVerde" name="GuardarNuevoComentario" value="Guardar comentario" onclick="guardarComentario(' . $idIndicador . ',$(\'#NuevoComentario\').val());"/>' .
			'</div>';
		}else{
			$response['html'] .=
			'<div class="Error">' .
				'Error al cargar el panel de comentarios. Por favor, intente de nuevo.' .
			'</div>';
		}
	}else{
		$response['html'] .=
		'<div class="Error">' .
			'Error al cargar el panel de comentarios. Por favor, intente de nuevo.' .
		'</div>';
	}
	
	$response['html'] .=
	'</div>';
	
	echo json_encode($response);
}

function respuestas(){
	$response = crearResponseObject();
	
	if (ISSET($_POST['idComentario'])){
		$idComentario = $_POST['idComentario'];
		if (is_numeric($idComentario) && ctype_digit($idComentario)){
			$comentariosHijos = comentariosHijos($idComentario);
			
			foreach($comentariosHijos as $hijo){
				$response['html'] .= renderizarComentario($hijo);
			}
			
			$response['success'] = true;
		}else{
			$response['errores']['general'] = 'Error al cargar las respuestas del comentario. Por favor, intente de nuevo.';
		}
	}else{
		$response['errores']['general'] = 'Error al cargar las respuestas del comentario. Por favor, intente de nuevo.';
	}
	
	echo json_encode($response);
}

function guardarComentario(){
	$response = crearResponseObject();
	
	if (ISSET($_SESSION['usuario'])) {
		if (ISSET($_POST['idIndicador']) && ISSET($_POST['texto'])) {
			$idIndicador = $_POST['idIndicador'];
			$texto = $_POST['texto'];

			if (is_numeric($idIndicador) && ctype_digit($idIndicador)) {
				if (strlen($texto) > 0) {
					$patron_texto = '/^[a-zA-ZÁáÉéÍíÓóÚúñÑ0-9!@#$%^&*()_+\-=;:.,?<>\/ ]+$/';
					if (preg_match($patron_texto, $texto)) {
						if (strlen($texto) <= 500) {
							try {
								$response['html'] = renderizarComentario(selectComentarioPorId(insertComentario($idIndicador, $texto)));
								$response['success'] = true;
							} catch (Exception $e) {
								$response['errores']['general'] = $e->getMessage();
							}
						} else {
							$response['errores']['texto'] = 'El texto del comentario no debe exceder el tama&ntilde;o maximo de 500 caracteres.';
						}
					} else {
						$response['errores']['texto'] = 'El texto del comentario contiene caracteres invalidos.';
					}
				} else {
					$response['errores']['texto'] = 'Debes escribir un comentario antes de guardar.';
				}
			} else {
				$response['errores']['general'] = 'Ocurrio un error al intentar guardar el comentario. Por favor, intentelo de nuevo.';
			}
		} else {
			$response['errores']['general'] = 'Ocurrio un error al intentar guardar el comentario. Por favor, intentelo de nuevo.';
		}
	} else {
		$response['errores']['general'] = 'Para comentar en los indicadores debe iniciar su sesión en el SIEE.';
                $response['errores']['tipo'] = 'dialogo';
	}
	echo json_encode($response);
}

function guardarNuevaRespuesta(){
	$response = crearResponseObject();
	
	if (ISSET($_SESSION['usuario'])) {
		if (ISSET($_POST['idIndicador']) && ISSET($_POST['idComentarioPadre']) && ISSET($_POST['texto'])) {
			$idIndicador = $_POST['idIndicador'];
			$idComentarioPadre = $_POST['idComentarioPadre'];
			$texto = $_POST['texto'];

			if ((is_numeric($idIndicador) && ctype_digit($idIndicador)) && (is_numeric($idComentarioPadre) && ctype_digit($idComentarioPadre))) {
				if (strlen($texto) > 0) {
					$patron_texto = '/^[a-zA-ZÁáÉéÍíÓóÚúñÑ0-9!@#$%^&*()_+\-=;:.,?<>\/ ]+$/';
					if (preg_match($patron_texto, $texto)) {
						if (strlen($texto) <= 500) {
							try {
								$response['html'] = renderizarComentario(selectComentarioPorId(insertRespuesta($idIndicador, $idComentarioPadre, $texto)));
								$response['success'] = true;
							} catch (Exception $e) {
								$response['errores']['general'] = $e->getMessage();
							}
						} else {
							$response['errores']['texto'] = 'El texto de la respuesta no debe exceder el tama&ntilde;o maximo de 500 caracteres.';
						}
					} else {
						$response['errores']['texto'] = 'El texto de la respuesta contiene caracteres invalidos.';
					}
				} else {
					$response['errores']['texto'] = 'Debes escribir una respuesta antes de guardar.';
				}
			} else {
				$response['errores']['general'] = 'Ocurrio un error al intentar guardar la respuesta. Por favor, intentelo de nuevo.';
			}
		} else {
			$response['errores']['general'] = 'Ocurrio un error al intentar guardar la respuesta. Por favor, intentelo de nuevo.';
		}
	} else {
		$response['errores']['general'] = 'Debes iniciar una sesion antes de responder a un comentario.';
	}
	
	echo json_encode($response);
}

function guardarModificacion(){
	$response = crearResponseObject();
	
	if (ISSET($_SESSION['usuario'])) {
		if (ISSET($_POST['idComentario']) && ISSET($_POST['texto'])) {
			$idComentario = $_POST['idComentario'];
			$texto = $_POST['texto'];

			if (is_numeric($idComentario) && ctype_digit($idComentario)) {
				$comentario = selectComentarioPorId($idComentario);
				if ($comentario['usuario_creador_id'] == $_SESSION['usuario']['id']) {
					if (strlen($texto) > 0) {
						$patron_texto = '/^[a-zA-ZÁáÉéÍíÓóÚúñÑ0-9!@#$%^&*()_+\-=;:.,?<>\/ ]+$/';
						if (preg_match($patron_texto, $texto)) {
							if (strlen($texto) <= 500) {
								try {
									updateComentario($idComentario, $texto);
									$response['html'] = renderizarComentario(selectComentarioPorId($idComentario));
									$response['success'] = true;
								} catch (Exception $e) {
									$response['errores']['general'] = $e->getMessage();
								}
							} else {
								$response['errores']['texto'] = 'El texto del comentario no debe exceder el tama&ntilde;o maximo de 500 caracteres.';
							}
						} else {
							$response['errores']['texto'] = 'El texto del comentario contiene caracteres invalidos.';
						}
					} else {
						$response['errores']['texto'] = 'Debes escribir el nuevo texto antes de editar tu comentario.';
					}
				} else {
					$response['errores']['general'] = 'No puedes editar comentarios de otros usuarios.';
				}
			} else {
				$response['errores']['general'] = 'Ocurrio un error al intentar editar el comentario. Por favor, intentelo de nuevo.';
			}
		} else {
			$response['errores']['general'] = 'Ocurrio un error al intentar editar el comentario. Por favor, intentelo de nuevo.';
		}
	} else {
		$response['erroers']['general'] = 'Debes iniciar una sesion antes editar tu comentario.';
	}
	echo json_encode($response);
}

function eliminarComentario(){
	$response = crearResponseObject();
	
	if (ISSET($_SESSION['usuario'])) {
		if (ISSET($_POST['idComentario'])) {
			$idComentario = $_POST['idComentario'];

			if (is_numeric($idComentario) && ctype_digit($idComentario)) {
				$comentario = selectComentarioPorId($idComentario);
				if ($comentario['usuario_creador_id'] == $_SESSION['usuario']['id']) {
					try {
						desactivarComentario($idComentario);
						$comentario['activo'] = 0;
						$response['html'] = renderizarComentario($comentario);
						$response['success'] = true;
					} catch (Exception $e) {
						$response['errores']['general'] = $e->getMessage();
					}
				}else{
					$response['errores']['general'] = 'No puedes eliminar comentarios de otros usuarios.';
				}
			} else {
				$response['errores']['general'] = 'Ocurrio un error al intentar eliminar el comentario. Por favor, intentelo de nuevo.';
			}
		} else {
			$response['errores']['general'] = 'Ocurrio un error al intentar eliminar el comentario. Por favor, intentelo de nuevo.';
		}
	} else {
		$response['errores']['general'] = 'Debes iniciar una sesion antes de eliminar un comentario.';
	}
	
	echo json_encode($response);
}
function renderizarComentario($comentario){
	$html = '<div id="c_' . $comentario['id'] . '" class="Comentario">';
	$html .= renderizarEncabezadoDeComentario($comentario);
	$html .= renderizarCuerpoDeComentario($comentario);
	$html .= renderizarPieDeComentario($comentario);
	$html .= renderizarHijosDeComentario($comentario);
	$html .= '</div>';
	
	return $html;
}

function renderizarEncabezadoDeComentario($comentario){
	$datosDeCreacion = datosDeCreacion($comentario['id']);
	$datosDeModificacion = datosDeModificacion($comentario['id']);
	
	$encabezado =
	'<div class="Encabezado">' .
		'<span class="Usuario">' .
			$datosDeCreacion['usuario'] . 
		'</span>' .
		
		'<span class="Fecha">' .
			$datosDeCreacion['fecha'];
					
	if (!($datosDeCreacion['fecha'] === $datosDeModificacion['fecha'])){
		$encabezado .= ' (modificado en ' . $datosDeModificacion['fecha'] . ')';
	}
		
	$encabezado .=
		'</span>' .
	'</div>';
	
	return $encabezado;
}

function renderizarCuerpoDeComentario($comentario){
	if ($comentario['activo']){
		$cuerpo =
		'<div class="Cuerpo">' . 
		    htmlentities( $comentario['texto'] ).
		'</div>';

		$cuerpo .= 
		'<div id="PanelDeModificacion_' . $comentario['id'] . '" class="PanelDeModificacion">' .
			'<label for="NuevoTexto">' .
				'Escribe aqui tu comentario:' .
			'</label>' .

			'<br/>' .

			'<div class="Error"></div>'.

			'<textarea name="NuevoTexto" maxlength="500" rows="8" cols="50"></textarea>' .

			'<br/>' .

			'<input type="button" name="GuardarModificacion" value="Guardar" onclick="guardarModificacion(' . $comentario['id'] . ', ' . '$(\'#PanelDeModificacion_' . $comentario['id'] . ' textarea\').val());"/>' .

			'<input type="button" name="CancelarModificacion" value="Cancelar" onclick="cerrarPanelDeModificacion(' . $comentario['id'] . ');"/>' .
		'</div>';
	}else{
		$cuerpo =
		'<div class="Cuerpo">' .
			'<div class="Notificacion">' .
				'Este comentario fue eliminado por el autor original o un moderador.' .
			'</div>' .
		'</div>';
	}
	return $cuerpo;
}

function renderizarPieDeComentario($comentario){
	$pie =
	'<div class="Pie">';
	
	if (ISSET($_SESSION['usuario'])){
		$pie .= '<a href="javascript:cargarPanelDeRespuesta(' . $comentario['id'] . ');" class="Opcion">responder</a>';

		if ($comentario['activo']){		
			if (($_SESSION['usuario']['id'] == $comentario['usuario_creador_id'])){
				$pie .= '<a href="javascript:cargarPanelDeModificacion(' . $comentario['id'] . ');" class="Opcion">editar</a>';
				$pie .= '<a href="javascript:eliminarComentario(' . $comentario['id'] . ');" class="Opcion">eliminar</a>';
			}else if ($_SESSION['usuario']['rol']['es_moderador']){
				$pie .= '<a href="javascript:eliminarComentario(' . $comentario['id'] . ');" class="Opcion">eliminar</a>';
			}
		}
	}
	
	$cantidadDeHijos = cantidadDeHijos($comentario);
	
	if ($cantidadDeHijos > 0){
		$pie .= '<a href="javascript:cargarRespuestas(' . $comentario['id'] . ')" class="Opcion">ver respuestas(' . $cantidadDeHijos . ')</a>';
	}
	
	$pie .=
	'</div>';
	
	return $pie;
}


function renderizarHijosDeComentario($comentario){
	$hijos = 
	'<div class="Hijos">';
	
	$hijos .=
	'<div id="PanelDeRespuesta_' . $comentario['id'] . '" class="PanelDeRespuesta">' .
		'<label for="NuevaRespuesta">' .
			'Escribe aqui tu respuesta:' .
		'</label>' .

		'<br/>' .

		'<div class="Error"></div>'.

		'<textarea name="NuevaRespuesta" maxlength="500" rows="8" cols="50"></textarea>' .

		'<br/>' .

		'<input type="button" class="botonVerde" name="GuardarNuevaRespuesta" value="Guardar" onclick="guardarNuevaRespuesta(' . $comentario['indicador_id'] . ', ' . $comentario['id'] . ', ' . '$(\'#PanelDeRespuesta_' . $comentario['id'] . ' textarea\').val());"/>' .
		
		'<input style="margin-left:10px;" type="button" class="botonAmarillo" name="CancelarNuevaRespuesta" value="Cancelar" onclick="cerrarPanelDeRespuesta(' . $comentario['id'] . ');"/>' .
	'</div>';
	
	$hijos .=
	'</div>';
	
	return $hijos;
}

function cantidadDeHijos($comentario){
	global $conn;
	$stmt_cantidad_de_hijos = $conn->query('SELECT COUNT(*) FROM "siee_rel-comentario__comentario" WHERE comentario_padre_id = ' . $comentario['id'] . ';');
	$cantidad_de_hijos = $stmt_cantidad_de_hijos->fetch();
	$stmt_cantidad_de_hijos->closeCursor();
	
	return $cantidad_de_hijos[0];
}

function cantidadDeComentarios(){
	if (ISSET($_POST['idIndicador'])){
		$idIndicador = $_POST['idIndicador'];

		if (is_numeric($idIndicador) && ctype_digit($idIndicador)){
			$stmt_cantidad_de_comentarios = $conn->query('SELECT COUNT(*) FROM siee_comentario WHERE indicador_id = ' . $idIndicador . ' AND activo = 1;');
			$cantidad_de_comentarios = $stmt_cantidad_de_comentarios->fetch();
			$stmt_cantidad_de_comentarios->closeCursor();

			$response = array();
			$response['cantidadDeComentarios'] = $cantidad_de_comentarios[0];	
			json_encode($response);
		}else{
			error('Parametro \'idIndicador\' debe ser de tipo entero');
		}
	}else{
		error('Parametro requerido: \'idIndicador\'');
	}
}

function insertComentario($idIndicador, $texto){
	global $conn;
	
	$conn->exec('BEGIN TRANSACTION');
	
	try{
		$stmt_insertar_comentario = $conn->prepare('INSERT INTO siee_comentario (
														texto, 
														indicador_id,
														activo,
														usuario_creador_id,
														fecha_creacion,
														usuario_modificador_id,
														fecha_modificacion)
													VALUES (?,?,?,?,CURRENT_TIMESTAMP,?,CURRENT_TIMESTAMP);');
		
		$activo = 1;
		$usuario_creador_id = $_SESSION['usuario']['id'];
		$usuario_modificador_id = $usuario_creador_id;
		
		if ($stmt_insertar_comentario->execute(array(utf8_decode($texto), $idIndicador, $activo, $usuario_creador_id, $usuario_modificador_id))){
			$nuevoComentario_id = recuperar_identity($conn);
			$conn->exec('COMMIT TRANSACTION');
			return $nuevoComentario_id;
		}else{
			$exception_message = print_r($stmt_insertar_comentario->errorInfo(),true);
			$conn->exec('ROLLBACK TRANSACTION');
			throw new Exception($exception_message);
		}
	}catch(Exception $e){
		$conn->exec('ROLLBACK TRANSACTION');
		throw new Exception('Ocurrio un error al intentar guardar el comentario. Por favor, intentelo de nuevo.');
		//throw $e;
	}
}

function insertRespuesta($idIndicador, $idComentarioPadre, $texto){
	global $conn;
	
	try{
		$nuevoComentario_id = insertComentario($idIndicador, $texto);
		
		$conn->exec('BEGIN TRANSACTION');
		
		$stmt_insertar_relacion = $conn->prepare('INSERT INTO "siee_rel-comentario__comentario" (comentario_padre_id, comentario_hijo_id) VALUES (?,?);');
		
		if ($stmt_insertar_relacion->execute(array($idComentarioPadre, $nuevoComentario_id))){
			$conn->exec('COMMIT TRANSACTION');
			return $nuevoComentario_id;
		}else{
			$exception_message = print_r($stmt_insertar_relacion->errorInfo(),true);
			$stmt_eliminar_nuevo_comentario = $conn->query('DELETE FROM siee_comentario WHERE id = ' . $comentarioNuevo_id . ';');
			$stmt_eliminar_nuevo_comentario->execute();
			$conn->exec('ROLLBACK TRANSACTION');
			throw new Exception($exception_message);
		}
	}catch(Exception $e){
		$conn->exec('ROLLBACK TRANSACTION');
		throw new Exception('Ocurrio un error al intentar guardar la respuesta. Por favor, intentelo de nuevo.');
		//throw $e;
	}
}

function selectComentarioPorId($idComentario){
	global $conn;
	
	$stmt_select_comentario = $conn->query('SELECT * FROM siee_comentario WHERE id = ' . $idComentario . ';');
	$comentario = $stmt_select_comentario->fetch();
	$stmt_select_comentario->closeCursor();
	
	return $comentario;
}

function updateComentario($idComentario, $texto){
	global $conn;
	
	$conn->exec('BEGIN TRANSACTION');
	
	try{
		$stmt_modificar_comentario = $conn->prepare('UPDATE siee_comentario SET
														texto = ?, 
														usuario_modificador_id = ?,
														fecha_modificacion = CURRENT_TIMESTAMP
													WHERE id = ?;');
		
		$usuario_modificador_id = $_SESSION['usuario']['id'];
		
		if ($stmt_modificar_comentario->execute(array(utf8_decode($texto), $usuario_modificador_id, $idComentario))){
			$conn->exec('COMMIT TRANSACTION');
		}else{
			$exception_message = print_r($stmt_insertar_comentario->errorInfo(),true);
			$conn->exec('ROLLBACK TRANSACTION');
			throw new Exception($exception_message);
		}
	}catch(Exception $e){
		$conn->exec('ROLLBACK TRANSACTION');
		throw new Exception('Ocurrio un error al intentar modificar el comentario. Por favor, intentelo de nuevo.');
		//throw $e;
	}
}

function desactivarComentario($idComentario){
	global $conn;
	
	$conn->exec('BEGIN TRANSACTION');
	
	try{
		$stmt_desactivar_comentario = $conn->prepare('UPDATE siee_comentario SET
														activo = CASE activo WHEN 1 THEN 0 ELSE 1 END
													WHERE id = ?;');
		
		if ($stmt_desactivar_comentario->execute(array($idComentario))){
			$conn->exec('COMMIT TRANSACTION');
		}else{
			$exception_message = print_r($stmt_insertar_comentario->errorInfo(),true);
			$conn->exec('ROLLBACK TRANSACTION');
			throw new Exception($exception_message);
		}
	}catch(Exception $e){
		$conn->exec('ROLLBACK TRANSACTION');
		throw new Exception('Ocurrio un error al intentar eliminar el comentario. Por favor, intentelo de nuevo.');
		//throw $e;
	}
}

function comentariosHijos($idComentario){
	global $conn;
	$stmt_comentarios_hijos = $conn->query('SELECT * FROM siee_comentario WHERE id IN (SELECT comentario_hijo_id FROM "siee_rel-comentario__comentario" WHERE comentario_padre_id = ' . $idComentario . ') ORDER BY fecha_creacion DESC;');
	$comentarios_hijos = $stmt_comentarios_hijos->fetchAll();
	$stmt_comentarios_hijos->closeCursor();
	
	return $comentarios_hijos;
}

function comentariosRoot($idIndicador){
	global $conn;
	$stmt_comentarios_root = $conn->query('SELECT * FROM siee_comentario WHERE indicador_id = ' . $idIndicador . ' AND id NOT IN (SELECT comentario_hijo_id FROM "siee_rel-comentario__comentario") ORDER BY fecha_creacion DESC;');
	$comentarios_root = $stmt_comentarios_root->fetchAll();
	$stmt_comentarios_root->closeCursor();
	
	return $comentarios_root;
}

function datosDeCreacion($idComentario){
	global $conn;
	$stmt_datos_de_creacion = $conn->query('SELECT u.nombre_usuario AS usuario, c.fecha_creacion AS fecha FROM siee_usuario AS u, siee_comentario AS c WHERE c.usuario_creador_id = u.id AND c.id = ' . $idComentario . ';');
	$datos_de_creacion = $stmt_datos_de_creacion->fetch();
	$stmt_datos_de_creacion->closeCursor();
	
	return $datos_de_creacion;
}

function datosDeModificacion($idComentario){
	global $conn;
	$stmt_datos_de_modificacion = $conn->query('SELECT u.nombre_usuario AS usuario, c.fecha_modificacion AS fecha FROM siee_usuario AS u, siee_comentario AS c WHERE c.usuario_modificador_id = u.id AND c.id = ' . $idComentario . ';');
	$datos_de_modificacion = $stmt_datos_de_modificacion->fetch();
	$stmt_datos_de_modificacion->closeCursor();
	
	return $datos_de_modificacion;
}

function crearResponseObject(){
	$response = array();
	$response['success'] = false;
	$response['errores'] = array();
	$response['data'] = array();
	$response['html'] = '';
	
	return $response;
}
?>
