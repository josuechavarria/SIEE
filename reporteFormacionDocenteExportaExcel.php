<?php
include 'phpIncluidos/conexion.php';

echo '  <table BORDER="1">
            <tr>
                <th ALIGN="LEFT" BGCOLOR="#CCCCCC">A&ntilde;o</th>
                <td ALIGN="LEFT">' . $anio . '</td>                
            </tr>
        </table>'
?>

<?php
include "phpIncluidos/simplyExportExcel.php";
?>