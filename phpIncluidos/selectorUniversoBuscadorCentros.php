<iframe id="iframeDownloader" src="" style="display:none; visibility:hidden;"></iframe>
<?php 
include_once 'conexion.php';
include_once 'conexion_ee.php';
$stmt_aniosDisponibles = $conn->query(" SELECT DISTINCT periodo_id as anio FROM siee_resumen_data_indicadores WHERE es_inicial = 1 AND tipo_indicador_id = 7 ORDER BY periodo_id DESC ");
$lista_aniosDisponibles = $stmt_aniosDisponibles->fetchAll();
$stmt_aniosDisponibles->closeCursor();

$stmt_departamentos = $conn_ee->query(' SELECT *
                                        FROM ee_departamentos
                                        WHERE id <> 19
                                        ORDER BY descripcion_departamento');
$lista_departamentos = $stmt_departamentos->fetchAll();
$stmt_departamentos->closeCursor();


?>
<div id="panelBusquedas" class="pBusquedas" tour-step="subsite_tour_10">
    <ul class="headerPaneles">
        <li class="liInicial">&nbsp;</li>
        <li id="titulo_panelSelUniversoBusqueda" class="liSelected" onclick="mostrarPanelUniversoGlobalDatos(this.id)">Selecci&oacute;n de Universo</li>
        <li id="titulo_panelRealizarBusqueda" class="" onclick="mostrarPanelUniversoGlobalDatos(this.id)">Buscar Centro Educativo</li>
        <li class="liFinal">Panel de Selecci&oacute;n Universo de "Indicadores"/B&uacute;squeda C.E. del SIEE&nbsp;&nbsp;|&nbsp;<a class="cerrarBusqueda" style="background-color:#fff;" onclick="cerrarPanelSeleccionUniversos()" tour-step="subsite_tour_11">Cerrar</a></li>
    </ul>
    <div id="panelSelUniversoBusqueda" class="contenidoPaneles">                    
        <div class="opcionesUniverso" name="mostrarSiempre">
            <div class="item">
                <label><img src="recursos/iconos/calendar-select.png"/>&nbsp;Escoja un a&ntilde;o.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </label>
                <select id="selectorDataAnioGlobal" onchange="cambiarAnioGlobal(this)">
                    <?php
                    foreach ($lista_aniosDisponibles as $anio) {
                        echo '<option value=' . $anio['anio'] . '>' . $anio['anio'] . '</option>';
                    }
                    ?>                          
                </select>
            </div>
            <div class="item">
                <label><img src="recursos/iconos/mapGreen.png"/>&nbsp;Selecciona Departamento : </label>
                <select id="selectorDataDepartamentoGlobal" class="selectorFiltros" style="text-align: left;" onchange="cambiarDepartamentoGlobal(this)">
                    <option value="0">Todos</option>
                    <?php
                    foreach ($lista_departamentos as $depto) {
                        echo '<option value="' . $depto['id'] . '">' . htmlentities(ucwords(strtolower($depto['descripcion_departamento']))) . '</option>';
                    }
                    ?>                    
                </select>
            </div>
        </div>
        <div class="opcionesUniverso" name="mostrarParcialmente">
            <div class="item" name="mostrarParcialmente">
                <label name="mostrarParcialmente"><img name="mostrarParcialmente" src="recursos/iconos/mapBlue.png"/>&nbsp;Selecciona el Municipio&nbsp; : </label>
                <select id="selectorDataMunicipioGlobal" onchange="cambiarMunicipioGlobal(this)" disabled="disabled">
                    <option value="0">- - -</option>
                </select>
            </div>
            <!--div class="item" name="mostrarParcialmente">
                <label name="mostrarParcialmente"><img src="recursos/iconos/levels.png" name="mostrarParcialmente"/>&nbsp;Escoja Nivel Educativo&nbsp;&nbsp;&nbsp; : </label>
                <select id="selectorNivelEducativoGlobal" name="mostrarParcialmente" disabled="disabled">
                    <option value="todos" name="mostrarParcialmente">Todos</option>
                    <option value="prebasica" name="mostrarParcialmente">Preb&aacute;sica</option>
                    <option value="basica" name="mostrarParcialmente">B&aacute;sica</option>
                    <option value="media" name="mostrarParcialmente">Media</option>
                </select>
            </div-->
        </div>
    </div>
    <div id="panelRealizarBusqueda" class="contenidoPaneles" style="display: none;">
        <div class="opcionesUniverso" style="margin-top: 10px; margin-left: 14px;" name="mostrarSiempre">                        
            <div class="buscadorCentrosEducativos">
                <div class="opcionesBusqueda">
                    <label for="BuscadorDeCentroEducativo">Buscar Centro Educat&iacute;vo:</label>
                        <input id="BuscadorDeCentroEducativo" class="busquedaNombre" type="text" value="" cod-ce="" desc-ce="" placeholder="Escriba aquí el código o nombre del centro educativo que necesita."/>
                </div>
                <div style="padding: 4px; float: left;">&nbsp;</div>
                <div id="btnBusquedaCentros" class="botonBusqueda" original-title="Presiona para utilizar el C.E. seleccionado."  onclick="centroEducativoGlobal()">
                    <img src="recursos/imagenes/btnBusquedaCentros.png" onclick="centroEducativoGlobal()"/>
                </div>
                <a id="verCentroEnMapaEducativo" class="linkVerCentroEnMapa" href="" title="">Ver en Mapa</a>
                <span id="separadorOpcionesCE" class="linkVerCentroEnMapa" style="color: #777; text-decoration: none;">|</span>
                <a id="masInformacionDeCentroeducativo" class="linkVerCentroEnMapa" style="box-shadow: -9px 0 4px #FFFFFF;" href="" title="">Más Informacion</a>
            </div>
        </div>
    </div>    
</div>
<script type="text/javascript">
    var listadoDeCentros = new Array();
    //obtenerCodigoCentro()  <-- funcion en el archivo jsSitio.js
    $( function(){
        $('#BuscadorDeCentroEducativo').autocomplete({
            source: function( request, response ) {
                $.ajax({
                    type: "GET",
                    url: "phpIncluidos/getDataSiee.php",
                    dataType: 'json',
                    cache : false,
                    data: {
                        opcion          :   1,
                        str_actual      :   request.term,
                        anio_global	:   $('#selectorDataAnioGlobal').val(),
                        departamento	:   $('#selectorDataDepartamentoGlobal').val(),
                        municipio	:   $('#selectorDataMunicipioGlobal').val()
                    },
                    error: function(){
                        var _html = "<p>Parece que hay un problema al realizar la busqueda, puede ser que en este momento la base de datos este muy ocupada, "+
                            "Por favor intenta esta acción de nuevo, también revisa tu conexión.</p>"
                        $( "#dialogWindow_contenido" ).html(_html);
                        $( "#dialogWindow_contenido" ).dialog({
                            'title'   : 'Error',
                            'modal'   : true,
                            'buttons' : { 
                                "ok": function() { 
                                    $(this).dialog("close"); 
                                } 
                            },
                            'minWidth': '600',
                            'resizable': false
                        });
                    },
                    success: function( data ) {
                        response( $.map( data.centros, function( item ) {
                            return {
                                label: item.codigo + " - " + item.nombre,
                                value: item.codigo + " - " + item.nombre,
                                centro_id : item.id
                            }
                        }));
                    }
                });
            },
            minLength: 2,
            select: function( event, ui ) {
                if( ui.item ){
                    //escogio un centro
                    $("#BuscadorDeCentroEducativo").attr('value', ui.item.label);
                }else{
                    $("#BuscadorDeCentroEducativo").attr('value', '');
                }
            }
        });
    });
</script>