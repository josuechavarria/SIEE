<?php
include 'phpIncluidos/conexion.php';
$subSitioId = 6;
include 'phpIncluidos/dataDeBuscador.php';
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9, IE=8"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="css/estiloGeneral.css" />
        <link rel="stylesheet" type="text/css" href="css/estiloOeI.css" />
        <link rel="stylesheet" type="text/css" href="fancyBox/jquery.fancybox-1.3.4.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="jQueryUI/jquery-ui-1.8.23.custom/css/custom-theme/jquery-ui-1.8.23.custom.css" />
        <script src="javascript/html5.js" type="text/javascript"></script>        
        <script type="text/javascript" src="jqueryLib/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="jQueryUI/jquery-ui-1.8.23.custom/js/jquery-ui-1.8.23.custom.min.js"></script>
        <title>Indicadores OI</title>
        <link rel="SHORTCUT ICON" href="favicon_oi.png"/>
    </head>
    <body id="cuerpo" onload="$('#controlMinMax').trigger('click')">
        <div id="ContenedorGlobal" class="contenedorGlobal">
            <header id="sieeHeader">
                <?php include 'phpIncluidos/headerSiee.php'; ?>            
            </header>
            <div id="contenedorColores" class="contenedorMenusSubsitios">
                <div class="contenedorMenusSubsitiosInterno">
                    <div class="tituloSubsitios">
                        <h2 id="PageTitle" onclick="subiraPosInicial()">
                            Indicadores - OI</h2>
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
                            <li><a>Ir a&nbsp;&nbsp;&#187;</a>
                                <ul name="subMenuUl" class="boxShadowMenu">
                                    <li><a href="sistemaEscolarDeHonduras.php" id="seh" original-title="''Sistema Escolar de Honduras''"
                                           onmouseover="toolTipPequenio(this.id)">Sist. Escolar de Honduras</a></li>
                                    <li><a href="indicadoresDeCoberturaCalidad.php" id="CC" original-title="''Cobertura y Calidad''"
                                           onmouseover="toolTipPequenio(this.id)">Indicadores CC</a></li>                                    
                                    <li><a href="indicadoresMetasEfa.php" id="efa" original-title="''Educación para Todos''"
                                           onmouseover="toolTipPequenio(this.id)">Indicadores EFA</a></li>
                                    <li><a href="indicadoresEducativosDeComparacionInternacional.php" id="eci" original-title="''Educativos de Comparación Internacional''"
                                           onmouseover="toolTipPequenio(this.id)">Indicadores ECI</a></li>
                                    <li><a href="indicadoresDeOportunidadesEducativas.php" id="oe" original-title="''Oportunidades Educativas''"
                                           onmouseover="toolTipPequenio(this.id)">Indicadores OE</a></li>
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
								if (ISSET($_SESSION['usuario'])){
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
								}else{
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
                        <a href="inicio.php">Inicio - SIEE</a>&nbsp;&raquo;&nbsp;<span>Inicio - OI</span>
                    </div>
                </div>
                <div id="LoadingSiteBar" class="loadingBarSite">
                    <span>Cargando ...</span>
                    <br/>
                    <img src="recursos/imagenes/loadingBar_gray.gif"/>
                </div>
            </div>
            <div id="contenedorInternoGlobal" class="contenidoGlobalInterno">
                <?php /*include 'phpIncluidos/buscadorDeIndicadores.php';*/ ?>
                <div id="dialogWindow"></div>
                <?php include 'phpIncluidos/selectorUniversoBuscadorCentros.php'; ?>
                <table style="width: 100%;" cellspacing="0" cellpading="0">
                    <tr>
                        <td valign="top" class="leftTd">
                            <div id="leftPanel" class="leftPanelControl">
                                <div class="headerTitle">
                                    <div id="panelTitle" class="innerDiv">
                                        Panel de Trabajo</div>
                                    <a id="controlMinMax" name="min" class="control" onclick="minMaxPanelTrabajo('leftPanel','controlMinMax')">
                                        &nbsp;&nbsp;&nbsp;&nbsp;</a>
                                </div>
                                <!--div id="panelContent" class="panelInnerContent"> 
                                <?php
                                    include 'phpIncluidos/cajaMasOpciones.php';
                                ?>
                                </div-->
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
                                                <span class="h1">Indicadores de Ofertas e Insumos</span>
                                                <br/>
                                                <span class="subH1">
                                                    Contiene indicadores Nacionales sobre los recursos, programas
                                                    y financiamiento del Sistema Educativo. Tambien contamos con una seccion de descargas
                                                    donde podra encontrar la misma informaci&oacute;n en archivos descargables
                                                    para trabajos externos. <a href="seccionDescargas.php" class="link" target="_blank">Ir al Centro de Descargas</a>.
                                                </span>
                                            </div>                                            
                                        </div>                                        
                                    </div>
                                    <br />
                                    <!--div id="contenedorIndicadores">
                                    </div-->
                                    <div id="dialogWindow_contenido" style="display:none;"></div>
                                    <div  style="text-align: center;">
                                        <?php include 'phpIncluidos/mensajeBajoConstruccion.php'; ?>
                                    </div>                                    
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
        <input id="anioGlobalDeData" style="display:none;" value=""/>
        <input id="departamentoGlobalDeData" style="display:none;" value=""/>
        <input id="municipioGlobalDeData" style="display:none;" value=""/>
        <input id="centroEduGlobalDeData" style="display:none;" value=""/>
    </body>
<script type="text/javascript" src="jqueryLib/tipsy-0.1.7/jquery.tipsy.js"></script>
<script type="text/javascript" src="fancyBox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="fancyBox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="chartsLib/Highcharts-2.3.2/js/highcharts.js"></script>
<script type="text/javascript" src="javascript/chartsJs.js"></script>
<script type="text/javascript" src="chartsLib/Highcharts-2.3.2/js/modules/exporting.js"></script>
<script type="text/javascript" src="javascript/sieeMenuJs.js"></script>
<script type="text/javascript" src="javascript/jsSitio.js"></script>
<script type="text/javascript">
    var dropdown = new sieeHMenu.dropdown.init("dropdown", { id: 'menu', active: 'menuhover' });
    $('#controlMinMax').tipsy({
        fallback: "Cliquea para Minimizar este panel.",
        gravity :   'w'
    });
</script>
<script type="text/javascript" src="javascript/jsSitio.js"></script>
<script type="text/javascript" id="espacioJavascript">
</script>
</html>