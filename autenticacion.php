<?php
    include 'phpIncluidos/conexion.php';
    $response = array();   
    if (ISSET($_SESSION['usuario'])){
        $response['autenticado'] = true;
        $response['usuario'] = $_SESSION['usuario'];
    }else{
        try{
            $nombre_usuario = $_POST['nombre_usuario'];
            $clave_acceso = md5($_POST['clave_acceso']);
           
            $stmt_usuario = $conn->prepare('SELECT * FROM siee_usuario WHERE nombre_usuario = ? AND clave_acceso = ? AND activo = 1;');
            $stmt_usuario->bindParam(1, utf8_encode($nombre_usuario));
            $stmt_usuario->bindParam(2, utf8_encode($clave_acceso));
            $stmt_usuario->execute();
            $usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);
            $stmt_usuario->closeCursor();
           
            if($usuario){
                $stmt_rol = $conn->query('SELECT * FROM siee_rol WHERE id = ' . $usuario['rol_id'] . ';');
                $rol = $stmt_rol->fetch();
                $usuario['rol'] = $rol;
                $stmt_rol->closeCursor();
                $_SESSION['usuario'] = $usuario;
                $response['autenticado'] = true;
                $response['usuario'] = $usuario;
            }else{
                $response['autenticado'] = false;
            }
        }catch(Exception $e){
            $response['autenticado'] = false;
        }
    } 
    echo json_encode($response);
?>