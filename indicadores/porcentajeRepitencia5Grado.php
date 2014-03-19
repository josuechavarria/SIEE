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
        $indicador = selectIndicadorPorId(52);
        $DatosQuery = totales_valorIndicador($ParametrosQuery, $indicador);
        
        /**
         *Calculo del indicador 
         */
        //calculo del dato para el promedio nacional       
        $DatosParametrizados_PromedioNacional = $DatosQuery['DatosPerfilGeneral'];
        $repitente_PromedioNacional = $DatosParametrizados_PromedioNacional['repitentes'];
        $matricula_PromedioNacional = $DatosParametrizados_PromedioNacional['matricula'];
      
        $valorIndicador_PromedioNacional = (  $repitente_PromedioNacional / $matricula_PromedioNacional) * 100;

        //calculo del datos para el año 
        $DatosParametrizados_anioBase = $DatosQuery['DatosAnioBase'];
        $repitente_anioBase = $DatosParametrizados_anioBase['repitentes'];
        $matricula_anioBase = $DatosParametrizados_anioBase['matricula'];
      
        $valorIndicador_anioBase = (   $repitente_anioBase / $matricula_anioBase) * 100;       

        //agregando los valor
        $indicador['PromedioNacional'] = number_format($valorIndicador_PromedioNacional, 2);
        $indicador['ValorBase'] = number_format($valorIndicador_anioBase, 2);
        
        if($desagregacion === '0'){
            //calculos para el indicador sin desagregaciones mas que, los filtros
            //calculo del indicador segun los detalles solicitados en la formula
            $DatosParametrizados = $DatosQuery['DatosParametrizados'];        
            $repitente = $DatosParametrizados['repitentes'];
            $matricula = $DatosParametrizados['matricula'];
           
            $valorIndicador = (  $repitente / $matricula) * 100;
            
        }else{
            //calculo para el indicador con desagregaciones.
            //calculo del indicador segun los detalles solicitados en la formula
            $DatosParametrizados = $DatosQuery['DatosParametrizados'];        
            $repitente_A = $DatosParametrizados['repitentes_A'];
            $matricula_A = $DatosParametrizados['matricula_A'];
            $repitente_B = $DatosParametrizados['repitentes_B'];
            $matricula_B = $DatosParametrizados['matricula_B'];
            $valorIndicador_A = ( $repitente_A / $matricula_A ) * 100;
            $valorIndicador_B = (  $repitente_B / $matricula_B) * 100;
            
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
                                           Repitente
                                        </th>
                                        <td>  
                                            <?php echo number_format($repitente, 0) ?>
                                        </td> 
                                    </tr>
                                    <tr>
                                        <th>
                                            Matricula
                                        </th>
                                        <td>
                                            <?php echo number_format($matricula, 0) ?>
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
                                            Matricula
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
                                    dataLabels: {
                                        enabled: true,
                                        color: '#000000',
                                        connectorColor: '#000000',
                                        formatter: function() {
                                            return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(2) +' %';
                                        }
                                    }
                                }  
                            },
                             <?php if ($desagregacion === '0') { ?>
                            series: [{
                                    type: 'pie',
                                    name: '<?php echo utf8_encode($indicador['titulo']) ?>',
                                    data: [
                                        ['No repitentes',   <?php echo ($matricula - $repitente) ?>],
                                        ['Repitentes',   <?php echo $repitente ?>]
                                    ]
                                }]
                            <?php }else{ ?>
                                 series: [{
                                    type: 'pie',
                                    name: '<?php echo utf8_encode($indicador['titulo']) ?>',
                                    data: [
                                        ['No repitentes <?php echo utf8_encode($etiqueta_A) ?>',   <?php echo ($matricula_A - $repitente_A) ?>],
                                        ['Repitentes <?php echo utf8_encode($etiqueta_A) ?>',   <?php echo $repitente_A ?>]
                                    ],
                                    center:['30%','50%'],
                                    size:200
                                },{
                                    type: 'pie',
                                    name: '<?php echo utf8_encode($indicador['titulo']) ?>',
                                    data: [
                                        ['No repitentes <?php echo utf8_encode($etiqueta_B) ?>',   <?php echo ($matricula_B - $repitente_B) ?>],
                                        ['Repitentes <?php echo utf8_encode($etiqueta_B) ?>',   <?php echo $repitente_B ?>]
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