<?php
include 'phpIncluidos/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if ( ISSET($_GET['anio']) && ISSET($_GET['departamento']) && ISSET($_GET['municipio'])
            && ISSET($_GET['centroEducativo']) && ISSET($_GET['fileName']) && ISSET($_GET['tablaDatos'])) {
        
        $tabla_de_datos_de_indicador = $_GET['tablaDatos'];
        $arch_indicador = $_GET['fileName'];
        
        $tabla_de_datos_de_indicador = str_replace('|', '"', $tabla_de_datos_de_indicador);
        $tabla_de_datos_de_indicador = str_replace('@', '=', $tabla_de_datos_de_indicador);
        $tabla_de_datos_de_indicador = str_replace('[', '<', $tabla_de_datos_de_indicador);
        $tabla_de_datos_de_indicador = str_replace(']', '>', $tabla_de_datos_de_indicador);
        $tabla_de_datos_de_indicador = str_replace('~', '#', $tabla_de_datos_de_indicador);
        
        include "phpIncluidos/simplyExportExcel.php";
        
        //armando la tabla que se envia en el archivo de excel
        echo '<table BORDER="1">
                <tr>
                    <th ALIGN="LEFT" BGCOLOR="#CCCCCC">A&ntilde;o</th>
                    <td ALIGN="LEFT">' . $_GET['anio'] . '</td>                
                </tr>
                <tr>
                    <th ALIGN="LEFT" BGCOLOR="#CCCCCC">Departamento(s)</th>
                    <td ALIGN="LEFT">' . utf8_decode($_GET['departamento']) . '</td>
                </tr>
                <tr>
                    <th ALIGN="LEFT" BGCOLOR="#CCCCCC">Municipio(s)</th>
                    <td ALIGN="LEFT">' . utf8_decode($_GET['municipio']) . '</td>
                </tr>
                <tr>
                    <th ALIGN="LEFT" BGCOLOR="#CCCCCC">Centro Educativo</th>
                    <td ALIGN="LEFT">' . utf8_decode($_GET['centroEducativo']) . '</td>
                </tr>
            </table>' . $tabla_de_datos_de_indicador;
    }
}
?>