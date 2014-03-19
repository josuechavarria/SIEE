<?php
include '../phpIncluidos/conexion.php';
$errores = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (empty($_POST) && empty($_FILES)) { //Si el archivo excede el post_max_size
		$_POST['titulo'] = '';
		$_POST['descripcion'] = '';
		$_POST['privado'] = 0;
		$errores['archivo'] = 'El archivo excede el tamano maximo de 2MB.';
	} else {
		if (!ISSET($_POST['titulo']) || !ISSET($_POST['privado'])) {
			$errores['general'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acci&otilde;n de nuevo.';
		} else {
			$dir_archivos = 'C:\\wamp\\www\\SIEE\\archivos\\';

			if ($_FILES['archivo']['error'] > 0) {
				$error_num = $_FILES['archivo']['error'];

				if ($error_num == 1) {
					$errores['archivo'] = 'El archivo excede el tamano maximo de 2MB.';
				} else if ($error_num == 4) {
					$errores['archivo'] = 'Debe seleccionar un archivo.';
				} else {
					$errores['archivo'] = 'Error code ' . $error_num;
				}
			} else {
				if (!($extension = end(explode('.', $_FILES['archivo']['name'])))) {
					$errores['archivo'] = 'El nombre del archivo debe tener una extension.';
				}
			}

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

			if (sizeof($errores) == 0) {
				if (strcasecmp($extension, 'xlsx') == 0) {
					$tipo = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
				} else if (strcasecmp($extension, 'xltx') == 0) {
					$tipo = 'application/vnd.openxmlformats-officedocument.spreadsheetml.template';
				} else if (strcasecmp($extension, 'potx') == 0) {
					$tipo = 'application/vnd.openxmlformats-officedocument.presentationml.template';
				} else if (strcasecmp($extension, 'ppsx') == 0) {
					$tipo = 'application/vnd.openxmlformats-officedocument.presentationml.slideshow';
				} else if (strcasecmp($extension, 'pptx') == 0) {
					$tipo = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
				} else if (strcasecmp($extension, 'sldx') == 0) {
					$tipo = 'application/vnd.openxmlformats-officedocument.presentationml.slide';
				} else if (strcasecmp($extension, 'docx') == 0) {
					$tipo = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
				} else if (strcasecmp($extension, 'dotx') == 0) {
					$tipo = 'application/vnd.openxmlformats-officedocument.wordprocessingml.template';
				} else if (strcasecmp($extension, 'xlam') == 0) {
					$tipo = 'application/vnd.ms-excel.addin.macroEnabled.12';
				} else if (strcasecmp($extension, 'xlsb') == 0) {
					$tipo = 'application/vnd.ms-excel.sheet.binary.macroEnabled.12';
				} else {
					$finfo = new finfo(FILEINFO_MIME);
					$type = $finfo->file($_FILES['archivo']['tmp_name']);
					$tipo = substr($type, 0, strpos($type, ';'));
				}

				$nombre = md5($_FILES['archivo']['name'] . $_SESSION['usuario']['id'] . $_SERVER['REQUEST_TIME']);
				$tamano = $_FILES['archivo']['size'] / 1024; //guardar tamano en KB

				if (!preg_match('/^[01]$/', (($privado = $_POST['privado'])))) {
					$privado = 1;
				}

				$activo = 1;
				$usuario_creador_id = $_SESSION['usuario']['id'];
				$usuario_modificador_id = $_SESSION['usuario']['id'];

				$stmt_insertar_archivo = $conn->prepare("INSERT INTO siee_archivo ( titulo
                                                                                ,descripcion
                                                                                ,nombre
                                                                                ,tipo
                                                                                ,extension
                                                                                ,tamano
                                                                                ,privado
                                                                                ,activo
                                                                                ,usuario_creador_id
                                                                                ,fecha_creacion
                                                                                ,usuario_modificador_id
                                                                                ,fecha_modificacion)
                                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP, ?, CURRENT_TIMESTAMP);");

				$conn->exec('BEGIN TRANSACTION');

				try {
					if (!$stmt_insertar_archivo->execute(array(utf8_decode($titulo), utf8_decode($descripcion), utf8_decode($nombre), $tipo, utf8_decode($extension), $tamano, $privado, $activo, $usuario_creador_id, $usuario_modificador_id))) {
						$errores['general'] = 'Error al tratar de cargar el archivo:' . print_r($stmt_insertar_archivo->errorInfo(), true);
						$conn->exec('ROLLBACK TRANSACTION');
					} else {
						if (!move_uploaded_file($_FILES['archivo']['tmp_name'], $dir_archivos . $nombre)) {
							$errores['general'] = 'Error al tratar de mover el archivo a la carpeta permanente.';
							$conn->exec('ROLLBACK TRANSACTION');
						} else {
							$conn->exec('COMMIT TRANSACTION');
						}
					}
				} catch (PDOException $ex) {
					$errores['general'] = 'Error al tratar de cargar el archivo:' . $ex;
				}
			}
		}
	}
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/iframe.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="../jQueryUI/jquery-ui-1.8.23.custom/css/custom-theme/jquery-ui-1.8.23.custom.css" />
        <title></title>
    </head>
    <body>
        <form action="carga_de_archivo.php" method="post" enctype="multipart/form-data">
            <div class="formularios">
                <p>
                    <?php echo $_SERVER['REQUEST_METHOD'] == 'POST' ? (sizeof($errores) == 0 ? 'El archivo fue cargado exitosamente.' : 'Ocurrieron errores al tratar de cargar el archivo.') : '' ?>
                </p>
                <div id="CamposFormulario">
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_Archivo">
                            <?php echo array_key_exists('archivo', $errores) ? $errores['archivo'] : ''; ?>
                        </ul>
                        <label for="Archivo">Seleccione el Archivo:</label>
                        <input id="Archivo" name="archivo" type="file"/>
                    </div>

                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_TituloArchivo">
                            <?php echo array_key_exists('titulo', $errores) ? $errores['titulo'] : ''; ?>
                        </ul>
                        <label for="TituloArchivo">Escriba el titulo del Archivo:</label>
                        <input id="TituloArchivo" name="titulo"  type="text" maxlength="80" value="<?php echo sizeof($errores) > 0 ? $_POST['titulo'] : ''; ?>"/>
                    </div>

                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_DescripcionArchivo">
                            <?php echo array_key_exists('descripcion', $errores) ? $errores['descripcion'] : ''; ?>
                        </ul>
                        <label for="DescripcionArchivo">Descripci&oacute;n del Archivo:</label>
                        <textarea id="DescripcionArchivo" name="descripcion" maxlength="300" ><?php echo sizeof($errores) > 0 ? $_POST['descripcion'] : ''; ?></textarea>
                    </div>

                    <div class="itemsFormularios">
                        <label>Acceso:</label>
                        <span id="RadioAccesoArchivo">
                            <?php
                            if (sizeof($errores) > 0 && $_POST['privado'] == 0) {
                                ?>

                                <input type="radio" id="AccesoPrivado" name="privado" value="1"/><label for="AccesoPrivado">Privado</label>
                                <input type="radio" id="AccesoPublico" name="privado" value="0" checked="checked"/><label for="AccesoPublico">Publico</label>

                                <?php
                            } else {
                                ?>

                                <input type="radio" id="AccesoPrivado" name="privado" value="1" checked="checked"/><label for="AccesoPrivado">Privado</label>
                                <input type="radio" id="AccesoPublico" name="privado" value="0"/><label for="AccesoPublico">Publico</label>

                                <?php
                            }
                            ?>
                        </span>
                    </div>
                </div>
                <br>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <input type="submit" name="submit" value="Cargar Archivo"/>
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
