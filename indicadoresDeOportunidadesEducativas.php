<?php
include 'phpIncluidos/conexion.php';
$subSitioId = 5;
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9, IE=8"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="description" content="En este Sitio encontrará indicadores sobre los avances y desaf&iacute;os pendientes del Sistema Educativo, desde el nacional hasta el nivel escolar." />
        <link rel="stylesheet" type="text/css" href="css/estiloGeneral.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/estiloOE.css"  media="screen"/>
        <link rel="stylesheet" type="text/css" href="fancyBox/jquery.fancybox-1.3.4.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="jqueryLib/tipsy-0.1.7/tipsy.css" />
        <link rel="stylesheet" type="text/css" href="jQueryUI/jquery-ui-1.8.23.custom/css/custom-theme/jquery-ui-1.8.23.custom.css" />
        <script src="javascript/html5.js" type="text/javascript"></script>        
        <script type="text/javascript" src="jqueryLib/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="jQueryUI/jquery-ui-1.8.23.custom/js/jquery-ui-1.8.23.custom.min.js"></script>
        <title>Indicadores OE</title>
        <link rel="SHORTCUT ICON" href="favicon_oe.png">
    </head>
    <body id="cuerpo">
        <div id="ContenedorGlobal" class="contenedorGlobal">
            <header id="sieeHeader">
                <?php include 'phpIncluidos/headerSiee.php'; ?>            
            </header>
            <div id="contenedorColores" class="contenedorMenusSubsitios">
                <div class="contenedorMenusSubsitiosInterno">
                    <div class="tituloSubsitios">
                        <h2 id="PageTitle" onclick="subiraPosInicial()">
                            Indicadores - OE</h2>
                    </div>
                    <div class="espacioMenuSubsitios">
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
                        <a href="inicio.php">Inicio - SIEE</a>&nbsp;&raquo;&nbsp;<span>Inicio - OE</span>
                    </div>
                </div>
                <div id="LoadingSiteBar" class="loadingBarSite">
                    <span>Cargando ...</span>
                    <br/>
                    <img src="recursos/imagenes/loadingBar_gray.gif"/>
                </div>
            </div>
            <div id="contenedorInternoGlobal" class="contenidoGlobalInterno">
                <div id="dialogWindow"></div>
                <?php include 'phpIncluidos/buscadorDeIndicadores.php'; ?>
                <?php include 'phpIncluidos/selectorUniversoBuscadorCentros.php'; ?>
                <table style="width: 100%;" cellspacing="0" cellpading="0">
                    <tr>
                        <td valign="top" class="leftTd">
                            <div id="leftPanel" class="leftPanelControl">
                                <div estado="1" class="headerTitle" onclick="AbrirCerrarPanelTrabajo()" title="Haz clic aqui para colapsar el panel de trabajo." grav="w">
                                    <div id="panelTitle" class="innerDiv">
                                        Panel  de Trabajo
                                    </div>
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
                                    <div id="seccionEncabezadoGeneralSitios">
                                        <div class="seccionPromoSubsitio">
                                            <div class="tituloSitio">
                                                <img src="recursos/iconos/subSitesIconGray.png" />
                                                <span class="lineaDivisora">&nbsp;</span>
                                                <span class="h1">Indicadores de Oportunidades Educativas</span>
                                                <br/>
                                                <span class="subH1">
                                                    Contiene los indicadores sobre los avances y desaf&iacute;os pendientes del Sistema Educativo,
                                                    desde el nacional hasta el nivel escolar. Tambien contamos con una seccion de descargas
                                                    donde podra encontrar la misma informaci&oacute;n en archivos descargables
                                                    para trabajos externos. <a href="#" class="link">Ir al Centro de Descargas</a>.
                                                </span>
                                            </div>                                            
                                        </div>                                        
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
    <script type="text/javascript" src="javascript/jsSitio.js?v=1"></script>
    <script type="text/javascript">
        var dropdown = new sieeHMenu.dropdown.init("dropdown", { id: 'menu', active: 'menuhover' });
    </script>
</html>