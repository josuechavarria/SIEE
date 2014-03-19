<?php
include 'conexion.php';

function renderizarIndicador($indicador){
	$html = renderizarTitulo($indicador);
        $html .= renderizarPerfilGeneral($indicador);
	$html .= renderizarPanelDePaginacion($indicador['codigo_indicador']);
	$html .= renderizarPanelBotonesMetadata($indicador['codigo_indicador']);
	$html .= renderizarPanelMetadata($indicador);
	$html .= renderizarContenedorDeGrafica($indicador);
	return $html;
}

function renderizarTitulo($indicador){
	$html = 
	'<div class="tituloIndicadores" id="tituloIndicador">' .
            htmlentities($indicador['titulo']) . 
            '<div class="opcionEliminarIndicador">' .
                    '<a onclick="removerIndicadorDeContenido(\'' . $indicador['codigo_indicador'] . '\')">Remover indicador</a>' . 
            '</div>' .
	'</div>';
	
	return $html;
}
function renderizarPerfilGeneral($indicador){
    $html = 
        '<div class="IndicadorPerfilGeneral" style="max-width:20%;">
            <div class="encabezado">Prom. nacional</div>
            <p class="Big">'. $indicador['PromedioNacional'] . '%</p>
        </div>
        <div class="IndicadorPerfilGeneral" style="max-width:20%;">
            <div class="encabezado">Año base</div>
            <p class="Big">' . $indicador['anio_base'] . '</p>
        </div>
        <div class="IndicadorPerfilGeneral" style="width:54%;">
            <div class="encabezado">Comparación con el año base</div>
            <div class="DescripcionEstado">
                <div>Año base ('.$indicador['anio_base'].'): <span id="valorAnioBase-'. $indicador['codigo_indicador'] .'"></span></div>
                <div>Año seleccionado: <span id="valorAnioActual-'. $indicador['codigo_indicador'] .'"></span></div>
                <div id="EstadoIndicador-'. $indicador['codigo_indicador'] .'"></div>
            </div>
        </div>
        <div class="IndicadorPerfilGeneral" style="width:96%;height:auto;">
            <div class="encabezado">Otros titulos con los cuales se le conoce:</div>
            <ul class="listaMinimalista">';
            if( sizeOf($indicador['alias']) > 0) {
                foreach ($indicador['alias'] as $alias) {
                    $html .= "<li>" . utf8_encode($alias['titulo']) . "</li>";
                }
            } else {
                $html .= '<li style="font-style:italic;">Ninguno</li>';
            }
        $html .= '</ul></div>';
    return $html;
}

function renderizarPanelDePaginacion($codigo){
	$html =
	'<div class="headerPanelOpciones" tour-step="subsite_tour_14_3">
		<a for="' . $codigo . '-pagina1" class="btnPaginaActiva" onclick="paginarPanelInfoInd(this)"/>
		<a for="' . $codigo . '-pagina2" class="btnPaginaInactiva" onclick="paginarPanelInfoInd(this)"/>
	</div>';
	
	return $html;
}

function renderizarPanelBotonesMetadata($codigo){
	$html = 
	'<div tour-step="subsite_tour_14_2" class="panelOpcionesIndicador" id="OpcionesIndicador-' . $codigo . '">
	<div name="paginasOpciones" id="' . $codigo . '-pagina1" style="">
		<div for="' . $codigo . '-metadato_1" name="InformacionIndicador" class="opciones">
			<div class="icono">
				<img src="recursos/iconos/educTipes.png">
			</div>
			<div class="descripcion">
				Tipos Educación
			</div>
		</div>
        <div style="float:left;">
			&nbsp;
		</div>
		<div for="' . $codigo . '-metadato_2" name="InformacionIndicador" class="opciones">
			<div class="icono">
				<img src="recursos/iconos/levels.png">
			</div>

			<div class="descripcion">
				Niveles
			</div>
		</div>
		<div style="float:left;">
			&nbsp;
		</div>
		<div for="' . $codigo . '-metadato_3" name="InformacionIndicador" class="opciones">
			<div class="icono">
				<img src="recursos/iconos/add-descrp.png">
			</div>

			<div class="descripcion">
				Descripción
			</div>
		</div>
		<div style="float:left;">
			&nbsp;
		</div>
		<div for="' . $codigo . '-metadato_4" name="InformacionIndicador" class="opciones">
			<div class="icono">
				<img src="recursos/iconos/add-interp.png">
			</div>

			<div class="descripcion">
				Interpretación
			</div>
		</div>
		<div style="float:left;">
			&nbsp;
		</div>
		<div for="' . $codigo . '-metadato_5" name="InformacionIndicador" class="opciones">
			<div class="icono">
				<img src="recursos/iconos/dataSource.png">
			</div>

			<div class="descripcion">
				Fuente de Datos
			</div>
		</div>
        <div style="float:left;">
			&nbsp;
		</div>
		<div for="' . $codigo . '-metadato_6" name="InformacionIndicador" class="opciones">
			<div class="icono">
				<img src="recursos/iconos/function.png">
			</div>

			<div class="descripcion">
				Fórmula
			</div>
		</div>
	</div>
    <div style="display: none;" name="paginasOpciones" id="' . $codigo . '-pagina2">
		<div style="float:left;">
			&nbsp;
		</div>
		<div for="' . $codigo . '-metadato_7" name="InformacionIndicador" class="opciones">
			<div class="icono">
				<img src="recursos/iconos/funnel-plus.png">
			</div>

			<div class="descripcion">
				Desagregaciones
			</div>
		</div>
		<div style="float:left;">
			&nbsp;
		</div>
		<div for="' . $codigo . '-metadato_8" name="InformacionIndicador" class="opciones">
			<div class="icono">
				<img src="recursos/iconos/eye-plus.png">
			</div>

			<div class="descripcion">
				Observaciones generales
			</div>
		</div>
		<div style="float:left;">
			&nbsp;
		</div>
		<div for="' . $codigo . '-metadato_9" name="InformacionIndicador" class="opciones">
			<div class="icono">
				<img src="recursos/iconos/eye-plus.png">
			</div>
			<div class="descripcion">
				Observaciones de la grafica
			</div>
		</div>
	</div>
	<div for="OpcionesIndicador-' . $codigo . '" name="MostrarTodaMetadata" class="opcionesAgrTodo">
		<div class="icono">
			<img src="recursos/iconos/information-button.png">
		</div>

		<div class="descripcion">
			Agregar Todo
		</div>
	</div>
	<div for="' . $codigo . '" name="EsconderTodaMetadata" class="opcionEsconderTodo">
		<div class="icono">
			<img src="recursos/iconos/eraser.png">
		</div>

		<div class="descripcion">
			Esconder Todo
		</div>
	</div>
	</div>';
	
	return $html;
}

function renderizarPanelMetadata($indicador){
	$html = 
	'<div class="informacionIndicadores" id="' . $indicador['codigo_indicador'] . '-metadato_1" style="display: none;">
	<div class="titulo">
		Tipo(s) de Educación :
		<div name="EsconderInformacionIndicador" class="esconderDatos">
			<img src="recursos/iconos/eraser.png">
		</div>
	</div>

	<div class="descripcion">
		' . htmlentities($indicador['tipo_de_educacion']['titulo']) . '
	</div>
	</div>';
	
	
	
	$html .=
	'<div class="informacionIndicadores" id="' . $indicador['codigo_indicador'] . '-metadato_2" style="display: none;">
	<div class="titulo">Niveles Educativos:
		<div name="EsconderInformacionIndicador" class="esconderDatos">
			<img src="recursos/iconos/eraser.png">
		</div>
	</div>
	<div class="descripcion">
		<ul style=" list-style-type: disc; margin-left: 10px;">';
	
	foreach($indicador['niveles_educativos'] as $nivel){
		$html .= '<li>' . htmlentities($nivel['titulo']) . '</li>';
	}
	
	$html .=
		'</ul>
	</div>
	</div>';
	
	
	
	$html .=
	'<div class="informacionIndicadores" id="' . $indicador['codigo_indicador'] . '-metadato_3" style="display: none;">
	<div class="titulo">Descripción :
		<div name="EsconderInformacionIndicador" class="esconderDatos">
			<img src="recursos/iconos/eraser.png">
		</div>
	</div>
	<div class="descripcion">
		' . htmlentities($indicador['descripcion']) . '
	</div>
	</div>';
	
	
	
	$html .=
	'<div class="informacionIndicadores" id="' . $indicador['codigo_indicador'] . '-metadato_4" style="display: none;">
	<div class="titulo">Interpretación :
		<div name="EsconderInformacionIndicador" class="esconderDatos">
			<img src="recursos/iconos/eraser.png">
		</div>
	</div>
	<div class="descripcion">
		' . htmlentities($indicador['interpretacion']) . '
	</div>
	</div>';
	
	
	
	$html .=
	'<div class="informacionIndicadores" id="' . $indicador['codigo_indicador'] . '-metadato_5" style="display: none;">
	<div class="titulo">Fuente(s) de los datos :
		<div name="EsconderInformacionIndicador" class="esconderDatos">
			<img src="recursos/iconos/eraser.png">
		</div>
	</div>
	<div class="descripcion">
		<ul style=" list-style-type: disc; margin-left: 10px;">';
	
	foreach($indicador['fuentes_de_datos'] as $fuente){
		$html .= '<li>' . htmlentities($fuente['titulo']) . '</li>';
	}
	
	$html .=
		'</ul>
	</div>
	</div>';
	
	
	
	$html .=
	'<div id="' . $indicador['codigo_indicador'] . '-metadato_6" class="informacionIndicadores" style="display: none;">
	<div class="titulo">F&oacute;rmula de c&aacute;lculo :
		<div class="esconderDatos" name="EsconderInformacionIndicador">
			<img src="recursos/iconos/eraser.png"/>
		</div>
	</div>
	<div class="descripcion">
		<div class="formulaIndicador">
			<div class="formula">'
				. html_entity_decode(trim($indicador['formula_mathml'])) .
			'</div>
			<div class="variable">
				<div class="titulo">Descripción de variable(s):</div>';
				 
	foreach($indicador['variables'] as $variable){
		$html .= 
		'<div class="formulaVariable">' . 
			'<span class="formula">' . html_entity_decode($variable['titulo']) . '</span> = '.
			'<span class="descripcionVariable">' . utf8_encode($variable['descripcion']) . '</span>' .
		'</div>';
	}
	
	$html .=
			'</div>
		</div>
	</div>
	</div>';
	
	
	
	$html .=
	'<div class="informacionIndicadores" id="' . $indicador['codigo_indicador'] . '-metadato_7" style="display: none;">
	<div class="titulo">Desagregaciones :
		<div name="EsconderInformacionIndicador" class="esconderDatos">
			<img src="recursos/iconos/eraser.png">
		</div>
	</div>
	<div class="descripcion">
		<ul style=" list-style-type: disc; margin-left: 10px;">';
		
	foreach($indicador['desagregaciones'] as $desagregacion){
		$html .= '<li>' . htmlentities($desagregacion['titulo']) . '</li>';
	}
	
	$html .=
		'</ul>
	</div>
	</div>';
	
	
	
	$html .=
	'<div class="informacionIndicadores" id="' . $indicador['codigo_indicador'] . '-metadato_8" style="display: none;">
	<div class="titulo">Observaciones Generales :
		<div name="EsconderInformacionIndicador" class="esconderDatos">
			<img src="recursos/iconos/eraser.png">
		</div>
	</div>
	<div class="descripcion">'
		. htmlentities($indicador['observacion_general']) .	
	'</div>
	</div>';
	
	
	
	$html .=
	'<div class="informacionIndicadores" id="' . $indicador['codigo_indicador'] . '-metadato_9" style="display: none;">
	<div class="titulo">Observaciones de la grafica:
		<div name="EsconderInformacionIndicador" class="esconderDatos">
			<img src="recursos/iconos/eraser.png">
		</div>
	</div>
	<div class="descripcion">'
		. htmlentities($indicador['observaciones_grafica']) . 
	'</div>
	</div>';
	
	return $html;
}

function renderizarContenedorDeGrafica($indicador){
	global $conn;
	
	$html = 
	'<br/>' .
	'<table id="' . $indicador['codigo_indicador'] . '" class="sieeTables_a" cellspacing="0" cellpadding="0">' . 
		'<thead>' .
			'<tr style="height:inherit;">' .
				'<td class="titlesBorderRight" style="height:inherit;">' .
					'<div class="botonDesagregaciones">' .
						'<input for="' . $indicador['codigo_indicador'] . '-panelDesagregaciones" onclick="abrirPanelDesagregaciones(this)" type="button"/>' .
					'</div>' .
					
					'<div class="botonRecargaIndicador">' .
						'<input name="DesagregaIndicador" onclick="recargarIndicador(\'' . $indicador['url_archivo_indicador'] . '\', \'0\')" type="button"/>' .
					'</div>' .
					
					'<div id="' . $indicador['codigo_indicador'] . '-panelDesagregaciones" class="panelDesagregaciones">' .
						'<div class="titulo">' .
							'Panel de Desagregaciones :' .
							'<div for="' . $indicador['codigo_indicador'] . '-panelDesagregaciones" class="cerrarPanel" onclick="cerrarPanelDesagregaciones(this)">Cerrar</div>' . 
						'</div>' .
						
						'<div class="contenidos">';
	
	foreach($indicador['desagregaciones'] as $desagregacion){
		if ($desagregacion['id'] == 1){
			$html .=
			'<div name="DesagregaIndicador" class="botonesDesagreacion" onclick="recargarIndicador(\'' .trim($indicador['url_archivo_indicador']) .'\',\''.$desagregacion['id'].'\')">'.
				'<img src="recursos/iconos/gender.png"/>&nbsp;&nbsp;Desagregar Por Genero' .
			'</div>';
		}else if ($desagregacion['id'] == 2){
			$html .=
			'<div name="DesagregaIndicador" class="botonesDesagreacion" onclick="recargarIndicador(\'' .trim($indicador['url_archivo_indicador']) .'\',\''.$desagregacion['id'].'\')">'.
                '<img src="recursos/iconos/bank.png"/>&nbsp;&nbsp;Desagregar Por Administraci&oacute;n' .
            '</div>';
		}else if ($desagregacion['id'] == 3){
			$html .=
			'<div name="DesagregaIndicador" class="botonesDesagreacion" onclick="recargarIndicador(\'' .trim($indicador['url_archivo_indicador']) .'\',\''.$desagregacion['id'].'\')">' .
                '<img src="recursos/iconos/zone.png"/>&nbsp;&nbsp;Desagregar Por Zona' .
			'</div>';
		}else if ($desagregacion['id'] == 7){
			$html .=
			'<div name="DesagregaIndicador" class="botonesDesagreacion" onclick="recargarIndicador(\'' .trim($indicador['url_archivo_indicador']) .'\',\''.$desagregacion['id'].'\')">' .
                '<img src="recursos/iconos/pencil-ruler.png"/>&nbsp;&nbsp;Desagregar Por Modalidad' .
            '</div>';
		}else{
			continue;
		}
	}
	
	$html .=
							'<div id="' . $indicador['codigo_indicador'] . '_btnGlobal" class="botonResetDesagreacion" onclick="recargarIndicador(\'' .trim($indicador['url_archivo_indicador']) .'\',\'0\')">' .
								'<img src="recursos/iconos/globe.png"/>&nbsp;&nbsp;Ver Global' .
							'</div>' . 
						'</div>' .
					'</div>' .
				'</td>' .
			'</tr>' .
		'</thead>' .
		'<tbody>' .
			'<tr class="whiteRow">' .
				'<td class="rowheight rightBorder contentCell">' .
					'<div id="contenedorGraficas-' . $indicador['codigo_indicador'] . '" style="width: 770px; height: auto; margin: 0 auto">' .
					
					'</div>' .
				'</td>' .    
			'</tr>' .      
		'</tbody>' .
			
		'<tfoot>' .
			'<tr>' .
				'<td colspan="4">' .
					'<div class="tableButtonsContainerLeft">' .
						'<div class="tableButtons" tour-step="subsite_tour_14_7">' .
							'<input id="' . $indicador['codigo_indicador'] . '_fancyInfoIndicador" onclick="obtenerFichaTecnica(\'' . $indicador['codigo_indicador'] . '\')" title="Haga clic aqui para ver la Ficha Técnica." grav="sw" name="botonesTablas" class="infoTableViewEnabled" type="button" />' .
						'</div>' .
						'<div class="tableButtons" tour-step="subsite_tour_14_8">' .
							'<input name="botonesTablas" class="viewDataTableEnabled" type="button" onclick="obtenerTablaDatos(\'' . $indicador['codigo_indicador'] . '\')" id="'. $indicador['codigo_indicador'] . '_btnDataTable" title="Haga clic aqui para ver la Tabla de Datos." grav="sw"/>' .
						'</div>' .
						'<a class="EnlaceVerComentarios" href="javascript:cargarPanelDeComentarios(' . $indicador['id'] . ');">';
	
	$stmt_cantidad_comentarios = $conn->query('SELECT COUNT(*) FROM siee_comentario WHERE indicador_id = ' . $indicador['id'] . ' AND activo = 1;');
	$cantidad_comentarios = $stmt_cantidad_comentarios->fetch();
	$stmt_cantidad_comentarios->closeCursor();

	if ($cantidad_comentarios[0] == 0){
		$html.= 'Comentar';
	}else{
		$html.= 'Ver comentarios (' . $cantidad_comentarios[0] . ')';
	}
	
	$html .=
						'</a>' .
					'</div>' .
					'<div class="tableButtonsContainerRight">' .
						'<!--div id="tableDownload" class="tableButtons">' .
							'<input name="botonesTablas" class="downloadTableViewEnabled" type="button" /></div>' .
						'<div id="tableExpand" class="tableButtons">' .
							'<input name="botonesTablas" class="expandTableViewDisabled" type="button" /></div-->' .
					'</div>' .
				'</td>' .
			'</tr>' .
		'</tfoot>' .
	'</table>';
	
	return $html;
}

function selectIndicadorPorId($id){
	global $conn;
	
	$stmt_indicador = $conn->query('SELECT * FROM siee_indicador WHERE id = ' . $id . ';');
	$indicador = $stmt_indicador->fetch();
	$stmt_indicador->closeCursor();
	
	$stmt_tipo_de_educacion = $conn->query('SELECT T.* FROM siee_tipo_educacion AS T, siee_indicador AS I WHERE T.id = I.tipo_educacion_id AND I.id = ' . $id . ';');
	$tipo_de_educacion = $stmt_tipo_de_educacion->fetch();
	$stmt_tipo_de_educacion->closeCursor();
	
	$stmt_niveles = $conn->query('SELECT N.* FROM siee_nivel_educativo AS N, "siee_rel-indicador__nivel_educativo" AS R, siee_indicador AS I WHERE N.id = R.nivel_educativo_id AND R.indicador_id = I.id AND I.id = ' . $id . ';');
	$niveles = $stmt_niveles->fetchAll();
	$stmt_niveles->closeCursor();
	
	$stmt_fuentes = $conn->query('SELECT * FROM siee_fuente_dato
                                    WHERE id IN (
                                                    SELECT DISTINCT fuente_dato_id
                                                    FROM "siee_rel-indicador__fuente_dato"
                                                    WHERE indicador_id = ' . $id . '
                                            )
                                    ORDER BY titulo');
	$fuentes = $stmt_fuentes->fetchAll();
	$stmt_fuentes->closeCursor();
	
	$stmt_variables = $conn->query('SELECT * FROM siee_variables_indicador WHERE indicador_id = ' . $id);
	$variables = $stmt_variables->fetchAll();
	$stmt_variables->closeCursor();
	
	$stmt_desagregaciones = $conn->query('	SELECT TD.*
                                                FROM "siee_rel-indicador__tipo_desagregacion" REL
                                                INNER JOIN siee_tipo_desagregacion TD ON TD.id = REL.tipo_desagregacion_id
                                                WHERE REL.indicador_id = ' . $id);
	$desagregaciones = $stmt_desagregaciones->fetchAll();
	$stmt_desagregaciones->closeCursor();
	
        $stmt_alias = $conn->query('	SELECT titulo
                                        FROM siee_alias
                                        WHERE indicador_id = ' . $id .' ORDER BY titulo');
	$alias = $stmt_alias->fetchAll();
	$stmt_alias->closeCursor();
        
        
	$indicador['tipo_de_educacion'] = $tipo_de_educacion;
	$indicador['niveles_educativos'] = $niveles;
	$indicador['fuentes_de_datos'] = $fuentes;
	$indicador['variables'] = $variables;
	$indicador['desagregaciones'] = $desagregaciones;
        $indicador['alias'] = $alias;
	
	return $indicador;
}
/**
 *Esta funcion retorn un dicionario de datos los cuales contienen los totales de lcada variable
 * que son los que iran en la tabla de datos, y el valor total del indicador.
 * @param type $DatosQuery
 * @param type $indicador
 * @return Diccionario de datos, con los 3 calculos
 */
function totales_valorIndicador($DatosQuery, $indicador){
    $anioBase = $indicador['anio_base'];
    $anioSeleccionado = $DatosQuery['anio'];
    $nombreindicador = $indicador['url_archivo_indicador'];
    $arr_datos = Array();
    // obtencion de los datos
    $QueryParametrizado = ObtenerDatos($nombreindicador, $DatosQuery);
    $DatosQuery['anio'] = $anioBase;
    $DatosQuery['desagregacion'] = 0;
    $QueryBase = ObtenerDatos($nombreindicador, $DatosQuery);
    $DatosQuery['anio'] = $anioSeleccionado;
    $DatosQuery['departamento'] = 0;
    $DatosQuery['municipio'] = 0;
    $DatosQuery['centro'] = 0;
    $QueryPerfilGeneral = ObtenerDatos($nombreindicador, $DatosQuery);

    $arr_datos = Array(
            'DatosParametrizados'   => $QueryParametrizado,
            'DatosPerfilGeneral'    => $QueryPerfilGeneral,
            'DatosAnioBase'         => $QueryBase
    );
    
    return $arr_datos;
}
function ObtenerDatos($NombreDeIndicador, $DatosQuery) {
    global $conn;
    #echo '<script>alert("'.$DatosQuery['anio']." ".$DatosQuery['desagregacion']." ".$DatosQuery['departamento'].'");</script>';
    $stmt_datos = $conn->prepare('EXEC Recupera_Indicador_' . $NombreDeIndicador . ' :periodo_id, :tipo_desagregacion_id, :filtroDepto, :filtroMunicipio, :filtroCentroEdu');
    $stmt_datos->execute(
            Array(
                'periodo_id'            => $DatosQuery['anio'],
                'tipo_desagregacion_id' => $DatosQuery['desagregacion'],
                'filtroDepto'           => $DatosQuery['departamento'],
                'filtroMunicipio'       => $DatosQuery['municipio'],
                'filtroCentroEdu'       => $DatosQuery['centro']
    ));
    $datos_indicador = $stmt_datos->fetch();
    $stmt_datos->closeCursor();
    
    return $datos_indicador;
}
?>
