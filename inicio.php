<?php

include 'phpIncluidos/conexion.php';

/*if( $_SESSION["correr_tour"] && $_SESSION["inicio_tour"] && ($_SESSION["step_actual_tour"] == 1))
{
    $en_tour = true;
}
else
{
    $en_tour = false;
}*/

$stmt_subsitios = $conn->query(' SELECT * FROM siee_subsitio WHERE activo = 1 ORDER BY titulo');
$lst_subsitios = $stmt_subsitios->fetchAll();
$stmt_subsitios->closeCursor();

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9, IE=8"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="description" content="El SIEE permite a los usuarios en general obtener información estadistica de la educación en honduras, entre estos se encuentran indicadores que tratan sobre cobertura, deserción, repitencia, matricula, Riesgo escolar etc." />
        <meta name="google" content="notranslate" />

        <link rel="stylesheet" type="text/css" href="css/estiloGeneral.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="jQueryUI/jquery-ui-1.8.23.custom/css/custom-theme/jquery-ui-1.8.23.custom.css" />
        <!--link rel="stylesheet" type="text/css" href="jqueryLib/jQuerySIEETour/css/siee_tour.css" /-->
        <link rel="stylesheet" type="text/css" href="css/estiloInicio.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="fancyBox/jquery.fancybox-1.3.4.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="jqueryLib/tipsy-0.1.7/tipsy.css" />
        <link rel="stylesheet" type="text/css" href="jqueryLib/nivo-slider/nivo-slider.css" />
        <link rel="stylesheet" href="jqueryLib/nivo-slider/themes/dark/dark.css" type="text/css" media="screen" />
        <script src="javascript/html5.js" type="text/javascript"></script>
        <title>SIEE - inicio</title>
        <link rel="SHORTCUT ICON" href="favicon_siee.ico" />
    </head>
    <body>
        <div id="ContenedorGlobal" class="contenedorGlobal">
            <header id="sieeHeader" tour-step="siee_tour_0" style="background-color: #F1EFE8;">
                <h1>
                    <img alt="SIEE" src="recursos/imagenes/logos/headerTitleLogo.png" />
                </h1>
            </header>
            <div class="contendorAzulInicio">
                <div id="barraMenusInicio" class="barraMenuInicio">
                    <div class="barraMenuInicioInterna" tour-step="siee_tour_10">
                        <ul id="menu" class="menu">
                            <li><a href="../">Portal de estadistica</a>
                                <ul id="info">
                                    <li>
                                        <p>
                                            Regresa al portal de estadisticas de la secretaria de educación.
                                        </p>
                                    </li>
                                </ul>
                            </li>
                            <li><a>Secciones del SIEE</a>
                                <ul name="subMenuUl" class="boxShadowMenu">
                                    <?php
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
                </div>
                <div class="contenedorSlide">
                    <div class="contenedorSlideInterno">
                        <div class="slider-wrapper theme-dark">
                            <div id="slideShowSiee" class="nivoSlider">
                                <a href="http://www.se.gob.hn" target="_blank"><img src="recursos/imagenes/banners/seduc.png" alt="" title="#promoSEDUC" /></a>
                                <img src="recursos/imagenes/banners/img_00.jpg" alt="" />
                                <?php
                                $cont = 1;
                                foreach ($lst_subsitios as $subsitio) {
                                    echo '<a href="'.$subsitio['url'].'"><img src="recursos/imagenes/banners/'. strtolower(trim($subsitio['abreviatura'])) .'.png" alt="" title="#promo_'. strtolower(trim($subsitio['abreviatura'])) .'" /></a>';
                                    echo '<img src="recursos/imagenes/banners/img_0'. $cont .'.jpg" alt="" />';
                                    $cont += 1;
                                }
                                ?>
                            </div>
                        </div>
                        <div id="promoSEDUC" class="nivo-html-caption">
                            <strong>Secretaria de Educación de la Republica de Honduras</strong> Esta plataforma es desarrollada por la <em>Secretaria de educación de Honduras</em> para el manejo de la información
                            estadistica educativa. <a href="http://www.se.gob.hn">Visite nuestra página web</a>.
                        </div>
                        <?php
                        $cont = 1;
                        foreach ($lst_subsitios as $subsitio) {
                            echo '<div id="promo_'. strtolower(trim($subsitio['abreviatura'])) .'" class="nivo-html-caption">
                                    <strong>' . htmlentities($subsitio['titulo']) . '</strong>
                                        ' . htmlentities($subsitio['descripcion']) . '
                                        <a href="'.$subsitio['url'].'">Ir a esta sección</a>.
                                </div>';
                            $cont += 1;
                        }
                        ?>
                    </div>
                </div>
                <div class="barraInferiorSlide">
                    <div class="EspacioCooperantes">
                        <h3>Cooperantes: </h3>
                        <ul>
                            <li><a href="http://www.se.gob.hn" target="_blank"><img title="Secretaria de Educación de Honduras" grav="n" class="thumbnail fadedIn" src="recursos/imagenes/logos-cooperantes/seduc.png" height="52"/></a></li>
                            <li><a href="http://www.bancomundial.org/es/country/honduras" target="_blank"><img title="Banco mundial" grav="n" class="thumbnail fadedIn" src="recursos/imagenes/logos-cooperantes/bm.jpg" height="52"/></a></li>
                            <li><a href="http://www.sica.int/cecc/" target="_blank"><img title="CECC/SICA" grav="n" class="thumbnail fadedIn" src="recursos/imagenes/logos-cooperantes/ceccsica.png" height="52"/></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="ContenidoInicioSiee" class="contenidoInicio">
                <div class="contenidoInicioInterno">
                    <div tour-step="siee_tour_1" style="background-color: #fff;">
                        <div class="tituloInicio">
                            Sobre SIEE:
                        </div>
                        <div class="descripcionInicio">
                            En esta plataforma usted encuentra datos e indicadores estadisticos educativos para el Conocimiento y la
                            acci&oacute;n. Desde aqu&iacute; usted tiene acceso a todas las diferentes secciones del
                            <strong>Sistema de Indicadores Estad&iacute;sticos Educativos (SIEE)</strong>, Como ser:
                        </div>
                    </div>
                    <div class="descripcionInicio">
                        <ul class="detallesSubsitios">
                            <?php
                            foreach ($lst_subsitios as $subsitio) {
                                echo '<li>
                                        <div>
                                            <a href="'.$subsitio['url'].'" target="_blank"><img class="thumbnail" width="300" height="242" src="recursos/imagenes/secciones/'. strtolower(trim($subsitio['abreviatura'])). '.png"/></a>
                                        </div>
                                        <div>
                                            <h2>' . htmlentities($subsitio['titulo']) . '</h2>                                    
                                            <p style="height: 70px;">
                                                ' . htmlentities($subsitio['descripcion']) . '
                                            </p>
                                            


                                            <!--<p style="font-size: 10pt;margin-top:4px;">
                                                La siguiente lista muestra algunos de los indicadores contenidos en esta sección.
                                            </p>
                                            <ul>
                                                <li>Tasa neta de grado en preparatoria</li>
                                                <li>Cobertura en primer grado</li>
                                            </ul>-->


                                            <p><a style="text-decoration:none;" class="botonVerde" href="'.$subsitio['url'].'">Llevarme a esta sección &rightarrow; </a></p>
                                        </div>
                                    </li><hr class="puntedo"/>';
                            }
                        ?> 
                        </ul>
                    </div>
                </div>
            </div>
            <footer>
                <?php include 'phpIncluidos/footerSiee.php'; ?>
            </footer>
        </div>
    </body>
    <script src="jqueryLib/jquery-1.8.2.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="jQueryUI/jquery-ui-1.8.23.custom/js/jquery-ui-1.8.23.custom.min.js"></script>
    <script type="text/javascript" src="jqueryLib/nivo-slider/jquery.nivo.slider.pack.js"></script>
    <script type="text/javascript" src="fancyBox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="fancyBox/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="javascript/sieeMenuJs.js"></script>
    <!--script type="text/javascript" src="jqueryLib/html2canvas/initCanvas.js"></script-->
    <script type="text/javascript" src="jqueryLib/tipsy-0.1.7/jquery.tipsy.js"></script>
    <!--script type="text/javascript" src="jqueryLib/jQuerySIEETour/js/jquery.easing.1.3.js"></script-->
    <script type="text/javascript" src="javascript/jsSitio.js"></script>
    <script type="text/javascript">
        var dropdown = new sieeHMenu.dropdown.init("dropdown", { id: 'menu', active: 'menuhover' });
    </script>
    <!--?php
    if($en_tour){
        echo '<script type="text/javascript" src="jqueryLib/jQuerySIEETour/js/sieeTour_A.js"></script>';
    }
    ?-->
    <script type="text/javascript">
        $(window).load(function() {
            $('#slideShowSiee').nivoSlider({
                pauseOnHover: true,
                effect : 'fade'
            });
        });
    </script>
</html>