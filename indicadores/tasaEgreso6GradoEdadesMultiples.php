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
        $indicador = selectIndicadorPorId(66);
        $DatosQuery = totales_valorIndicador($ParametrosQuery, $indicador);
        
        /**
         *Calculo del indicador 
         */
        //calculo del dato para el promedio nacional       
        $DatosParametrizados_PromedioNacional = $DatosQuery['DatosPerfilGeneral'];
        $egresado_PromedioNacional = $DatosParametrizados_PromedioNacional['egresados'];
        $poblacion_estimada_PromedioNacional = $DatosParametrizados_PromedioNacional['poblacion_estimada'];
      
        $valorIndicador_PromedioNacional = (  $egresado_PromedioNacional / $poblacion_estimada_PromedioNacional) * 100;

        //calculo del datos para el año 
        $DatosParametrizados_anioBase = $DatosQuery['DatosAnioBase'];
        $egresado_anioBase = $DatosParametrizados_anioBase['egresados'];
        $poblacion_estimada_anioBase = $DatosParametrizados_anioBase['poblacion_estimada'];
      
        $valorIndicador_anioBase = (   $egresado_anioBase / $poblacion_estimada_anioBase) * 100;       

        //agregando los valor
        $indicador['PromedioNacional'] = number_format($valorIndicador_PromedioNacional, 2);
        $indicador['ValorBase'] = number_format($valorIndicador_anioBase, 2);
        
        if($desagregacion === '0'){
            //calculos para el indicador sin desagregaciones mas que, los filtros
            //calculo del indicador segun los detalles solicitados en la formula
            $DatosParametrizados = $DatosQuery['DatosParametrizados'];        
            $egresado = $DatosParametrizados['egresados'];
            $poblacion_estimada = $DatosParametrizados['poblacion_estimada'];
           
            $valorIndicador = (  $egresado / $poblacion_estimada) * 100;
            
        }else{
            //calculo para el indicador con desagregaciones.
            //calculo del indicador segun los detalles solicitados en la formula
            $DatosParametrizados = $DatosQuery['DatosParametrizados'];        
            $egresado_A = $DatosParametrizados['egresados_A'];
            $poblacion_estimada_A = $DatosParametrizados['poblacion_estimada_A'];
            $egresado_B = $DatosParametrizados['egresados_B'];
            $poblacion_estimada_B = $DatosParametrizados['poblacion_estimada_B'];
            $valorIndicador_A = ( $egresado_A / $poblacion_estimada_A ) * 100;
            $valorIndicador_B = (  $egresado_B / $poblacion_estimada_B) * 100;
            
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
                                           Egresados
                                        </th>
                                        <td>  
                                            <?php echo number_format($egresado, 0) ?>
                                        </td> 
                                    </tr>
                                    <tr>
                                        <th>
                                            Poblacion Estimada
                                        </th>
                                        <td>
                                            <?php echo number_format($poblacion_estimada, 0) ?>
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
                                            Egresados
                                        </th>
                                        <td>  
                                            <?php echo number_format($egresado_A, 0) ?>
                                        </td> 
                                        <td>  
                                            <?php echo number_format($egresado_B, 0) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Poblacion Estimada
                                        </th>
                                        <td>
                                            <?php echo number_format($poblacion_estimada_A, 0) ?>
                                        </td>
                                        <td>
                                            <?php echo number_format($poblacion_estimada_B, 0) ?>
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
                                        ['Egresados',   <?php echo $egresado ?>],
                                        ['No egresados',   <?php echo ($poblacion_estimada - $egresado) ?>]
                                    ]
                                }]
                            <?php }else{ ?>
                                 series: [{
                                    type: 'pie',
                                    name: '<?php echo utf8_encode($indicador['titulo']) ?>',
                                    data: [
                                        ['Egresados <?php echo utf8_encode($etiqueta_A) ?>',   <?php echo $egresado_A ?>],
                                        ['No egresados <?php echo utf8_encode($etiqueta_A) ?>',   <?php echo ($poblacion_estimada_A - $egresado_A) ?>]
                                    ],
                                    center:['30%','50%'],
                                    size:200
                                },{
                                    type: 'pie',
                                    name: '<?php echo utf8_encode($indicador['titulo']) ?>',
                                    data: [
                                        ['Egresados <?php echo utf8_encode($etiqueta_B) ?>',   <?php echo $egresado_B ?>],
                                        ['No egresados <?php echo utf8_encode($etiqueta_B) ?>',   <?php echo ($poblacion_estimada_B - $egresado_B) ?>]
                                    ],
                                    center:['65%','50%'],
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