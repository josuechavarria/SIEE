<?php
include '../phpIncluidos/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $stmt_listado_series_indicadores_act = $conn->query('SELECT * FROM siee_serie_indicadores WHERE activo = 1 ORDER BY codigo_serie_indicadores');
    $lista_series_indicadores_act = $stmt_listado_series_indicadores_act->fetchAll();
    $stmt_listado_series_indicadores_act->closeCursor();

    $stmt_lista_niveles_educativos = $conn->query('SELECT * FROM  siee_nivel_educativo Where activo = 1 ORDER BY id');
    $lista_niveles_educativos = $stmt_lista_niveles_educativos->fetchAll();
    $stmt_lista_niveles_educativos->closeCursor();

    $stmt_lista_tipos_desagregacion = $conn->query('SELECT * FROM  siee_tipo_desagregacion Where activo = 1 ORDER BY id');
    $lista_tipos_desagregacion = $stmt_lista_tipos_desagregacion->fetchAll();
    $stmt_lista_tipos_desagregacion->closeCursor();

    $stmt_lista_tipos_matricula = $conn->query('SELECT * FROM  siee_tipo_matricula Where activo = 1 ORDER BY id');
    $lista_tipos_matricula = $stmt_lista_tipos_matricula->fetchAll();
    $stmt_lista_tipos_matricula->closeCursor();

    $stmt_lista_tipos_educacion = $conn->query('SELECT * FROM  siee_tipo_educacion Where activo = 1 ORDER BY id');
    $lista_tipos_educacion = $stmt_lista_tipos_educacion->fetchAll();
    $stmt_lista_tipos_educacion->closeCursor();
	
    $stmt_lista_indicadores = $conn->query('SELECT * FROM siee_indicador ORDER BY codigo_indicador');
    $lista_indicadores = $stmt_lista_indicadores->fetchAll();
    $stmt_lista_indicadores->closeCursor();
}
?>
<div class="encabezado" id="seccionEncabezadoReporteria">
    <div class="icono">
        <img src="recursos/iconos/preparaReporteIcon_48px.png">
    </div>
    <div class="lineaVertical">&nbsp;</div>
    <div class="descripcion" id="seccionDescripcionEncabezadoReporteria">
        <div class="titulo">
            Administraci&oacute;n de Indicadores
            <div onclick="cerrarSeccionAdmin()" class="botonCerrarSeccion">Cerrar Secci&oacute;n</div> 
        </div>
        <div class="subTitulo">                                                    
        </div>                                                
    </div>
</div>
<div class="contenido">
    <br/>
    <div id="dialogWindow" title="" style="font-size: 10pt;">
    </div>
    <div id="tabsIndicadores">
        <ul>
            <li><a href="#tabsIndicadores-1" optionInd="1">
                    <img class="tabIcons" src="recursos/iconos/plus.png" />
                    Registrar nuevo
                </a>
            </li>
            <li><a href="#tabsIndicadores-2" optionInd="2">
                    <img class="tabIcons" src="recursos/iconos/megaphone.png" />
                    Publicar
                </a>
            </li>
            <li><a href="#tabsIndicadores-3" optionInd="3">
                    <img class="tabIcons" src="recursos/iconos/pencil.png" />
                    Modificar
                </a>
            </li>
            <li><a href="#tabsIndicadores-4" optionInd="4">
                    <img class="tabIcons" src="recursos/iconos/chain--plus.png" />
                    Relaciones
                </a>
            </li>
            <li><a href="#tabsIndicadores-5" optionInd="5">
                    <img class="tabIcons" src="recursos/iconos/control-record.png" />
                    Activar/Desactivar
                </a>
            </li>
            <li><a href="#tabsIndicadores-6" optionInd="6">
                    <img class="tabIcons" src="recursos/iconos/date.png" />
                    A&ntildeo Base
                </a>
            </li>
        </ul>
        <div id="tabsIndicadores-1">
            <div class="formularios">
                <div id="CamposFormulario">
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_TituloIndicador">
                        </ul>
                        <label for="TituloIndicador">Titulo del indicador:</label>
                        <input id="TituloIndicador" name="tituloIndicador"  type="text" maxlength="256" />
                    </div>
					
                    <hr/>
                    <div id="CampoDeAlias" style="background-color:#fcfcfc;" class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_Alias">
                        </ul>
                        <div id="alias">
                        </div>
                        <div class="itemsFormularios" style="text-align:right;" id="EspacioBotonAgregarAlias">
                            <input type ="button" class="ui-boton-guardar" onclick="AgregarAlias()"value ="Agregar nuevo alias"/>
                        </div>
						
                    </div>
                    <hr/>
					
					<div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_UrlArchivoIndicador">
                        </ul>
                        <label for="UrlArchivoIndicador">Nombre del archivo:</label>
                        <input id="UrlArchivoIndicador" name="url_archivo_indicador"  type="text" maxlength="256" />
                    </div>
					
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_NivelesIds">
                        </ul>
                        <label for="NivelesIndicador">Niveles que aplica:</label>                        
                        <div id="NivelesIndicador" class="boxListasChkBx">
                            <ul>
                                <?php
                                foreach ($lista_niveles_educativos as $nivel) {
                                    echo '<li>
                                                <label style="cursor:pointer;"><input name="NivelesId" type="checkbox" value="' . $nivel['id'] . '"/>' . htmlentities($nivel['titulo']) . '</label>
                                            </li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
					
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_DesagregacionIds">
                        </ul>
                        <label for="GrupoDesagregaciones">Desagregaciones : </label>
                        <div id="GrupoDesagregaciones" class="boxListasChkBx">
                            <ul>
                                <?php
                                foreach ($lista_tipos_desagregacion as $t_desagegacion) {
                                    echo '  <li>
                                                    <label style="cursor:pointer;"><input name="tipoDesagregacionId" type="checkbox" value="' . $t_desagegacion['id'] . '"/>' . htmlentities($t_desagegacion['titulo']) . '</label>
                                                </li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
					
					<div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_FuentesDatosIds">
                        </ul>
                        <label for="FuentesDatos">Fuentes de datos : </label>
                        <div id="FuentesDatos" class="boxListasChkBx">
                            <ul>
                                <?php
								$stmt_fuentes = $conn->query('SELECT * FROM siee_fuente_dato WHERE activo = 1 ORDER BY titulo;');
								$fuentes = $stmt_fuentes->fetchAll();
								$stmt_fuentes->closeCursor();
								
                                foreach ($fuentes as $fuente) {
								?>
								<li>
									<label style="cursor:pointer;">
										<input name="fuenteDatoId" type="checkbox" value="<?php echo $fuente['id'] ?>"/><?php echo htmlentities($fuente['titulo']) ?>
									</label>
                                </li>
								<?php	
								}
								?>
                            </ul>
                        </div>
                    </div>
					
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_PrivadoIndicador">
                        </ul>
                        <label for="PrivadoIndicador">¿Es Privado?</label>
                        <div id="rdBtnEsPrivado" style="display:inline-block;">
                                <label for="NoEsPrivado">No</label>
                                <input id="NoEsPrivado" type="radio" name="Privado" value="0" checked ="Checked" />
                                <label for="SiEsPrivado">Si</label>
                                <input id="SiEsPrivado" type="radio" name="Privado" value="1" />
                        </div>
                    </div>
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_DescripcionIndicador">
                        </ul>
                        <label for="DescripcionIndicador">Descripci&oacute;n:</label>
                        <textarea id="DescripcionIndicador" name="descripcionIndicador" maxlength="2048" ></textarea>
                    </div>
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_InterpretacionIndicador">
                        </ul>
                        <label for="InterpretacionIndicador" >Interpretaci&oacute;n:</label>
                        <textarea id="InterpretacionIndicador" name="observacionIndicador" maxlength="2048" ></textarea>
                    </div>
					
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_CodigoMathml">
                        </ul>

                        <div id="MathmlDeFormula">
                            <label for="CodigoMathml" ><a href="http://es.wikipedia.org/wiki/MathML" style="font-size: 10pt;" target="_blank">MATHML</a> de la F&oacute;rmula:</label>
                            <textarea id="CodigoMathml" name="CodigoMathml" maxlength="4096" ></textarea>
                        </div>
                    </div>
					<hr/>
                    <div id="CampoDeVariables" style="background-color:#fcfcfc;">
                        <div class="itemsFormularios">
                            <ul class="errores_por_campo" id="errors_listaDeVariables"></ul>
                            <label>Mathml variable : </label>
                            <textarea name="variables" maxlength="2048"></textarea>
                            <ul class="errores_por_campo" id="errors_listaDeVariablesDescripcion"></ul>
                            <div style="margin-top:4px;">
                                <label>Descripci&oacute;n de variable</label>
                                <input type="text" name="variablesDescripcion" maxlength="2048"/>
                            </div>
                        </div>
                        <div class="itemsFormularios" style="text-align:right;" id="EspacioBotonAgregarVariable">
                            <input type ="button" class="ui-boton-guardar" onclick="AgregarVariable()"value ="Agregar nuevo campo de variables"/>
                        </div>
                    </div>
					<hr/>
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_ObservacionGraficos">
                        </ul>
                        <label for="ObservacionGraficos" >Observaciones del Gr&aacute;fico:</label>
                        <textarea id="ObservacionGraficos" name="observacionGraficos" maxlength="256" ></textarea>
                    </div>
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_ObservacionGenerales">
                        </ul>
                        <label for="ObservacionGenerales" >Observaciones Generales:</label>
                        <textarea id="ObservacionGenerales" name="observacionGenerales" maxlength="2048" ></textarea>
                    </div>
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_TipoDeMatriculaIndicador">
                        </ul>
                        <label for="" >Tipo de Matricula:</label>
                        <select id="TipoDeMatriculaIndicador">
                            <option value ="0">- - -</option>
                            <?php
                            foreach ($lista_tipos_matricula as $t_matricula) {
                                echo '<option value="' . $t_matricula['id'] . '">' . htmlentities($t_matricula['titulo']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="itemsFormularios">
                        <ul class="errores_por_campo" id="errors_TipoDeEducacionIndicador">
                        </ul>
                        <label for="" >Tipo de Educaci&oacute;n:</label>
                        <select id ="TipoDeEducacionIndicador">
                            <option value="0">- - -</option>
                            <?php
                            foreach ($lista_tipos_educacion as $t_educ) {
                                echo '<option value="' . $t_educ['id'] . '">' . htmlentities($t_educ['titulo']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="itemsFormularios">     
                        <label for="SerieIndicadores">Selecciona la(s) Serie(s) a las que pertenece este indicador:</label>
                        <label style="font-size:7pt;color:#aaa;">* Las series que est&aacute;n en rojo llegaron al limite de indicadores que soportan.</label>
                        <ul class="errores_por_campo" id="errors_SeriesIndicadoresIds">
                        </ul>
                        <div class="itemsFormularios" style="height: 320px;" >                      
                            <div id="SerieIndicadores" style="width:97.3%;max-height: none;height: 100%;" class="boxListasChkBx">
                                <ul>
                                    <?php
                                    foreach ($lista_series_indicadores_act as $serie_ind) {
                                        $serie_id = $serie_ind['id'];

                                        $stmt_lista_serie_numero = $conn->query('SELECT  count(indicador_id)
                                                                            FROM [siee_rel-indicador__serie_indicadores]
                                                                            where serie_indicadores_id = ' . $serie_id);
                                        $lista_serie = $stmt_lista_serie_numero->fetchAll();
                                        $stmt_lista_serie_numero->closeCursor();
										
                                        if (sizeof($lista_serie) == 0) {
                                            echo '<li>
                                                    <label style="cursor:pointer;"><input name="serieIndicadoresId" type="checkbox" value="' . $serie_id . '"/>' . htmlentities($serie_ind['titulo']) . '</label><label style="float:right;min-width:0;">' . $lista_serie[0][0] .' de '. $serie_ind['cantidad_indicadores'] . '</label>
                                                </li>';
                                        } else {
//                                            
                                            if ($lista_serie[0][0] >= $serie_ind['cantidad_indicadores']) {
                                                // echo htmlentities($serie_ind['titulo']);
                                                //aqui deberia salir los que no deberian salir por
                                                echo '<li style = "color:red;">
														<label style="cursor:pointer;"><input disabled="disabled" name="serieIndicadoresId" type="checkbox" value="' . $serie_id . '"/>' . htmlentities($serie_ind['titulo']) . '</label><label style="float:right;min-width:0;">' . $lista_serie[0][0] .' de '. $serie_ind['cantidad_indicadores'] . '</label>
													</li>';
                                            } else {
                                                echo '<li>
														<label style="cursor:pointer;"><input name="serieIndicadoresId" type="checkbox" value="' . $serie_id . '"/>' . htmlentities($serie_ind['titulo']) . '</label><label style="float:right;min-width:0;">' . $lista_serie[0][0] .' de '. $serie_ind['cantidad_indicadores'] . '</label>
													</li>';
                                            }
                                        }
                                    }
                                    ?>
                                </ul>

                            </div>
                        </div>
                    </div>
                    <div class="itemsFormularios">
                        <div class="optionPane">
                            <button class="ui-boton-guardar" onclick="guardarAdminIndicadores()">Guardar Indicador</button>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
        <div id="tabsIndicadores-2">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="radioBtn_filtroActInact" style="max-width: 400px;">Filtra los indicadores que deseas ver:</label>
                        <div id="radioBtn_filtroActInact" name="radioOptions">
                            <label for="radioBtn_filtroPublicoNoPub1" style="height: 30px;">Indicadores Publicados</label>
                            <input type="radio" id="radioBtn_filtroPublicoNoPub1" value="1" name="radioOptionsActDesactIndicadoresPublicar" onclick='filtroDeIndicadoresModPublicar(this.value)' />
                            <label for="radioBtn_filtroPublicoNoPub2" style="height: 30px;">Todos</label>
                            <input type="radio" id="radioBtn_filtroPublicoNoPub2" value="2" name="radioOptionsActDesactIndicadoresPublicar" onclick='filtroDeIndicadoresModPublicar(this.value)' checked="checked"/>
                            <label for="radioBtn_filtroPublicoNoPub3" style="height: 30px;">Indicadores No Publicados</label>
                            <input type="radio" id="radioBtn_filtroPublicoNoPub3" value="0" name="radioOptionsActDesactIndicadoresPublicar" onclick='filtroDeIndicadoresModPublicar(this.value)' />
                        </div>
                        <br/>
                    </div>
                </div>
                <div class="listado" id="panelListadoModificarIndicadores">
                    <ul id="listadoPublicarNoPublicarIndicadores">
                        <?php
                        $lista_titulos_indicadores = "";
                        foreach ($lista_indicadores as $indicador) {
                            $id_indicador = $indicador['id'];
                            $codigo = $indicador['codigo_indicador'];
                            $titulo = $indicador['titulo'];
                            $descripcion = $indicador['descripcion'];
                            $publicado = $indicador['publicado'];

                            $lista_titulos_indicadores .= utf8_encode(strtolower($titulo)) . ',';
							if ($indicador['activo']){
								if ($publicado) {


									echo '<li  titulo_Indicadores="' . utf8_encode(strtolower($titulo)) . '" esta_publicada="' . $publicado . '">
											<div class="descripcion">
												<div class="items">
													<span style="font-weight: bold;">' . $codigo . '</span> - ' . htmlentities(substr($titulo, 0, 64)) . '
												</div>
												<div class="items">
													' . htmlentities(substr($descripcion, 0, 70)) . '...
												</div>
											</div>
											<div class="opciones">
												<label class="chkDesactivar"><input  name="estatusIndicadoresPublicacion" type="checkbox" value="' . $id_indicador . '" onchange="uiActDesact(this)"/>No Publicar</label>
											</div>
										</li>';
								} else {
									echo '<li  titulo_Indicadores="' . utf8_encode(strtolower($titulo)) . '" esta_publicada="' . $publicado . '">
											<div class="descripcion">
												<div class="items">
													<span style="font-weight: bold;">' . $codigo . '</span> - ' . htmlentities(substr($titulo, 0, 64)) . '
												</div>
												<div class="items">
													' . htmlentities(substr($descripcion, 0, 70)) . '...
												</div>
											</div>
											<div class="opciones">
												<label class="chkActivar"><input name="estatusIndicadoresPublicacion" type="checkbox" value="' . $id_indicador . '" onchange="uiActDesact(this)"/>Publicar</label>
											</div>
										</li>';
								}
							}
                        }
                        ?>                                                
                    </ul>
                </div>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarIndicadoresPublicarNoPublicar()">Guardar Pulicar / No Publicar</button>
                    </div>
                </div>
            </div> 
        </div>
        <div id="tabsIndicadores-3">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="buscadorIndicador" style="max-width: 400px;">Escribe aqu&iacute; el Indicador que quieres encontrar:</label>
                        <br/>
                        <input id="buscadorIndicador" type="text" onkeyup='filtroDeIndicadores(this.value)' style="width:677px;"/>
                    </div>
                </div>
                <div class="listado" id="panelListadoModificarIndicador" style="height:auto;max-height:600px">
                    <ul id="listadoModificarIndicador">
                        <?php
                        $lista_titulos_indicadores = "";
                        foreach ($lista_indicadores as $indicador) {

                            $id_indicador = $indicador['id'];
                            $codigo = $indicador['codigo_indicador'];
                            $titulo = $indicador['titulo'];
                            $descripcion = $indicador['descripcion'];
                            $activo = $indicador['activo'];

                            if ($activo) {


                                $lista_titulos_indicadores .= utf8_encode(strtolower($titulo)) . ',';

                                echo '<li  titulo_Indicadores="' . utf8_encode(strtolower($titulo)) . '">
                                    <div class="descripcion">
                                        <div class="items">
                                           <span style="font-weight: bold;">' . $codigo . '</span> - ' . htmlentities(substr($titulo, 0, 64)) . '
                                        </div>
                                        <div class="items">
                                            ' . htmlentities(substr($descripcion, 0, 70)) . '...
                                        </div>
                                    </div>
                                    <div class="opciones">
                                        <button id="' . $id_indicador . '" class="ui-boton-modificar" onclick="cargarPanelModificacionIndicadores(this.id)">Modificar</button>
                                    </div>
                                </li>';
                            }
                        }
                        ?>                                                
                    </ul>
                </div>
            </div>  
        </div>
        <div id="tabsIndicadores-4">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="buscadorIndicador" style="max-width: 400px;">Escribe aqu&iacute; el Indicador que quieres encontrar:</label>
                        <br/>
                        <input id="buscadorIndicador" type="text" onkeyup='filtroDeIndicadores(this.value)' />
                    </div>
                </div>
                <div class="listado" id="panelListadoModificarIndicador" style="height:auto;max-height:600px">
                    <ul id="listadoModificarIndicador">
                        <?php
                        $lista_titulos_indicadores = "";
                        foreach ($lista_indicadores as $indicador) {

                            $id_indicador = $indicador['id'];
                            $codigo = $indicador['codigo_indicador'];
                            $titulo = $indicador['titulo'];
                            $descripcion = $indicador['descripcion'];
                            $activo = $indicador['activo'];

                            $stmt_lista_indicadores_descripcion = $conn->query('select i2.titulo, case when r.indicador_id = ' . $id_indicador . ' then r.indicador_id2 else r.indicador_id end As indicador
                                                                                From siee_indicador AS i1,"siee_rel-indicador__indicador" AS r,siee_indicador AS i2
                                                                                where ((i1.id = r.indicador_id AND r.indicador_id2 = i2.id) OR (i1.id = r.indicador_id2 AND i2.id = r.indicador_id))
                                                                                and i1.id = ' . $id_indicador);
                            $lista_indicadores_desc = $stmt_lista_indicadores_descripcion->fetchAll();
                            $stmt_lista_indicadores_descripcion->closeCursor();

                            if ($activo) {
                                $lista_titulos_indicadores .= utf8_encode(strtolower($titulo)) . ',';

                                echo '<li  titulo_Indicadores="' . utf8_encode(strtolower($titulo)) . '">
                                    <div class="descripcion">
                                        <div class="items">
                                           <span style="font-weight: bold;">' . $codigo . '</span> - ' . htmlentities(substr($titulo, 0, 64)) . '
                                        </div>
                                        <div class="items"><h2 style = "font-weight: bold;">Indicadores Relacionados</h2>';
                                foreach ($lista_indicadores_desc as $ind) {
                                    echo '<div class="items" style="margin-left:10px;">
                                                        <span style="font-weight: bold;">' . $ind['indicador'] . '</span> - ' . htmlentities(substr($ind['titulo'], 0, 64)) . '
                                                    </div>';
                                }

                                echo '</div>
                                    </div>
                                    <div class="opciones">
                                        <button id="' . $id_indicador . '" class="ui-boton-modificar" onclick="cargarPanelModificacionIndicadoresRelaciones(this.id)">Modificar</button>
                                    </div>
                                </li>';
                            }
                        }
                        ?>                                                
                    </ul>
                </div>
            </div>  
        </div>
        <div id="tabsIndicadores-5">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="radioBtn_filtroActInact" style="max-width: 400px;">Filtra los indicadores que deseas ver:</label>
                        <div id="radioBtn_filtroActInact" name="radioOptions">
                            <label for="radioBtn_filtroActInact1" style="height: 30px;">Indicadores Activos</label>
                            <input type="radio" id="radioBtn_filtroActInact1" value="1" name="radioOptionsActDesactIndicadores" onclick='filtroDeIndicadoresMod(this.value)' />
                            <label for="radioBtn_filtroActInact2" style="height: 30px;">Todos</label>
                            <input type="radio" id="radioBtn_filtroActInact2" value="2" name="radioOptionsActDesactIndicadores" onclick='filtroDeIndicadoresMod(this.value)' checked="checked"/>
                            <label for="radioBtn_filtroActInact3" style="height: 30px;">Indicadores Inactivos</label>
                            <input type="radio" id="radioBtn_filtroActInact3" value="0" name="radioOptionsActDesactIndicadores" onclick='filtroDeIndicadoresMod(this.value)' />
                        </div>
                        <br/>
                    </div>
                </div>
                <div class="listado" id="panelListadoModificarIndicadores">
                    <ul id="listadoActDesactIndicadores">
                        <?php
                        $lista_titulos_indicadores = "";
                        foreach ($lista_indicadores as $indicador) {
                            $id_indicador = $indicador['id'];
                            $codigo = $indicador['codigo_indicador'];
                            $titulo = $indicador['titulo'];
                            $descripcion = $indicador['descripcion'];
                            $activo = $indicador['activo'];

                            $lista_titulos_indicadores .= utf8_encode(strtolower($titulo)) . ',';

                            if ($activo) {


                                echo '<li  titulo_Indicadores="' . utf8_encode(strtolower($titulo)) . '" esta_activa="' . $activo . '">
                                        <div class="descripcion">
                                            <div class="items">
                                                <span style="font-weight: bold;">' . $codigo . '</span> - ' . htmlentities(substr($titulo, 0, 64)) . '
                                            </div>
                                            <div class="items">
                                                ' . htmlentities(substr($descripcion, 0, 70)) . '...
                                            </div>
                                        </div>
                                        <div class="opciones">
                                            <label class="chkDesactivar"><input  name="estatusIndicadores" type="checkbox" value="' . $id_indicador . '" onchange="uiActDesact(this)"/>Desactivar</label>
                                        </div>
                                    </li>';
                            } else {
                                echo '<li  titulo_Indicadores="' . utf8_encode(strtolower($titulo)) . '" esta_activa="' . $activo . '">
                                        <div class="descripcion">
                                            <div class="items">
                                                <span style="font-weight: bold;">' . $codigo . '</span> - ' . htmlentities(substr($titulo, 0, 64)) . '
                                            </div>
                                            <div class="items">
                                                ' . htmlentities(substr($descripcion, 0, 70)) . '...
                                            </div>
                                        </div>
                                        <div class="opciones">
                                            <label class="chkActivar"><input name="estatusIndicadores" type="checkbox" value="' . $id_indicador . '" onchange="uiActDesact(this)"/>Activar</label>
                                        </div>
                                    </li>';
                            }
                        }
                        ?>                                                
                    </ul>
                </div>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarIndicadoresActivarDesactivar()">Guardar Activaciones / Desactivaciones</button>
                    </div>
                </div>
            </div> 
        </div>
        <div id="tabsIndicadores-6">
            <div class="formularios">
               <div class="itemsFormularios">
                    <div class="contenidoBuscador">
                        <label for="buscadorIndicador" style="max-width: 400px;">Escribe aqu&iacute; el Indicador que quieres encontrar:</label>
                        <br/>
                        <input id="buscadorIndicador" type="text" onkeyup='filtroDeIndicadoresAnoBase(this.value)' style="width:677px;"/>
                    </div>
                </div>
                <div class="listado" id="panelListadoModificarIndicadores">
                    <ul id="listadoAnoBaseIndicador">
                        <?php
                            $stmt_nombres_tablas_resumen = $conn->query('SELECT DISTINCT periodo_id FROM siee_resumen_data_indicadores WHERE es_inicial = 1 AND tipo_indicador_id = 7 order by periodo_id; ');
                            $anios = $stmt_nombres_tablas_resumen->fetchAll();
                            $stmt_nombres_tablas_resumen->closeCursor();
                           
                            $lista_titulos_indicadores = "";
                            foreach ($lista_indicadores as $indicador) {
                                $lista_titulos_indicadores .= utf8_encode(strtolower($indicador['titulo'])) . ',';

                                if ($activo) {
                                    echo '<li titulo_Indicadores="' . utf8_encode(strtolower($indicador['titulo'])) . '">
                                            <div class="descripcion">
                                                <div class="items">
                                                    <span style="font-weight: bold;">' . $indicador['codigo_indicador'] . '</span> - ' . htmlentities(substr($indicador['titulo'], 0, 64)) . '
                                                </div>
                                                <div class="items">
                                                    ' . htmlentities(substr($indicador['descripcion'], 0, 70)) . '...
                                                </div>
                                            </div>
                                            <div class="opciones">
                                                <select id="anio_base_' . $indicador['id'] . '" onchange="$(this).attr(\'cambiado\',\'si\');">';
                                   
                                    foreach($anios as $anio){
                                       if ($indicador['anio_base'] == $anio['periodo_id']){
                                            echo '<option selected=\"SELECTED\" value="'.$anio['periodo_id'] .'">'.$anio['periodo_id'].'</option>';
                                        }else{
                                            echo '<option value="'.$anio['periodo_id'].'">'.$anio['periodo_id'].'</option>';
                                        }
                                    }
                                   
                                    echo        '</select>
                                            </div>
                                        </li>';
                                }
                            }
                        ?>
                    </ul>
                </div>
               
                <div>
                    <label>
                        Aplicar este a&ntilde;o base a todos los indicadores:
                    </label>
                   
                    <select id="anio_base_global">
                        <?php
                            foreach($anios as $anio){
                                echo '<option value="' . $anio['periodo_id'] . '">'.$anio['periodo_id'].'</option>';
                            }
                        ?>
                    </select>
                   
                    <input type="button" value="Aplicar" onclick="aplicarAnioParaTodos();"/>
                </div>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-guardar" onclick="guardarIndicadoresAnoBase()">Guardar Año Base</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        var _data_indicadores = '<?php echo $lista_titulos_indicadores; ?>'.split(',');
        
        $('#buscadorIndicadores').autocomplete({
            source : _data_indicadores
        });
       
        $( "#tabsIndicadores" ).tabs();
        $( ".ui-boton-guardar" ).button({
            icons: {
                primary: "ui-icon ui-icon-disk"
            }
            
        });
        $( ".ui-boton-modificar" ).button({
            icons: {
                primary: "ui-icon ui-icon-pencil"
            } 
        }); 
        $( ".ui-boton-cerrar" ).button({
            icons: {
                primary: "ui-icon ui-icon-closethick"
            } 
        });
        $('[name="radioOptions"], #rdBtnEsPrivado').buttonset();        
    });
    function cargarDatosSerieSeleccionada(value)
    {
        if(value != '0')
        {
            $.ajax({
                type: "GET",
                url: "administracion/ajaxGetSiee.php",
                data: {
                    opcion      : 1,
                    serie_id    : value
                },
                error: function(){
                    var _html = "<p>Parece que hay un problema de conección, refresca la pagina y realiza esta acción de nuevo.</p>";
                    $( "#dialogWindow_admonIndicadores" ).html(_html);
                    $( "#dialogWindow_admonIndicadores" ).dialog({
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
                success: function(_resp){  
                    $('#espacioJavascript').remove();
                    $('#cuerpo').append(_resp);
                }
            });
            
        }
        else
        {
            $( ".ui-boton-guardar" ).button({               
                disabled: true
            });
        }
    }    
    function AgregarVariable() {
        var htmlCampoVariables = '<div class="itemsFormularios"><hr class="punteado"/>'+
            '<ul class="errores_por_campo" id="errors_listaDeVariables"></ul>'+
            '<label>Mathml variable : </label>'+
            '<textarea name="variables" maxlength="2048"></textarea>'+
            '<div style="margin-top:4px;">'+
            '<label>Descripci&oacute;n de variable</label>'+
            '<input type="text" name="variablesDescripcion" maxlength="2048" style="width:464px"/>'+
			'<a name="QuitarFormula" onclick="eliminarEstaVariable(this)" style="display:inline-block;left:4px;top:2px;height:20px"></a>'+
            '</div>'+
            '</div>';
        var htmlbtn = '<div class="itemsFormularios" style="text-align:right;" id="EspacioBotonAgregarVariable">'+
            '<input type="button" class="ui-boton-guardar" onclick="AgregarVariable()"value ="Agregar nuevo campo de variables"/>'+
            '</div>';                   
                    
        $('#EspacioBotonAgregarVariable').slideUp('fast', function(){
            $(this).remove();
            $('#CampoDeVariables').append(htmlCampoVariables + htmlbtn);
            $( ".ui-boton-guardar" ).button({
                icons: {
                    primary: "ui-icon ui-icon-disk"
                }

            });
             $( ".ui-boton-cerrar" ).button({
                icons: {
                    primary: "ui-icon ui-icon-closethick"
                } 
            });
			$('a[name="QuitarFormula"]').button({
				icons: {
                    primary: "ui-icon ui-icon-trash"
                }
			});
        });
        
    }
	
	function AgregarAlias() {
        var htmlCampoAlias = '<div class="itemsFormularios"><hr class="punteado"/>'+
            '<label>Alias:</label>'+
            '<input type="text" name="alias" maxlength="256" style="width:464px"/>'+
            '<a name="QuitarAlias" onclick="eliminarEsteAlias(this)" style="display:inline-block;left:4px;top:2px;height:20px"></a>'+
            '</div>'+
            '</div>';
        var htmlbtn = '<div class="itemsFormularios" style="text-align:right;" id="EspacioBotonAgregarAlias">'+
            '<input type="button" class="ui-boton-guardar" onclick="AgregarAlias()"value ="Agregar nuevo alias"/>'+
            '</div>';
        var divButton ='<div class="itemsFormularios" style="text-align:right;" id="EspacioBotonAgregarAlias"></div>'
                    
        $('#EspacioBotonAgregarAlias').slideUp('fast', function(){
            $(this).remove();
            
        
            $('#alias').append(htmlCampoAlias);
            $('#CampoDeAlias').append(divButton);
            $('#EspacioBotonAgregarAlias').append(htmlbtn);
            
            $( ".ui-boton-guardar" ).button({
                icons: {
                    primary: "ui-icon ui-icon-disk"
                }

            });
            $( ".ui-boton-cerrar" ).button({
                icons: {
                    primary: "ui-icon ui-icon-closethick"
                } 
            });
            $('a[name="QuitarAlias"]').button({
                icons: {
                    primary: "ui-icon ui-icon-trash"
                }
            });
        });
        
    }
    function eliminarEstaVariable(elem){
        $(elem).parent().parent().slideUp('fast', function(){
            $(this).remove();
        });
    }
	function eliminarEsteAlias(elem){
        $(elem).parent().slideUp('fast', function(){
            $(this).remove();
        });
    }
    function aplicarAnioParaTodos(){
        var anio = $('#anio_base_global').val();
        $('select[id^="anio_base_"]').val(anio).trigger('onchange');
    }
</script>
