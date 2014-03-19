<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9, IE=8"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/estiloGeneral.css" />
    <link rel="stylesheet" type="text/css" href="css/estiloInicio.css" />
    <link rel="stylesheet" type="text/css" href="fancyBox/jquery.fancybox-1.3.4.css" media="screen" />
    <script src="javascript/html5.js" type="text/javascript"></script>    
    <style rel="stylesheet" type="text/css" >
        .titulo
        {
            font-size: 20pt;
            color: #aaaaaa;
            padding-top: 10px;
            border-bottom: 1px solid  #aaaaaa;
            text-align: left;
            padding-bottom: 10px;
            text-shadow: 0px 1px 0px #000;
        }
        .contenido
        {
            padding-top: 30px;
            padding-bottom: 20px;
            text-align: left;
            color: #cccccc;
        }
    </style>
    <title>Error - Conexi&oacute;n</title>
</head>
<link rel="SHORTCUT ICON" href="siee_favicon.ico" />
<body>
    <div id="ContenedorGlobal" class="contenedorGlobal">
        <header id="sieeHeader">
            <h1>
                <a href="inicio.php">
                    <img alt="Ir a Inicio - SIEE" src="recursos/imagenes/logos/headerTitleLogo.png" />
                </a>
            </h1>
        </header>
        <div class="contendorAzulInicio">
            <div id="barraMenusInicio" class="barraMenuInicio">
                <div class="barraMenuInicioInterna">
                    &nbsp;</div>
            </div>
            <div class="contenedorSlide" style="height: 360px;">
                <div class="contenedorSlideInterno">
                    <div class="titulo">
                        Error al tratar de conectarse con la Base de Datos</div>
                    <div class="contenido">
                        Se ha producido un error de conexión con la base de datos. Es posible que el servidor
                        se encuentre muy ocupado en este momento. Por favor vuelva a intentar de nuevo en
                        unos pocos minutos.
                    </div>
                    <div style="width: auto; min-width: 960px; text-align: right; display: block;">
                        <span class="botones">
                            <label class="botonNormal">
                                <a id="return" href="inicio.php" tabindex="1">
                                    <input id="inputReturn" type="button" value="Ir a la p&aacute;gina de Inicio" />
                                </a>
                            </label>
                        </span>
                        &nbsp;
                        <!--span class="botones">
                            <label class="botonNormal">
                                <a id="return" href="javascript:history.go(-1)" tabindex="2">
                                    <input type="button" value="Regresar a la p&aacute;gina anterior" />
                                </a>
                            </label>
                        </span-->
                    </div>
                </div>
            </div>
            <div class="barraInferiorSlide">
            </div>
        </div>
        <footer>
            <div class="footerSiee">
                <div class="footerInterno">
                    <div class="texto">Secretaria de Educación | <a id="fancyCreditos" href="creditos_siee.html">&copy; Unidad de Infotecnología</a> | Desarrollado Por: <span>Wilfredo Rodríguez Guevara</span> | Tegucigalpa, Honduras C.A. | Abril, 2011<div class="escudoHonduras">&nbsp;</div></div>
                </div>
            </div>
        </footer>
    </div>
</body>
<script type="text/javascript" src="jqueryLib/jquery-1.8.2.min.js"/></script>
<script type="text/javascript" src="fancyBox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="fancyBox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript">
    $(document).ready(function() {         
        $("a#fancyCreditos").fancybox({
                'overlayShow'   : true,
                'transitionIn'  : 'elastic',
                'transitionOut' : 'elastic',
                'overlayColor'  : '#000',
                'easingIn'      : 'swing',
                'easingOut'     : 'swing',
                'autoDimensions': true,
                'centerOnScroll': true
        });
        
    });
    $('#inputReturn').click(function() {
        window.location.href = "inicio.php";
    }); 
</script>
</html>