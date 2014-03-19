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
        $indicador = selectIndicadorPorId(16);
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

        $reprobados_PromedioNacional = $DatosParametrizados_PromedioNacional['reprobados'];
        $totalMatricula_PromedioNacional = $DatosParametrizados_PromedioNacional['totalMatricula'];
        $abandonantes_PromedioNacional = $DatosParametrizados_PromedioNacional['abandonantes'];
        $valorIndicador_PromedioNacional = (( $reprobados_PromedioNacional + $abandonantes_PromedioNacional) / $totalMatricula_PromedioNacional) * 100;


        //calculo del datos para el año 
        $DatosParametrizados_anioBase = $DatosQuery['DatosAnioBase'];

        $reprobados_anioBase = $DatosParametrizados_anioBase['reprobados'];
        $totalMatricula_anioBase = $DatosParametrizados_anioBase['totalMatricula'];
        $abandonantes_anioBase = $DatosParametrizados_anioBase['abandonantes'];
        $valorIndicador_anioBase = (( $reprobados_anioBase + $abandonantes_anioBase) / $totalMatricula_anioBase) * 100;


        //agregando los valores de los calculos
        $indicador['PromedioNacional'] = number_format($valorIndicador_PromedioNacional, 2);
        $indicador['ValorBase'] = number_format($valorIndicador_anioBase, 2);

        if ($desagregacion === "0") {
            //calculo del indicador segun los detalles solicitados en la formula
            $DatosParametrizados = $DatosQuery['DatosParametrizados'];

            $reprobados = $DatosParametrizados['reprobados'];
            $totalMatricula = $DatosParametrizados['totalMatricula'];
            $abandonantes = $DatosParametrizados['abandonantes'];            
            $estudiantesEnRiesgos = $DatosParametrizados['enRiesgoEsc'];
            $aprobados = $DatosParametrizados['aprobados'];

            $valorIndicador = (( $reprobados + $abandonantes ) / $totalMatricula) * 100;
        } else {
           
            $DatosParametrizados = $DatosQuery['DatosParametrizados'];
            
            $reprobados_A = $DatosParametrizados['reprobados_A'];
            $totalMatricula_A = $DatosParametrizados['totalMatricula_A'];
            $abandonantes_A = $DatosParametrizados['abandonantes_A'];
            $estudiantesEnRiesgos_A = $DatosParametrizados['enRiesgoEsc_A'];
            $aprobados_A = $DatosParametrizados['aprobados_A'];
            
            
            $reprobados_B = $DatosParametrizados['reprobados_B'];
            $totalMatricula_B = $DatosParametrizados['totalMatricula_B'];
            $abandonantes_B = $DatosParametrizados['abandonantes_B'];
            $estudiantesEnRiesgos_B = $DatosParametrizados['enRiesgoEsc_B'];
            $aprobados_B = $DatosParametrizados['aprobados_B'];
            
            $valorIndicador_A = ( ($reprobados_A + $abandonantes_A) / $totalMatricula_A ) * 100;
            $valorIndicador_B = ( ($reprobados_B + $abandonantes_B) / $totalMatricula_B ) * 100;
            
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
                                            Datos de Cálculo
                                        </th>
                                        <th>
                                            Total Estudiantes
                                        </th>
                                        <th>
                                            Porcentaje
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr >
                                        <th>
                                            Matricula de 1° Ciclo(de 1° a 3°)
                                        </th>
                                        <td>  
                                            <?php echo $totalMatricula ?>
                                        </td>
                                        <td>  
                                            100%
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Aprobados
                                        </th>
                                        <td>
                                            <?php echo number_format($aprobados) ?>
                                        </td> 
                                        <td>  
                                            <?php echo number_format((($aprobados / $totalMatricula) * 100), 2) ?>%
                                        </td>
                                    </tr>                     
                                    <tr>
                                        <th>
                                            Reprobados
                                        </th>
                                        <td>
                                            <?php echo number_format($reprobados) ?>
                                        </td> 
                                        <td>  
                                            <?php echo number_format((($reprobados / $totalMatricula) * 100), 2) ?>%
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Abandonantes
                                        </th>
                                        <td>
                                            <?php echo number_format($abandonantes) ?>
                                        </td> 
                                        <td>  
                                            <?php echo number_format((($abandonantes / $totalMatricula) * 100), 2) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Estudiantes en Riesgo
                                        </th>
                                        <td>
                                            <?php echo number_format($estudiantesEnRiesgos) ?>
                                        </td> 
                                        <td>  
                                            <?php echo number_format((($estudiantesEnRiesgos / $totalMatricula) * 100), 2) ?>%
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
                                            Datos de Cálculo
                                        </th>
                                        <th>
                                            Total Estudiantes <?php echo htmlentities($etiqueta_A) ?>
                                        </th>
                                        <th>
                                            Porcentaje <?php echo htmlentities($etiqueta_A) ?>
                                        </th>
                                        <th>
                                            Total Estudiantes <?php echo htmlentities($etiqueta_B) ?>
                                        </th>
                                        <th>
                                            Porcentaje <?php echo htmlentities($etiqueta_B) ?>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr >
                                        <th>
                                            Matricula de 1° Ciclo(de 1° a 3°)
                                        </th>
                                        <td>  
                                            <?php echo $totalMatricula_A ?>
                                        </td>
                                        <td>  
                                            100%
                                        </td>
                                        <td>  
                                            <?php echo $totalMatricula_B ?>
                                        </td>
                                        <td>  
                                            100%
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Aprobados
                                        </th>
                                        <td>
                                            <?php echo number_format($aprobados_A) ?>
                                        </td> 
                                        <td>  
                                            <?php echo number_format((($aprobados_A / $totalMatricula_A) * 100), 2) ?>%
                                        </td>
                                        <td>
                                            <?php echo number_format($aprobados_B) ?>
                                        </td> 
                                        <td>  
                                            <?php echo number_format((($aprobados_B / $totalMatricula_B) * 100), 2) ?>%
                                        </td>
                                    </tr>                     
                                    <tr>
                                        <th>
                                            Reprobados
                                        </th>
                                        <td>
                                            <?php echo number_format($reprobados_A) ?>
                                        </td> 
                                        <td>  
                                            <?php echo number_format((($reprobados_A / $totalMatricula_A) * 100), 2) ?>%
                                        </td>
                                        <td>
                                            <?php echo number_format($reprobados_B) ?>
                                        </td> 
                                        <td>  
                                            <?php echo number_format((($reprobados_B / $totalMatricula_B) * 100), 2) ?>%
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Abandonantes
                                        </th>
                                        <td>
                                            <?php echo number_format($abandonantes_A) ?>
                                        </td> 
                                        <td>  
                                            <?php echo number_format((($abandonantes_A / $totalMatricula_A) * 100), 2) ?>
                                        </td>
                                        <td>
                                            <?php echo number_format($abandonantes_B) ?>
                                        </td> 
                                        <td>  
                                            <?php echo number_format((($abandonantes_B / $totalMatricula_B) * 100), 2) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Estudiantes en Riesgo
                                        </th>
                                        <td>
                                            <?php echo number_format($estudiantesEnRiesgos_A) ?>
                                        </td> 
                                        <td>  
                                            <?php echo number_format((($estudiantesEnRiesgos_A / $totalMatricula_A) * 100), 2) ?>%
                                        </td>
                                        <td>
                                            <?php echo number_format($estudiantesEnRiesgos_B) ?>
                                        </td> 
                                        <td>  
                                            <?php echo number_format((($estudiantesEnRiesgos_B / $totalMatricula_B) * 100), 2) ?>%
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
                        values: [ <?php echo $valorIndicador_anioBase ?>,<?php echo $valorIndicador ?>],
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
                        var colors = Highcharts.getOptions().colors,
                        categories = ['Estudiantes Aprobados', 'Estudiantes en Riesgo'],
                        name = '<?php echo utf8_encode($indicador["titulo"]) ?>',
                        <?php if ($desagregacion === '0') { ?> 
                        data = [{
                                y: <?php echo $aprobados ?>,
                                color: colors[0],
                                drilldown: {
                                    name: 'Estudiantes Aprobados',
                                    categories: ['Aprobados'],
                                    data: [<?php echo $aprobados ?>],
                                    color: colors[0]
                                }
                            }, {
                                y: <?php echo $estudiantesEnRiesgos ?>,
                                color: colors[1],
                                drilldown: {
                                    name: 'Estudiantes en Riesgo',
                                    categories: ['Reprobados', 'Abandonates'],
                                    data: [<?php echo $reprobados ?>, <?php echo $abandonantes ?>],
                                    color: colors[1]
                                }                                
                            }];
                        <?php }else{ ?>
                            data_A = [{
                                y: <?php echo $aprobados_A ?>,
                                color: colors[0],
                                drilldown: {
                                    name: 'Aprobados <?php echo $etiqueta_A ?>',
                                    categories: ['APB <?php echo $etiqueta_A ?>'],
                                    data_A: [<?php echo $aprobados_A ?>],
                                    color: colors[0]
                                }
                            }, {
                                y: <?php echo $estudiantesEnRiesgos_A ?>,
                                color: colors[1],
                                drilldown: {
                                    name: 'Estudiantes en Riesgo <?php echo $etiqueta_A ?>',
                                    categories: ['RPB <?php echo $etiqueta_A ?>', 'Aband. <?php echo $etiqueta_A ?>'],
                                    data_A: [<?php echo $reprobados_A ?>, <?php echo $abandonantes_A ?>],
                                    color: colors[1]
                                }                                
                            }];
                            data_B = [{
                                y: <?php echo $aprobados_B ?>,
                                color: colors[2],
                                drilldown: {
                                    name: 'Aprobados <?php echo $etiqueta_B ?>',
                                    categories: ['APB <?php echo $etiqueta_B ?>'],
                                    data_B: [<?php echo $aprobados_B ?>],
                                    color: colors[2]
                                }
                            }, {
                                y: <?php echo $estudiantesEnRiesgos_B ?>,
                                color: colors[3],
                                drilldown: {
                                    name: 'Estudiantes en Riesgo <?php echo $etiqueta_B ?>',
                                    categories: ['RPB <?php echo $etiqueta_B ?>', 'Aband. <?php echo $etiqueta_B ?>'],
                                    data_B: [<?php echo $reprobados_B ?>, <?php echo $abandonantes_B ?>],
                                    color: colors[3]
                                }                                
                            }];
                        <?php } ?>
                        // Build the data arrays
                        <?php if ($desagregacion === '0') { ?>
                            var totalAlumnos = [];
                            var totalAlumnosGranulado = [];
                            for (var i = 0; i < data.length; i++) {

                                // add browser data
                                totalAlumnos.push({
                                    name: categories[i],
                                    y: data[i].y,
                                    color: data[i].color
                                });

                                // add version data
                                for (var j = 0; j < data[i].drilldown.data.length; j++) {
                                    var brightness = 0.2 - (j / data[i].drilldown.data.length) / 5 ;
                                    totalAlumnosGranulado.push({
                                        name: data[i].drilldown.categories[j],
                                        y: data[i].drilldown.data[j],
                                        color: Highcharts.Color(data[i].color).brighten(brightness).get()
                                    });
                                }
                            }
                        <?php }else{ ?>
                            var totalAlumnos_A = [];
                            var totalAlumnosGranulado_A = [];
                            for (var i = 0; i < data_A.length; i++) {

                                // add browser data
                                totalAlumnos_A.push({
                                    name: categories[i],
                                    y: data_A[i].y,
                                    color: data_A[i].color
                                });

                                // add version data
                                for (var j = 0; j < data_A[i].drilldown.data_A.length; j++) {
                                    var brightness = 0.2 - (j / data_A[i].drilldown.data_A.length) / 5 ;
                                    totalAlumnosGranulado_A.push({
                                        name: data_A[i].drilldown.categories[j],
                                        y: data_A[i].drilldown.data_A[j],
                                        color: Highcharts.Color(data_A[i].color).brighten(brightness).get()
                                    });
                                }
                            }
                            var totalAlumnos_B = [];
                            var totalAlumnosGranulado_B = [];
                            for (var i = 0; i < data_B.length; i++) {

                                // add browser data
                                totalAlumnos_B.push({
                                    name: categories[i],
                                    y: data_B[i].y,
                                    color: data_B[i].color
                                });

                                // add version data
                                for (var j = 0; j < data_B[i].drilldown.data_B.length; j++) {
                                    var brightness = 0.2 - (j / data_B[i].drilldown.data_B.length) / 5 ;
                                    totalAlumnosGranulado_B.push({
                                        name: data_B[i].drilldown.categories[j],
                                        y: data_B[i].drilldown.data_B[j],
                                        color: Highcharts.Color(data_B[i].color).brighten(brightness).get()
                                    });
                                }
                            }
                        <?php } ?>
                        
                        chart = new Highcharts.Chart({
                            chart: {
                                renderTo: 'contenedorGraficas-<?php echo $indicador['codigo_indicador']; ?>',
                                type: 'pie'
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
                                filename: '<?php echo str_replace(" ", "_", utf8_encode($indicador['titulo'])) ?>'
                            },
                            legend: {
                                layout: 'vertical',
                                backgroundColor: '#FFFFFF',
                                align: 'left',
                                verticalAlign: 'top',
                                x: 100,
                                y: 70,
                                floating: true,
                                shadow: true
                            },
                            tooltip: {
                                valueSuffix: ''
                            },
                            plotOptions: {
                                pie: {
                                    shadow: false
                                }
                            },
                           <?php if ($desagregacion === '0') { ?> 
                            series: [{
                                    name: 'Cantidad de alumnos',
                                    data: totalAlumnos,
                                    size: '60%',
                                    dataLabels: {
                                        formatter: function() {
                                            return this.y > 5 ? this.point.name + ':<br/>' + FormatoComas(this.y) + ' (' + ((this.y/<?php echo $totalMatricula ?>)*100).toFixed(2) + '%)' : null;
                                        },
                                        color: 'black',
                                        distance: -30
                                    }
                                }, {
                                    name: 'Cantidad de alumnos',
                                    data: totalAlumnosGranulado,
                                    innerSize: '60%',
                                    dataLabels: {
                                        formatter: function() {
                                            // display only if larger than 1
                                            return this.y > 1 ? '<b>'+ this.point.name +':</b> ' +  FormatoComas(this.y) + ' (' + ((this.y/<?php echo $totalMatricula ?>)*100).toFixed(2) + '%)'  : null;
                                        }
                                    }
                                }]
                            <?php }else{ ?>
                            series: [{
                                    name: 'Cantidad de alumnos <?php echo $reprobados_A ?>',
                                    data: totalAlumnos_A,
                                    size: '60%',
                                    center:['35%','50%'],
                                    dataLabels: {
                                        formatter: function() {
                                            return this.y > 5 ? this.point.name + ':<br/>' + FormatoComas(this.y) + ' (' + ((this.y/<?php echo $totalMatricula_A ?>)*100).toFixed(2) + '%)' : null;
                                        },
                                        color: 'black',
                                        distance: -30
                                    }
                                }, {
                                    name: 'Cantidad de alumnos <?php echo $reprobados_A ?>',
                                    data: totalAlumnosGranulado_A,
                                    innerSize: '60%',
                                    center:['35%','50%'],
                                    dataLabels: {
                                        formatter: function() {
                                            // display only if larger than 1
                                            return this.y > 1 ? '<b>'+ this.point.name +':</b> ' +  FormatoComas(this.y) + ' (' + ((this.y/<?php echo $totalMatricula_A ?>)*100).toFixed(2) + '%)'  : null;
                                        }
                                    }
                                },
                                {
                                    name: 'Cantidad de alumnos <?php echo $reprobados_B ?>',
                                    data: totalAlumnos_B,
                                    size: '60%',
                                    center:['70%','50%'],
                                    dataLabels: {
                                        formatter: function() {
                                            return this.y > 5 ? this.point.name + ':<br/>' + FormatoComas(this.y) + ' (' + ((this.y/<?php echo $totalMatricula_B ?>)*100).toFixed(2) + '%)' : null;
                                        },
                                        color: 'black',
                                        distance: -30
                                    }
                                }, {
                                    name: 'Cantidad de alumnos <?php echo $reprobados_B ?>',
                                    data: totalAlumnosGranulado_B,
                                    innerSize: '60%',
                                    center:['70%','50%'],
                                    dataLabels: {
                                        formatter: function() {
                                            // display only if larger than 1
                                            return this.y > 1 ? '<b>'+ this.point.name +':</b> ' +  FormatoComas(this.y) + ' (' + ((this.y/<?php echo $totalMatricula_B ?>)*100).toFixed(2) + '%)'  : null;
                                        }
                                    }
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
