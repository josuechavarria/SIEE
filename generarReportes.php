<?php
include 'phpIncluidos/conexion.php';
include 'phpIncluidos/conexion_ee.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt_listaDepartamentos = $conn_ee->query('    SELECT id as departamento_id, descripcion_departamento
                                                    FROM ee_departamentos
                                                    WHERE id <> 0
                                                    ORDER BY descripcion_departamento');

    $lista_departamentos = $stmt_listaDepartamentos->fetchAll();
    $stmt_listaDepartamentos->closeCursor();

    $stmt_listaGrados = $conn->query("  SELECT * FROM [siee_catalogo-grado]");
    $lista_grados = $stmt_listaGrados->fetchAll();
    $stmt_listaGrados->closeCursor();
    
    $stmt_aniosDisponibles = $conn->query(' SELECT DISTINCT periodo_id as anio
                                            FROM siee_resumen_data_indicadores
                                            WHERE es_inicial = 1 AND tipo_indicador_id = 7
                                            ORDER BY periodo_id DESC');
    $lista_aniosDisponibles = $stmt_aniosDisponibles->fetchAll();
    $stmt_aniosDisponibles->closeCursor();   
    
    $stmt_lista_estadistica = $conn->query("    SELECT DISTINCT TI.id, TI.nombre
                                                FROM siee_resumen_data_indicadores RDI
                                                INNER JOIN [siee_catalogo-tipos_indicador] as TI ON TI.id = RDI.tipo_indicador_id
                                                WHERE tipo_indicador_id <> 5
                                                ORDER BY TI.nombre");
    $lista_tipos_estadistica = $stmt_lista_estadistica->fetchAll();
    $stmt_lista_estadistica->closeCursor();
    
    $stmt_lista_discapacidades = $conn_ee->query(" SELECT id as discapacidad_id, descripcion_discapacidad as discapacidad
                                                FROM ee_discapacidades
                                                WHERE es_discapacidad = 1
                                                ORDER BY ordenamiento_discapacidad");
    $lista_discapacidades = $stmt_lista_discapacidades->fetchAll();
    $stmt_lista_discapacidades->closeCursor();
    
    $stmt_lista_tipos_electricidad = $conn_ee->query(" SELECT id as electricidad_id, descripcion_suministro
                                                    FROM ee_suministros_electricidad
                                                    WHERE id <> 4");
    $lista_tipos_electricidad = $stmt_lista_tipos_electricidad->fetchAll();
    $stmt_lista_tipos_electricidad->closeCursor();
    
    $stmt_lista_tipos_agua = $conn_ee->query(" SELECT id as tipo_agua_id, descripcion_tipo_agua
                                            FROM ee_tipo_agua
                                            WHERE id <> 4");
    $lista_tipos_agua = $stmt_lista_tipos_agua->fetchAll();
    $stmt_lista_tipos_agua->closeCursor();
    
    $stmt_lista_almacenamientos_agua = $conn_ee->query("   SELECT id as almacenamiento_id, descripcion_almacenamiento
                                                        FROM ee_almacenamiento_agua
                                                        WHERE id <> 5");
    $lista_almacenamientos_agua = $stmt_lista_almacenamientos_agua->fetchAll();
    $stmt_lista_almacenamientos_agua->closeCursor();
}
?>
<div id="seccionGeneraReportes" class="reporteria">
    <div id="seccionEncabezadoReporteria" class="encabezado">
        <div class="icono">
            <img src="recursos/iconos/preparaReporteIcon_48px.png" />
        </div>
        <div class="lineaVertical">&nbsp;</div>
        <div id="seccionDescripcionEncabezadoReporteria" class="descripcion">
            <div class="titulo">
                Preparar Reportes
                <div class="botonCerrarReporteria" onclick="cerrarPrepararReportes()">Cerrar Reporter&iacute;a</div> 
            </div>
            <div class="subTitulo">
                Despliega una lista de Reportes Pre-definidos, usted podr&aacute; aplicar filtros que generen
                informaci&oacute;n deacuerdo a su necesidad.
            </div>
        </div>
    </div>
    <div class="contenido">
        <!-- FILTROS GENERALES -->
        <div class="cajas" style="border: 1px solid #6480a5; background-color: #f1f1f1;">
            <div class="titulo" style="border-bottom: 1px dotted #6480a5;">
                <img src="recursos/iconos/funnel-pencil.png"/>&nbsp;&nbsp;Filtros Generales :
            </div>
            <div class="items">
                <label><img src="recursos/iconos/calendar-select.png"/>&nbsp;Escoja un a&ntilde;o : </label>
                <select id="filtroGral_anio">
                    <?php
                        foreach( $lista_aniosDisponibles as $anioDisponible )
                        {
                            echo '<option value=' . $anioDisponible['anio'] . '>' . $anioDisponible['anio'] . '</option>';
                        }
                    ?>                    
                </select>
            </div>
            <div class="items" style="font-size: 12pt; color: #aaaaaa;">
                &nbsp;|&nbsp;
            </div>
            <div class="items">
                <label><img src="recursos/iconos/levels.png"/>&nbsp;Escoja Nivel Educativo : </label>
                <select id="filtroGral_niveles" disabled="disabled">
                    <option value="todos">Todos</option>
                    <option value="Prebasica">Preb&aacute;sica</option>
                    <option value="Basica">B&aacute;sica</option>
                    <option value="Media">Media</option>
                </select>
            </div>
        </div>
        <!--    FIN    -->
        <div class="asteriscos"><span>*&nbsp;</span>Campos Opcionales</div>
        <div class="cajas">
            <div class="titulo">
                <img src="recursos/iconos/reports-stack.png"/>&nbsp;&nbsp;Listado de Reportes de Estudiantes por Departamentos : 
            </div>
            <div class="items">
                <div class="itemReporte">
                    <div class="itemRepL">
                        <img src="recursos/iconos/report.png"/>&nbsp;Por Tipo de Administraci&oacute;n.
                    </div>                    
                    <div class="itemRepR">
                        <div id="reporteDeptoAdmon_boton" class="botonGenerarReporte" onclick="cargarReporteSeleccionadoGr(this.id, '1')">
                            Generar</div>
                    </div>
                    <div style="float: right;">&nbsp;</div>
                    <div class="itemRepR">
                        <span>*</span>
                        <label ><img src="recursos/iconos/grade-persons.png"/>&nbsp;Grado : </label>
                        <select id="reporteDeptoAdmon_grado">
                            <option value="todos">Todos</option>
                            <?php
                            foreach ($lista_grados as $grado) {
                                echo '<option value="' . $grado['id'] . '">' . htmlentities($grado['abreviatura_grado']) . '</option>';
                            }
                            ?>                    
                        </select>                                                             
                    </div>
                    <div style="float: right; font-size: 12pt; color: #aaaaaa;">&nbsp;|&nbsp;</div>
                    <div class="itemRepR">
                        <label><img src="recursos/iconos/chart-up.png"/>&nbsp;Indicador : </label>
                        <select id="reporteDeptoAdmon_indicador">
                            <?php
                                foreach( $lista_tipos_estadistica as $tipo_estadistica)
                                {
                                    echo '<option value="'. $tipo_estadistica['id'] .'">'. $tipo_estadistica['nombre'] .'</option>';
                                }
                            ?>                      
                        </select>
                    </div> 
                </div>                                                        
            </div>
            <div class="items">
                <div class="itemReporte">
                    <div class="itemRepL">
                        <img src="recursos/iconos/report.png"/>&nbsp;Por Tipo de Zona.
                    </div>
                    <div class="itemRepR">
                        <div id="reporteDeptoZona_boton" class="botonGenerarReporte" onclick="cargarReporteSeleccionadoGr(this.id, '2')">
                            Generar                            
                        </div>
                    </div>
                    <div style="float: right;">&nbsp;</div>
                    <div class="itemRepR">
                        <span>*</span>
                        <label><img src="recursos/iconos/grade-persons.png"/>&nbsp;Grado : </label>
                        <select id="reporteDeptoZona_grado">
                            <option value="todos">Todos</option>
                            <?php
                            foreach ($lista_grados as $grado) {
                                echo '<option value="' . $grado['id'] . '">' . htmlentities($grado['abreviatura_grado']) . '</option>';
                            }
                            ?>                    
                        </select>
                    </div>
                    <div style="float: right; font-size: 12pt; color: #aaaaaa;">&nbsp;|&nbsp;</div>
                    <div class="itemRepR">
                        <label><img src="recursos/iconos/chart-up.png"/>&nbsp;Indicador : </label>
                        <select id="reporteDeptoZona_indicador">
                            <?php
                                foreach( $lista_tipos_estadistica as $tipo_estadistica)
                                {
                                    echo '<option value="'. $tipo_estadistica['id'] .'">'. $tipo_estadistica['nombre'] .'</option>';
                                }
                            ?>                        
                        </select>
                    </div> 
                </div>                                                        
            </div>
            <!--div class="items">
                <div class="itemReporte">
                    <div class="itemRepL">
                        <img src="recursos/iconos/report.png"/>&nbsp;Por Condici&oacute;n de Edad.
                    </div>
                    <div class="itemRepR">
                        <div id="reporteDeptoCondEdad_boton" class="botonGenerarReporte" onclick="cargarReporteSeleccionadoGr(this.id, '3')">
                            Generar                            
                        </div>
                    </div>
                    <div style="float: right;">&nbsp;</div>
                    <div class="itemRepR">
                        <span>*</span>
                        <label><img src="recursos/iconos/grade-persons.png"/>&nbsp;Grado : </label>
                        <select id="reporteDeptoCondEdad_grado">
                            <option value="todos">Todos</option>
                            <?php
                            foreach ($lista_grados as $grado) {
                                echo '<option value="' . $grado['id'] . '">' . htmlentities($grado['abreviatura_grado']) . '</option>';
                            }
                            ?>                    
                        </select>
                    </div>
                    <div style="float: right; font-size: 12pt; color: #aaaaaa;">&nbsp;|&nbsp;</div>
                    <div class="itemRepR">
                        <label><img src="recursos/iconos/chart-up.png"/>&nbsp;Indicador : </label>
                        <select id="reporteDeptoCondEdad_indicador">
                            <?php
                                foreach( $lista_tipos_estadistica as $tipo_estadistica)
                                {
                                    echo '<option value="'. $tipo_estadistica['id'] .'">'. $tipo_estadistica['nombre'] .'</option>';
                                }
                            ?>                       
                        </select>
                    </div> 
                </div>                                                        
            </div-->
            <div class="items">
                <div class="itemReporte">
                    <div class="itemRepL">
                        <img src="recursos/iconos/report.png"/>&nbsp;Por Genero.
                    </div>
                    <div class="itemRepR">
                        <div id="reporteDeptoGenero_boton" class="botonGenerarReporte" onclick="cargarReporteSeleccionadoGr(this.id, '4')">
                            Generar                            
                        </div>
                    </div>
                    <div style="float: right;">&nbsp;</div>
                    <div class="itemRepR">
                        <span>*</span>
                        <label><img src="recursos/iconos/grade-persons.png"/>&nbsp;Grado : </label>
                        <select id="reporteDeptoGenero_grado">
                            <option value="todos">Todos</option>
                            <?php
                            foreach ($lista_grados as $grado) {
                                echo '<option value="' . $grado['id'] . '">' . htmlentities($grado['abreviatura_grado']) . '</option>';
                            }
                            ?>                    
                        </select>
                    </div>
                    <div style="float: right; font-size: 12pt; color: #aaaaaa;">&nbsp;|&nbsp;</div>
                    <div class="itemRepR">
                        <label><img src="recursos/iconos/chart-up.png"/>&nbsp;Indicador : </label>
                        <select id="reporteDeptoGenero_indicador">
                            <?php
                                foreach( $lista_tipos_estadistica as $tipo_estadistica)
                                {
                                    echo '<option value="'. $tipo_estadistica['id'] .'">'. $tipo_estadistica['nombre'] .'</option>';
                                }
                            ?>                            
                        </select>
                    </div>                    
                </div>                                                        
            </div>
        </div>
        <div class="cajas">
            <div class="titulo">
                <img src="recursos/iconos/reports-stack.png"/>&nbsp;&nbsp;Listado de Reportes de Estudiantes por Grado : 
            </div>
            <div class="items">
                <div class="itemReporte">
                    <div class="itemRepL">
                        <img src="recursos/iconos/report.png"/>&nbsp;Por Tipo de Administraci&oacute;n.
                    </div>
                    <div class="itemRepR">
                        <div id="reporteGradoAdmon_boton" class="botonGenerarReporte" onclick="cargarReporteSeleccionadoDpt(this.id, '1')">
                            Generar                            
                        </div>
                    </div>
                    <div style="float: right;">&nbsp;</div>
                    <div class="itemRepR">
                        <span>*</span>
                        <label><img src="recursos/iconos/map.png"/>&nbsp;Departamento : </label>
                        <select id="reporteGradoAdmon_depto" style="width: 110px;">
                            <option value="todos">Todos</option>
                            <?php
                            foreach ($lista_departamentos as $departamento) {
                                echo '<option value="' . $departamento['departamento_id'] . '">' . htmlentities($departamento['descripcion_departamento']) . '</option>';
                            }
                            ?>                      
                        </select>
                    </div>
                    <div style="float: right; font-size: 12pt; color: #aaaaaa;">&nbsp;|&nbsp;</div>
                    <div class="itemRepR">
                        <label><img src="recursos/iconos/chart-up.png"/>&nbsp;Indicador : </label>
                        <select id="reporteGradoAdmon_indicador">
                            <?php
                                foreach( $lista_tipos_estadistica as $tipo_estadistica)
                                {
                                    echo '<option value="'. $tipo_estadistica['id'] .'">'. $tipo_estadistica['nombre'] .'</option>';
                                }
                            ?>                         
                        </select>
                    </div> 
                </div>                                                        
            </div>
            <div class="items">
                <div class="itemReporte">
                    <div class="itemRepL">
                        <img src="recursos/iconos/report.png"/>&nbsp;Por Tipo de Zona.
                    </div>
                    <div class="itemRepR">
                        <div id="reporteGradoZona_boton" class="botonGenerarReporte" onclick="cargarReporteSeleccionadoDpt(this.id, '2')">
                            Generar                            
                        </div>
                    </div>
                    <div style="float: right;">&nbsp;</div>
                    <div class="itemRepR">
                        <span>*</span>
                        <label><img src="recursos/iconos/map.png"/>&nbsp;Departamento : </label>
                        <select id="reporteGradoZona_depto" style="width: 110px;">
                            <option value="todos">Todos</option>
                            <?php
                            foreach ($lista_departamentos as $departamento) {
                                echo '<option value="' . $departamento['departamento_id'] . '">' . htmlentities($departamento['descripcion_departamento']) . '</option>';
                            }
                            ?>                      
                        </select>
                    </div>
                    <div style="float: right; font-size: 12pt; color: #aaaaaa;">&nbsp;|&nbsp;</div>
                    <div class="itemRepR">
                        <label><img src="recursos/iconos/chart-up.png"/>&nbsp;Indicador : </label>
                        <select id="reporteGradoZona_indicador">
                            <?php
                                foreach( $lista_tipos_estadistica as $tipo_estadistica)
                                {
                                    echo '<option value="'. $tipo_estadistica['id'] .'">'. $tipo_estadistica['nombre'] .'</option>';
                                }
                            ?>                         
                        </select>
                    </div> 
                </div>                                                        
            </div>
            <!--div class="items">
                <div class="itemReporte">
                    <div class="itemRepL">
                        <img src="recursos/iconos/report.png"/>&nbsp;Por Condici&oacute;n de Edad.
                    </div>
                    <div class="itemRepR">
                        <div id="reporteGradoCondEdad_boton" class="botonGenerarReporte" onclick="cargarReporteSeleccionadoDpt(this.id, '3')">
                            Generar                            
                        </div>
                    </div>
                    <div style="float: right;">&nbsp;</div>
                    <div class="itemRepR">
                        <span>*</span>
                        <label><img src="recursos/iconos/map.png"/>&nbsp;Departamento : </label>
                        <select id="reporteGradoCondEdad_depto" style="width: 110px;">
                            <option value="todos">Todos</option>
                            <?php
                            foreach ($lista_departamentos as $departamento) {
                                echo '<option value="' . $departamento['departamento_id'] . '">' . htmlentities($departamento['descripcion_departamento']) . '</option>';
                            }
                            ?>                      
                        </select>
                    </div>
                    <div style="float: right; font-size: 12pt; color: #aaaaaa;">&nbsp;|&nbsp;</div>
                    <div class="itemRepR">
                        <label><img src="recursos/iconos/chart-up.png"/>&nbsp;Indicador : </label>
                        <select id="reporteGradoCondEdad_indicador">
                            <?php
                                foreach( $lista_tipos_estadistica as $tipo_estadistica)
                                {
                                    echo '<option value="'. $tipo_estadistica['id'] .'">'. $tipo_estadistica['nombre'] .'</option>';
                                }
                            ?>                         
                        </select>
                    </div> 
                </div>                                                        
            </div-->
            <div class="items">
                <div class="itemReporte">
                    <div class="itemRepL">
                        <img src="recursos/iconos/report.png"/>&nbsp;Por Genero.
                    </div>
                    <div class="itemRepR">
                        <div id="reporteGradoGenero_boton" class="botonGenerarReporte" onclick="cargarReporteSeleccionadoDpt(this.id, '4')">
                            Generar                            
                        </div>
                    </div>
                    <div style="float: right;">&nbsp;</div>
                    <div class="itemRepR">
                        <span>*</span>
                        <label><img src="recursos/iconos/map.png"/>&nbsp;Departamento : </label>
                        <select id="reporteGradoGenero_depto" style="width: 110px;">
                            <option value="todos">Todos</option>
                            <?php
                            foreach ($lista_departamentos as $departamento) {
                                echo '<option value="' . $departamento['departamento_id'] . '">' . htmlentities($departamento['descripcion_departamento']) . '</option>';
                            }
                            ?>                      
                        </select>
                    </div>
                    <div style="float: right; font-size: 12pt; color: #aaaaaa;">&nbsp;|&nbsp;</div>
                    <div class="itemRepR">
                        <label><img src="recursos/iconos/chart-up.png"/>&nbsp;Indicador : </label>
                        <select id="reporteGradoGenero_indicador">
                            <?php
                                foreach( $lista_tipos_estadistica as $tipo_estadistica)
                                {
                                    echo '<option value="'. $tipo_estadistica['id'] .'">'. $tipo_estadistica['nombre'] .'</option>';
                                }
                            ?>                         
                        </select>
                    </div> 
                </div>                                                        
            </div>
        </div> 
        <div>
            <hr width="100%" size="5" noshade/>
        </div>
        <div class="cajas" style="border: 1px solid #6480a5; background-color: #f1f1f1; height: 86px;">
            <div class="titulo" style="border-bottom: 1px dotted #6480a5;">
                <img src="recursos/iconos/funnel-pencil.png"/>&nbsp;&nbsp;Seleccione los filtros para - Otros reportes de Interes:
            </div>
            <div class="items">
                <label><img src="recursos/iconos/calendar-select.png"/>&nbsp;Escoja un a&ntilde;o : </label>
                <select id="otrosReportes_anio" style="width: 60px;">
                    <?php
                        foreach( $lista_aniosDisponibles as $anioDisponible )
                        {
                            echo '<option value=' . $anioDisponible['anio'] . '>' . $anioDisponible['anio'] . '</option>';
                        }
                    ?>                    
                </select>
            </div>
            <div class="items" style="font-size: 12pt; color: #aaaaaa;">
                &nbsp;|&nbsp;
            </div>
            <div class="items">
                <label><img src="recursos/iconos/mapGreen.png"/>&nbsp;Departamento : </label>
                <select id="otrosReportes_depto" class="selectorFiltros" style="text-align: left; width: 160px;" onchange="cambiarDeptoReportesDinamicos(this.id)">
                    <option value="0">- - -</option>                
                </select>
            </div>
            <div class="items" style="font-size: 12pt; color: #aaaaaa;">
                &nbsp;|&nbsp;
            </div>
            <div class="items">
                <label name="mostrarParcialmente"><img src="recursos/iconos/mapBlue.png"/>&nbsp;Municipio : </label>
                <select id="otrosReportes_muni" disabled="disabled" style="width: 160px;" >
                    <option value="0">Todos</option>
                </select>
            </div>
            <br/>
            <div class="items">
                <label><img src="recursos/iconos/zone.png"/>&nbsp;Zona : </label>
                <select id="otrosReportes_zona" style="width: 80px;">
                    <option value="0">Todos</option>
                    <option value="1">Rural</option>
                    <option value="2">Urbano</option>
                </select>
            </div>
            <div class="items" style="font-size: 12pt; color: #aaaaaa;">
                &nbsp;|&nbsp;
            </div>
            <div class="items">
                <label><img src="recursos/iconos/bank.png"/>&nbsp;Administraci&oacute;n : </label>
                <select id="otrosReportes_admon" style="width: 80px;">
                    <option value="0">Todos</option>
                    <option value="1">P&uacute;blico</option>
                    <option value="2">Privado</option>
                </select>
            </div>
        </div>
        <div class="cajas">
            <div class="titulo">
                <img src="recursos/iconos/reports-stack.png"/>&nbsp;&nbsp;Otros reportes de Interes : 
            </div>
            <div class="items">
                <div class="itemReporte">
                    <div class="itemRepL">
                        <img src="recursos/iconos/report.png"/>&nbsp;Formaci&oacute;n Docente por Niveles Educativos.
                    </div>
                    <div class="itemRepR">
                        <div id="formacionDocente" class="botonGenerarReporte" onclick="cargarReportesInteres(this.id)">
                            Generar
                        </div>
                    </div>
                </div>                                                        
            </div>      
            <div class="items">
                <div class="itemReporte">
                    <div class="itemRepL">
                        <img src="recursos/iconos/report.png"/>&nbsp;Ingresos a 1° Grado "SIN" Preparatoria.
                    </div>
                    <div class="itemRepR">
                        <div id="sinPrepaGrado1" class="botonGenerarReporte" onclick="cargarReportesInteres(this.id)">
                            Generar
                        </div>
                    </div>
                </div>                                                        
            </div>
            <div class="items">
                <div class="itemReporte">
                    <div class="itemRepL">
                        <img src="recursos/iconos/report.png"/>&nbsp;Ingresos a 1° Grado "CON" Preparatoria.
                    </div>
                    <div class="itemRepR">
                        <div id="conPrepaGrado1" class="botonGenerarReporte" onclick="cargarReportesInteres(this.id)">
                            Generar
                        </div>
                    </div>
                </div>                                                        
            </div>
            <div class="items">
                <div class="itemReporte">
                    <div class="itemRepL">
                        <img src="recursos/iconos/report.png"/>&nbsp;Estudiantes con Discapacidades.
                    </div>
                    <div class="itemRepR">
                        <div id="conDiscapacidades" class="botonGenerarReporte" onclick="cargarReportesInteres(this.id)">
                            Generar
                        </div>
                    </div>
                    <div style="float: right;">&nbsp;</div>
                    <div class="itemRepR">
                        <label><img src="recursos/iconos/disability.png"/>&nbsp;Discapacidad : </label>
                        <select id="tipoDiscapacidad_id" style="width: 110px;">
                            <option value="0">Todas</option>
                            <?php
                            foreach ($lista_discapacidades as $discapacidad) {
                                echo '<option value="' . $discapacidad['discapacidad_id'] . '">' . htmlentities($discapacidad['discapacidad']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <!--div style="float: right; font-size: 12pt; color: #aaaaaa;">&nbsp;|&nbsp;</div>
                    <div class="itemRepR">
                        <label><img src="recursos/iconos/grade-persons.png"/>&nbsp;Grados : </label>
                        <select id="" style="width: 110px;">
                            <option value="todos">Todos</option>
                            <?php
                            foreach ($lista_grados as $grado) {
                                echo '<option value="' . $grado['grado_id'] . '">' . htmlentities($grado['descripcion_grado_app']) . '</option>';
                            }
                            ?>
                        </select>
                    </div-->
                </div>
            </div>
            <div class="items">
                <div class="itemReporte">
                    <div class="itemRepL">
                        <img src="recursos/iconos/report.png"/>&nbsp;Cantidad de Centros Educativos Integrados en Redes educativas.
                    </div>
                    <div class="itemRepR">
                        <div id="redesEducativas" class="botonGenerarReporte" onclick="cargarReportesInteres(this.id)">
                            Generar
                        </div>
                    </div>
                </div>                                                        
            </div>
            <div class="items">
                <div class="itemReporte">
                    <div class="itemRepL">
                        <img src="recursos/iconos/report.png"/>&nbsp;Cantidad de Centros con Equipo de Computo.
                    </div>
                    <div class="itemRepR">
                        <div id="equipoComputo" class="botonGenerarReporte" onclick="cargarReportesInteres(this.id)">
                            Generar
                        </div>
                    </div>
                </div>                                                        
            </div>
            <div class="items">
                <div class="itemReporte">
                    <div class="itemRepL">
                        <img src="recursos/iconos/report.png"/>&nbsp;Cantidad de Centros con Energia Electrica.
                    </div>
                    <div class="itemRepR">
                        <div id="centroConEnergiaElectrica" class="botonGenerarReporte" onclick="cargarReportesInteres(this.id)">
                            Generar
                        </div>
                    </div>
                    <div style="float: right;">&nbsp;</div>
                    <div class="itemRepR">
                        <label><img src="recursos/iconos/light-bulb_1.png"/>&nbsp;Tipo Suministro Electrico : </label>
                        <select id="tipoEnergiaElectrica_id" style="width: 110px;">
                            <option value="0">Todos</option>
                            <?php
                            foreach ($lista_tipos_electricidad as $tipo_electricidad) {
                                echo '<option value="' . $tipo_electricidad['electricidad_id'] . '">' . htmlentities($tipo_electricidad['descripcion_suministro']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>                                                        
            </div>
            <div class="items">
                <div class="itemReporte">
                    <div class="itemRepL">
                        <img src="recursos/iconos/report.png"/>&nbsp;Cantidad de Centros con Agua.
                    </div>
                    <div class="itemRepR">
                        <div id="centrosSuministroAgua" class="botonGenerarReporte" onclick="cargarReportesInteres(this.id)">
                            Generar
                        </div>
                    </div>    
                    <div style="float: right;">&nbsp;</div>
                    <div class="itemRepR">
                        <label><img src="recursos/iconos/wooden-box.png"/>&nbsp;Almacenamiento del Agua : </label>
                        <select id="tipoAlmacenamientoAgua_id" style="width: 110px;">
                            <option value="0">Todos</option>
                             <?php
                            foreach ($lista_almacenamientos_agua as $almacenamiento) {
                                echo '<option value="' . $almacenamiento['almacenamiento_id'] . '">' . htmlentities($almacenamiento['descripcion_almacenamiento']) . '</option>';
                            }
                            ?>                            
                        </select>
                    </div>
                    <div style="float: right; font-size: 12pt; color: #aaaaaa;">&nbsp;|&nbsp;</div>
                    <div class="itemRepR">
                        <label><img src="recursos/iconos/water.png"/>&nbsp;Tipo de Agua : </label>
                        <select id="tipoAgua_id" style="width: 110px;">
                            <option value="0">Todos</option>
                            <?php
                            foreach ($lista_tipos_agua as $tipo_agua) {
                                echo '<option value="' . $tipo_agua['tipo_agua_id'] . '">' . htmlentities($tipo_agua['descripcion_tipo_agua']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>                                                        
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function cargarReporteSeleccionadoDpt(idBoton, numReporte)
    {
        var anio = $('#filtroGral_anio').val() + '&niv=';
        var nivel = $('#filtroGral_niveles').val() + '&ind=';
        var indicador = $('#' + idBoton.split('_')[0] + '_indicador').val() + '&dpt=';
        var depto_id = $('#' + idBoton.split('_')[0] + '_depto' ).val() + '&id=' + numReporte;
        
        var request = anio + nivel + indicador + depto_id;
        
        window.open('reportesPorGrado.php?an=' + request, '_blank');
    }
    function cargarReporteSeleccionadoGr(idBoton, numReporte)
    {
        var anio = $.trim($('#filtroGral_anio').val()) + '&niv=';
        var nivel = $.trim($('#filtroGral_niveles').val()) + '&ind=';
        var indicador = $.trim($('#' + idBoton.split('_')[0] + '_indicador').val()) + '&gr=';
        var grado_id = $.trim($('#' + idBoton.split('_')[0] + '_grado' ).val()) + '&id=' + numReporte;
        
        var request = 'an='+ anio + nivel + indicador + grado_id;
        
        window.open('reportesPorDepartamento.php?' + request, '_blank');
    }
    function cargarReportesInteres(idBoton)
    {
        var _anio = $('#otrosReportes_anio').val();
        var _admon = $('#otrosReportes_admon').val();
        var _zona = $('#otrosReportes_zona').val();
        var _filtroDepto = $('#otrosReportes_depto').val();
        var _filtroMuni = $('#otrosReportes_muni').val();

        var request = 'anio='+ _anio + '&admon=' + _admon + '&zona=' + _zona + '&filtroDepto=' + _filtroDepto + '&filtroMuni=' + _filtroMuni;

        if(idBoton === 'formacionDocente')
        {
            window.open('reporteFormacionDocente.php?' + request, '_blank');
        }
        if(idBoton === 'sinPrepaGrado1')
        {
            window.open('reporteIngresosGrado1SinPreparatoria.php?' + request, '_blank');
        }
        if(idBoton === 'conPrepaGrado1')
        {
            window.open('reporteIngresosGrado1ConPreparatoria.php?' + request, '_blank');
        }
        if(idBoton === 'conDiscapacidades')
        {
            request += '&filtroDiscapacidad=' + $('#tipoDiscapacidad_id').val();
            window.open('reporteEstudiantesDiscapacidades.php?' + request, '_blank');
        } 
        if(idBoton === 'redesEducativas')
        {
            window.open('cantidadCentrosRedesEducativas.php?' + request, '_blank');
        }
        if(idBoton === 'equipoComputo')
        {
            window.open('reporteCentrosConEquipoComputo.php?' + request, '_blank');
        }
        if(idBoton === 'centroConEnergiaElectrica')
        {
            request += '&filtroTipoEnergia=' + $('#tipoEnergiaElectrica_id').val();
            window.open('reporteCentrosConEnergiaElectrica.php?' + request, '_blank');
        }
        if(idBoton === 'centrosSuministroAgua')
        {
            request += '&filtroTipoAgua=' + $('#tipoAgua_id').val() + '&filtroAlmacenamientoAgua=' + $('#tipoAlmacenamientoAgua_id').val();
            window.open('reporteCentrosSuministroAgua.php?' + request, '_blank');
        }
    }
    $('#otrosReportes_depto').html($('#selectorDataDepartamentoGlobal').html());
</script>
