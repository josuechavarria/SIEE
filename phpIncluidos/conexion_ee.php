<?php
//utilizo PDO para poder utilizar queries seguros con parametros
try {
    $conn_ee = new PDO("odbc:Driver={SQL Server};Server=HUMUIT33044-HP\SQLEXPRESS;Database=BD_ESTADISTICAS_PUBLICA");
} catch (PDOException $e) {
    //Header("Location: error_conexion_baseDatos.php");
    echo $e->getMessage();
    exit;
}
?>