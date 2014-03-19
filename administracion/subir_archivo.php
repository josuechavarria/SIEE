<?php

include '../phpIncluidos/conexion.php';

if ($_FILES["archivo"]["error"] > 0) {
    $error_num = $_FILES['archivo']['error'];

    if ($error_num == 1) {
        echo 'El archivo excede el tamano maximo de 2MB (default).';
    } else {
        echo 'Error code ' . $error_num . '. Buscar en google.';
    }
} else {
    if (!ISSET($_POST['titulo']) || !ISSET($_POST['privado'])) {
        echo 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acci&otilde;n de nuevo.';
    } else {
        if (!($titulo = trim($_POST['titulo']))) {
            echo 'Titulo es requerido.';
            exit;
        } else {
            if (!($extension = stristr($_FILES['archivo']['name'], '.'))) {
                echo 'El nombre del archivo debe tener una extension. \'' . $titulo . '\'';
                exit;
            }
        }

        $dir_archivos = 'C:\\wamp\\www\\SIEE\\archivos\\';
        $titulo = trim($_POST['titulo']);
        $descripcion = trim($_POST['descripcion']);
        $direccion = $dir_archivos . md5($_FILES['archivo']['name'] . $_SESSION['usuario']['id'] . $_SERVER['REQUEST_TIME']);

        $finfo = new finfo(FILEINFO_MIME);
        $type = $finfo->file($_FILES['archivo']['tmp_name']);
        $tipo = substr($type, 0, strpos($type, ';'));

        $tamano = $_FILES['archivo']['size'] / 1024; //guardar tamano en KB
        $privado = $_POST['privado'];
        $activo = 0;
        $usuario_creador_id = $_SESSION['usuario']['id'];
        $usuario_modificador_id = $_SESSION['usuario']['id'];

        $stmt_insertar_archivo = $conn->prepare("INSERT INTO siee_archivo ( titulo
                                                                            ,descripcion
                                                                            ,direccion
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

        $stmt_insertar_archivo->bindParam(1, utf8_decode($titulo));
        $stmt_insertar_archivo->bindParam(2, utf8_decode($descripcion));
        $stmt_insertar_archivo->bindParam(3, utf8_decode($direccion));
        $stmt_insertar_archivo->bindParam(4, $tipo);
        $stmt_insertar_archivo->bindParam(5, utf8_decode($extension));
        $stmt_insertar_archivo->bindParam(6, $tamano);
        $stmt_insertar_archivo->bindParam(7, $privado);
        $stmt_insertar_archivo->bindParam(8, $activo);
        $stmt_insertar_archivo->bindParam(9, $usuario_creador_id);
        $stmt_insertar_archivo->bindParam(10, $usuario_modificador_id);

        $conn->exec('BEGIN TRANSACTION');

        try {
            if (!$stmt_insertar_archivo->execute()) {
                echo 'Fallo la insercion del archivo.<br/>';

                echo 'Error Info: ';
                print_r($stmt_insertar_archivo->errorInfo());

                //echo '<br />Message: ';
                //print_r($stmt_insertar_archivo->getMessage());

                echo '<br />error code: ';
                print_r($stmt_insertar_archivo->errorCode());

                $conn->exec('ROLLBACK TRANSACTION');
            } else {
                if (!move_uploaded_file($_FILES['archivo']['tmp_name'], $direccion)) {
                    echo 'Fallo mover el archivo del directorio temporal al directorio de trabajo.';
                    $conn->exec('ROLLBACK TRANSACTION');
                } else {
                    $conn->exec('COMMIT TRANSACTION');
                    header('Location: admon_archivo.php');
                    echo 'Archivo subido exitosamente! Detalles: <br/><br/>';

                    echo "Upload: " . $_FILES["archivo"]["name"] . "<br />";
                    echo "Type: " . $_FILES["archivo"]["type"] . "<br />";
                    echo "Size: " . ($_FILES["archivo"]["size"] / 1024) . " Kb<br />";
                    echo "Se guardo temporalmente en: " . $_FILES["archivo"]["tmp_name"] . "<br />";

                    //echo "Se pudo mover: " . move_uploaded_file($_FILES["archivo"]["tmp_name"], "../archivos/up.jpg");
                }
            }
        } catch (PDOException $ex) {
            echo 'Error al guardar el archivo. Detalles:' . $ex;
        }
    }
}
?>
