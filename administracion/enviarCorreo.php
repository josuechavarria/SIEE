<?php
 
  //variable de validacion
 
  $valida = true;
 
  if (empty($_POST['nombre'])) {
 
    echo "<b>No se especifico nombre</b><br/>";
 
    $valida = false;
 
  }
 
  if (empty($_POST['email'])) {
 
   echo "<b>No se especifico E - mail</b><br/>";
 
   $valida = false;
 
  }
 
  if (empty($_POST['asunto'])) {
 
   echo "<b>No se especifico asunto</b><br/>";
 
   $valida = false;
 
  }
 
  if (empty($_POST['mensaje'])) {
 
   echo "<b>Por favor, no envie un mensaje en blanco</b><br/>";
 
   $valida = false;
 
  }
 
  // Validamos la direccion de correo electronico
 
  if (!strchr($_POST['email'],"@") || !strchr($_POST['email'],"."))
   {
 
    echo "<b>No es un correo valido</b><br/>";
 
    $valida = false;
 
   }
 
  // Si las comprobaciones son correctas
 
  if ($valida == true)
 
   {
 
    // Creamos el header para el mensaje
 
    // para:
 
    $to = $_POST['para'];
 
    // Asunto
 
    $subject = $_POST['asunto'];
 
    // Cabeceras del mail (Content-Type y demas info)
 
    $headers = "MIME-Version: 1.0\n";
 
    $headers .= "Content-type: text/html; charset=utf-8\n";
 
    // El From: en la forma Nombre <email@sitio.com>, esto garantiza que
 
    // el receptor vea solo el nombre de quien envia
 
    $headers .= "From: ".$_POST['nombre']." <".$_POST['email'].">\n";
 
    // Opcional: Resopnder a:
 
    $headers .= "Reply-To: " . $_POST['email']."\n";
 
    //Opcional X-Mailer
 
    $headers .= "X-Mailer: PHP/" . phpversion();
 
    // Cuerpo del email
 
    $message = $_POST['mensaje'];
 
    if(mail($to, $subject, $message,$headers))
     {
 
      echo "<p>Mensaje enviado, Gracias por escribirnos.<br /><a href=\"javascript:history.go(-1)\">Volver</a></p>";
 
     }
 
   }
 
?>