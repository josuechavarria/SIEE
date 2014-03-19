<?php
include 'phpIncluidos/conexion.php';

if (ISSET($_SESSION['usuario'])) {
    if ($_SESSION['usuario']['rol']['es_administrador'] == 0) {
        header('Location: inicio.php');
        exit;
    }
} else {
    header('Location: inicio.php');
    exit;
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9, IE=8"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="css/estiloGeneral.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="css/estiloAdministracion.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="fancyBox/jquery.fancybox-1.3.4.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="jqueryLib/tipsy-0.1.7/tipsy.css" />
        <link rel="stylesheet" type="text/css" href="jQueryUI/jquery-ui-1.8.23.custom/css/custom-theme/jquery-ui-1.8.23.custom.css"  />
        <link rel="stylesheet" type="text/css" href="jqueryLib/multiselect/css/ui.multiselect.css" />
        <script src="javascript/html5.js" type="text/javascript"></script>
        <title>Administraci&oacute;n</title>
        <link rel="SHORTCUT ICON" href="siee_favicon.ico" />
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
                            Administraci&oacute;n - SIEE</h2>
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
                            <li><a>Operaciones r&aacute;pidas</a>
                                <ul name="subMenuUl" class="boxShadowMenu">
                                    <li>
                                        <a href="#" onclick="abrirSeccionAdmin(2,1)">Nuevo Indicador</a>
                                    </li>
                                    <li>
                                        <a href="#" onclick="abrirSeccionAdmin(2,2)">Publicar Indicadores</a>
                                    </li>
                                    <li>
                                        <a href="#" onclick="abrirSeccionAdmin(13,1)">Subir archivo</a>
                                    </li>
                                    <li>
                                        <a href="#" onclick="abrirSeccionAdmin(4,1)">Crear usuario</a>
                                    </li>
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
            <div id="contenedorInternoGlobal" class="contenidoGlobalInterno">
                <table style="width: 100%;" cellspacing="0" cellpading="0">
                    <tr>
                        <td valign="top" class="leftTd">
                            <div id="leftPanel" class="leftPanelControl">
                                <div class="headerTitle">
                                    <div id="panelTitle" class="innerDiv">
                                        Panel de Administraci&oacute;n
                                    </div>                             
                                </div>
                                <div id="panelContent" class="panelInnerContent">
                                    <div class="cajaOpciones">
                                        <div class="headerTitle"><br/>Series de Indicadores&nbsp;</div> 
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/plus.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(1,1)">Registrar nueva</div>
                                        </div>   
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/pencil.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(1,2)">Modificar serie</div>
                                        </div>
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/traffic-light.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(1,3)">Activar / Desactivar</div>
                                        </div>                                       
                                        <br/>
                                    </div>
                                    <div class="cajaOpciones">
                                        <div class="headerTitle"><br/>Indicadores&nbsp;</div> 
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/plus.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(2,1)">Registrar nuevo</div>
                                        </div>                                       
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/megaphone.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(2,2)">Publicar indicador(es)</div>
                                        </div>
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/pencil.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(2,3)">Modificar indicador</div>
                                        </div>
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/chain--plus.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(2,4)">Relaci&oacute;n entre indicadores</div>
                                        </div>
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/control-record.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(2,5)">Desactivar indicador(es)</div>
                                        </div>
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/date.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(2,6)">A&ntilde;o base</div>
                                        </div>
                                        <br/>
                                    </div>
                                    <div class="cajaOpciones">
                                        <div class="headerTitle"><br/>Grupos de Indicadores&nbsp;</div> 
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/plus.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(3,1)">Crear nuevo grupo</div>
                                        </div>
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/pencil.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(3,2)">Modificar grupo</div>
                                        </div>
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/traffic-light.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(3,3)">Activar / Desactivar</div>
                                        </div>
                                        <br/>
                                    </div>
                                    <div class="cajaOpciones">
                                        <div class="headerTitle"><br/>Usuarios&nbsp;</div> 
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/user--plus.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(4,1)">Registrar nuevo usuario</div>
                                        </div>
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/user--pencil.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(4,2)">Modificar usuario</div>
                                        </div>
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/user--minus.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(4,3)">Act. / Desact. usuario(s)</div>
                                        </div>
                                        <br/>
                                    </div>
                                    <div class="cajaOpciones">
                                        <div class="headerTitle"><br/>Otras Parametrizaciones&nbsp;</div> 
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/globe--plus.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(5,1)">Subsitios</div>
                                        </div> 
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/funnel.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(6,1)">Tipos de desagregaci&oacute;n</div>
                                        </div> 
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/funnel.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(7,1)">Tipos de matricula</div>
                                        </div> 
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/educTipes.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(8,1)">Tipos de educaci&oacute;n</div>
                                        </div>

                                        <div class="items">
                                            <div class="espacioIcono">
                                                <img src="recursos/iconos/databases.png"/>
                                            </div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(14,1)">
                                                Fuentes de datos
                                            </div>
                                        </div>

                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/calendar.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(9,1)">A&ntilde;os de referencia</div>
                                        </div>
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/levels.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(10,1)">Niveles Educativos</div>
                                        </div>
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/license-key.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(11,1)">Tipos de perfil/Rol</div>
                                        </div>

                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/grade-persons.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(12,1)">Poblaci&oacute;n estimada</div>
                                        </div>

                                        <div class="items">
                                            <div class="espacioIcono">
                                                <img src="recursos/iconos/folder.png"/>
                                            </div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(13,1)">
                                                Archivos
                                            </div>
                                        </div>
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/book_open.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(15,1)">Glosario</div>
                                        </div>
                                        <div class="items">
                                            <div class="espacioIcono"><img src="recursos/iconos/database-import.png"/></div>
                                            <div class="espacioDescripcion" onclick="abrirSeccionAdmin(16,1)" grav="sw" title="Ayuda a migrar estadistica de nuevos años de la aplicación SEE hacia el SIEE.">Migracion  de datos</div>
                                        </div>
                                        <br/>
                                    </div>                                    
                                </div>
                            </div>
                        </td>
                        <td valign="top">
                            <div id="rightContentPanel" class="righContentPanel">
                                <div id="informationContent">
                                    <div id="seccionEncabezadoGeneralSitios">
                                        <div class="seccionPromoSubsitio">
                                            <div class="tituloSitio">
                                                <img src="recursos/iconos/administracionSiee.png" />
                                                <span class="lineaDivisora">&nbsp;</span>
                                                <span class="h1">Secci&oacute;n Administrativa</span>
                                                <br/>
                                                <span class="subH1">
                                                    Esta secci&oacute;n tiene el control de los datos e indicadores que se muestran en el 
                                                    sitio web, as&iacute; como la administraci&oacute;n de usuarios del sistema entre otros.
                                                </span>
                                            </div>                                            
                                        </div>
                                    </div>
                                    <div id="espacioProcesosAdministrativos" class="espacioProcesosAdmon">                                        
                                    </div>
                                    <div id="loadingGif" style="text-align: center; width: 100%; padding-top: 20px; background-color: #fff; border-bottom: 1px solid #cccccc;
                                         color: #bbbbbb; border-top: 1px solid #cccccc; font-size: 11pt; padding-bottom: 16px; display: none;">
                                        Cargando, espere porfavor . . . 
                                        <br/>
                                        <img src="recursos/imagenes/loading1.gif" />
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
    </body>
    <script type="text/javascript" src="jqueryLib/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="javascript/jsSitio.js"></script>
    <script type="text/javascript" src="jQueryUI/jquery-ui-1.8.23.custom/js/jquery-ui-1.8.23.custom.min.js"></script>
    <script type="text/javascript" src="jqueryLib/tipsy-0.1.7/jquery.tipsy.js"></script>
    <script type="text/javascript" src="jqueryLib/caretPos/jquery.caret.js"></script>
    <script type="text/javascript" src="fancyBox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="fancyBox/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="jqueryLib/multiselect/js/ui.multiselect.js"></script>
    <script type="text/javascript" src="jqueryLib/multiselect/js/plugins/localisation/jquery.localisation-min.js"></script>
    <script type="text/javascript" src="javascript/sieeMenuJs.js"></script>
    <script type="text/javascript">
        var dropdown = new sieeHMenu.dropdown.init("dropdown", { id: 'menu', active: 'menuhover' });
    </script>
    <script type="text/javascript" id="espacioJavascript">
    </script>
</html>