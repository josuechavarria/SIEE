<?php
include 'phpIncluidos/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $cantDatosErroneos = 0;

    if (ISSET($_GET['anio']) && ISSET($_GET['admon']) && ISSET($_GET['zona']) && ISSET($_GET['filtroDepto']) && ISSET($_GET['filtroMuni']) ) {

        $anio = $_GET['anio'];
        $admon = $_GET['admon'];
        $zona = $_GET['zona'];
        $filtroDepto = $_GET['filtroDepto'];
        $filtroMuni = $_GET['filtroMuni'];

        $etiquetaAdmon = ($admon == 0 ? 'Todos' : ($admon == 1 ? 'Publico' : 'Privado') );
        $etiquetaZona = ($zona == 0 ? 'Todos' : ($zona == 1 ? 'Rural' : 'Urbano') );


        $stmt_dptos= $conn->query("  SELECT DISTINCT descripcion_departamento
                                     FROM ee_departamentos
                                     WHERE id = '". $filtroDepto ."'");
        $dpto = $stmt_dptos->fetch();
        $stmt_dptos->closeCursor();
        $etiquetaDepto = ($filtroDepto == 0 ? 'Todos' :  $dpto['descripcion_departamento']);
        
        $stmt_munis= $conn->query("  SELECT DISTINCT descripcion_municipio
                                     FROM ee_municipios
                                     WHERE id = '". $filtroMuni ."'");
        $muni = $stmt_munis->fetch();
        $stmt_munis->closeCursor();
        $etiquetaMuni = ($filtroMuni == 0 ? 'Todos' :  $muni['descripcion_municipio']);
        

        $stmt_datos = $conn->prepare('EXEC Recupera_Reporte_Cantidad_Centros_Equipo_Computo :anio, :filtroDepartamento, :filtroMunicipio, :filtroZona, :filtroAdministracion');
        $stmt_datos->execute(Array(
            'anio' => $anio,
            'filtroDepartamento' => $filtroDepto,
            'filtroMunicipio' => $filtroMuni,
            'filtroZona' => $zona,
            'filtroAdministracion' => $admon
        ));

        $data_reporte = $stmt_datos->fetchAll();
        $stmt_datos->closeCursor();
    }//cierre ISSET
    else {
        $data_reporte = null;
    }
}
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
        <title>Reporte : Centros con Equipo de Computo</title>
    </head>
    <link rel="SHORTCUT ICON" href="seh_favicon.png">
    <body id="cuerpo">
        <div id="ContenedorGlobal" class="contenedorGlobal">
            <header id="sieeHeader">
                <?php include 'phpIncluidos/headerSiee.php'; ?>            
            </header>
            <?php
            //si existen datos para el reporte mostrar la info
            if ( (sizeOf($data_reporte) > 0) &&  ($cantDatosErroneos == 0) ) {
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
                                                            Generado desde el Listado de Otros Reportes de Interes.
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
                                                        <img src="recursos/iconos/bank.png"/>
                                                        <label>&nbsp;Administraci&oacute;n : </label><span><?php echo $etiquetaAdmon; ?></span>
                                                    </div>
                                                    <div style="font-size: 12pt; color: #aaaaaa;" class="items">
                                                        &nbsp;|&nbsp;
                                                    </div>
                                                    <div class="items">
                                                        <img src="recursos/iconos/zone.png"/>
                                                        <label>&nbsp;Zona : </label><span><?php echo $etiquetaZona; ?></span>
                                                    </div>
                                                    <div class="items">
                                                        <img src="recursos/iconos/mapGreen.png"/>
                                                        <label>&nbsp;Departamento: </label><span><?php echo htmlentities($etiquetaDepto); ?></span>
                                                    </div>
                                                    <div style="font-size: 12pt; color: #aaaaaa;" class="items">
                                                        &nbsp;|&nbsp;
                                                    </div>
                                                    <div class="items">
                                                        <img src="recursos/iconos/mapBlue.png"/>
                                                        <label>&nbsp;Municipio : </label><span><?php echo htmlentities($etiquetaMuni); ?></span>
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
                                                    <div id="cotenedorIndicadores">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4">&nbsp;</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <br />
                                    <div id="espaciotablaReporte">
                                        <table id="tablas_datos_reporte" class="tablaReportes" cellspacing="0" cellpadding="0">
                                            <thead style="font-size: 10pt;">
                                                <tr style="height: inherit;">
                                                    <th colspan="2" style="border: 1px solid #6D6D6D; font-size: inherit;">Departamento</th>
                                                    <th colspan="2" style="border: 1px solid #6D6D6D; font-size: inherit;">Municipio</th>
                                                    <th rowspan="2" style="border: 1px solid #6D6D6D; font-size: inherit;">Administraci&oacute;n</th>
                                                    <th rowspan="2" style="border: 1px solid #6D6D6D; font-size: inherit;">Zona</th>
                                                    <th colspan="4" style="border: 1px solid #6D6D6D; font-size: inherit;">Cant. Centros con Equipo computo</th>
                                                </tr>
                                                <tr>
                                                    <th style="border: 1px solid #6D6D6D; font-size: inherit;">Cod.</th>
                                                    <th style="border: 1px solid #6D6D6D; font-size: inherit;">Nombre</th>
                                                    <th style="border: 1px solid #6D6D6D; font-size: inherit;">Cod.</th>
                                                    <th style="border: 1px solid #6D6D6D; font-size: inherit;">Nombre</th>
                                                    <th style="border: 1px solid #6D6D6D; font-size: inherit;">Alumnos</th>
                                                    <th style="border: 1px solid #6D6D6D; font-size: inherit;">Maestros</th>
                                                    <th style="border: 1px solid #6D6D6D; font-size: inherit;">Admon.</th>
                                                    <th style="border: 1px solid #6D6D6D; font-size: inherit;">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                $contador = 0;
                                                $grandTotal = 0;
                                                $total_A = 0;
                                                $total_B = 0;
                                                $total_C = 0;
                                                foreach ($data_reporte as $data) {
                                                    if (($contador % 2) == 0) {
                                                        echo '<tr class="filaAzul">';
                                                    } else {
                                                        echo '<tr>';
                                                    }
                                                    
                                                    echo '  <th class="bordeIzqCeldas bordeAbajoCeldas">' . $data['codigo_departamento'] . '</th>
                                                            <th class="bordeIzqCeldas bordeAbajoCeldas">' . htmlentities($data['nombre_departamento']) . '</th>
                                                            <th class="bordeIzqCeldas bordeAbajoCeldas">' . $data['codigo_municipio'] . '</th>
                                                            <th class="bordeIzqCeldas bordeAbajoCeldas">' . htmlentities($data['nombre_municipio']) . '</th>
                                                            <th class="bordeIzqCeldas bordeAbajoCeldas">' . htmlentities($data['administracion']) . '</th>
                                                            <th class="bordeIzqCeldas bordeAbajoCeldas">' . htmlentities($data['zona']) . '</th>
                                                            <td class="bordeIzqCeldas celdaNumerica bordeAbajoCeldas">' . number_format($data['cant_centros_pc_alumnos']) . '</td>
                                                            <td class="bordeIzqCeldas celdaNumerica bordeAbajoCeldas">' . number_format($data['cant_centros_pc_maestros']) . '</td>
                                                            <td class="bordeIzqCeldas celdaNumerica bordeAbajoCeldas">' . number_format($data['cant_centros_pc_admon']) . '</td>
                                                            <td class="celdaNumerica bordeAbajoCeldas">' . number_format($data['total_centros']) . '</td>
                                                          </tr>';
                                                    
                                                    $total_A += $data['cant_centros_pc_alumnos'];
                                                    $total_B += $data['cant_centros_pc_maestros'];
                                                    $total_C += $data['cant_centros_pc_admon'];
                                                    $grandTotal += $data['total_centros'];
                                                    $contador++;
                                                }
                                            ?>
                                            </tbody>
                                            <tfoot style="display: none;">
                                                <tr>
                                                    <th colspan="10">&nbsp;</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <table class="tablaReportes" cellspacing="0" cellpadding="0" style="border-top: 0;">
                                            <thead style="display: none;">
                                                <tr style="height: inherit;">
                                                    <th style="border: 1px solid #6D6D6D; font-size: inherit;">Departamento</th>
                                                    <th style="border: 1px solid #6D6D6D; font-size: inherit;">codigo Departamento</th>
                                                    <th style="border: 1px solid #6D6D6D; font-size: inherit;">Municipio</th>
                                                    <th style="border: 1px solid #6D6D6D; font-size: inherit;">codigo Municipio</th>
                                                    <th style="border: 1px solid #6D6D6D; font-size: inherit;">Administraci&oacute;n</th>
                                                    <th style="border: 1px solid #6D6D6D; font-size: inherit;">Zona</th>
                                                    <th style="border: 1px solid #6D6D6D; font-size: inherit;">Total Centros</th>
                                                    <th style="border: 1px solid #6D6D6D; font-size: inherit;">Total Centros</th>
                                                    <th style="border: 1px solid #6D6D6D; font-size: inherit;">Total Centros</th>
                                                    <th style="border: 1px solid #6D6D6D; font-size: inherit;">Total Centros</th>
                                                </tr>
                                            </thead>
                                            <tfoot style="border-top:0;">
                                                <tr>
                                                    <th colspan="6" style="text-align: center; width: 70%;">TOTALES</th>
                                                    <th style="text-align: right;"><?php echo number_format($total_A) ?>&nbsp;</th>
                                                    <th style="text-align: right;"><?php echo number_format($total_B) ?>&nbsp;</th>
                                                    <th style="text-align: right;"><?php echo number_format($total_C) ?>&nbsp;</th>
                                                    <th style="text-align: right;"><?php echo number_format($grandTotal) ?>&nbsp;</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <br/>                                    
                                    <br/>
                                </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <!--input id="tituloParaGrafico" style="display: none;" type="hidden" value="<?php echo htmlentities($data_reporte[0]['titulo']); ?> por Grados"/>
                <input id="universoParaGrafico" style="display: none;" type="hidden" value="
                <?php
                /*echo "Año : " . $anio . " | Nivel Educatívo : " . $nivel .
                " | Indicador : " . $indicador . " | Departamento : " . htmlentities($nombre_departamento);*/
                ?>"/-->
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
        if(window.location.search.toString() == '')
        {
            window.location.href = "inicio.php";
        }
    </script>
</html>