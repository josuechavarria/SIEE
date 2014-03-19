<?php
/**
 * Send a GET requst using cURL
 * @param string $url to request
 * @param array $get values to send
 * @param array $options for cURL
 * @return string
 */
function curl_get($url, array $get = NULL, array $options = array()) {
    $defaults = array(
        CURLOPT_URL => $url . (strpos($url, '?') === FALSE ? '?' : '') . http_build_query($get),
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_TIMEOUT => 4
    );

    $ch = curl_init();
    curl_setopt_array($ch, ($options + $defaults));
    if (!$result = curl_exec($ch)) {
        trigger_error(curl_error($ch));
    }
    curl_close($ch);
    return $result;
}
/**
 * Send a POST requst using cURL
 * @param string $url to request
 * @param array $post values to send
 * @param array $options for cURL
 * @return string
 */
function curl_post($url, array $post = NULL, array $options = array()) {
    $defaults = array(
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_URL => $url,
        CURLOPT_FRESH_CONNECT => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FORBID_REUSE => 1,
        CURLOPT_TIMEOUT => 4,
        CURLOPT_POSTFIELDS => http_build_query($post)
    );

    $ch = curl_init();
    curl_setopt_array($ch, ($options + $defaults));
    if (!$result = curl_exec($ch)) {
        trigger_error(curl_error($ch));
    }
    curl_close($ch);
    
    return $result;
}
$_token = md5('see_sace');
$_url = "http://190.5.81.201/api/ingresar_centro";
$post_params = array(
    'token' => $_token,
    'codigo' => '010100007',
    'nombre' => 'CRISTOBAL COLON',
    'direccion' => 'COL. YESSENIA CASTILLO',
    'telefono' => '24424139',
    'celular' => '98186701'
);
$respuesta = json_decode(curl_post($_url, $post_params));

if ( $respuesta->{'status'} != 1)
{
    if($respuesta->{'status'} == 4)
    {
        echo 'Faltan los siguientes datos: ' . $respuesta->{'error'};
    }
    else
    {
        echo $respuesta->{'error'};
    }
}
else
{
    echo 'El registro de este centro ha sido exitoso en SACE <br/><br/> El centro ingresado es: ' .
        $respuesta->{'nombre'};
}
?>