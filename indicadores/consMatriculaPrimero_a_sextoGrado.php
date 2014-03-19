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
        $indicador = selectIndicadorPorId(12);
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
        $PrimerGrado_PromedioNacional = $DatosParametrizados_PromedioNacional['primerGrado']; //cambiar nombre de variable primer grado
        $SextoGrado_PromedioNacional = $DatosParametrizados_PromedioNacional['sextoGrado'];//cambiar nombre de variable sexto grado
        
        $valorIndicador_PromedioNacional = ($SextoGrado_PromedioNacional / $PrimerGrado_PromedioNacional) * 100;


        //calculo del datos para el año 
        $DatosParametrizados_anioBase = $DatosQuery['DatosAnioBase'];
        $PrimerGrado_anioBase = $DatosParametrizados_anioBase['primerGrado'];
        $SextoGrado_anioBase = $DatosParametrizados_anioBase['sextoGrado'];

        $valorIndicador_anioBase = ($SextoGrado_anioBase / $PrimerGrado_anioBase) * 100;


        //agregando los valores de los calculos
        $indicador['PromedioNacional'] = number_format($valorIndicador_PromedioNacional,2);
        $indicador['ValorBase'] = number_format($valorIndicador_anioBase,2);

        if ($desagregacion === "0") {
            //calculo del indicador segun los detalles solicitados en la formula
            $DatosParametrizados = $DatosQuery['DatosParametrizados'];
            $PrimerGrado = $DatosParametrizados['primerGrado'];
            $SextoGrado = $DatosParametrizados['sextoGrado'];

            $valorIndicador = ($SextoGrado / $PrimerGrado) * 100;
        } else {
            $DatosParametrizados = $DatosQuery['DatosParametrizados'];
            $PrimerGrado_A = $DatosParametrizados['primerGrado_A'];
            $SextoGrado_A = $DatosParametrizados['sextoGrado_A'];
            $PrimerGrado_B = $DatosParametrizados['primerGrado_B'];
            $SextoGrado_B = $DatosParametrizados['sextoGrado_B'];

            $valorIndicador_A = ($SextoGrado_A / $PrimerGrado_A) * 100;
            $valorIndicador_B = ($SextoGrado_B / $PrimerGrado_B) * 100;
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
                                    <tr >
                                        <th>
                                            Estudiantes de 1° Grado
                                        </th>
                                        <td>  
                                             <?php echo number_format($PrimerGrado, 0) ?>
                                        </td> 
                                    </tr>
                                    <tr>
                                        <th>
                                            Estudiantes de 6° Grado 
                                        </th>
                                        <td>
                                           <?php echo number_format($SextoGrado, 0) ?>
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
                                            Estudiantes de 1° Grado
                                        </th>
                                        <td>  
                                            <?php echo number_format($PrimerGrado_A, 0) ?>
                                        </td> 
                                        <td>  
                                            <?php echo number_format($PrimerGrado_B, 0) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Estudiantes de 6° Grado
                                        </th>
                                        <td>
                                            <?php echo number_format($SextoGrado_A, 0) ?>
                                        </td>
                                        <td>
                                            <?php echo number_format($SextoGrado_B, 0) ?>
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
                                filename: '<?php echo str_replace(" ", "_", utf8_encode($indicador['titulo'])) ?>'
                            },
                            xAxis: {
                                categories: ['Matricula 1° Grado', 'Matricula 6° Grado']
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: 'Cantidad de alumno (k=mil) '
                                }
                            },
                            tooltip: {
                                 formatter: function() {
                                    return '<b>'+ this.series.name + '</b><br/>'+
                                         this.x +': '+ FormatoComas(this.y);
                                }
                            },
                            plotOptions: {
                                column: {
                                        dataLabels: {
                                            enabled: true,
                                            formatter : function() {
                                                    return this.x + ': ' + FormatoComas(this.y);
                                            },
                                            color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black'
                                        }
                                    }
                            },
                            <?php if ($desagregacion === '0') { ?>
                            series: [{
                                        name: '<?php echo utf8_encode($indicador['titulo']) ?>',
                                        data: [<?php echo $PrimerGrado ?>,<?php echo $SextoGrado ?>],
                                        type : 'column'
                                        
                                    }
                                ]
                            <?php }else{ ?>
                            series: [{
                                        name: 'CMG <?php echo utf8_encode($etiqueta_A) ?>',
                                        data: [<?php echo $PrimerGrado_A ?>,<?php echo $SextoGrado_A ?>]
                                        
                                    },
                                    {
                                        name: 'CMG <?php echo utf8_encode($etiqueta_B) ?>',
                                        data: [<?php echo $PrimerGrado_B ?>,<?php echo $SextoGrado_B ?>]
                                        
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