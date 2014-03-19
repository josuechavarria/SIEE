<?php
include 'phpIncluidos/conexion.php';

$patron_nombres = '/^[a-zA-ZáÁéÉíÍóÓúÚ]+$/';
$patron_nombres_err = 'Solo puedes ingresar caracteres a-z, A-Z y letras acentuadas.';
$patron_usuario = '/^[a-zA-Z0-9áÁéÉíÍóÓúÚ._-]+$/';
$patron_usuario_err = 'Solo puedes ingresar caracteres de la a-z, letras acentuadas mayusculas y/o minusculas, ., -, _';
$patron_telefono = '/^[0-9]+$/';
$patron_telefono_err = 'Solo puedes ingresar caracteres numericos (0-9).';
$patron_correo = '/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9_.-]+.[a-zA-Z0-9_.-]+$/';
$patron_correo_err = 'El formato del correo electronico debe ser \'nombre@ejemplo.com\'.';

$response = array();
$errores = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!ISSET($_POST['primer_nombre']) || !ISSET($_POST['segundo_nombre']) || !ISSET($_POST['primer_apellido']) || !ISSET($_POST['segundo_apellido']) || !ISSET($_POST['telefono_fijo']) || !ISSET($_POST['telefono_movil']) || !ISSET($_POST['correo_electronico'])){
        $response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acciÃ³n de nuevo.';
    }else{
        if (!($primer_nombre = trim($_POST['primer_nombre']))){
            $errores['PrimerNombreUsuario_mod'] = 'Escriba aqui el primer nombre del usuario.';
        }else{
            if (!preg_match($patron_nombres, $primer_nombre)){
                $errores['PrimerNombreUsuario_mod'] = $patron_nombres_err;
            }
        }
       
        if (($segundo_nombre = trim($_POST['segundo_nombre']))){
            if (!preg_match($patron_nombres, $segundo_nombre)){
                $errores['SegundoNombreUsuario_mod'] = $patron_nombres_err;
            }
        }
       
        if (!($primer_apellido = trim($_POST['primer_apellido']))){
            $errores['PrimerApellidoUsuario_mod'] = 'Escriba aqui el primer apellido del usuario.';
        }else{
            if (!preg_match($patron_nombres, $primer_apellido)){
                $errores['PrimerApellidoUsuario_mod'] = $patron_nombres_err;
            }
        }
       
        if (($segundo_apellido = trim($_POST['segundo_apellido']))){
            if (!preg_match($patron_nombres, $segundo_apellido)){
                $errores['SegundoApellidoUsuario_mod'] = 'Solo puedes ingresar caracteres a-z, A-Z y letras acentuadas.';
            }
        }
       
        if (($telefono_fijo = trim($_POST['telefono_fijo']))){
            if (strlen($telefono_fijo) < 8){
                $errores['TelefonoFijoUsuario_mod'] = 'El telefono fijo debe tener al menos 8 caracteres.';
            }else{
                if (!preg_match($patron_telefono, $telefono_fijo)){
                    $errores['TelefonoFijoUsuario_mod'] = $patron_telefono_err;
                }
            }
        }
       
        if (($telefono_movil = trim($_POST['telefono_movil']))){
            if (strlen($telefono_movil) < 8){
                $errores['TelefonoMovilUsuario_mod'] = 'El telefono movil debe tener al menos 8 caracteres.';
            }else{
                if (!preg_match($patron_telefono, $telefono_movil)){
                    $errores['TelefonoMovilUsuario_mod'] = $patron_telefono_err;
                }
            }
        }
       
        if (!($correo_electronico = trim($_POST['correo_electronico']))){
            $errores['CorreoElectronicoUsuario_mod'] = 'Escriba aqui el correo electronico del usuario.';
        }else{
            if (!preg_match($patron_correo, $correo_electronico)){
                $errores['CorreoElectronicoUsuario_mod'] = $patron_correo_err;
            }
        }

        if (sizeof($errores) == 0){
            $idUsuario = $_SESSION['usuario']['id'];
            $usuario_modificador = $idUsuario;
           
            $stmt_modificar_usuario = $conn->prepare("UPDATE siee_usuario SET
                                                        primer_nombre = ?,
                                                        segundo_nombre = ?,
                                                        primer_apellido = ?,
                                                        segundo_apellido = ?,
                                                        telefono_fijo = ?,
                                                        telefono_movil = ?,
                                                        correo_electronico = ?,
                                                        usuario_modificador_id = ?,
                                                        fecha_modificacion = CURRENT_TIMESTAMP
                                                    WHERE id = ?;");
           
            $stmt_modificar_usuario->bindParam(1, utf8_decode($primer_nombre));
            $stmt_modificar_usuario->bindParam(2, utf8_decode($segundo_nombre));
            $stmt_modificar_usuario->bindParam(3, utf8_decode($primer_apellido));
            $stmt_modificar_usuario->bindParam(4, utf8_decode($segundo_apellido));
            $stmt_modificar_usuario->bindParam(5, utf8_decode($telefono_fijo));
            $stmt_modificar_usuario->bindParam(6, utf8_decode($telefono_movil));
            $stmt_modificar_usuario->bindParam(7, utf8_decode($correo_electronico));
            $stmt_modificar_usuario->bindParam(8, $usuario_modificador);
            $stmt_modificar_usuario->bindParam(9, $idUsuario);
           
            $conn->exec('BEGIN TRANSACTION');
            try {               
                if (!$stmt_modificar_usuario->execute()){
                    // aqui se detecatron errores al tratar de guardar los datos en la base de datos.
                    $conn->exec('ROLLBACK TRANSACTION');
                    $response['refresh_error'] = 'Hubo un error al tratar de guardar los datos en la base de datos, es posible que la base de datos estÃ© ocupada en este momento. Porfavor, intentalo de nuevo.';
                }else{
                    $conn->exec('COMMIT TRANSACTION');
                    $_SESSION['usuario']['primer_nombre'] = $primer_nombre;
                    $_SESSION['usuario']['segundo_nombre'] = $segundo_nombre;
                    $_SESSION['usuario']['primer_apellido'] = $primer_apellido;
                    $_SESSION['usuario']['segundo_apellido'] = $segundo_apellido;
                    $_SESSION['usuario']['correo_electronico'] = $correo_electronico;
                    $_SESSION['usuario']['telefono_fijo'] = $telefono_fijo;
                    $_SESSION['usuario']['telefono_movil'] = $telefono_movil;
                }
            } catch (PDOException $e) {
                $conn->exec('ROLLBACK TRANSACTION');
                $stmt_modificar_usuario->closeCursor();
                // enviar html de errores o js function que ejecute el mensaje de errores
                $response['refresh_error'] = 'Hubo un error al tratar de insertar los datos en la base de datos. Porfavor, intentalo de nuevo.';
            }
        }
    }
}else{
    $response['refresh_error'] = 'Los datos estan corruptos o se intento violar la seguridad, porfavor refresca la pagina y realiza esta acciÃ³n de nuevo.';
}

if (sizeof($errores) > 0){
    $response['errores'] = $errores;
}

echo json_encode($response);
?>