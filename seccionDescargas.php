<?php
include 'phpIncluidos/conexion.php';
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9, IE=8"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="description" content="Sección de descargas del Sistema de indicadores estadisticos educativos de la Republica de Honduras." />
        <link rel="stylesheet" type="text/css" href="css/estiloGeneral.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/estiloAdministracion.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="css/estiloDescargas.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="fancyBox/jquery.fancybox-1.3.4.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="jqueryLib/tipsy-0.1.7/tipsy.css" />
        <link rel="stylesheet" type="text/css" href="jQueryUI/jquery-ui-1.8.23.custom/css/custom-theme/jquery-ui-1.8.23.custom.css" />
        <script src="javascript/html5.js" type="text/javascript"></script>        
        <script type="text/javascript" src="jqueryLib/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="jQueryUI/jquery-ui-1.8.23.custom/js/jquery-ui-1.8.23.custom.min.js"></script>
        <title>Descargas - SIEE</title>
        <!--link rel="SHORTCUT ICON" href="seh_favicon.png" /-->
    </head>
    <body id="cuerpo">
        <div id="ContenedorGlobal" class="contenedorGlobal">
            <header id="sieeHeader">
                <?php include 'phpIncluidos/headerSiee.php'; ?>            
            </header>
            <div id="contenedorColores" class="contenedorMenusSubsitios">
                <div class="contenedorMenusSubsitiosInterno">
                    <div class="tituloSubsitios">
                        <h2 id="PageTitle" style="">
                            SIEE - Descargas</h2>
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
                        <a href="inicio.php">Inicio - SIEE</a>&nbsp;&raquo;&nbsp;<span>Inicio - Descargas</span>
                    </div>
                </div>
            </div>
            <div id="contenedorInternoGlobal" class="contenidoGlobalInterno">
                <table style="width: 100%;" cellspacing="0" cellpading="0">
                    <tr>
                        <td valign="top" style="background-color: #eeeeee; border-right: 1px solid #666666; width: 28px; vertical-align: top;">
                            <div id="leftPanel" class="leftPanelControl">
                                <div class="headerTitle">
                                    <div id="panelTitle" class="innerDiv">
                                        Panel de Opciones
                                    </div>                     
                                    <a id="controlMinMax" name="min" class="control" onclick="minMaxPanelTrabajo('leftPanel','controlMinMax')">
                                        &nbsp;&nbsp;&nbsp;&nbsp;</a>                             
                                </div>
                                <div id="panelContent" class="panelInnerContent">
                                    <br/>
                                    <div class="cajaOpciones">
                                        <div class="headerTitle"><br/>&nbsp;</div>
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/table-excel.png"/></div>
                                            <div class="espacioDescripcion" file="excel" onclick="cargarArchivo(this)">Reportes Excel</div>
                                        </div>
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/report_word.png"/></div>
                                            <div class="espacioDescripcion" file="word" onclick="cargarArchivo(this)">Reportes Word</div>
                                        </div>
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/page_white_acrobat.png"/></div>
                                            <div class="espacioDescripcion" file="pdf" onclick="cargarArchivo(this)">Reportes PDF</div>
                                        </div>
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/page_white_powerpoint.png"/></div>
                                            <div class="espacioDescripcion" file="powerpoint" onclick="cargarArchivo(this)">Presentaciones Power point</div>
                                        </div>
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/images.png"/></div>
                                            <div class="espacioDescripcion" file="image" onclick="cargarArchivo(this)">Imagenes</div>
                                        </div>
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/applications-blue.png"/></div>
                                            <div class="espacioDescripcion" file="exe" onclick="cargarArchivo(this)">Aplicaciones</div>
                                        </div>
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/applications-blue.png"/></div>
                                            <div class="espacioDescripcion" file="otros" onclick="cargarArchivo(this)">Otros</div>
                                        </div>
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/applications-blue.png"/></div>
                                            <div class="espacioDescripcion" file="todos" onclick="cargarArchivo(this)">Todos los archivos</div>
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
                                        <div class="seccionPromoSubsitio">
                                            <div class="tituloSitio">
                                                <img src="recursos/iconos/download_48px.png" />
                                                <span class="lineaDivisora">&nbsp;</span>
                                                <span class="h1">Secci&oacute;n de Descargas</span>
                                                <br/>
                                                <span class="subH1">
                                                    Seleccione del panel izquierdo le tipo de archivo que busca para descargar.
                                                </span>
                                            </div>                                            
                                        </div>                                        
                                    </div>
                                    <br/>
                                    <div class="espacioProcesosAdmon" style="display:block;">
                                        <div id="tabsSerieIndicadores" class="contenido">
                                            <ul>
                                                <li>
                                                    <a href="#tabsDescargas-1">SIEE descargas</a>
                                                </li>
                                            </ul>
                                            <div id="tabsDescargas-1">
                                                <div class="formularios">
                                                    <div class="CamposFormulario">
                                                        <div class="itemsFormularios">
                                                            <div class="contenidoBuscador">
                                                                <label for="buscadorArchivo" style="max-width: 400px;">Escriba aqui un titulo relacionado al archivo que busca:</label>
                                                                <p>
                                                                    <input id="buscadorArchivo" type="text" onkeyup='filtroDeArchivo(this.value)' style="width:680px;" />
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="listado" id="panelListadoDeArchivo" style="height:auto;max-height:600px">
                                                            <br />
                                                            <div id="loadingGif" style="text-align: center; width: 100%; padding-top: 20px; background-color: #fff; border-bottom: 1px solid #cccccc;
                                                                color: #bbbbbb; border-top: 1px solid #cccccc; font-size: 11pt; padding-bottom: 16px; display: none;">
                                                                <br/><br/><img src="recursos/imagenes/loading1.gif" />
                                                            </div>
                                                            <ul id="listadoDeArchivos">
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="dialogWindow" style="display:none;"></div>
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
    <script type="text/javascript" src="jqueryLib/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="javascript/jsSitio.js"></script>
    <script type="text/javascript" src="jQueryUI/jquery-ui-1.8.23.custom/js/jquery-ui-1.8.23.custom.min.js"></script>
    <script type="text/javascript" src="jqueryLib/tipsy-0.1.7/jquery.tipsy.js"></script>
    <script type="text/javascript" src="fancyBox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="fancyBox/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="javascript/sieeMenuJs.js"></script>
    <script type="text/javascript">
        
      
        
        var dropdown = new sieeHMenu.dropdown.init("dropdown", { id: 'menu', active: 'menuhover' });
        $(function() {        
            $( "#tabsSerieIndicadores" ).tabs();
        });
        
        /**
         *
         */
        function cargarArchivo(elem) {
            var ext = $(elem).attr('file');
            var urlicono = $(elem).parent().find('img').attr('src');
            var texto = $(elem).text();			
			
            $('#loadingGif').stop(true, true).fadeIn('fast');
            
            $.ajax({
                type: "POST",
                url: "phpIncluidos/listaDeArchivosDescargables.php",
                dataType: 'json',
                data: {
                    extension      :    ext
                },
                error: function(){
                    $('#loadingGif').stop(true, true).fadeOut('fast');
                    var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexion. Porfavor, intentalo de nuevo.</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                        
                    });
                },
                success: function(resp)
                {
                    $('#tabsSerieIndicadores ul li a').html('<img src="' + urlicono + '" />&nbsp;' + texto);
                    $('#loadingGif').stop(true, true).fadeOut('fast');
                    $('#listadoDeArchivos').stop(true,true).fadeOut("fast", function(){
                        var titulos = new Array();
                        $('#listadoDeArchivos').html('');
                        for(var key in resp){
                            titulos.push(resp[key].titulo);
                            $('#listadoDeArchivos').append(
                            '<li titulo_archivo="' + resp[key].titulo +  '(' + resp[key].extension + ')">' +
                                '<div class="descripcion">' +
                                '<div class="items">' +
                                '<span style="font-weight: bold;">' + resp[key].titulo + '</span>(' + resp[key].extension + ')' + 
                                '</div>' +

                                '<div class="items">' + resp[key].descripcion + '</div>' +
                                '</div>'+

                                '<div class="opciones">' +
                                '<a href="administracion/descargar_archivo.php?id=' + resp[key].id + '">Descargar</a>' +
                                '</div>' +
                                '</li>'
                        );
                        }
                        $(this).fadeIn("fast");
                        $('#buscadorArchivo').autocomplete({source:titulos});
                    });
                }
                
            });
        }
        function filtroDeArchivo(str){
            $('#listadoDeArchivos li').css('display', 'none');
            str = $.trim(str);

            if (str == "")
            {
                $('#listadoDeArchivos li').fadeIn('fast');
            }
            else
            {
                $('#listadoDeArchivos [titulo_archivo*="'+ str +'"]').fadeIn('fast');
            }
        }
    </script>
</html>