<?php
//utilizo PDO para poder utilizar queries seguros con parametros
try {
    $conn = new PDO("odbc:Driver={SQL Server};Server=HUMUIT33044-HP\SQLEXPRESS;Database=BD_SIEE;");
} catch (PDOException $e) {
    //Header("Location: error_conexion_baseDatos.php");
    echo $e->getMessage();
    exit;
}
session_start();
//para el tour
/*$expire= time()+60*60*24*30; //1 mes

if (ISSET($_COOKIE['siee_tour'])) {
    
    if($_COOKIE['siee_tour'] == '1')
    {
        if(!ISSET($_SESSION["correr_tour"]))
        {
            $_SESSION["correr_tour"] = true;
        }
        $_SESSION["inicio_tour"] = true;
        $_SESSION["step_actual_tour"] = 1;
    }
    else
    {
        $_SESSION["correr_tour"] = false;
        $_SESSION["inicio_tour"] = true;
        $_SESSION["step_actual_tour"] = -1;
    }
}
else
{
    setcookie('siee_tour');
    setcookie('siee_tour', '1', $expire);
    $_SESSION["correr_tour"] = true;
    $_SESSION["inicio_tour"] = true;
    $_SESSION["step_actual_tour"] = 1;
}*/
//funcion de uso general para SQL SERVER...
function recuperar_identity($conn)
{
    $stmt_identity = $conn->query('SELECT @@IDENTITY AS last_id');
    $row_ultimo = $stmt_identity->fetch();
    $ultimo = (int)$row_ultimo['last_id'];
    $stmt_identity->closeCursor();
    return $ultimo;
}
//para convertir los campos de un hash table con utf8 enconding
function utf8_encode_mix($input, $encode_keys = false, $UcTheWord = false) {
    if (is_array($input)) {
        $result = array();
        foreach ($input as $k => $v) {
            $key = ($encode_keys) ? utf8_encode($k) : $k;
            $result[$key] = utf8_encode_mix($v, $encode_keys, $UcTheWord);
        }
    } else {
        $result = ($UcTheWord) ? ucwords(utf8_encode($input)) : utf8_encode($input);
    }

    return $result;
}
?>