<?php
include '../phpIncluidos/RenderizadorDeIndicador.php';
	
if(ISSET($_POST['anio']) && ISSET($_POST['departamento']) && ISSET($_POST['municipio']) && ISSET($_POST['centro']) && ISSET($_POST['desagregacion'])){
	$anio = $_POST['anio'];
	$departamento = $_POST['departamento'];
	$municipio = $_POST['municipio'];
	$centro = $_POST['centro'];
	$desagregacion = $_POST['desagregacion'];
        
        $ParametrosQuery = Array(
            "anio" => $anio,
            "departamento" => $departamento,
            "municipio" => $municipio,
            "centro" => $centro,
            "desagregacion" => $desagregacion

        );
        $DatosQuery = array();
	if (is_numeric($anio) && ctype_digit($anio) && is_numeric($departamento) && ctype_digit($departamento) && is_numeric($municipio) && ctype_digit($municipio) && is_numeric($centro) && ctype_digit($centro) && is_numeric($desagregacion) && ctype_digit($desagregacion)){
                $indicador = selectIndicadorPorId(6);
                $DatosQuery = totales_valorIndicador($ParametrosQuery, $indicador);
                /**
                *En las siguientes lineas se haran los calculos del indicador
                *segun las especificaciones de la formula, para esto se deben realizar 3
                *veces el mismo calculo, los cuales son para:
                * el dato segun la seleccion del usuarios, el dato para el año base y el dato
                * para el promedio nacional del indicador.
                **/
                //calculo del dato para el promedio nacional       
                $DatosParametrizados_PromedioNacional = $DatosQuery['DatosPerfilGeneral'];
                $valorIndicador_PromedioNacional = 0;

                //calculo del datos para el año 
                $DatosParametrizados_anioBase = $DatosQuery['DatosAnioBase'];
                $valorIndicador_anioBase = 0;

                //agregando los valores de los calculos
                $indicador['PromedioNacional'] = $valorIndicador_PromedioNacional;
                $indicador['ValorBase'] = $valorIndicador_anioBase;
                
                if($desagregacion === "0"){
                    //calculo del indicador segun los detalles solicitados en la formula
                    $DatosParametrizados = $DatosQuery['DatosParametrizados'];
                    $valorIndicador = 0;
                }
                else{
                    $DatosParametrizados = $DatosQuery['DatosParametrizados'];
                    $valorIndicador_A = 0;
                    $valorIndicador_B = 0;
                    
                    $etiqueta_A = $DatosParametrizados["etiqueta_A"];
                    $etiqueta_B = $DatosParametrizados["etiqueta_B"];
                    
                }
?>

<div id="contenedorIndicador-<?php echo $indicador['codigo_indicador']; ?>" class="contenedorGlobalDeIndicadores">
	<div id="<?php echo $indicador['codigo_indicador']; ?>" class="indicadorEnContenido">
		<?php
			echo renderizarIndicador($indicador);
		?>
		
		
		<div id="<?php echo $indicador['codigo_indicador'] . "-tablaDatos"; ?>" class="informacionIndicadores">
			<div class="titulo">Tabla de Datos :
				<div name="EsconderInformacionIndicador" class="esconderDatos">
					<img src="recursos/iconos/eraser.png">
				</div>
			</div>
			<div class="descripcion">
				<table id="<?php echo $indicador['codigo_indicador'] . "-tablaDatosIndicador"; ?>" class="TablaDatosSiee" name="indDataTables" cellspacing="0" cellpadding="0">
		<?php
		//SI NO SE APLICAN LAS DESAGREGACIONES SE MUESTRA ESTA TABLA
			if($desagregacion === "0"){
		?>
					<thead>
						<tr>                
							<th>
								Titulo 1
							</th>
							<th>
								Valor
							</th>
						</tr>
					</thead>
					
					<tbody>
						<tr >
							<th>
								Descripci&oacute;n datos 1
							</th>
							<td>  
								7
							</td> 
						</tr>
						<tr>
							<th>
								Descripci&oacute;n datos 2
							</th>
							<td>
								77
							</td> 
						</tr>                     
					</tbody>
					
		<?php
			} else {
			//SI SE APLICAN DESAGREGACIONES, SACAMOS LA TABLA CON LOS CAMPOS
		?>
					<thead>
						<tr >                
							<th >
								Titulo 1
							</th>                            
							<th>
								Valor <?php echo htmlentities($etiqueta_A) ?>
							</th>
							<th>
								Valor <?php echo htmlentities($etiqueta_B) ?>
							</th>
						</tr>
					</thead>
					
					<tbody>
						<tr >
							<th>
								Descripcion 1
							</th>
							<t>  
								7
							</td> 
							<td>  
								77
							</td>
						</tr>
					</tbody>
		<?php
			}
		?> 
					
					<tfoot>
						<tr>
							<td colspan="0">                            
								<div>
                                                                    <button id="<?php echo $indicador['codigo_indicador'] ?>_btnDescargarExcel" title="Haga clic aqui para exportar los datos a Excel" grav="se" name="botonesTablas" onclick="descargarTablaIndicador('<?php echo $indicador['codigo_indicador'] ?>; ?>')">Exportar datos a Excel</button>
								</div>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
		
		<div id="ContainerPanelDeComentarios_<?php echo $indicador['id']; ?>" class="informacionIndicadores">
		</div>  
	</div>
	
	<script type="text/javascript">
                //funcion para ver como se aleja este indicador en base al año base
                $(function() {
                    $("#EstadoIndicador-<?php echo $indicador['codigo_indicador']; ?>").slider({
                        range: true,
                        disabled: true,
                        min: 0,
                        max: 100,
                        values: [ <?php echo $valorIndicador_anioBase?>,  <?php echo $valorIndicador?>],
                        slide: function( event, ui ) {
                            $( "#valorAnioBase-<?php echo $indicador['codigo_indicador']; ?>").text( ui.values[ 0 ] + "%" );
                            $( "#valorAnioActual-<?php echo $indicador['codigo_indicador']; ?>").text( ui.values[ 1 ] + "%" );
                        }
                    });
                    $( "#valorAnioBase-<?php echo $indicador['codigo_indicador']; ?>").text( $( "#EstadoIndicador-<?php echo $indicador['codigo_indicador']; ?>" ).slider( "values", 0 ) + "%" );
                    $( "#valorAnioActual-<?php echo $indicador['codigo_indicador']; ?>").text( $( "#EstadoIndicador-<?php echo $indicador['codigo_indicador']; ?>" ).slider( "values", 1 ) + "%" );
                });
		$(function () {
			var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'contenedorGraficas-<?php echo $indicador['codigo_indicador'];?>',
						type: 'column'
					},
					title: {
						text: '<?php echo utf8_encode($indicador['titulo']) ?>'
					},
					subtitle: {
                                            text: "Universo: " + $('#etiquetaDataMuniGlobal').attr('etiqueta-grafico') + " " + $('#etiquetaDataDeptoGlobal').attr('etiqueta-grafico') + ", Año " + $('#etiquetaDataAnioGlobal').text()
                                        },
					credits: {
						enabled: false
					},
					exporting: {
						filename: '<?php echo str_replace(" ", "_", $indicador['titulo']) ?>'
					},
					xAxis: {
						categories: [
							'1',
							'2',
							'3',
							'4'
						]
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Capacidad (mm)'
						}
					},
					legend: {
						layout: 'vertical',
						backgroundColor: '#FFFFFF',
						align: 'left',
						verticalAlign: 'top',
						x: 100,
						y: 70,
						floating: true,
						shadow: true
					},
					tooltip: {
						formatter: function() {
							return ''+
								this.x +': '+ this.y +' mm';
						}
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0
						}
					},
						series: [{
						name: 'Dato1',
						data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

					}]
				});
			});

		});
	</script>
	<br/>
</div>

<?php
	}else{
		echo 'Error: Uno o mas de los datos enviados tiene formato invalido.';
	}
}else{
	echo 'Error: Falta uno o mas datos para completar la solicitud.';
}
?>