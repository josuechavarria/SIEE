<?php
include 'phpIncluidos/conexion.php';
$error = false;
$id_ventana = "";
$html_header = "";
$html_contenido = "";
    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        if(ISSET($_GET['id_ventana']) && ISSET($_GET['html_contenido']) && ISSET($_GET['html_header']))
        {
            $id_ventana = $_GET['id_ventana'];
            $html_header = $_GET['html_header'];
            $html_contenido = $_GET['html_contenido'];
        }
        else
        {
            $error = true;
			exit;
        }
    }
?>
<div id="<?php echo $id_ventana; ?>" class="ventanaProcesosSIEE">
    <div onclick="eliminarDialogoFlotante('<?php echo $id_ventana; ?>')" class="cerrar" href="#">x</div>
    <div class="encabezadoVentana">
        <?php echo $html_header; ?>
    </div>
    <div class="contenidoVentana">
        <?php echo $html_contenido; ?>
    </div>
</div>