<?php
include '../phpIncluidos/conexion.php';
$errores = array();
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
	if (!ISSET($_POST['id']) || !ISSET($_POST['titulo']) || !ISSET($_POST['privado'])) {
		$errores['general'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acci&otilde;n de nuevo.';
	} else {
		$id = $_POST['id'];
		$stmt_archivo = $conn->prepare('SELECT * FROM siee_archivo WHERE id = ?;');
		$stmt_archivo->bindParam(1, $id);
		$stmt_archivo->execute();
		$archivo = $stmt_archivo->fetch();
		$stmt_archivo->closeCursor();

		if (!($titulo = trim($_POST['titulo']))) {
			$errores['titulo'] = 'El titulo del archivo es requerido.';
		} else {
			if (strlen($titulo) > 80) {
				$errores['titulo'] = 'El titulo del archivo puede tener una longitud maxima de 80 caracteres.';
			}
		}

		if (($descripcion = trim($_POST['descripcion']))) {
			if (strlen($descripcion) > 300) {
				$errores['descripcion'] = 'La descripcion del archivo puede tener una longitud maxima de 80 caracteres.';
			}
		}

		if (!preg_match('/^[01]$/', (($privado = $_POST['privado'])))) {
			$privado = 1;
		}

		$usuario_modificador_id = $_SESSION['usuario']['id'];

		if ($_FILES['archivo']['error'] != 4) {
			if ($_FILES['archivo']['error'] > 0) {
				$error_num = $_FILES['archivo']['error'];

				if ($error_num == 1) {
					$errores['archivo'] = 'El archivo excede el tamano maximo de 2MB.';
				} else {
					$errores['archivo'] = 'Error code ' . $error_num . '.';
				}
			} else {
				if (!($extension = end(explode('.', $_FILES['archivo']['name'])))) {
					$errores['archivo'] = 'El nombre del archivo debe tener una extension.';
				} else {
					if (strcasecmp($extension, '.xlsx') == 0) {
						$tipo = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
					} else if (strcasecmp($extension, '.xltx') == 0) {
						$tipo = 'application/vnd.openxmlformats-officedocument.spreadsheetml.template';
					} else if (strcasecmp($extension, '.potx') == 0) {
						$tipo = 'application/vnd.openxmlformats-officedocument.presentationml.template';
					} else if (strcasecmp($extension, '.ppsx') == 0) {
						$tipo = 'application/vnd.openxmlformats-officedocument.presentationml.slideshow';
					} else if (strcasecmp($extension, '.pptx') == 0) {
						$tipo = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
					} else if (strcasecmp($extension, '.sldx') == 0) {
						$tipo = 'application/vnd.openxmlformats-officedocument.presentationml.slide';
					} else if (strcasecmp($extension, '.docx') == 0) {
						$tipo = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
					} else if (strcasecmp($extension, '.dotx') == 0) {
						$tipo = 'application/vnd.openxmlformats-officedocument.wordprocessingml.template';
					} else if (strcasecmp($extension, '.xlam') == 0) {
						$tipo = 'application/vnd.ms-excel.addin.macroEnabled.12';
					} else if (strcasecmp($extension, '.xlsb') == 0) {
						$tipo = 'application/vnd.ms-excel.sheet.binary.macroEnabled.12';
					} else {
						$finfo = new finfo(FILEINFO_MIME);
						$type = $finfo->file($_FILES['archivo']['tmp_name']);
						$tipo = substr($type, 0, strpos($type, ';'));
					}

					$nombre = md5($_FILES['archivo']['name'] . $_SESSION['usuario']['id'] . $_SERVER['REQUEST_TIME']);
					$tamano = $_FILES['archivo']['size'] / 1024; //guardar tamano en KB
				}
			}

			if (sizeof($errores) == 0) {
				$stmt_modificar_archivo = $conn->prepare("UPDATE siee_archivo SET
															titulo = ?,
															descripcion = ?,
															nombre = ?,
															tipo = ?,
															extension = ?,
															tamano = ?,
															privado = ?,
															usuario_modificador_id = ?,
															fecha_modificacion = CURRENT_TIMESTAMP
														WHERE id = ?;");
				$conn->exec('BEGIN TRANSACTION');

				try {
					if (!$stmt_modificar_archivo->execute(array(utf8_decode($titulo), utf8_decode($descripcion), utf8_decode($nombre), $tipo, utf8_decode($extension), $tamano, $privado, $usuario_modificador_id, $id))) {
						$errores['general'] = 'Error al tratar de modificar el archivo:' . print_r($stmt_modificar_archivo->errorInfo(), true);
						$conn->exec('ROLLBACK TRANSACTION');
					} else {
						$dir_archivos = 'C:\\wamp\\www\\SIEE\\archivos\\';

						if (!move_uploaded_file($_FILES['archivo']['tmp_name'], $dir_archivos . $nombre)) {
							$errores['general'] = 'Error al tratar de mover el archivo a la carpeta permanente.';
							$conn->exec('ROLLBACK TRANSACTION');
						} else {
							unlink($dir_archivos . $archivo['nombre']);
							$conn->exec('COMMIT TRANSACTION');
						}
					}
				} catch (PDOException $ex) {
					$errores['general'] = 'Error al tratar de modificar el archivo: EX ' . $ex;
				}
			}
		} else {
			if (sizeof($errores) == 0) {
				$stmt_modificar_archivo = $conn->prepare("UPDATE siee_archivo SET
															titulo = ?,
															descripcion = ?,
															privado = ?,
															usuario_modificador_id = ?,
															fecha_modificacion = CURRENT_TIMESTAMP
														WHERE id = ?;");
				$conn->exec('BEGIN TRANSACTION');

				try {
					if (!$stmt_modificar_archivo->execute(array(utf8_decode($titulo), utf8_decode($descripcion), $privado, $usuario_modificador_id, $id))) {
						$errores['general'] = 'Error al tratar de modificar el archivo:' . print_r($stmt_modificar_archivo->errorInfo(), true);
						$conn->exec('ROLLBACK TRANSACTION');
					} else {
						$conn->exec('COMMIT TRANSACTION');
					}
				} catch (PDOException $ex) {
					$errores['general'] = 'Error al tratar de modificar el archivo:' . $ex;
				}
			}
		}
		
		$stmt_archivo = $conn->prepare('SELECT * FROM siee_archivo WHERE id = ?;');
		$stmt_archivo->bindParam(1, $id);
		$stmt_archivo->execute();
		$archivo = $stmt_archivo->fetch();
		$stmt_archivo->closeCursor();
	}
} else if ($method == 'GET') {
	if (!ISSET($_GET['id'])) {
		// File doesn't exist, output error
		die('no viene id');
	} else {
		$id = $_GET['id'];
		$stmt_archivo = $conn->prepare('SELECT * FROM siee_archivo WHERE id = ?;');
		$stmt_archivo->bindParam(1, $id);
		$stmt_archivo->execute();
		$archivo = $stmt_archivo->fetch();
		$stmt_archivo->closeCursor();
	}
}
?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/iframe.css" media="screen"/>
		<link rel="stylesheet" type="text/css" href="../jQueryUI/jquery-ui-1.8.23.custom/css/custom-theme/jquery-ui-1.8.23.custom.css" />
		<title></title>
	</head>
	<body>
		<form action="modificar_archivo.php" method="post" enctype="multipart/form-data">
			<div id="PanelModificacionDeRol" class="formularios">
				<div>
					<?php echo $method == 'POST' ? (sizeof($errores) == 0 ? 'El archivo fue modificado exitosamente.':'Ocurrieron errores al tratar de modificar el archivo.'):''?>
				</div>
				<div class="headerFromularios">
					Panel de modificaci&oacute;n de Archivo
				</div>

				<p>
					<?php echo array_key_exists('general', $errores) ? $errores['general'] : '' ?>
				</p>

				<div id="CamposFormulario">
					<input type="hidden" name="id" value="<?php echo $archivo['id'] ?>"/>

					<div class="itemsFormularios">
						<ul class="errores_por_campo">
							<?php echo array_key_exists('titulo', $errores) ? $errores['titulo'] : '' ?>
						</ul>
						<label for="TituloArchivo_mod">Titulo del Archivo:</label>
						<input id="TituloArchivo_mod" name="titulo" type="text" maxlength="80" value="<?php echo htmlentities($method == 'POST' ? $_POST['titulo']:$archivo['titulo'])?>" />
					</div>

					<div class="itemsFormularios">
						<ul class="errores_por_campo">
							<?php echo array_key_exists('descripcion', $errores) ? $errores['descripcion'] : '' ?>
						</ul>
						<label for="DescripcionArchivo_mod">Descripci&oacute;n:</label>
						<textarea id="DescripcionArchivo_mod" name="descripcion" maxlength="300" ><?php echo htmlentities($method == 'POST' ? $_POST['descripcion']:$archivo['descripcion'])?></textarea>
					</div>

					<div class="itemsFormularios">
						<label>Acceso:</label>
						<span id="RadioAccesoArchivo">
							<?php
								if (($method == 'POST' && $_POST['privado'] == 0) || ($archivo['privado'] == 0)) {
									?>

									<input type="radio" id="AccesoPrivado_mod" name="privado" value="1"/><label for="AccesoPrivado_mod">Privado</label>
									<input type="radio" id="AccesoPublico_mod" name="privado" value="0" checked="checked"/><label for="AccesoPublico_mod">Publico</label>

									<?php
								} else {
									?>

									<input type="radio" id="AccesoPrivado_mod" name="privado" value="1" checked="checked"/><label for="AccesoPrivado_mod">Privado</label>
									<input type="radio" id="AccesoPublico_mod" name="privado" value="0"/><label for="AccesoPublico_mod">Publico</label>

									<?php
								}
							?>
						</span>
					</div>

					<ul>
						<li>
                                                    Extensi&oacute;n: <?php echo $archivo['extension'] ?>
						</li>

						<li>
							Tipo: <?php echo $archivo['tipo'] ?>
						</li>

						<li>
							Tama&ntilde;o: <?php echo round($archivo['tamano'],2) ?> KB
						</li>

						<li>
							Nombre del archivo: <?php echo $archivo['nombre'] ?>
						</li>

						<li>
							<?php
							$stmt_usuario_creador = $conn->query('SELECT nombre_usuario FROM siee_usuario WHERE id = ' . $archivo['usuario_creador_id'] . ';');
							$usuario_creador = $stmt_usuario_creador->fetch();
							$stmt_usuario_creador->closeCursor();
							?>
							Creado en <?php echo $archivo['fecha_creacion'] ?> por <?php echo $usuario_creador[0] ?>
						</li>

						<li>
							<?php
							$stmt_usuario_modificador = $conn->query('SELECT nombre_usuario FROM siee_usuario WHERE id = ' . $archivo['usuario_modificador_id'] . ';');
							$usuario_modificador = $stmt_usuario_modificador->fetch();
							$stmt_usuario_modificador->closeCursor();
							?>
							Modificado en <?php echo $archivo['fecha_modificacion'] ?> por <?php echo $usuario_modificador[0] ?>
						</li>
					</ul>

					<div class="itemsFormularios">
						<ul class="errores_por_campo">
							<?php echo array_key_exists('archivo', $errores) ? $errores['archivo'] : ''; ?>
						</ul>
						<label for="Archivo_mod">Sustituir el Archivo:</label>
						<input id="Archivo_mod" name="archivo" type="file" value=/>
					</div>

					<div class="itemsFormularios">
						<div class="optionPane">
							<button class="ui-boton-cerrar" onclick="cerrarPanelModificacionArchivo()">Cerrar sin guardar</button>
							<input type="submit" name="submit" value="Submit"/>
						</div>
					</div>
				</div>
			</div>
		</form>
		<script type="text/javascript" src="../jqueryLib/jquery-1.8.2.min.js"></script>
		<script type="text/javascript" src="../jQueryUI/jquery-ui-1.8.23.custom/js/jquery-ui-1.8.23.custom.min.js"></script>
		<script type="text/javascript">
			$(function(){
				$('#RadioAccesoArchivo').buttonset().css({
					'font-size':'0.8em',
					'height' : '28px'
				}).find('label').css('height','28px');
				$('[name="submit"]').button({
					icons : {
						primary : "ui-icon ui-icon-disk"
					}
				}).css({
					'font-size':'0.8em',
					'height' : '28px'
				});
				$('button').button({
					icons : {
						primary : "ui-icon ui-icon-close"
					}
				}).css({
					'font-size':'0.8em',
					'height' : '28px'
				});
			});
		</script>
    </body>
</html>
