<?php
include 'phpIncluidos/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    include 'phpIncluidos/queryDinamico.php';
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9, IE=8"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="css/estiloGeneral.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/estiloSEH.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="fancyBox/jquery.fancybox-1.3.4.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="jqueryLib/tipsy-0.1.7/tipsy.css" />
        <script src="javascript/html5.js" type="text/javascript"></script>
        <title>Tabla Dinamica Generada</title>
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
                <input id="campoCalculadoGenerado" style="display: none;" type="hidden" value="<?php echo $campo_calculado; ?>"/>
                <input id="operacionCalculoGenerado" style="display: none;" type="hidden" value="<?php echo htmlentities($reporte_calculo); ?>"/>
                <div id="contenedorColores" class="contenedorMenusSubsitios">
                    <div class="contenedorMenusSubsitiosInterno">
                        <div class="tituloSubsitios">
                            <h2 id="PageTitle" style="">
                                TABLAS DE DATOS - Sistema Escolar de Honduras</h2>
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
                                                <div class="espacioDescripcion" onclick="excelExporter_1_0(window.location, 'reporteTablaDinamica')">Descargar Tabla</div>
                                            </div>
                                            <?php
                                            if ($col_B0_esDatoCalculo && $col_C0_esDatoCalculo && $col_D0_esDatoCalculo) {
                                                ?>
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
                                                <div class="items">
                                                    <div class="espacioIcono"><img src="recursos/iconos/chart-pie.png"/></div>
                                                    <div class="espacioDescripcion" onclick="verGraficas('pie')">Ver Grafico de Pastel</div>
                                                </div>
                                                <?php
                                            }
                                            ?>
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
                                                        <img src="recursos/iconos/preparaTablasDatosIcon_48px.png">
                                                    </div>
                                                    <div class="lineaVertical">&nbsp;</div>
                                                    <div class="descripcion" id="seccionDescripcionEncabezadoReporteria">
                                                        <div class="titulo">
                                                            Reporte Dinamico                                                       
                                                        </div>
                                                        <div class="subTitulo">
                                                            Generado desde la Opci&oacute;n de Generar Tablas de Datos.
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
                                                        <label>&nbsp;Tipo de Indicador : </label><span><?php echo $indicador_id; ?></span>
                                                    </div>
                                                </div>
                                                <div style="height:32px;">
                                                    <div class="items">
                                                        <img src="recursos/iconos/function.png"/>
                                                        <label>&nbsp;Tipo de Calculo<label style="width: 12px; display: inline-table;">&nbsp;</label>:&nbsp;</label>
                                                        <span><?php echo htmlentities($reporte_calculo); ?></span>
                                                    </div> 
                                                    <div style="font-size: 12pt; color: #aaaaaa;" class="items">
                                                        &nbsp;|&nbsp;
                                                    </div>
                                                    <div class="items">
                                                        <img src="recursos/iconos/odata.png"/>
                                                        <label>&nbsp;Campo<label style="width: 38px; display: inline-table;">&nbsp;</label>:&nbsp;</label>
                                                        <span><?php echo $campo_calculado; ?></span>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br />
                                    <table id="tablaIndicador" class="tablaReportes" style="display: none;" cellspacing="0" cellpadding="0">
                                        <thead>
                                            <tr style="height: inherit;">
                                                <th></th>
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
                                        <tfoot>
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <br />
                                    <div id="espaciotablaReporte" style="overflow-x: scroll; border: 4px solid #cccccc; padding: 4px 12px;">                                    
                                        <table id="tablas_datos_reporte" class="tablaReportes" cellspacing="0" cellpadding="0">
                                            <thead>
                                                <tr style="height: 14px;">
                                                    <?php
                                                    SWITCH ($col_A0){
                                                        CASE 'departamento_id' :
                                                            echo '<th class="bordeIzq" style="font-size: 11pt;">Departamentos</th>';
                                                        BREAK;
                                                        CASE 'tipo_zona_id' :
                                                            echo '<th class="bordeIzqCeldas bordeAbajoCeldas">Zona</th>';
                                                        BREAK;
                                                    }
                                                    //PARTE DE LOS CAMPOS QUE SERAN ETIQUETAS
                                                    /*if (!$col_B0_esDatoCalculo) {
                                                        if ($col_B0_etiquetaCampo == 'departamento') {
                                                            echo '<th class="bordeIzq" style="font-size: 11pt;">Departamentos</th>';
                                                        }
                                                        if ($col_B0_etiquetaCampo == 'administracion') {
                                                            echo '<th class="bordeIzq" style="font-size: 11pt;">Administraci&oacute;n</th>';
                                                        }
                                                        if ($col_B0_etiquetaCampo == 'zona') {
                                                            echo '<th class="bordeIzq" style="font-size: 11pt;">Zona</th>';
                                                        }
                                                        if ($col_B0_etiquetaCampo == 'grado') {
                                                            echo '<th class="bordeIzq" style="font-size: 11pt;">Grados</th>';
                                                        }
                                                        if ($col_B0_etiquetaCampo == 'genero') {
                                                            echo '<th class="bordeIzq" style="font-size: 11pt;">Genero</th>';
                                                        }
                                                    }
                                                    if (!$col_C0_esDatoCalculo) {
                                                        if ($col_C0_etiquetaCampo == 'departamento') {
                                                            echo '<th class="bordeIzq" style="font-size: 11pt;">Departamentos</th>';
                                                        }
                                                        if ($col_C0_etiquetaCampo == 'administracion') {
                                                            echo '<th class="bordeIzq" style="font-size: 11pt;">Administraci&oacute;n</th>';
                                                        }
                                                        if ($col_C0_etiquetaCampo == 'zona') {
                                                            echo '<th class="bordeIzq" style="font-size: 11pt;">Zona</th>';
                                                        }
                                                        if ($col_C0_etiquetaCampo == 'grado') {
                                                            echo '<th class="bordeIzq" style="font-size: 11pt;">Grados</th>';
                                                        }
                                                        if ($col_C0_etiquetaCampo == 'genero') {
                                                            echo '<th class="bordeIzq" style="font-size: 11pt;">Genero</th>';
                                                        }
                                                    }
                                                    if (!$col_D0_esDatoCalculo) {
                                                        if ($col_D0_etiquetaCampo == 'departamento') {
                                                            echo '<th class="bordeIzq" style="font-size: 11pt;">Departamentos</th>';
                                                        }
                                                        if ($col_D0_etiquetaCampo == 'administracion') {
                                                            echo '<th class="bordeIzq" style="font-size: 11pt;">Administraci&oacute;n</th>';
                                                        }
                                                        if ($col_D0_etiquetaCampo == 'zona') {
                                                            echo '<th class="bordeIzq" style="font-size: 11pt;">Zona</th>';
                                                        }
                                                        if ($col_D0_etiquetaCampo == 'grado') {
                                                            echo '<th class="bordeIzq" style="font-size: 11pt;">Grados</th>';
                                                        }
                                                        if ($col_D0_etiquetaCampo == 'genero') {
                                                            echo '<th class="bordeIzq" style="font-size: 11pt;">Genero</th>';
                                                        }
                                                    }


                                                    if ($col_B0 == 'administracion' || $col_C0 == 'administracion' || $col_D0 == 'administracion' || $col_E0 == 'administracion') {
                                                        echo '    <th class="bordeIzq" style="font-size: 11pt;">Total P&uacute;blico</th>
                                                                  <th class="bordeIzq" style="font-size: 11pt;">Total Privado</th>';
                                                    }
                                                    if ($col_B0 == 'zona' || $col_C0 == 'zona' || $col_D0 == 'zona' || $col_E0 == 'zona') {
                                                        echo '<th class="bordeIzq" style="font-size: 11pt;">Total Rural</th>
                                                                  <th class="bordeIzq" style="font-size: 11pt;">Total Urbano</th>';
                                                    }
                                                    if ($col_B0 == 'departamento' || $col_C0 == 'departamento' || $col_D0 == 'departamento' || $col_E0 == 'departamento') {
                                                        echo '  <th class="bordeIzq" style="font-size: 11pt;">Atl&aacute;ntida</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Choluteca</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Col&oacute;n</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Comayagua</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Cop&aacute;n</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Cort&eacute;s</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">El Para&iacute;so</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Francisco Moraz&aacute;n</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Gracias a Dios</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Intibuc&aacute;</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Islas de la Bah&iacute;a</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">La Paz</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Lempira</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Ocotepeque</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Olancho</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Santa B&aacute;rbara</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Valle</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Yoro</th>';
                                                    }
                                                    if ($col_B0 == 'grado' || $col_C0 == 'grado' || $col_D0 == 'grado' || $col_E0 == 'grado') {
                                                        echo '  <th class="bordeIzq" style="font-size: 11pt;">CCEPREB</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Pre-kinder</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Kinder</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Preparatoria</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Grado 1</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Grado 2</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Grado 3</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Grado 4</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Grado 5</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Grado 6</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Grado 7</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Grado 8</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Grado 9</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Grado 10</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Grado 11</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Grado 12</th>
                                                                <th class="bordeIzq" style="font-size: 11pt;">Grado 13</th>  ';
                                                    }
                                                    if ($col_B0 == 'genero' || $col_C0 == 'genero' || $col_D0 == 'genero' || $col_E0 == 'genero') {
                                                        echo '<th class="bordeIzq" style="font-size: 11pt;">Total Femenino</th>
                                                                  <th class="bordeIzq" style="font-size: 11pt;">Total Masculino</th>';
                                                    }*/
                                                    echo '<th class="bordeIzq" style="font-size: 11pt;">Total General</th>';
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $contador = 0;
                                                foreach ($data_reporte as $data) {
                                                    if (($contador % 2) == 0) {
                                                        echo '<tr class="filaAzul">';
                                                    } else {
                                                        echo "<tr>";
                                                    }
                                                    SWITCH ($col_A0){
                                                        CASE 'departamento_id' :
                                                            echo '<th class="bordeIzqCeldas bordeAbajoCeldas">' . ucfirst(htmlentities($data['Departamento'])) . '</th>';
                                                        BREAK;
                                                        CASE 'tipo_zona_id' :
                                                            echo '<th class="bordeIzqCeldas bordeAbajoCeldas">' . ucfirst(htmlentities($data['Zona'])) . '</th>';
                                                        BREAK;
                                                    }
                                                    /*if (!$col_B0_esDatoCalculo) {
                                                        echo '<th class="bordeIzqCeldas bordeAbajoCeldas">' . ucfirst(htmlentities($data[$col_B0_etiquetaCampo])) . '</th>';
                                                    }
                                                    if (!$col_C0_esDatoCalculo) {
                                                        echo '<th class="bordeIzqCeldas bordeAbajoCeldas">' . ucfirst(htmlentities($data[$col_C0_etiquetaCampo])) . '</th>';
                                                    }
                                                    if (!$col_D0_esDatoCalculo) {
                                                        echo '<th class="bordeIzqCeldas bordeAbajoCeldas">' . ucfirst(htmlentities($data[$col_D0_etiquetaCampo])) . '</th>';
                                                    }
                                                    if ($col_B0 == 'administracion' || $col_C0 == 'administracion' || $col_D0 == 'administracion' || $col_E0 == 'administracion') {
                                                        echo '<td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_publico']) . '</td>
                                                                <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_privado']) . '</td>';
                                                    }
                                                    if ($col_B0 == 'zona' || $col_C0 == 'zona' || $col_D0 == 'zona' || $col_E0 == 'zona') {
                                                        echo '<td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_rural']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_urbano']) . '</td>';
                                                    }
                                                    if ($col_B0 == 'departamento' || $col_C0 == 'departamento' || $col_D0 == 'departamento' || $col_E0 == 'departamento') {
                                                        echo '<td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_atlantida']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_choluteca']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_colon']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_comayagua']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_copan']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_cortes']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_elparaiso']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_fcomorazan']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_grasadios']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_intibuca']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_islasbahia']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_lapaz']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_lempira']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_ocotepeque']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_olancho']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_sntabarbara']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_valle']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_yoro']) . '</td>';
                                                    }
                                                    if ($col_B0 == 'grado' || $col_C0 == 'grado' || $col_D0 == 'grado' || $col_E0 == 'grado') {
                                                        echo '<td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_ccepreb']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_prekinder']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_kinder']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_preparatoria']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_gradoUno']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_gradoDos']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_gradoTres']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_gradoCuatro']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_gradoCinco']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_gradoSeis']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_gradoSiete']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_gradoOcho']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_gradoNueve']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_gradoDiez']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_gradoOnce']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_gradoDoce']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_gradoTrece']) . '</td>';
                                                    }
                                                    if ($col_B0 == 'genero' || $col_C0 == 'genero' || $col_D0 == 'genero' || $col_E0 == 'genero') {
                                                        echo '<td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_femenino']) . '</td>
                                                                    <td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_masculino']) . '</td>';
                                                    }*/
                                                    //echo '<td class="celdaNumerica bordeIzqCeldas bordeAbajoCeldas">' . number_format($data['total_general']) . '</td>';
                                                    echo "</tr>";
                                                    $contador++;
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="40">&nbsp;</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <br/>                                    
                                    <br/>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php
            }//si no hay datos motrar mensage de error o alerta
            else {
                ?>
                <div id="contenedorColores" class="contenedorMenusSubsitios">
                    <div class="contenedorMenusSubsitiosInterno">
                        <div class="tituloSubsitios">
                            <h2 id="PageTitle" style="">
                                TABLAS DE DATOS - Sistema Escolar de Honduras</h2>
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
                                <?php
                                if ($cantDatosErroneos == 0) {
                                    ?>
                                    <li>No se encontraron datos para el Universo seleccionado,</li>
                                    <li>El Reporte no existe en el Sistema.</li>
                                    <?php
                                } else {
                                    ?>
                                    <li>La URL parece estar Corrupta.</li>
                                    <?php
                                }
                                ?>
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
    <script type="text/javascript">
        
        /**
         * Visualize an HTML table using Highcharts. The top (horizontal) header 
         * is used for series names, and the left (vertical) header is used 
         * for category names. This function is based on jQuery.
         * @param {Object} table The reference to the HTML table to visualize
         * @param {Object} options Highcharts options
         */
        var tipoGrafica = 'column';
        function verGraficas(_tipoGrafica)
        {
            tipoGrafica = _tipoGrafica;
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
                        text: '' /*+ document.getElementById('tituloParaGrafico').value*/
                    },
                    subtitle: {
                        text: 'UNIVERSO - Total de alumnos : ' + document.getElementById('campoCalculadoGenerado').value
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
                        },plotOptions: {
                            pie: {
                                    allowPointSelect: true,
                                    cursor: 'pointer',
                                    dataLabels: {
                                            enabled: true,
                                            color: '#333333',
                                            connectorColor: '#666666',
                                            formatter: function() {
                                                    return '<b>'+ this.point.name +'</b>: '+ redondeaNumero(Math.max(this.percentage), 2) +' %';
                                            }                                           
                                }
                            }
                    },
                    credits: {
                        enabled: false
                    },
                    exporting: {
                        filename: 'grafica_tablaDinamica' /*+ document.getElementById('tituloParaGrafico').value + ''*/
                    }
                };		      					
                Highcharts.visualize(table, options);
            });
        }
    </script>
</html>