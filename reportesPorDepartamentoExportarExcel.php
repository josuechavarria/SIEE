<?php
include 'phpIncluidos/conexion.php';
include 'phpIncluidos/reportesPorDepto.php';

echo '  <table BORDER="1">
            <tr>
                <th ALIGN="LEFT" BGCOLOR="#CCCCCC">A&ntilde;o</th>
                <td ALIGN="LEFT">'. $anio .'</td>                
            </tr>
            <tr>
                <th ALIGN="LEFT" BGCOLOR="#CCCCCC">Indicador</th>
                <td ALIGN="LEFT">'. $indicador .'</td>
            </tr>
            <tr>
                <th ALIGN="LEFT" BGCOLOR="#CCCCCC">Grado(s)</th>
                <td ALIGN="LEFT">' . $grado . '</td>
            </tr>
        </table>'
?>
<table>
</table>
<table BORDER="1" BGCOLOR="#CCCCCC">
    <thead BORDER="2" HEIGHT="60">
        <tr>
            <?php
            echo '<th>DEPARTAMENTOS</th>';
            if ($numero_reporte == 1) {
                echo '<th>TOTAL PUBLICO</th>
                      <th>TOTAL PRIVADO</th>';
            }
            if ($numero_reporte == 2) {
                echo '<th>TOTAL RURAL</th>
                      <th>TOTAL URBANO</th>';
            }
            if ($numero_reporte == 3) {
                echo '<th>Falta</th>
                      <th>Falta</th>';
            }
            if ($numero_reporte == 4) {
                echo '<th>TOTAL FEMENINO</th>
                      <th>TOTAL MASCULINO</th>';
            }
            echo '<th>TOTAL GENERAL</th>';
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $contador = 0;
        $totalA = 0;
        $totalB = 0;
        $grandTotal = 0;
        foreach ($data_reporte as $data) {
            if (($contador % 2) == 0) {
                echo '<tr BGCOLOR="#F1F5FA">';
            } else {
                echo '<tr BGCOLOR="#FFFFFF">';
            }
            echo '<th ALIGN="LEFT">' . ucfirst($data['departamento']) . '</th>';
            if ($numero_reporte == 1) {
                $totalA += $data['total_publico'];
                $totalB += $data['total_privado'];
                echo '<td ALIGN="RIGHT">' . $data['total_publico'] . '</td>
                      <td ALIGN="RIGHT">' . $data['total_privado'] . '</td>';
            }
            if ($numero_reporte == 2) {
                $totalA += $data['total_rural'];
                $totalB += $data['total_urbana'];
                echo '<td ALIGN="RIGHT">' . $data['total_rural'] . '</td>
                      <td ALIGN="RIGHT">' . $data['total_urbana'] . '</td>';
            }
            if ($numero_reporte == 3) {
                $totalA += 0;
                $totalB += 0;
                echo '<td ALIGN="RIGHT">0</td>
                      <td ALIGN="RIGHT">0</td>';
            }
            if ($numero_reporte == 4) {
                $totalA += $data['total_femenino'];
                $totalB += $data['total_masculino'];
                echo '<td ALIGN="RIGHT">' . $data['total_femenino'] . '</td>
                      <td ALIGN="RIGHT">' . $data['total_masculino'] . '</td>';
            }
            $grandTotal += $data['total_general'];
            echo '<td ALIGN="RIGHT">' . $data['total_general'] . '</td>';
            echo "</tr>";
            $contador++;
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th ALIGN="CENTER" BGCOLOR="#CCCCCC">Totales</th>
            <th ALIGN="RIGHT" BGCOLOR="#CCCCCC"><?php echo number_format($totalA) ?>&nbsp;</th>
            <th ALIGN="RIGHT" BGCOLOR="#CCCCCC"><?php echo number_format($totalB) ?>&nbsp;</th>
            <th ALIGN="RIGHT" BGCOLOR="#CCCCCC"><?php echo number_format($grandTotal) ?>&nbsp;</th>
        </tr>
    </tfoot>
</table>
<?php
include "phpIncluidos/simplyExportExcel.php";
?>