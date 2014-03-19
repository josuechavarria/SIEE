<?php
include 'phpIncluidos/conexion.php';
include 'phpIncluidos/reportesPorDepto.php';
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9, IE=8"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="css/estiloGeneral.css" />
        <link rel="stylesheet" type="text/css" href="css/estiloSEH.css" />
        <link rel="stylesheet" type="text/css" href="fancyBox/jquery.fancybox-1.3.4.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="jqueryLib/tipsy-0.1.7/tipsy.css" />
        <script src="javascript/html5.js" type="text/javascript"></script>
        <title>Reporte : Estudiantes por Departamento</title>
    </head>
    <link rel="SHORTCUT ICON" href="seh_favicon.png">
    <body id="cuerpo">
        <div id="ContenedorGlobal" class="contenedorGlobal">
            <header id="sieeHeader">
                <?php include 'phpIncluidos/headerSiee.php'; ?>            
            </header>
            <?php
            //si existen datos para el reporte mostrar la info
            if (sizeOf($data_reporte) > 0) {
                ?>
                <div id="contenedorColores" class="contenedorMenusSubsitios">
                    <div class="contenedorMenusSubsitiosInterno">
                        <div class="tituloSubsitios">
                            <h2 id="PageTitle" style="">
                                REPORTES - Sistema Escolar de Honduras</h2>
                        </div>
                        <!--div class="espacioMenuSubsitios" style="color: #fff; font-size: 14pt; height: 30px; padding-top: 6px; text-align: center;">
                            Total de Estudiantes por Departamentos
                        </div-->
                        <div class="espacioMenuSubsitios">
                            &nbsp;
                        </div>
                        <div id="navegacionSecuencial" class="navegacionSecunciales">
                            &nbsp;
                        </div>
                    </div>
                    <div id="LoadingSiteBar" class="loadingBarSite">
                        <span>Cargando ...</span>
                        <br/>
                        <img src="recursos/imagenes/loadingBar_gray.gif"/>
                    </div>
                </div>
                <div id="contenedorInternoGlobal" class="contenidoGlobalInterno">
                    <table style="width: 100%;" cellspacing="0" cellpading="0">
                        <tr>
                            <td valign="top" style="background-color: #eeeeee; border-right: 1px solid #666666; width: 28px; vertical-align: top;">
                                <div id="leftPanel" class="leftPanelControl">
                                    <div class="headerTitle">
                                        <div id="panelTitle" class="innerDiv">
                                            Panel  de Trabajo
                                        </div>                     
                                        <a id="controlMinMax" name="min" class="control" onclick="minMaxPanelTrabajo('leftPanel','controlMinMax')">
                                            &nbsp;&nbsp;&nbsp;&nbsp;</a>                             
                                    </div>
                                    <div id="panelContent" class="panelInnerContent">
                                        <br/>
                                        <div class="cajaOpciones">
                                            <div class="headerTitle"><br/>Opciones del Reporte&nbsp;</div>
                                            <div class="items">
                                                <div class="espacioIcono"><img src="recursos/iconos/table-excel.png"/></div>
                                                <div class="espacioDescripcion" onclick="excelExporterReportes_1_0(window.location, $('#tituloParaGrafico').val())">Descargar Reporte</div>
                                            </div>
                                            <div class="items">
                                                <div class="espacioIcono"><img src="recursos/iconos/chart-plus.png"/></div>
                                                <div class="espacioDescripcion" onclick="verGraficas('column')">Ver Grafico de Columnas</div>
                                            </div>
                                            <div class="items">
                                                <div class="espacioIcono"><img src="recursos/iconos/chart-up.png"/></div>
                                                <div class="espacioDescripcion" onclick="verGraficas('area')">Ver Grafico de Areas</div>
                                            </div>
                                            <div class="items">
                                                <div class="espacioIcono"><img src="recursos/iconos/chart-up.png"/></div>
                                                <div class="espacioDescripcion" onclick="verGraficas('line')">Ver Grafico de Lineas</div>
                                            </div>
                                            <!--div class="items">
                                                <div class="espacioIcono"><img src="recursos/iconos/chart-pie.png"/></div>
                                                <div class="espacioDescripcion" onclick="verGraficas('pie')">Ver Grafico de Pastel</div>
                                            </div-->
                                            <div class="items">
                                                <div class="espacioIcono"><img src="recursos/iconos/printer.png"/></div>
                                                <div class="espacioDescripcion">Imprimir Contenido Actual</div>
                                            </div>                                        
                                            <br/>
                                        </div>
                                        <br/>
                                    </div>
                                </div>
                            </td>
                            <td valign="top">
                                <div id="rightContentPanel" class="righContentPanel">
                                    <div id="informationContent">
                                        <div id="seccionEncabezadoGeneralSitios">
                                            <div class="encabezadoReporteGenerado">
                                                <div class="encabezado">
                                                    <div class="icono">
                                                        <img src="recursos/iconos/preparaReporteIcon_48px.png">
                                                    </div>
                                                    <div class="lineaVertical">&nbsp;</div>
                                                    <div class="descripcion" id="seccionDescripcionEncabezadoReporteria">
                                                        <div class="titulo">
                                                            <?php echo htmlentities($data_reporte[0]['titulo']); ?>                                                       
                                                        </div>
                                                        <div class="subTitulo">
                                                            Generado desde el listado de reportes de estudiantes por departamentos.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="descripcionSubsitio">
                                            <div class="cajaFiltrosReporteGenerado">
                                                <div class="titulo">
                                                    <img src="recursos/iconos/funnel-pencil.png"/>
                                                    &nbsp;&nbsp;Universo del Reporte seg&uacute;n su elecci&oacute;n:
                                                </div>
                                                <div style="height:32px;">
                                                    <div class="items">
                                                        <img src="recursos/iconos/calendar-select.png"/>
                                                        <label>&nbsp;A&ntilde;o Seleccionado : </label><span><?php echo $anio; ?></span>
                                                    </div>
                                                    <div style="font-size: 12pt; color: #aaaaaa;" class="items">
                                                        &nbsp;|&nbsp;
                                                    </div>
                                                    <div class="items">
                                                        <img src="recursos/iconos/chart-up.png"/>
                                                        <label>&nbsp;Tipo de Indicador : </label><span><?php echo $indicador; ?></span>
                                                    </div>
                                                </div>
                                                <div style="height:32px;">
                                                    <div class="items">
                                                        <img src="recursos/iconos/levels.png"/>
                                                        <label>&nbsp;Nivel Educativo<label style="width: 20px; display: inline-table;">&nbsp;</label>:&nbsp;</label><span><?php echo htmlentities($nivel); ?></span>
                                                    </div>
                                                    <div style="font-size: 12pt; color: #aaaaaa;" class="items">
                                                        &nbsp;|&nbsp;
                                                    </div>
                                                    <div class="items">
                                                        <img src="recursos/iconos/grade-persons.png" />
                                                        <label>&nbsp;Grado(s)<label style="width: 51px; display: inline-table;">&nbsp;</label>:&nbsp;</label><span><?php echo htmlentities($grado); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br />
                                    <table id="tablaIndicador" class="tablaReportes" style="display: none;" cellspacing="0" cellpadding="0">
                                        <thead>
                                            <tr style="height: inherit;">
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div id="contenedorIndicadores">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot style="border-top:0;">
                                            <tr>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <br />
                                    <div id="espaciotablaReporte">
                                        <div style="display:inline-block;">
                                            <table id="tablaSelecciones" class="tablaReportes" cellspacing="0" cellpadding="0" style="width: 70px;">
                                                <thead>
                                                    <tr style="height:inherit;">
                                                        <th id="encabezadoCalcular" checados="0">Calcular</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $i = 1; 
                                                        foreach ($data_reporte as $data) {
                                                             if (($i % 2) == 0) {
                                                                echo '<tr>';
                                                            } else {
                                                                echo '<tr class="filaAzul">';
                                                            }
                                                            echo '<th class="bordeAbajoCeldas" style="text-align:center;"><input name="realizarCalculo" item="'.$i.'" type="checkbox"/></th></tr>';
                                                            $i++;
                                                        }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>&nbsp;</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div style="display:inline-block;width:700px;">
                                            <table id="tablas_datos_reporte" class="tablaReportes" cellspacing="0" cellpadding="0">
                                                <thead>
                                                    <tr style="height: inherit;">
                                                        <?php
                                                        echo '<th class="bordeIzq">Departamentos</th>';
                                                        $lbl_A = "";
                                                        $lbl_B = "";
                                                        if ($numero_reporte == 1) {
                                                            $lbl_A = "P&uacute;blico";
                                                            $lbl_B = "Privado";                                                            
                                                        }
                                                        if ($numero_reporte == 2) {
                                                            $lbl_A = "Rural";
                                                            $lbl_B = "Urbano";
                                                        }
                                                        if ($numero_reporte == 3) {
                                                            $lbl_A = "falta";
                                                            $lbl_B = "falta";
                                                        }
                                                        if ($numero_reporte == 4) {
                                                            $lbl_A = "Femenino";
                                                            $lbl_B = "Masculino";
                                                        }
                                                        echo '<th style="width: 16%;" class="bordeIzq">Total ' . $lbl_A . '</th><th style="width: 16%;" class="bordeIzq">Total ' . $lbl_B . '</th>';
                                                        echo '<th style="width: 16%;">Total General</th>';
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
                                                            echo '<tr class="filaAzul">';
                                                        } else {
                                                            echo "<tr>";
                                                        }
                                                        echo '<th class="bordeIzqCeldas bordeAbajoCeldas">' . htmlentities($data['departamento']) . '</th>';
                                                        if ($numero_reporte == 1) {
                                                            $totalA += $data['total_publico'];
                                                            $totalB += $data['total_privado'];
                                                            echo '<td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas" total_a="'.($contador + 1).'">' . number_format($data['total_publico']) . '</td>
                                                                  <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas" total_b="'.($contador + 1).'">' . number_format($data['total_privado']) . '</td>';
                                                        }
                                                        if ($numero_reporte == 2) {
                                                            $totalA += $data['total_rural'];
                                                            $totalB += $data['total_urbana'];
                                                            echo '<td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas" total_a="'.($contador + 1).'">' . number_format($data['total_rural']) . '</td>
                                                                  <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas" total_b="'.($contador + 1).'">' . number_format($data['total_urbana']) . '</td>';
                                                        }
                                                        if ($numero_reporte == 3) {
                                                            $totalA += 0;
                                                            $totalB += 0;
                                                            echo '<td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas" total_a="'.($contador + 1).'">0</td>
                                                                  <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas" total_b="'.($contador + 1).'">0</td>';
                                                        }
                                                        if ($numero_reporte == 4) {
                                                            $totalA += $data['total_femenino'];
                                                            $totalB += $data['total_masculino'];
                                                            echo '<td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas" total_a="'.($contador + 1).'">' . number_format($data['total_femenino']) . '</td>
                                                                  <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas" total_b="'.($contador + 1).'">' . number_format($data['total_masculino']) . '</td>';
                                                        }
                                                        echo '<td class="celdaNumerica bordeAbajoCeldas">' . number_format($data['total_general']) . '</td>';
                                                        echo "</tr>";

                                                        $grandTotal += $data['total_general'];
                                                        $contador++;
                                                    }
                                                    ?>
                                                </tbody>
                                                <tfoot style="display: none;">
                                                    <tr>
                                                        <th colspan="4">&nbsp;</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <table class="tablaReportes" cellspacing="0" cellpadding="0" style="border-top: 0;">
                                                <tfoot style="border-top:0;">
                                                    <tr>
                                                        <th style="text-align: center;border-right:1px dashed #555;">TOTALES</th>
                                                        <th style="width:16%; text-align: right;border-right:1px dashed #555;"><?php echo number_format($totalA) ?>&nbsp;</th>
                                                        <th style="width:16%; text-align: right;border-right:1px dashed #555;"><?php echo number_format($totalB) ?>&nbsp;</th>
                                                        <th style="width:16%; text-align: right;"><?php echo number_format($grandTotal) ?>&nbsp;</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <br/>                                    
                                    <br/>
                                </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <input id="tituloParaGrafico" style="display: none;" type="hidden" value="<?php echo htmlentities($data_reporte[0]['titulo']); ?> por Departamento"/>
                <input id="universoParaGrafico" style="display: none;" type="hidden" value="
                <?php
                echo "Año : " . $anio . " | Nivel Educatívo : " . $nivel .
                " | Indicador : " . $indicador . " | Grado : " . $grado;
                ?>"/>
                       <?php
                   }//si no hay datos motrar mensage de error o alerta
                   else {
                       ?>
                <div id="contenedorColores" class="contenedorMenusSubsitios">
                    <div class="contenedorMenusSubsitiosInterno">
                        <div class="tituloSubsitios">
                            <h2 id="PageTitle" style="">
                                REPORTES - Sistema Escolar de Honduras</h2>
                        </div>
                        <div class="espacioMenuSubsitios">
                            &nbsp;
                        </div>
                        <div id="navegacionSecuencial" class="navegacionSecunciales">
                            &nbsp;
                        </div>
                    </div>
                    <div id="LoadingSiteBar" class="loadingBarSite">
                        <span>Cargando ...</span>
                        <br/>
                        <img src="recursos/imagenes/loadingBar_gray.gif"/>
                    </div>
                </div>
                <div id="contenedorInternoGlobal" class="contenidoGlobalInterno" style="text-align: center;">
                    <div class="cajaAmarillaAlertas">
                        <div class="encabezado">
                            <div class="titulo">Error en Solicitud de Reporte.</div>
                        </div>
                        <div class="descripcion">
                            No se ha podido generar el reporte solicitado por alguna de las siguientes Razones :
                            <br/>
                            <ul>
                                <li>No se encontraron datos para el Universo seleccionado,</li>
                                <li>El Reporte no existe en el Sistema.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <footer>
                <?php include 'phpIncluidos/footerSiee.php'; ?>
            </footer>
        </div>
    </body>
    <script type="text/javascript" src="jqueryLib/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="javascript/jsSitio.js"></script>
    <script type="text/javascript" src="jQueryUI/jquery-ui-1.8.23.custom/js/jquery-ui-1.8.23.custom.min.js"></script>
    <script type="text/javascript" src="jqueryLib/tipsy-0.1.7/jquery.tipsy.js"></script>
    <script type="text/javascript" src="fancyBox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="fancyBox/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="chartsLib/Highcharts-2.3.2/js/highcharts.js"></script>
    <script type="text/javascript" src="javascript/chartsJs.js"></script>
    <script type="text/javascript" src="chartsLib/Highcharts-2.3.2/js/modules/exporting.js"></script>
    <script type="text/javascript">
        var tipoGrafica = 'column';
        function verGraficas(_tipoGrafica)
        {
            tipoGrafica = _tipoGrafica;
            $('#contenedorIndicadores').html();
            $("#tablaIndicador").fadeIn('fast');
            Highcharts.visualize = function(table, options) {
                // the categories
                options.xAxis.categories = [];
                $('tbody th', table).each( function(i) {
                    options.xAxis.categories.push(this.innerHTML);
                });				
                // the data series
                options.series = [];
                $('tr', table).each( function(i) {
                    var tr = this;
                    $('th, td', tr).each( function(j) {
                        if (j > 0) { // skip first column
                            if (i == 0) { // get the name and init the series
                                options.series[j - 1] = { 
                                    name: this.innerHTML,
                                    data: []
                                };
                            } else { // add values
                                var value = this.innerHTML.toString().replace(',', '');
                                if(value.search(',') >= 0)
                                {                                    
                                    value = value.replace(',', '');
                                }
                                options.series[j - 1].data.push(parseFloat(value));
                            }
                        }
                    });
                });
				
                var chart = new Highcharts.Chart(options);
            }
				
            // On document ready, call visualize on the datatable.
            $(document).ready(function() {			
                var table = document.getElementById('tablas_datos_reporte'),
                options = {
                    chart: {
                        renderTo: 'contenedorIndicadores',
                        defaultSeriesType: tipoGrafica
                    },
                    title: {
                        text: '' + document.getElementById('tituloParaGrafico').value
                    },
                    subtitle: {
                        text: 'UNIVERSO - ' + document.getElementById('universoParaGrafico').value
                    },
                    xAxis: {
                        labels: {
                            rotation: -45,
                            align: 'right',
                            style: {
                                font: 'normal 9pt "lucida grande",tahoma,verdana,arial,sans-serif'
                            }
                        }
                    },
                    yAxis: {
                        min :   0,
                        title: {
                            text: 'Cantidad de Estudiantes en Miles'
                        },
                        labels: {
                            formatter: function() {
                                return this.value + '';
                            }
                        }
                    },
                    tooltip: {
                        formatter: function() {
                            return '<b>'+ this.series.name +'</b><br/>'+
                                this.y +' '+ this.x.toLowerCase();
                        }
                    },
                    credits: {
                        enabled: false
                    },
                    exporting: {
                        filename: 'grafica_' + $('#tituloParaGrafico').val().replace(/\s/g,'_')
                    }
                };		      					
                Highcharts.visualize(table, options);
            });
        }
        $(document).ready(function(){
            $('#tablaSelecciones input[name="realizarCalculo"], #encabezadoCalcular').css({
                'cursor' : 'pointer'
            });
            $('#encabezadoCalcular').mouseover(function(){
                if( $(this).attr('checados') == '0'){
                    $(this).tipsy({
                        fallback: "haz clic aquí para quitar todos.",
                        gravity :   's'
                    });
                }else{
                    $(this).tipsy({
                        fallback: "haz clic aquí para seleccionar todos.",
                        gravity :   's'
                    });
                }
            });
            $('#encabezadoCalcular').click(function(){
                if( $(this).attr('checados') == '0'){
                   $('input[name="realizarCalculo"]').prop("checked", true);
                   $(this).attr('checados', '1');
                }else{
                    $('input[name="realizarCalculo"]').prop("checked", false);
                    $(this).attr('checados', '0');
                }
                $('#tablaSelecciones [name="realizarCalculo"]').first().trigger('change');
            });
        });
        $('#tablaSelecciones [name="realizarCalculo"]').change(function(){ 
            var valor_global_a = 0;
            var valor_global_b = 0;
            var valor_global = 0;
            var divisor_global = 0;
            var contador_global = 0;
            $('#tablaSelecciones [name="realizarCalculo"]:checked').each(function(){
                divisor_global += 1;
                contador_global += 1;
                var itemNumb = $(this).attr('item');
                valor_global_a += parseInt($.trim($('#tablas_datos_reporte tbody tr td[total_a="'+ itemNumb + '"]').text().replace(/[,]/g,"")));
                valor_global_b += parseInt($.trim($('#tablas_datos_reporte tbody tr td[total_b="'+ itemNumb + '"]').text().replace(/[,]/g,"")));
            });
            valor_global = valor_global_a + valor_global_b;
            (divisor_global < 1 ? divisor_global = 1 : divisor_global = divisor_global);
            var _id = 'Calculos';
            var _html_contenido =    '<table class="tablaGeneral" cellspacing="0" cellpadding="0">' + 
                                            '<thead>'+  
                                                '<tr>'+
                                                    '<th>Calculo</th>'+
                                                    '<th><?php echo $lbl_A;?></th>'+
                                                    '<th><?php echo $lbl_B;?></th>'+
                                                    '<th>Total</th>'+
                                                '</tr>'+
                                            '</thead>'+
                                            '<tbody>'+
                                                '<tr>'+
                                                    '<th>Sumatoria</th>'+
                                                    '<td>' + addCommas(valor_global_a) + '</td>'+
                                                    '<td>' + addCommas(valor_global_b) + '</td>'+
                                                    '<td>' + addCommas(valor_global) + '</td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                    '<th>Promedio</th>'+
                                                    '<td>' + addCommas((valor_global_a/divisor_global).toFixed(2)) + '</td>'+
                                                    '<td>' + addCommas((valor_global_b/divisor_global).toFixed(2)) + '</td>'+
                                                    '<td>' + addCommas((valor_global/divisor_global).toFixed(2)) + '</td>'+
                                                '</tr>'+
                                            '</tbody>'
                                    '</table>';
            var _html_header= "Calculos";
            obtenerDialogoFlotante(_id, _html_header, _html_contenido);
        });
    </script>
</html>