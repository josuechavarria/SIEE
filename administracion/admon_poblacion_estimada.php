<?php
include '../phpIncluidos/conexion.php';
?>
<div class="encabezado" id="seccionEncabezadoReporteria">
    <div class="icono">
        <img src="recursos/iconos/preparaReporteIcon_48px.png">
    </div>
    <div class="lineaVertical">&nbsp;</div>
    <div class="descripcion" id="seccionDescripcionEncabezadoReporteria">
        <div class="titulo">
            Administraci&oacute;n de Poblaci&oacute;n Estimada
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
    <div id="tabsPoblacionEstimada">
        <ul>
            <li><a href="#tabsPoblacionEstimada-1" optionInd="1" >
                    <img class="tabIcons" src="recursos/iconos/plus.png" />
                    Par&aacute;metros de calculo de problaci&oacute;n estimada
                </a>
            </li>
        </ul>
        <div id="tabsPoblacionEstimada-1">
            <div class="formularios">
                <div id="CamposFormulario">
                    <label>
                            A&ntilde;o:
                    </label>

                    <select id="Anio" onchange="seleccionDeAnio(this.value);">
                            <?php
                            $stmt_anios_base = $conn->query(" SELECT DISTINCT periodo_id as anio FROM siee_resumen_data_indicadores WHERE es_inicial = 1 AND tipo_indicador_id = 7 ORDER BY periodo_id DESC ");
                            $anios_base = $stmt_anios_base->fetchAll();
                            $stmt_anios_base->closeCursor();

                            $primer_anio = array_shift($anios_base);

                            echo '<option value="' . $primer_anio['anio'] . '" selected="selected">' . $primer_anio['anio'] . '</option>';

                            foreach($anios_base as $anio){
                            echo '<option value="' . $anio['anio'] . '">' . $anio['anio'] . '</option>';
                            }
                            ?>
                    </select>

                    <hr/>

                    <div class="ContenedorTablaDeAnios">
                            <table id="TablaDeAnios">
                                    <thead>
                                            <tr>
                                                    <th>
                                                            Edad
                                                    </th>

                                                    <?php
                                                    for ($i = 1; $i <= 20; $i++) {
                                                            echo '<th title="' . $i . ' a&ntilde;os (Rangos de edades &rarr;)">' . sprintf("%02d", $i) . '</th>';
                                                    }
                                                    ?>
                                            </tr>
                                    </thead>

                                    <tbody>
                                            <?php
                                            include "generar_tabla_anios.php";
                                            ?>
                                    </tbody>
                            </table>

                            <div class="itemsFormularios">
                                    <div class="optionPane">
                                            <button class="ui-boton-guardar" onclick="guardarCambios()">Guardar Cambios</button>
                                    </div>
                            </div>
                    </div>
            </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $( "#tabsPoblacionEstimada" ).tabs();
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
    });
	
	function seleccionDeAnio(anioSeleccionado){
		$.ajax({
			type: "POST",
			url: "administracion/generar_tabla_anios.php",
			data: {anio : anioSeleccionado},
			error: function(){
			},
			success: function(html){
				$('#TablaDeAnios tbody').fadeOut('fast', function(){
					$('#TablaDeAnios tbody').html(html);
					$('#TablaDeAnios tbody').fadeIn('slow');
				});
			}
		});
	}
	
	function guardarCambios(){
		var anio = $('#Anio').val();
		var datos = new Array();
		
		$("input:checked").each(function() {
			datos.push($(this).val());
		});
		
		//alert(datos);
		$.ajax({
			type: "POST",
			url: "administracion/guardar_modificacion_poblacion_estimada.php",
			dataType : 'json',
			data: {
				anio	: anio,
				datos	: datos
			},
			error: function(){
				var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu coneccion este fallando. Porfavor, intentalo de nuevo.</p>";
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
			success: function(_resp){
				if (_resp.refresh_error){
					var _html = "<p>" + _resp.refresh_error + "</p>";
					$( "#dialogWindow" ).html(_html);
					$( "#dialogWindow" ).dialog({
						title   : 'Ups! error',
						modal   : true,
						buttons : {
							"Ok": function() {
								//$(this).dialog("close");
								location.reload();
							}
						},
						minWidth: 600,
						resizable: false
					});
				}else{
					$( "#dialogWindow" ).html('<p>Cambios guardados exitosamente.</p>');
					$( "#dialogWindow" ).dialog({
						title   : "Actualizaci&oacute;n exitosa!",
						modal   : true,
						position        : '50px',
						buttons : {
							"Ok": function() {
								$("#PageTitle").trigger("click");
								$(this).dialog("close");
							}
						},
						minWidth: 600,
						resizable: false
					});
				}
			}
		});
	}
</script>