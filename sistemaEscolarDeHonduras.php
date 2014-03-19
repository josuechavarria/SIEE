<?php
include 'phpIncluidos/conexion.php';
$subSitioId = 1;
/*if ($_SESSION["correr_tour"] && $_SESSION["inicio_tour"] && ($_SESSION["step_actual_tour"] == 1)) {
    $en_tour = true;
} else {
    $en_tour = false;
}*/
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9, IE=8"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="description" content="Perfil del sistema escolar de Honduras, tablas de datos absolutos, e indicadores de perfil general." />
        <link rel="stylesheet" type="text/css" href="css/estiloGeneral.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="css/estiloSEH.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="fancyBox/jquery.fancybox-1.3.4.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="jqueryLib/tipsy-0.1.7/tipsy.css" />
        <link rel="stylesheet" type="text/css" href="jQueryUI/jquery-ui-1.8.23.custom/css/custom-theme/jquery-ui-1.8.23.custom.css" />
        <script src="javascript/html5.js" type="text/javascript"></script>                
        <script type="text/javascript" src="jqueryLib/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="jQueryUI/jquery-ui-1.8.23.custom/js/jquery-ui-1.8.23.custom.min.js"></script>
        <!--link rel="stylesheet" type="text/css" href="jqueryLib/jQuerySIEETour/css/siee_tour.css" /-->
        <!--link rel="stylesheet" href="https://display-mathml.googlecode.com/hg/display-mathml.css?r=stable" />
        <script src="https://display-mathml.googlecode.com/hg/display-mathml.js?r=stable"></script-->
        <title>Sistema Escolar de Honduras</title>
        <link rel="SHORTCUT ICON" href="favicon_seh.png" />
    </head>
    <body id="cuerpo">
        <div id="ContenedorGlobal" class="contenedorGlobal">
            <header id="sieeHeader" tour-step="subsite_tour_0">
            <?php include 'phpIncluidos/headerSiee.php'; ?>            
            </header>
            <div id="contenedorColores" class="contenedorMenusSubsitios" tour-step="subsite_tour_1">
                <div class="contenedorMenusSubsitiosInterno" tour-step="subsite_tour_2">
                    <div class="tituloSubsitios">
                        <h2 id="PageTitle" onclick="subiraPosInicial()">
                            Sistema Escolar de Honduras</h2>
                    </div>
                    <div class="espacioMenuSubsitios" >
                        <ul id="menu" class="menu">
                            <li><a href="/SIEE/inicio.php">Inicio - SIEE</a>
                                <ul id="info">
                                    <li>
                                        <p>
                                            Regresa a la Pagina Principal.
                                        </p>
                                    </li>
                                </ul>
                            </li>                            
                            <li><a>Secciones</a>
                                <ul name="subMenuUl" class="boxShadowMenu">
                                <?php
                                    $stmt_subsitios = $conn->query(' SELECT * FROM siee_subsitio WHERE activo = 1 ORDER BY titulo;');
                                    $lst_subsitios = $stmt_subsitios->fetchAll();
                                    $stmt_subsitios->closeCursor();

                                    foreach ($lst_subsitios as $subsitio) {
                                        echo '<li><a href="' . $subsitio['url'] . '" title="' . htmlentities($subsitio['titulo']) . '" grav="w">Sistema ' . htmlentities($subsitio['abreviatura']) . '</a></li>';
                                    }
                                    ?>
                                </ul>
                            </li>
                            <li><a href="seccionDescargas.php">Sección de descargas</a>
                                <ul id="info">
                                    <li>
                                        <p>
                                            En esta Seccion encontrar&aacute; documentos descargables para Trabajos sin Conexi&oacute;n.
                                        </p>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="javascript:mostrarBuscadorIndicadores()">¿ Que indicador buscas ?</a>
                                <ul id="info">
                                    <li>
                                        <p>
                                            Cliquea aqui para abrir el buscador de Indicadores.
                                        </p>
                                    </li>
                                </ul>
                            </li>
                            <?php
                            if (ISSET($_SESSION['usuario'])) {
                                ?>
                                <li style="float:right;"><a href="#" id="btn_perfil">Hola, <?php echo $_SESSION['usuario']['nombre_usuario'] ?></a>
                                    <ul id="info">
                                        <li>
                                            <p>
                                                Haga clic aqui para ver los detalles de su perfil en el sistema.
                                            </p>
                                        </li>
                                    </ul>
                                </li>
                                <?php
                            } else {
                                ?>
                                <li style="float:right;"><a href="#" id="btn_iniciarSesion">Iniciar sesión</a>
                                    <ul id="info">
                                        <li>
                                            <p>
                                                Ingrese al sistema para poder realizar diferentes acciónes, como opinar/comentar en los indicadores.
                                            </p>
                                        </li>
                                    </ul>
                                </li>
                            <?php
                            }
                            ?>							
                        </ul>
                    </div>
                    <div id="navegacionSecuencial" class="navegacionSecunciales">
                        <a href="inicio.php">Inicio - SIEE</a>&nbsp;&raquo;&nbsp;<span>Inicio - SEH</span>
                    </div>
                </div>
                <div id="LoadingSiteBar" class="loadingBarSite">
                    <span>Cargando ...</span>
                    <br/>
                    <img src="recursos/imagenes/loadingBar_gray.gif"/>
                </div>
            </div>
            <div id="contenedorInternoGlobal" class="contenidoGlobalInterno" tour-step="final">
                <div id="dialogWindow"></div>
                <?php include 'phpIncluidos/buscadorDeIndicadores.php'; ?>
                <?php include 'phpIncluidos/selectorUniversoBuscadorCentros.php'; ?>
                <table style="width: 100%;" cellspacing="0" cellpading="0">
                    <tr>
                        <td valign="top" class="leftTd">
                            <div id="leftPanel" class="leftPanelControl">
                                <div class="headerTitle">
                                    <div id="panelTitle" class="innerDiv">
                                        Panel  de Trabajo
                                    </div>
                                    <a id="controlMinMax" name="min" class="control" onclick="minMaxPanelTrabajo('leftPanel','controlMinMax')">
                                        &nbsp;&nbsp;&nbsp;&nbsp;</a>
                                </div>
                                <div id="panelContent" class="panelInnerContent">
                                <?php
                                include 'phpIncluidos/etiquetasDeUniverso.php';
                                include 'phpIncluidos/gruposDeIndicadores.php';
                                include 'phpIncluidos/cajaMasOpciones.php';
                                ?>
                                </div>
                            </div>
                        </td>
                        <td valign="top">
                            <div id="rightContentPanel" class="righContentPanel">
                                <div id="informationContent">
                                    <div id="seccionEncabezadoGeneralSitios"  tour-step="subsite_tour_4">
                                        <div class="seccionPromoSubsitio">
                                            <div class="tituloSitio">
                                                <img src="recursos/iconos/subSitesIconGray.png" />
                                                <span class="lineaDivisora">&nbsp;</span>
                                                <span class="h1">Sistema Escolar de Honduras</span>
                                                <br/>
                                                <span class="subH1">
                                                    Aqui encontrar&aacute; los datos Oficiales de estudiantes y establecimientos. Estos datos
                                                    se utilizan en todos los apuntadores del Sitio. Tambien contamos con una seccion
                                                    de descargas donde podra encontrar la misma informaci&oacute;n en archivos descargables
                                                    para trabajos externos. <a href="#" class="link">Ir al Centro de Descargas</a>.
                                                </span>
                                            </div>                                            
                                        </div>
                                    </div>
                                    <div id="espacioMapaHn" class="espacioMapa">                                        
                                    </div>
                                    <div id="espacioReportesDinamicos" class="espacioReportes"> 
                                    </div>
                                    <br/>
                                    <div id="espacioTablasDinamicas" class="espacioReportes"> 
                                    </div>
                                    <br />
                                    <div id="loadingGif" style="text-align: center; width: 100%; padding-top: 20px; background-color: #fff; border-bottom: 1px solid #cccccc;
                                         color: #bbbbbb; border-top: 1px solid #cccccc; font-size: 11pt; padding-bottom: 16px; display: none;">
                                        Agregando Indicador(es) a Contenido . . . 
                                        <br/>
                                        <br/>
                                        <img src="recursos/imagenes/loading1.gif" />
                                    </div>
                                    <div id="contenedorIndicadores">
                                    </div>
                                    <div id="dialogWindow_contenido" style="display:none;"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <footer>
                <?php include 'phpIncluidos/footerSiee.php'; ?>
            </footer>
        </div>
    </body>
    <script type="text/javascript" src="fancyBox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="fancyBox/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="chartsLib/Highcharts-2.3.2/js/highcharts.js"></script>
    <script type="text/javascript" src="javascript/chartsJs.js"></script>
    <script type="text/javascript" src="chartsLib/Highcharts-2.3.2/js/modules/exporting.js"></script>
    <script type="text/javascript" src="javascript/sieeMenuJs.js"></script>
    <!--script type="text/javascript" src="jqueryLib/html2canvas/initCanvas.js"></script-->
    <script type="text/javascript" src="jqueryLib/tipsy-0.1.7/jquery.tipsy.js"></script>
    <script type="text/javascript" src="javascript/jsSitio.js"></script>
    <script type="text/javascript">
        var dropdown = new sieeHMenu.dropdown.init("dropdown", { id: 'menu', active: 'menuhover' });
    </script>    
    
    <script type="text/javascript" src="jqueryLib/caretPos/jquery.caret.js"></script>
    <!--script type="text/javascript" src="jqueryLib/jQuerySIEETour/js/jquery.easing.1.3.js"></script-->
    <!--?php
    if ($en_tour) {
        echo '<script type="text/javascript" src="jqueryLib/jQuerySIEETour/js/sieeTour_B.js"></script>';
    }
    ?-->
</html>