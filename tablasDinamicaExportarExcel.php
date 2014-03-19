<?php
include 'phpIncluidos/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (ISSET($_GET['fileName'])) {
        include 'phpIncluidos/queryDinamico.php';
        ?>
        <html>
            <head>
                <title>
                    Reporte Generado desde Tabla Dinamica
                </title>
            </head>
            <body>
                <?php
                echo '  <table BORDER="1">
                            <tr>
                                <th ALIGN="LEFT" BGCOLOR="#CCCCCC">A&ntilde;o</th>
                                <td ALIGN="LEFT">' . $anio . '</td>                
                            </tr>
                            <tr>
                                <th ALIGN="LEFT" BGCOLOR="#CCCCCC">Indicador</th>
                                <td ALIGN="LEFT">' . $indicador . '</td>
                            </tr>
                            <tr>
                                <th ALIGN="LEFT" BGCOLOR="#CCCCCC">Tipo de C&aacute;lculo</th>
                                <td ALIGN="LEFT">' . $reporte_calculo . ' ' . $campo_calculado . '</td>
                            </tr>
                        </table>'
                ?>
                <table>
                </table>
                <table BORDER="1" BGCOLOR="#CCCCCC">
                    <thead BORDER="2" HEIGHT="60">
                        <tr>
                            <?php
                            echo '<th>' . strtoupper($col_A0) . '</th>';
                            //PARTE DE LOS CAMPOS QUE SERAN ETIQUETAS
                            if (!$col_B0_esDatoCalculo) {
                                if ($col_B0_etiquetaCampo == 'departamento') {
                                    echo '<th>' . strtoupper($col_B0_etiquetaCampo) . 'S</th>';
                                }
                                if ($col_B0_etiquetaCampo == 'administracion') {
                                    echo '<th>ADMINISTRACIÓN</th>';
                                }
                                if ($col_B0_etiquetaCampo == 'zona') {
                                    echo '<th>' . strtoupper($col_B0_etiquetaCampo) . '</th>';
                                }
                                if ($col_B0_etiquetaCampo == 'grado') {
                                    echo '<th>' . strtoupper($col_B0_etiquetaCampo) . 'S</th>';
                                }
                                if ($col_B0_etiquetaCampo == 'genero') {
                                    echo '<th>GENERO</th>';
                                }
                            }
                            if (!$col_C0_esDatoCalculo) {
                                if ($col_C0_etiquetaCampo == 'departamento') {
                                    echo '<th>' . strtoupper($col_C0_etiquetaCampo) . 'S</th>';
                                }
                                if ($col_C0_etiquetaCampo == 'administracion') {
                                    echo '<th>ADMINISTRACIÓN</th>';
                                }
                                if ($col_C0_etiquetaCampo == 'zona') {
                                    echo '<th>' . strtoupper($col_C0_etiquetaCampo) . '</th>';
                                }
                                if ($col_C0_etiquetaCampo == 'grado') {
                                    echo '<th>' . strtoupper($col_C0_etiquetaCampo) . 'S</th>';
                                }
                                if ($col_C0_etiquetaCampo == 'genero') {
                                    echo '<th>' . strtoupper($col_C0_etiquetaCampo) . 'S</th>';
                                }
                            }
                            if (!$col_D0_esDatoCalculo) {
                                if ($col_D0_etiquetaCampo == 'departamento') {
                                    echo '<th>' . strtoupper($col_D0_etiquetaCampo) . 'S</th>';
                                }
                                if ($col_D0_etiquetaCampo == 'administracion') {
                                    echo '<th>ADMINISTRACIÓN</th>';
                                }
                                if ($col_D0_etiquetaCampo == 'zona') {
                                    echo '<th>' . strtoupper($col_D0_etiquetaCampo) . '</th>';
                                }
                                if ($col_D0_etiquetaCampo == 'grado') {
                                    echo '<th>' . strtoupper($col_D0_etiquetaCampo) . 'S</th>';
                                }
                                if ($col_D0_etiquetaCampo == 'genero') {
                                    echo '<th>' . strtoupper($col_D0_etiquetaCampo) . 'S</th>';
                                }
                            }


                            if ($col_B0 == 'administracion' || $col_C0 == 'administracion' || $col_D0 == 'administracion' || $col_E0 == 'administracion') {
                                echo '      <th>TOTAL PUBLICO</th>
                                            <th>TOTAL PRIVADO</th>';
                            }
                            if ($col_B0 == 'zona' || $col_C0 == 'zona' || $col_D0 == 'zona' || $col_E0 == 'zona') {
                                echo '  <th>TOTAL RURAL</th>
                                        <th>TOTAL URBANO</th>';
                            }
                            if ($col_B0 == 'departamento' || $col_C0 == 'departamento' || $col_D0 == 'departamento' || $col_E0 == 'departamento') {
                                echo '      <th>ATLÁNTIDA</th>
                                            <th>CHOLUTECA</th>
                                            <th>COLÓN</th>
                                            <th>COMAYAGU</th>
                                            <th>COPÁN</th>
                                            <th>CORTÉS</th>
                                            <th>EL PARAÍSO</th>
                                            <th>FRANCISCO MORAZÁN</th>
                                            <th>GRACIAS A DIOS</th>
                                            <th>INTIBUCÁ</th>
                                            <th>ISLAS DE LA BAHÍA</th>
                                            <th>LA PAZ</th>
                                            <th>LEMPIRA</th>
                                            <th>OCOTEPEQUE</th>
                                            <th>OLANCHO</th>
                                            <th>SANTA BÁRBARA</th>
                                            <th>VALLE</th>
                                            <th>YORO</th>';
                            }
                            if ($col_B0 == 'grado' || $col_C0 == 'grado' || $col_D0 == 'grado' || $col_E0 == 'grado') {
                                echo '      <th>CCEPREB</th>
                                            <th>Pre-kinder</th>
                                            <th>Kinder</th>
                                            <th>Preparatoria</th>
                                            <th>Grado 1</th>
                                            <th>Grado 2</th>
                                            <th>Grado 3</th>
                                            <th>Grado 4</th>
                                            <th>Grado 5</th>
                                            <th>Grado 6</th>
                                            <th>Grado 7</th>
                                            <th>Grado 8</th>
                                            <th>Grado 9</th>
                                            <th>Grado 10</th>
                                            <th>Grado 11</th>
                                            <th>Grado 12</th>
                                            <th>Grado 13</th>  ';
                            }
                            if ($col_B0 == 'genero' || $col_C0 == 'genero' || $col_D0 == 'genero' || $col_E0 == 'genero') {
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
                        foreach ($data_reporte as $data) {
                            if (($contador % 2) == 0) {
                                echo '<tr BGCOLOR="#F1F5FA">';
                            } else {
                                echo '<tr BGCOLOR="#FFFFFF">';
                            }
                            echo '<th ALIGN="LEFT">' . ucfirst(htmlentities($data[$col_A0])) . '</th>';
                            if (!$col_B0_esDatoCalculo) {
                                echo '<th ALIGN="LEFT">' . ucfirst(htmlentities($data[$col_B0_etiquetaCampo])) . '</th>';
                            }
                            if (!$col_C0_esDatoCalculo) {
                                echo '<th ALIGN="LEFT">' . ucfirst(htmlentities($data[$col_C0_etiquetaCampo])) . '</th>';
                            }
                            if (!$col_D0_esDatoCalculo) {
                                echo '<th ALIGN="LEFT">' . ucfirst(htmlentities($data[$col_D0_etiquetaCampo])) . '</th>';
                            }
                            if ($col_B0 == 'administracion' || $col_C0 == 'administracion' || $col_D0 == 'administracion' || $col_E0 == 'administracion') {
                                echo '<td ALIGN="RIGHT">' . $data['total_publico'] . '</td>
                                            <td ALIGN="RIGHT">' . $data['total_privado'] . '</td>';
                            }
                            if ($col_B0 == 'zona' || $col_C0 == 'zona' || $col_D0 == 'zona' || $col_E0 == 'zona') {
                                echo '<td ALIGN="RIGHT">' . $data['total_rural'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_urbano'] . '</td>';
                            }
                            if ($col_B0 == 'departamento' || $col_C0 == 'departamento' || $col_D0 == 'departamento' || $col_E0 == 'departamento') {
                                echo '<td ALIGN="RIGHT">' . $data['total_atlantida'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_choluteca'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_colon'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_comayagua'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_copan'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_cortes'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_elparaiso'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_fcomorazan'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_grasadios'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_intibuca'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_islasbahia'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_lapaz'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_lempira'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_ocotepeque'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_olancho'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_sntabarbara'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_valle'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_yoro'] . '</td>';
                            }
                            if ($col_B0 == 'grado' || $col_C0 == 'grado' || $col_D0 == 'grado' || $col_E0 == 'grado') {
                                echo '<td ALIGN="RIGHT">' . $data['total_ccepreb'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_prekinder'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_kinder'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_preparatoria'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_gradoUno'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_gradoDos'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_gradoTres'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_gradoCuatro'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_gradoCinco'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_gradoSeis'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_gradoSiete'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_gradoOcho'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_gradoNueve'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_gradoDiez'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_gradoOnce'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_gradoDoce'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_gradoTrece'] . '</td>';
                            }
                            if ($col_B0 == 'genero' || $col_C0 == 'genero' || $col_D0 == 'genero' || $col_E0 == 'genero') {
                                echo '<td ALIGN="RIGHT">' . $data['total_femenino'] . '</td>
                                        <td ALIGN="RIGHT">' . $data['total_masculino'] . '</td>';
                            }
                            echo '<td ALIGN="RIGHT">' . $data['total_general'] . '</td>';
                            echo "</tr>";
                            $contador++;
                        }
                        ?>
                    </tbody>
                </table>                    
            </table>
        </body>
        </html>
        <?php
        include "phpIncluidos/simplyExportExcel.php";
    }
}
?>