<?php
include '../phpIncluidos/RenderizadorDeIndicador.php';

if (ISSET($_POST['anio']) && ISSET($_POST['departamento']) && ISSET($_POST['municipio']) && ISSET($_POST['centro']) && ISSET($_POST['desagregacion'])) {
    $anio = $_POST['anio'];
    $departamento = $_POST['departamento'];
    $municipio = $_POST['municipio'];
    $centro = $_POST['centro'];
    $desagregacion = $_POST['desagregacion'];

    $ParametrosQuery = Array(
        "anio" => $anio,
        "departamento" => $departamento,
        "municipio" => $municipio,
        "centro" => $centro,
        "desagregacion" => $desagregacion
    );
    $DatosQuery = array();
    if (is_numeric($anio) && ctype_digit($anio) && is_numeric($departamento) && ctype_digit($departamento) && is_numeric($municipio) && ctype_digit($municipio) && is_numeric($centro) && ctype_digit($centro) && is_numeric($desagregacion) && ctype_digit($desagregacion)) {
        $indicador = selectIndicadorPorId(8);
        $DatosQuery = totales_valorIndicador($ParametrosQuery, $indicador);
        
        /**
         *Calculo del indicador 
         */
        //calculo del dato para el promedio nacional       
        $DatosParametrizados_PromedioNacional = $DatosQuery['DatosPerfilGeneral'];
        $PoblacionEstimada_PromedioNacional = $DatosParametrizados_PromedioNacional['estimacion'];
        $totalAlumnos_PromedioNacional = $DatosParametrizados_PromedioNacional['totalCincoAnios'];
        $PoblacionEstimada_PromedioNacional = ($PoblacionEstimada_PromedioNacional < $totalAlumnos_PromedioNacional) ? $totalAlumnos_PromedioNacional : $PoblacionEstimada_PromedioNacional;
        $valorIndicador_PromedioNacional = ($totalAlumnos_PromedioNacional  / $PoblacionEstimada_PromedioNacional) * 100;

        //calculo del datos para el año 
        $DatosParametrizados_anioBase = $DatosQuery['DatosAnioBase'];
        $PoblacionEstimada_anioBase = $DatosParametrizados_anioBase['estimacion'];
        $totalAlumnos_anioBase = $DatosParametrizados_anioBase['totalCincoAnios'];
        $PoblacionEstimada_anioBase = ($PoblacionEstimada_anioBase < $totalAlumnos_anioBase) ? $totalAlumnos_anioBase : $PoblacionEstimada_anioBase;
        $valorIndicador_anioBase = ($totalAlumnos_anioBase  / $PoblacionEstimada_anioBase) * 100;       

        //agregando los valor
        $indicador['PromedioNacional'] = number_format($valorIndicador_PromedioNacional, 2);
        $indicador['ValorBase'] = number_format($valorIndicador_anioBase, 2);
        
        if($desagregacion === '0'){
            //calculos para el indicador sin desagregaciones mas que, los filtros
            //calculo del indicador segun los detalles solicitados en la formula
            $DatosParametrizados = $DatosQuery['DatosParametrizados'];        
            $PoblacionEstimada = $DatosParametrizados['estimacion'];
            $totalAlumnos = $DatosParametrizados['totalCincoAnios'];
            $PoblacionEstimada = ($PoblacionEstimada < $totalAlumnos) ? $totalAlumnos : $PoblacionEstimada;
            $valorIndicador = ($totalAlumnos / $PoblacionEstimada) * 100;
            
        }else{
            //calculo para el indicador con desagregaciones.
            //calculo del indicador segun los detalles solicitados en la formula
            $DatosParametrizados = $DatosQuery['DatosParametrizados'];        
            $PoblacionEstimada_A = $DatosParametrizados['estimacion_A'];
            $totalAlumnos_A = $DatosParametrizados['totalCincoAnios_A'];
            $PoblacionEstimada_B = $DatosParametrizados['estimacion_B'];
            $totalAlumnos_B = $DatosParametrizados['totalCincoAnios_B'];
            $PoblacionEstimada_A = ($PoblacionEstimada_A < $totalAlumnos_A) ? $totalAlumnos_A : $PoblacionEstimada_A;
            $PoblacionEstimada_B = ($PoblacionEstimada_B < $totalAlumnos_B) ? $totalAlumnos_B : $PoblacionEstimada_B;
            $valorIndicador_A = ($totalAlumnos_A / $PoblacionEstimada_A) * 100;
            $valorIndicador_B = ($totalAlumnos_B / $PoblacionEstimada_B) * 100;
            
            $valorIndicador = ($valorIndicador_A + $valorIndicador_B) / 2;
            
            
            $etiqueta_A = $DatosParametrizados['etiqueta_A'];
            $etiqueta_B = $DatosParametrizados['etiqueta_B'];
        }
    ?>

        <div id="contenedorIndicador-<?php echo $indicador['codigo_indicador']; ?>" class="contenedorGlobalDeIndicadores">
            <div id="<?php echo $indicador['codigo_indicador']; ?>" class="indicadorEnContenido">
                <?php
                
                echo renderizarIndicador($indicador);
                ?>


                <div id="<?php echo $indicador['codigo_indicador'] . "-tablaDatos"; ?>" class="informacionIndicadores">
                    <div class="titulo">Tabla de Datos :
                        <div name="EsconderInformacionIndicador" class="esconderDatos">
                            <img src="recursos/iconos/eraser.png">
                        </div>
                    </div>
                    <div class="descripcion" style="display:block;">
                        <table id="<?php echo $indicador['codigo_indicador'] . "-tablaDatosIndicador"; ?>" class="TablaDatosSiee" name="indDataTables" cellspacing="0" cellpadding="0">
                            <?php
                            //SI NO SE APLICAN LAS DESAGREGACIONES SE MUESTRA ESTA TABLA
                            if ($desagregacion === '0') {
                                ?>
                                <thead>
                                    <tr>                
                                        <th>
                                            Descripción
                                        </th>
                                        <th>
                                            Valores
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>
                                            Población mínima estimada
                                        </th>
                                        <td>  
                                            <?php echo number_format($PoblacionEstimada, 0) ?>
                                        </td> 
                                    </tr>
                                    <tr>
                                        <th>
                                            Total de estudiantes
                                        </th>
                                        <td>
                                            <?php echo number_format($totalAlumnos, 0) ?>
                                        </td> 
                                    </tr>  
                                    <tr>
                                        <th>
                                           <?php echo htmlentities($indicador['titulo']) ?>
                                        </th>
                                        <td>  
                                            <?php echo number_format( $valorIndicador, 2) ?> %
                                        </td> 
                                    </tr>
                                </tbody>

                                <?php
                            } else {
                                //SI SE APLICAN DESAGREGACIONES, SACAMOS LA TABLA CON LOS CAMPOS
                                ?>
                                <thead>
                                    <tr>                
                                        <th>
                                            Descripción
                                        </th>                            
                                        <th>
                                            Valor <?php echo htmlentities($etiqueta_A) ?>
                                        </th>
                                        <th>
                                            Valor <?php echo htmlentities($etiqueta_B) ?>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <th>
                                            Población minima estimada
                                        </th>
                                        <td>  
                                            <?php echo number_format($PoblacionEstimada_A, 0) ?>
                                        </td> 
                                        <td>  
                                            <?php echo number_format($PoblacionEstimada_B, 0) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Total de estudiantes
                                        </th>
                                        <td>
                                            <?php echo number_format($totalAlumnos_A, 0) ?>
                                        </td>
                                        <td>
                                            <?php echo number_format($totalAlumnos_B, 0) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <?php echo htmlentities($indicador['titulo']) ?>
                                        </th>
                                        <td>  
                                            <?php echo number_format( $valorIndicador_A, 2) ?> %
                                        </td>
                                        <td>  
                                            <?php echo number_format( $valorIndicador_B, 2) ?> %
                                        </td> 
                                    </tr>
                                </tbody>
                                <?php
                            }
                            ?> 
                            <tfoot>
                                <tr>
                                    <td colspan="0">                            
                                        <div>
                                            <div id="tableDownload">
                                                <input id="<?php echo $indicador['codigo_indicador'] ?>_btnDescargarExcel" title="Haga clic aqui para exportar los datos a Excel" grav="se" name="botonesTablas" class="downloadTableViewEnabled" type="button" onclick="descargarTablaIndicador('<?php echo $indicador['id']; ?>')"  />
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div id="ContainerPanelDeComentarios_<?php echo $indicador['id']; ?>" class="informacionIndicadores">
                </div>  
            </div>

            <script type="text/javascript">
                //funcion para ver como se aleja este indicador en base al año base
                $(function() {
                    $("#EstadoIndicador-<?php echo $indicador['codigo_indicador']; ?>").slider({
                        range: true,
                        disabled: true,
                        min: 0,
                        max: 100,
                        values: [ <?php echo $valorIndicador_anioBase?>,  <?php echo $valorIndicador?>],
                        slide: function( event, ui ) {
                            $( "#valorAnioBase-<?php echo $indicador['codigo_indicador']; ?>").text( ui.values[ 0 ] + "%" );
                            $( "#valorAnioActual-<?php echo $indicador['codigo_indicador']; ?>").text( ui.values[ 1 ] + "%" );
                        }
                    });
                    $( "#valorAnioBase-<?php echo $indicador['codigo_indicador']; ?>").text( $( "#EstadoIndicador-<?php echo $indicador['codigo_indicador']; ?>" ).slider( "values", 0 ) + "%" );
                    $( "#valorAnioActual-<?php echo $indicador['codigo_indicador']; ?>").text( $( "#EstadoIndicador-<?php echo $indicador['codigo_indicador']; ?>" ).slider( "values", 1 ) + "%" );
                });
                $(function () {
                    var chart;
                    $(document).ready(function() {
                        chart = new Highcharts.Chart({
                            chart: {
                                renderTo: 'contenedorGraficas-<?php echo $indicador['codigo_indicador']; ?>',
                                type: 'column'
                            },
                            title: {
                                text: '<?php echo utf8_encode($indicador['titulo']) ?>'
                            },
                            subtitle: {
                                text: "Universo: " + $('#etiquetaDataMuniGlobal').attr('etiqueta-grafico') + " " + $('#etiquetaDataDeptoGlobal').attr('etiqueta-grafico') + ", Año " + $('#etiquetaDataAnioGlobal').text()
                            },
                            credits: {
                                enabled: false
                            },
                            exporting: {
                                filename: '<?php echo str_replace(" ", "_", $indicador['titulo']) ?>'
                            },
                            xAxis: {
                                categories: ['<?php echo utf8_encode($indicador['titulo']) ?>']
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: 'Porcentaje de alumno'
                                }
                            },
                            tooltip: {
                                 formatter: function() {
                                    return '<b>'+ this.x + '</b><br/>'+
                                        this.series.name +': '+ FormatoComas(this.y) + ' (' + this.percentage.toFixed(2) + '%)<br/>'+
                                        'Población estimada: '+ FormatoComas(this.point.stackTotal);
                                }
                            },
                            plotOptions: {
                                column: {
                                        stacking: 'percent',
                                        dataLabels: {
                                            enabled: true,
                                            formatter : function() {
                                                    return this.series.name + ': ' + this.percentage.toFixed(2) + '%';
                                            },
                                            color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                                        }
                                    }
                            },
                            <?php if ($desagregacion === '0') { ?>
                            series: [{
                                        name: 'Cobertura neta estimada',
                                        data: [<?php echo $totalAlumnos ?>]
                                    },
                                    {
                                        name: 'Cobertura estimada pendiente',
                                        data: [<?php echo ($PoblacionEstimada - $totalAlumnos) ?>]
                                    }
                                ]
                            <?php }else{ ?>
                            series: [{
                                        name: 'CNE <?php echo utf8_encode($etiqueta_A)  ?>',
                                        data: [<?php echo $totalAlumnos_A ?>],
                                        stack : '<?php echo utf8_encode($etiqueta_A)  ?>'
                                    },
                                    {
                                        name: 'CEP <?php echo utf8_encode($etiqueta_A)  ?>',
                                        data: [<?php echo ($PoblacionEstimada_A - $totalAlumnos_A) ?>],
                                        stack : '<?php echo utf8_encode($etiqueta_A)  ?>'
                                    },
                                    {
                                        name: 'CNE <?php echo utf8_encode($etiqueta_B)  ?>',
                                        data: [<?php echo $totalAlumnos_B ?>],
                                        stack : '<?php echo utf8_encode($etiqueta_B)  ?>'
                                    },
                                    {
                                        name: 'CEP <?php echo utf8_encode($etiqueta_B)  ?>',
                                        data: [<?php echo ($PoblacionEstimada_B - $totalAlumnos_B) ?>],
                                        stack : '<?php echo utf8_encode($etiqueta_B)  ?>'
                                    }
                                ]
                            <?php } ?>
                        });
                    });

                });
            </script>
            <br/>
        </div>

        <?php
    } else {
        echo 'Error: Uno o mas de los datos enviados tiene formato invalido.';
    }
} else {
    echo 'Error: Falta uno o mas datos para completar la solicitud.';
}
?>