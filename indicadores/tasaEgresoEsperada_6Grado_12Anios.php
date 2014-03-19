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
        $indicador = selectIndicadorPorId(56);
        $DatosQuery = totales_valorIndicador($ParametrosQuery, $indicador);
        /**
         * En las siguientes lineas se haran los calculos del indicador
         * segun las especificaciones de la formula, para esto se deben realizar 3
         * veces el mismo calculo, los cuales son para:
         * el dato segun la seleccion del usuarios, el dato para el año base y el dato
         * para el promedio nacional del indicador.
         * */
        //calculo del dato para el promedio nacional       
        $DatosParametrizados_PromedioNacional = $DatosQuery['DatosPerfilGeneral'];
        $repitente_PromedioNacional = $DatosParametrizados_PromedioNacional['total_repitentes'];
        $matricula_PromedioNacional = $DatosParametrizados_PromedioNacional['E_12'];
        $poblacion_PromedioNacional = $DatosParametrizados_PromedioNacional['E_12p'];

        $valorIndicador_PromedioNacional = (( $matricula_PromedioNacional - $repitente_PromedioNacional) / $poblacion_PromedioNacional ) * 100;

        //calculo del datos para el año 
        $DatosParametrizados_anioBase = $DatosQuery['DatosAnioBase'];
        $repitente_anioBase = $DatosParametrizados_anioBase['total_repitentes'];
        $matricula_anioBase = $DatosParametrizados_anioBase['E_12'];
        $poblacion_anioBase = $DatosParametrizados_anioBase['E_12p'];

        $valorIndicador_anioBase = (( $matricula_anioBase - $repitente_anioBase ) / $poblacion_anioBase) * 100;


        //agregando los valores de los calculos
        $indicador['PromedioNacional'] = number_format($valorIndicador_PromedioNacional, 2);
        $indicador['ValorBase'] = number_format($valorIndicador_anioBase, 2);

        if ($desagregacion === "0") {
            //calculo del indicador segun los detalles solicitados en la formula
            $DatosParametrizados = $DatosQuery['DatosParametrizados'];
            $repitente = $DatosParametrizados['total_repitentes'];
            $matricula = $DatosParametrizados['E_12'];
            $poblacion = $DatosParametrizados['E_12p'];

            $valorIndicador = (( $matricula - $repitente) / $poblacion ) * 100;
        } else {
            $DatosParametrizados = $DatosQuery['DatosParametrizados'];
            $repitente_A = $DatosParametrizados['total_repitentes_A'];
            $matricula_A = $DatosParametrizados['E_12_A'];
            $poblacion_A = $DatosParametrizados['E_12p_A'];
            $repitente_B = $DatosParametrizados['total_repitentes_B'];
            $matricula_B = $DatosParametrizados['E_12_B'];
            $poblacion_B = $DatosParametrizados['E_12p_B'];

            $valorIndicador_A = (( $matricula_A - $repitente_A) / $poblacion_A ) * 100;
            $valorIndicador_B = (( $matricula_B - $repitente_B) / $poblacion_B) * 100;

            $valorIndicador = ($valorIndicador_A + $valorIndicador_B) / 2;


            $etiqueta_A = $DatosParametrizados["etiqueta_A"];
            $etiqueta_B = $DatosParametrizados["etiqueta_B"];
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
                    <div class="descripcion">
                        <table id="<?php echo $indicador['codigo_indicador'] . "-tablaDatosIndicador"; ?>" class="TablaDatosSiee" name="indDataTables" cellspacing="0" cellpadding="0">
                            <?php
                            //SI NO SE APLICAN LAS DESAGREGACIONES SE MUESTRA ESTA TABLA
                            if ($desagregacion === "0") {
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
                                            Matricula Inicial 12 Años
                                        </th>
                                        <td>
                                            <?php echo number_format($matricula, 0) ?>
                                        </td> 
                                    </tr> 
                                    <tr>
                                        <th>
                                            Repitente
                                        </th>
                                        <td>  
                                            <?php echo number_format($repitente, 0) ?>
                                        </td> 
                                    </tr>
                                    <tr>
                                        <th>
                                            Población Estimada 12 Años
                                        </th>
                                        <td>  
                                            <?php echo number_format($poblacion, 0) ?>
                                        </td> 
                                    </tr>
                                    <tr>
                                        <th>
                                            <?php echo htmlentities($indicador['titulo']) ?>
                                        </th>
                                        <td>  
                                            <?php echo number_format($valorIndicador, 2) ?> %
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
                                            Matricula Inicial 12 Años
                                        </th>
                                        <td>
                                            <?php echo number_format($matricula_A, 0) ?>
                                        </td>
                                        <td>
                                            <?php echo number_format($matricula_B, 0) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Repitente
                                        </th>
                                        <td>  
                                            <?php echo number_format($repitente_A, 0) ?>
                                        </td> 
                                        <td>  
                                            <?php echo number_format($repitente_B, 0) ?>
                                        </td>
                                    </tr>
                                     <tr>
                                        <th>
                                            Población Estimada 12 Años
                                        </th>
                                        <td>  
                                            <?php echo number_format($poblacion_A, 0) ?>
                                        </td> 
                                        <td>  
                                            <?php echo number_format($poblacion_B, 0) ?>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <th>
                                            <?php echo htmlentities($indicador['titulo']) ?>
                                        </th>
                                        <td>  
                                            <?php echo number_format($valorIndicador_A, 2) ?> %
                                        </td>
                                        <td>  
                                            <?php echo number_format($valorIndicador_B, 2) ?> %
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
                                            <button id="<?php echo $indicador['codigo_indicador'] ?>_btnDescargarExcel" title="Haga clic aqui para exportar los datos a Excel" grav="se" name="botonesTablas" onclick="descargarTablaIndicador('<?php echo $indicador['codigo_indicador'] ?>; ?>')">Exportar datos a Excel</button>
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
                        values: [ <?php echo $valorIndicador_anioBase ?>,  <?php echo $valorIndicador ?>],
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
                                renderTo: 'contenedorGraficas-<?php echo $indicador['codigo_indicador']; ?>'
                                                
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
                            tooltip: {
                                    //pointFormat: '{series.name} <br/><b>porcentual:</b>{point.percentage}%<br/><b>absoluto:</b>{point.y}',
                                    pointFormat: '{series.name} <b>{point.percentage}%</b>',
                                    percentageDecimals: 2
                            },
                            plotOptions: {
                                pie: {
                                    allowPointSelect: true,
                                    cursor: 'pointer',
                                    showInLegend:true,
                                    dataLabels: {
                                        enabled: true,
                                        color: '#000000',
                                        connectorColor: '#000000',
                                        formatter: function() {
                                            return '<b>' + this.percentage.toFixed(2) +' %</b> ';
                                        }
                                    }
                                }  
                            },
                             <?php if ($desagregacion === '0') { ?>
                            series: [{
                                    type: 'pie',
                                    name: '<?php echo utf8_encode($indicador['titulo']) ?>',
                                    data: [
                                        ['Egreso Esperada',   <?php echo $matricula - $repitente ?>],
                                        ['No Egresado',   <?php echo $poblacion - ($matricula - $repitente) ?>],
                                       
                                        
                                    ]
                                }]
                            <?php }else{ ?>
                                 series: [{
                                    type: 'pie',
                                    name: '<?php echo utf8_encode($indicador['titulo']) ?>',
                                    data: [
                                        ['Egreso Esperada <?php echo $etiqueta_A?>',   <?php echo $matricula_A - $repitente_A ?>],
                                        ['No Egresado <?php echo $etiqueta_A?>',   <?php echo $poblacion_A - ($matricula_A - $repitente_A) ?>]
                                        
                                        
                                    ],
                                    center:['25%','50%'],
                                    size:200
                                },{
                                    type: 'pie',
                                    name: '<?php echo utf8_encode($indicador['titulo']) ?>',
                                    data: [
                                        ['Egreso Esperada <?php echo $etiqueta_B?>',   <?php echo $matricula_B - $repitente_B ?>],
                                        ['No Egresado <?php echo $etiqueta_B?>',   <?php echo $poblacion_B - ($matricula_B - $repitente_B) ?>]
                                        
                                        
                                    ],
                                    center:['70%','50%'],
                                    size:200
                                }]


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