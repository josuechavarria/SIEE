<?php
include '../phpIncluidos/conexion.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $no_hay_errores = FALSE;

    if (ISSET($_GET['id'])) {
        $queryIndicadores_id = $_GET['id'];
        $id_de_Indicadores = -1;
        //  echo 'Este es el id ' . $queryIndicadores_id;

        try {
            $id_de_Indicador = (int) $queryIndicadores_id;
            $no_hay_errores = TRUE;
        } catch (Exception $e) {
            $no_hay_errores = FALSE;
        }

        if ($no_hay_errores) {
            $stmt_Indicadores_indicadores = $conn->query('SELECT * FROM siee_indicador WHERE id = ' . $id_de_Indicador);
            $queryIndicadores = $stmt_Indicadores_indicadores->fetch();
            $stmt_Indicadores_indicadores->closeCursor();

            $stmt_listado_series_indicadores_mod = $conn->query('SELECT serie_indicadores_id FROM "siee_rel-indicador__serie_indicadores" WHERE indicador_id = ' . $id_de_Indicador);
            $lista_series_indicadores_mod = $stmt_listado_series_indicadores_mod->fetchAll(PDO::FETCH_COLUMN, 0);
            $stmt_listado_series_indicadores_mod->closeCursor();

            $stmt_queryListaDeIndicadores = $conn->query('SELECT * FROM siee_serie_indicadores Where activo = 1');
            $queryListaDeSeries = $stmt_queryListaDeIndicadores->fetchAll();
            $stmt_queryListaDeIndicadores->closeCursor();

            $stmt_lista_niveles_educativos = $conn->query('SELECT * FROM  siee_nivel_educativo Where activo = 1 ORDER BY id');
            $lista_niveles_educativos = $stmt_lista_niveles_educativos->fetchAll();
            $stmt_lista_niveles_educativos->closeCursor();

            $stmt_listado_nivel_educativo_mod = $conn->query('SELECT nivel_educativo_id FROM "siee_rel-indicador__nivel_educativo" WHERE indicador_id = ' . $id_de_Indicador);
            $lista_niveles_educativos_mod = $stmt_listado_nivel_educativo_mod->fetchAll(PDO::FETCH_COLUMN, 0);
            $stmt_listado_nivel_educativo_mod->closeCursor();

            $stmt_lista_tipos_desagregacion = $conn->query('SELECT * FROM  siee_tipo_desagregacion Where activo = 1 ORDER BY id');
            $lista_tipos_desagregacion = $stmt_lista_tipos_desagregacion->fetchAll();
            $stmt_lista_tipos_desagregacion->closeCursor();

            $stmt_listado_desagregacion_mod = $conn->query('SELECT tipo_desagregacion_id FROM "siee_rel-indicador__tipo_desagregacion" WHERE indicador_id = ' . $id_de_Indicador);
            $lista_desagregacion_mod = $stmt_listado_desagregacion_mod->fetchAll(PDO::FETCH_COLUMN, 0);
            $stmt_listado_desagregacion_mod->closeCursor();

            $stmt_lista_tipos_educacion = $conn->query('SELECT * FROM  siee_tipo_educacion Where activo = 1 ORDER BY id');
            $lista_tipos_educacion = $stmt_lista_tipos_educacion->fetchAll();
            $stmt_lista_tipos_educacion->closeCursor();

            $stmt_lista_tipos_matricula = $conn->query('SELECT * FROM  siee_tipo_matricula Where activo = 1 ORDER BY id');
            $lista_tipos_matricula = $stmt_lista_tipos_matricula->fetchAll();
            $stmt_lista_tipos_matricula->closeCursor();

            $stmt_lista_de_variables = $conn->query('SELECT * FROM  siee_variables_indicador WHERE indicador_id = ' . $id_de_Indicador);
            $lista_de_variables = $stmt_lista_de_variables->fetchAll();
            $stmt_lista_de_variables->closeCursor();

			$stmt_lista_de_alias = $conn->query('SELECT * FROM siee_alias WHERE indicador_id = ' . $id_de_Indicador . ' ORDER BY titulo ASC;');
			$lista_de_alias = $stmt_lista_de_alias->fetchAll();
			$stmt_lista_de_alias->closeCursor();

            $no_hay_errores = (sizeof($queryIndicadores) > 1);
        }
    } else {
        $no_hay_errores = false;
    }
}

if ($no_hay_errores) {
    ?>
    <div id="PanelModificacionDeIndicadores" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
        <div class="headerFromularios">
            Panel de modificaci&oacute;n de Indicador
        </div>
        <div id="CamposFormulario">


            <div class="itemsFormularios">
                <ul class="errores_por_campo" id="errors_TituloIndicador_mod">
                </ul>
                <label for="TituloIndicador_mod">Escriba el titulo del Indicador:</label>
                <input id="TituloIndicador_mod" name="tituloIndicador_mod"  type="text" maxlength="256"value="<?php echo htmlentities($queryIndicadores['titulo']) ?>" />
            </div>
			
			<hr/>
			<div class="itemsFormularios" style="background-color:#fcfcfc;" id="CampoDeAlias_mod">
				<ul id="errors_Alias_mod" class="errores_por_campo">
				</ul>
				<div id="alias_mod">
					<?php
						foreach($lista_de_alias as $alias){
					?>
					<div class="itemsFormularios">
						<hr class="punteado">
						<label>
							Alias:
						</label>
                                                <input type="text" style="width:464px" maxlength="256" name="alias_mod" value="<?php echo utf8_encode($alias['titulo'])?>">
						<a style="display:inline-block;left:4px;top:2px;height:20px" onclick="eliminarEsteAlias(this)" name="QuitarAlias"></a>
					</div>
					<?php
						}
					?>
				</div>
							
				<div id="EspacioBotonAgregarAlias_mod" style="text-align:right;" class="itemsFormularios">
					<div id="EspacioBotonAgregarAlias_mod" style="text-align:right;" class="itemsFormularios">
						<input type="button" value="Agregar nuevo alias" onclick="AgregarAliasMod()" class="ui-boton-agregar" role="button" aria-disabled="false">
					</div>
				</div>
			</div>
			<hr/>
			
            <div class="itemsFormularios">
                <ul class="errores_por_campo" id="errors_NivelesIds_mod">
                </ul>
                <label for="NivelesIndicador_mod">Niveles que aplica:</label>                        
                <div id="NivelesIndicador_mod" class="boxListasChkBx">
                    <ul>
                        <?php
                        foreach ($lista_niveles_educativos as $nivel) {
                            if (in_array($nivel['id'], $lista_niveles_educativos_mod)) {
                                echo '<li>
                                      <label style="cursor:pointer;"><input name="NivelesId_mod" type="checkbox" value="' . $nivel['id'] . '" checked="checked"/>' . htmlentities($nivel['titulo']) . '</label>
                                  </li>';
                            } else {
                                echo '<li>
                                      <label style="cursor:pointer;"><input name="NivelesId_mod" type="checkbox" value="' . $nivel['id'] . '"/>' . htmlentities($nivel['titulo']) . '</label>
                                  </li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>

            <div class="itemsFormularios">
                <ul class="errores_por_campo" id="errors_DesagregacionIds_mod">
                </ul>
                <label for="GrupoDesagregaciones_mod">Desagregaciones : </label>
                <div id="GrupoDesagregaciones_mod" class="boxListasChkBx">
                    <ul>
                        <?php
                        foreach ($lista_tipos_desagregacion as $desagregacion) {
                            if (in_array($desagregacion['id'], $lista_desagregacion_mod)) {
                                echo '<li>
                                      <label style="cursor:pointer;"><input name="tipoDesagregacionId_mod" type="checkbox" value="' . $desagregacion['id'] . '" checked="checked"/>' . htmlentities($desagregacion['titulo']) . '</label>
                                  </li>';
                            } else {
                                echo '<li>
                                      <label style="cursor:pointer;"><input name="tipoDesagregacionId_mod" type="checkbox" value="' . $desagregacion['id'] . '"/>' . htmlentities($desagregacion['titulo']) . '</label>
                                  </li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
			
			<div class="itemsFormularios">
				<ul class="errores_por_campo" id="errors_FuentesDatosIds_mod">
				</ul>
				<label for="FuentesDatos_mod">Fuentes de datos : </label>
				<div id="FuentesDatos_mod" class="boxListasChkBx">
					<ul>
						<?php
						$stmt_fuentes = $conn->query('SELECT * FROM siee_fuente_dato WHERE activo = 1 ORDER BY titulo;');
						$fuentes = $stmt_fuentes->fetchAll();
						$stmt_fuentes->closeCursor();
						
						$stmt_mis_fuentes = $conn->query('SELECT fuente_dato_id FROM "siee_rel-indicador__fuente_dato" where indicador_id = ' . $id_de_Indicador . ';');
						$mis_fuentes = $stmt_mis_fuentes->fetchAll(PDO::FETCH_COLUMN, 0);
						$stmt_mis_fuentes->closeCursor();
						
                        foreach ($fuentes as $fuente) {
                            if (in_array($fuente['id'], $mis_fuentes)) {
                                echo'<li>
									<label style="cursor:pointer;"><input name="fuenteDatoId_mod" type="checkbox" value="' . $fuente['id'] . '" checked="checked"/>' . htmlentities($fuente['titulo']) . '</label>
									</li>';
                            } else {
                                echo '<li>
                                      <label style="cursor:pointer;"><input name="fuenteDatoId_mod" type="checkbox" value="' . $fuente['id'] . '"/>' . htmlentities($fuente['titulo']) . '</label>
                                  </li>';
                            }
                        }
                        ?>
					</ul>
				</div>
			</div>
            <div class="itemsFormularios">
                <ul class="errores_por_campo" id="errors_PrivadoIndicador_mod">
                </ul>
                <label for="PrivadoIndicador_mod">¿Es Privado?</label>
                <div id="rdBtnEsPrivado_mod" style="display:inline-block;">
                <?php
                if ($queryIndicadores['privado'] == 1) {
                    echo '<label for="NoEsPrivado">No</label>';
                    echo '<input id="NoEsPrivado" type="radio" name="Privado_mod" value="0" />';
                    echo '<label for="SiEsPrivado">Si</label>';
                    echo '<input id="SiEsPrivado" type="radio" name="Privado_mod" value="1" checked="Checked" />';                    
                } else {
                    echo '<label for="NoEsPrivado">No</label>';
                    echo '<input id="NoEsPrivado" type="radio" name="Privado_mod" value="0" checked="Checked"/>';
                    echo '<label for="SiEsPrivado">Si</label>';
                    echo '<input id="SiEsPrivado" type="radio" name="Privado_mod" value="1" />';
                }
                ?>
                </div>



            </div>

            <div class="itemsFormularios">
                <ul class="errores_por_campo" id="errors_DescripcionIndicador_mod">
                </ul>
                <label for="DescripcionIndicador_mod">Descripci&oacute;n:</label>
                <textarea id="DescripcionIndicador_mod" name="descripcionIndicador_mod" maxlength="256" ><?php echo htmlentities($queryIndicadores['descripcion']) ?></textarea>
            </div>
            <div class="itemsFormularios">
                <ul class="errores_por_campo" id="errors_InterpretacionIndicador_mod">
                </ul>
                <label for="InterpretacionIndicador_mod" >Interpretaci&oacute;n:</label>
                <textarea id="InterpretacionIndicador_mod" name="observacionIndicador_mod" maxlength="2048" ><?php echo htmlentities($queryIndicadores['interpretacion']) ?></textarea>
            </div>
			
			<div class="itemsFormularios">
				<ul class="errores_por_campo" id="errors_CodigoMathml_mod">
				</ul>

				<div id="MathmlDeFormula_mod">
					<label for="CodigoMathml_mod" ><a href="http://es.wikipedia.org/wiki/MathML" style="font-size: 10pt;" target="_blank">MATHML</a> de la F&oacute;rmula:</label>
					<textarea id="CodigoMathml_mod" name="CodigoMathml_mod" maxlength="4096" ><?php echo html_entity_decode($queryIndicadores['formula_mathml']) ?></textarea>
				</div>
			</div>
			
			<hr/>
			<div id="CampoDeVariables_mod" style="background-color:#fcfcfc;">
				<?php
                                        $tmp = 0;
					foreach ($lista_de_variables as $variables) {
                                            if($tmp > 0){
                                                echo "<hr class=\"punteado\">";
                                            }
				?>
				<div class="itemsFormularios">
					<ul class="errores_por_campo" id="errors_listaDeVariables_mod"></ul>
					<label>Mathml variable : </label>
					<textarea name="variables_mod" maxlength="2048"><?php echo html_entity_decode($variables['titulo']) ?></textarea>
					<ul class="errores_por_campo" id="errors_listaDeVariablesDescripcion_mod"></ul>
					<div style="margin-top:4px;">
                                            <label>Descripci&oacute;n de variable</label>
                                            <input <?php echo ($tmp > 0) ? "style=\"width:464px\"" : ""; ?> type="text" name="variablesDescripcion_mod" maxlength="2048" value="<?php echo htmlentities($variables['descripcion'])?>"/>
                                            <?php 
                                                if($tmp > 0){
                                            ?>
                                            <a name="QuitarFormula" onclick="eliminarEstaVariable(this)" style="display:inline-block;left:4px;top:2px;height:20px"></a>
                                            <?php 
                                                }
                                            ?>
					</div>
				</div>
				<?php
                                    $tmp += 1;
                                    }
				?>
				<div class="itemsFormularios" style="text-align:right;" id="EspacioBotonAgregarVariable_mod">
					<input type ="button" class="ui-boton-agregar" onclick="AgregarVariableMod()"value ="Agregar nuevo campo de variables"/>
				</div>
			</div>
			<hr/>
			
            <div class="itemsFormularios">
                <ul class="errores_por_campo" id="errors_ObservacionGraficos_mod">
                </ul>
                <label for="ObservacionGraficos_mod" >Observaciones del Gr&aacute;fico:</label>
                <textarea id="ObservacionGraficos_mod" name="observacionGraficos_mod" maxlength="2048"><?php echo htmlentities($queryIndicadores['observaciones_grafica']) ?></textarea>
            </div>
            <div class="itemsFormularios">
                <ul class="errores_por_campo" id="errors_ObservacionGenerales_mod">
                </ul>
                <label for="ObservacionGenerales_mod" >Observaciones Generales:</label>
                <textarea id="ObservacionGenerales_mod" name="observacionGenerales_mod" maxlength="2048" ><?php echo htmlentities($queryIndicadores['observacion_general']) ?></textarea>
            </div>
            <div class="itemsFormularios">
                <ul class="errores_por_campo" id="errors_TipoDeEducacionIndicador_mod">
                </ul>
                <label for="" >Tipo de Educaci&oacute;n:</label>
                <select id="TipoDeEducacionIndicador_mod">
                    <?php
                    foreach ($lista_tipos_educacion as $tipoEducacion) {
                        if ($queryIndicadores['tipo_educacion_id'] == $tipoEducacion['id']) {
                            echo '<option value="' . $tipoEducacion['id'] . '"  selected="selected">' . utf8_encode($tipoEducacion['titulo']) . '</option>';
                        } else {
                            echo '<option value="' . $tipoEducacion['id'] . '">' . utf8_encode($tipoEducacion['titulo']) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="itemsFormularios">
                <ul class="errores_por_campo" id="errors_TipoDeMatriculaIndicador_mod">
                </ul>
                <label for="" >Tipo de Matricula:</label>
                <select id ="TipoDeMatriculaIndicador_mod">
                    <?php
                    foreach ($lista_tipos_matricula as $tipoMatricula) {
                        if ($queryIndicadores['tipo_matricula_id'] == $tipoMatricula['id']) {
                            echo '<option value="' . $tipoMatricula['id'] . '"  selected="selected">' . utf8_encode($tipoMatricula['titulo']) . '</option>';
                        } else {
                            echo '<option value="' . $tipoMatricula['id'] . '">' . utf8_encode($tipoMatricula['titulo']) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="itemsFormularios">     
                <ul class="errores_por_campo" id="errors_SeriesIndicadoresIds_mod">
                </ul>
                <label for="SerieIndicadores_mod" style="width:100%;">Selecciona la(s) Serie(s) a las que pertenece el indicador:</label>
                <div class="itemsFormularios" style="height: 320px;" >   

                    <div id="SerieIndicadores_mod" style="width:97.3%;max-height: none;height: 100%;" class="boxListasChkBx">
                        <ul>
                            <?php
                            foreach ($queryListaDeSeries as $serie_ind) {

                                $idSerieMod = $serie_ind['id'];

                                $stmt_lista_serie_numero_mod = $conn->query('SELECT  count(indicador_id)
                                                                            FROM [siee_rel-indicador__serie_indicadores]
                                                                            where serie_indicadores_id = ' . $idSerieMod);
                                $lista_serie_mod = $stmt_lista_serie_numero_mod->fetchAll();
                                $stmt_lista_serie_numero_mod->closeCursor();

                                if (sizeof($lista_serie_mod) == 0) {
                                    if (in_array($idSerieMod, $lista_series_indicadores_mod)) {
                                        echo '<li>
                                                    <label style="cursor:pointer;"><input name="serieIndicadoresId_mod" type="checkbox" value="' . $serie_ind['id'] . '" checked="checked"/>' . htmlentities($serie_ind['titulo']) . '</label><label style="float:right;min-width:0;">' . $lista_serie_mod[0][0] .' de '. $serie_ind['cantidad_indicadores'] . '</label>
                                                </li>';
                                    } else {
                                        echo '<li>
                                                    <label style="cursor:pointer;"><input name="serieIndicadoresId_mod" type="checkbox" value="' . $serie_ind['id'] . '"/>' . htmlentities($serie_ind['titulo']) . '</label><label style="float:right;min-width:0;">' . $lista_serie_mod[0][0] .' de '. $serie_ind['cantidad_indicadores'] . '</label>
                                                </li>';
                                    }
                                } else {
//                                            
                                    if ($lista_serie_mod[0][0] >= $serie_ind['cantidad_indicadores']) {
                                        // echo htmlentities($serie_ind['titulo']);
                                        //aqui deberia salir los que no deberian salir por
                                        if (in_array($idSerieMod, $lista_series_indicadores_mod)) {
                                            echo '<li style = "color:red;">
														<label style="cursor:pointer;"><input name="serieIndicadoresId_mod" type="checkbox" checked="checked" value="' . $serie_ind['id'] . '"/>' . htmlentities($serie_ind['titulo']) . '</label><label style="float:right;min-width:0;">' . $lista_serie_mod[0][0] .' de '. $serie_ind['cantidad_indicadores'] . '</label>
													</li>';
                                        } else {
                                            echo '<li style = "color:red;">
														<label style="cursor:pointer;"><input disabled="disabled" name="serieIndicadoresId_mod" type="checkbox" value="' . $serie_ind['id'] . '"/>' . htmlentities($serie_ind['titulo']) . '</label><label style="float:right;min-width:0;">' . $lista_serie_mod[0][0] .' de '. $serie_ind['cantidad_indicadores'] . '</label>
													</li>';
                                        }
                                    } else {
                                        if (in_array($idSerieMod, $lista_series_indicadores_mod)) {
                                            echo '<li>
													<label style="cursor:pointer;"><input name="serieIndicadoresId_mod" type="checkbox" checked="checked" value="' . $serie_ind['id'] . '"/>' . htmlentities($serie_ind['titulo']) . '</label><label style="float:right;min-width:0;">' . $lista_serie_mod[0][0] .' de '. $serie_ind['cantidad_indicadores'] . '</label>
												</li>';
                                        } else {
                                           echo '<li>
													<label style="cursor:pointer;"><input name="serieIndicadoresId_mod" type="checkbox" value="' . $serie_ind['id'] . '"/>' . htmlentities($serie_ind['titulo']) . '</label><label style="float:right;min-width:0;">' . $lista_serie_mod[0][0] .' de '. $serie_ind['cantidad_indicadores'] . '</label>
												</li>';
                                        }
                                    }
                                }
							}
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <input style="display: none;" type="text" id="IndicadoresId_mod" value="<?php echo $queryIndicadores['id'] ?>"/>
        </div>
        <div class="itemsFormularios">
            <div class="optionPane">
                <button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionDeIndicadores')">Cerrar sin guardar</button>
                <button class="ui-boton-guardar" onclick="guardarModificacionIndicadores()">Guardar cambios</button>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
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
            $( ".ui-boton-agregar" ).button({
                    icons: {
                            primary: "ui-icon ui-icon-disk"
                    }

            });
            $('a[name="QuitarAlias"]').button({
                    icons: {
                            primary: "ui-icon ui-icon-trash"
                    }
            });
            $('a[name="QuitarFormula"]').button({
                    icons: {
                            primary: "ui-icon ui-icon-trash"
                    }
            });
            $('[name="radioOptions"], #rdBtnEsPrivado_mod').buttonset();
        });
                                    
        function AgregarVariableMod() {
			var htmlCampoVariables = '<div class="itemsFormularios"><hr class="punteado"/>'+
				'<ul class="errores_por_campo" id="errors_listaDeVariables_mod"></ul>'+
				'<label>Mathml variable : </label>'+
				'<textarea name="variables_mod" maxlength="2048"></textarea>'+
				'<div style="margin-top:4px;">'+
				'<label>Descripci&oacute;n de variable</label>'+
				'<input type="text" name="variablesDescripcion_mod" maxlength="2048" style="width:464px"/>'+
				'<a name="QuitarFormula" onclick="eliminarEstaVariable(this)" style="display:inline-block;left:4px;top:2px;height:20px"></a>'+
				'</div>'+
				'</div>';
			var htmlbtn = '<div class="itemsFormularios" style="text-align:right;" id="EspacioBotonAgregarVariable_mod">'+
				'<input type="button" class="ui-boton-agregar" onclick="AgregarVariableMod()"value ="Agregar nuevo campo de variables"/>'+
				'</div>';                   

			$('#EspacioBotonAgregarVariable_mod').slideUp('fast', function(){
				$(this).remove();
				$('#CampoDeVariables_mod').append(htmlCampoVariables + htmlbtn);
				$( ".ui-boton-agregar" ).button({
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
		
		function AgregarAliasMod() {
			var htmlCampoAlias = '<div class="itemsFormularios"><hr class="punteado"/>'+
				'<label>Alias:</label>'+
				'<input type="text" name="alias_mod" maxlength="256" style="width:464px"/>'+
				'<a name="QuitarAlias" onclick="eliminarEsteAlias(this)" style="display:inline-block;left:4px;top:2px;height:20px"></a>'+
				'</div>'+
				'</div>';
			var htmlbtn = '<div class="itemsFormularios" style="text-align:right;" id="EspacioBotonAgregarAlias_mod">'+
				'<input type="button" class="ui-boton-agregar" onclick="AgregarAliasMod()" value="Agregar nuevo alias"/>'+
				'</div>';
			var divButton ='<div class="itemsFormularios" style="text-align:right;" id="EspacioBotonAgregarAlias_mod"></div>'

			$('#EspacioBotonAgregarAlias_mod').slideUp('fast', function(){
				$(this).remove();


				$('#alias_mod').append(htmlCampoAlias);
				$('#CampoDeAlias_mod').append(divButton);
				$('#EspacioBotonAgregarAlias_mod').append(htmlbtn);

				$( ".ui-boton-agregar" ).button({
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
                                
    </script>
    <?php
} else {
//si se encontraron errores
    ?>
    <div id="PanelModificacionDeIndicadores" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
        <div class="headerFromularios">
            No se encontr&oacute; el Indicador
        </div>
        <div id="CamposFormulario">
            <div class="itemsFormularios">
                El Indicador que tratas de modificar no ha sido encontrada en el SIEE,
                refresca la pagina, vuelve a entrar a esta secci&oacute;n y realiza la tarea de nuevo.
            </div>
            <div class="itemsFormularios">
                <div class="optionPane">
                    <button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionDeIndicadores')">Cerrar panel</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $( ".ui-boton-cerrar" ).button({
                icons: {
                    primary: "ui-icon ui-icon-closethick"
                } 
            });
        });                         
    </script>
    <?php
}
?>
