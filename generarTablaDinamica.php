<?php
include 'phpIncluidos/conexion.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {    
    $stmt_aniosDisponibles = $conn->query(' SELECT DISTINCT periodo_id as anio
                                            FROM siee_resumen_data_indicadores
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
}
?>
<div id="seccionGeneraTablasDinamicas" class="reporteria">
    <div id="seccionEncabezadoReporteria" class="encabezado">
        <div class="icono">
            <img src="recursos/iconos/preparaTablasDatosIcon_48px.png" />
        </div>
        <div class="lineaVertical">&nbsp;</div>
        <div id="seccionDescripcionEncabezadoReporteria" class="descripcion">
            <div class="titulo">
                Generar Tablas de Datos
                <div class="botonCerrarReporteria" onclick="cerrarPreparaTablaDinamica()">Cerrar Secci&oacute;n Tabla Din&aacute;mica</div> 
            </div>
            <div class="subTitulo">
                Aqui puede preparar Tablas de Datos con la informaci&oacute;n deacuerdo a su necesidad.
            </div>
        </div>
    </div>
    <div class="contenido">
        <!-- FILTROS GENERALES -->
        <div class="cajas" style="border: 1px solid #6480a5; background-color: #f1f1f1;">
            <div class="titulo" style="border-bottom: 1px dotted #6480a5;">
                <img src="recursos/iconos/funnel-pencil.png"/>&nbsp;&nbsp;Filtros de la Informaci&oacute;n :
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
                <label><img src="recursos/iconos/chart-up.png"/>&nbsp;Indicador : </label>
                <select id="filtroGral_indicador">
                    <?php
                        foreach( $lista_tipos_estadistica as $tipo_estadistica)
                        {
                            echo '<option value="'. $tipo_estadistica['id'] .'">'. $tipo_estadistica['nombre'] .'</option>';
                        }
                    ?>                        
                </select>
            </div>
        </div>        
        <div class="asteriscos"><span>*&nbsp;</span>Campos Opcionales</div>
        <div class="cajas" id="tableSpace" style="height: 244px; text-align: center; background-color: #fdfdfd; overflow:hidden;">
            <table id="tablaDinamicaDatos" class="tablaReportes" style="width: auto; display: inline-table; text-align: center;" cellspacing="0" cellpadding="0">
                <thead>
                    <tr id="0" style="height: inherit;">
                        <th id="A0" name="columnaTablaDinamica" class="bordeIzq">
                            <select id="selColTablaDinamica_A0" onchange="valuesColumnsChange(this.id)">
                                <option value="deptos" class="visible">Departamentos</option>
                                <option value="admon" class="visible">Administraci&oacute;n</option>
                                <option value="zona" class="visible">Zona</option>
                                <option value="grado" class="visible">Grados</option> 
                                <option value="genero" class="visible">Genero</option> 
                            </select>
                        </th>
                        <th id="B0" name="columnaTablaDinamica" class="bordeIzq" colspan="0">
                            <div id="btn_genTablaDinamica" class="btn_agregar" onclick="agregarColumna()">Agregar Columna</div>
                        </th>
                </tr>
                </thead>
                <tbody style="text-align: center; background-color: #fff;">
                    <!--tr>aqui debe ir los datos de la nueva celda creada</tr-->
                    <tr id="1">
                        <td id="A1" class="bordeIzqCeldas bordeAbajoCeldas">
                            <span style="color: #999999;">Celda con Etiquetas</span>
                        </td>
                        <!--  INSERCION DE CODIGO DINAMICAMENTE -->
                        <td id="B1" class="bordeAbajoCeldas">
                            <div id="selNumerosTablaDinamica">
                                <div>
                                    <label>Calcular : </label>
                                    <select id="celdasTablaDinamica_calculo">
                                        <option value="sumar">La Suma</option>
                                        <!--option value="contar">Conteo</option>
                                        <option value="promedio">El Promedio</option-->                     
                                    </select>
                                </div>
                                <div>
                                    <label>del Dato : </label>
                                    <select id="celdasTablaDinamica_dato">
                                        <option value="totalGral">Total General</option>
                                        <!--option value="precocidad">Precocidad</option>
                                        <option value="taorica">Teorica</option>
                                        <option value="1_sobreedad">1 a&ntilde;o Sobre-edad</option>
                                        <option value="2_sobreedad">2 a&ntilde;o Sobre-edad</option>
                                        <option value="3_sobreedad">3 a&ntilde;o Sobre-edad</option-->
                                        <option value="0a3anios">Hasta 3 a&ntilde;os</option>
                                        <option value="4anios">4 a&ntilde;os</option>
                                        <option value="5anios">5 a&ntilde;os</option>
                                        <option value="6anios">6 a&ntilde;os</option>
                                        <option value="7anios">7 a&ntilde;os</option>
                                        <option value="8anios">8 a&ntilde;os</option>
                                        <option value="9anios">9 a&ntilde;os</option>
                                        <option value="10anios">10 a&ntilde;os</option>
                                        <option value="11anios">11 a&ntilde;os</option>
                                        <option value="12anios">12 a&ntilde;os</option>
                                        <option value="13anios">13 a&ntilde;os</option>
                                    </select> 
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr id="2">
                        <td id="A2" class="bordeIzqCeldas bordeAbajoCeldas">   
                            <!--div class="btn_agregar">Agregar fila</div-->
                        </td>
                        <td id="B2" class="bordeAbajoCeldas" colspan="1" style="text-align: right;"> 
                            <div class="btn_generar" onclick="generarTablaDin()">Generar Tabla</div>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td id="tdfooterTablaDinamica" colspan="2">&nbsp;</td>
                    </tr>
                </tfoot>
            </table>
            <div style="width: 100%; text-align: right; margin-top: 6px;">
                <div class="btn_restablecerTabla" onclick="restableceTabla()">Restablecer Tabla</div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function agregarColumna()
    {         
        var cantidad_columnas_habiles = $('[name|="columnaTablaDinamica"]').length;
        //var id_penultima_columna = $('[name|="columnaTablaDinamica"]')[cantidad_columnas_habiles - 2].id;
        var id_ultima_columna_actual = $('[name|="columnaTablaDinamica"]')[cantidad_columnas_habiles - 1].id;               
        var stringColumnaSelect =   '<th id="'+ id_ultima_columna_actual +'" name="columnaTablaDinamica" class="bordeIzq">'+
                                        '<select id="selColTablaDinamica_'+ id_ultima_columna_actual +'" onchange="valuesColumnsChange(this.id)">'+
                                            '<option value="deptos" class="visible">Departamentos</option>'+
                                            '<option value="admon" class="visible" >Administraci&oacute;n</option>'+
                                            '<option value="zona" class="visible">Zona</option>'+
                                            '<option value="grado" class="visible">Grados</option> '+
                                            '<option value="genero" class="visible">Genero</option>'+
                                        '</select>'+
                                    '</th>';
        var id_ultima_columna_nueva = numaLetra(cantidad_columnas_habiles + 1) + '0';
        
        var stringCelda_de_nuevaColumna = '';
        
        var stringDataBoton =   '<th id="'+ id_ultima_columna_nueva +'" name="columnaTablaDinamica" class="bordeIzq">'+
                                    '<div id="btn_genTablaDinamica" class="btn_agregar" onclick="agregarColumna()">Agregar Columna</div>'+
                                '</th>';                                    
        document.getElementById('0').removeChild(document.getElementById(id_ultima_columna_actual));
        if(cantidad_columnas_habiles < 5)
        {
            $('#0').append(stringColumnaSelect);
            $('#0').append(stringDataBoton);
        }
        else
        {
            $('#0').append(stringColumnaSelect);
        }               
        //despues de crear las nuevas rows y filas de la tabla escondemos data que este previamente seleccionada
        cantidad_columnas_habiles--;
        for(var i = 0; i < cantidad_columnas_habiles; i++)
        {
            var valSelecionados = $('#selColTablaDinamica_' + numaLetra(i+1) + '0').val();
            $('#selColTablaDinamica_' + id_ultima_columna_actual + ' [value|="' + valSelecionados +'"]').removeClass('visible');
            $('#selColTablaDinamica_' + id_ultima_columna_actual + ' [value|="' + valSelecionados +'"]').addClass('hidden');
            
            //alert($('#columnasTablaDinamica_' + id_ultima_columna_actual + ' [value|="' + valSelecionados +'"]').attr('class'));
            
            if($('#selColTablaDinamica_' + id_ultima_columna_actual + ' [value|="' + valSelecionados +'"]').attr('class') == 'hidden')
            {
                $('#selColTablaDinamica_' + id_ultima_columna_actual + ' [value|="' + valSelecionados +'"]').remove();
            }
        }
        // y hacemos selected un de las opciones visibles
        $('#selColTablaDinamica_' + id_ultima_columna_actual + " > .visible").attr('selected', '"selected"');
        if(cantidad_columnas_habiles < 4)
        {
            //sacando el id del td que estaba abajo del boton "Agregar Columna" para insertar el nuevo td con los radio buttons
            //copiar el inner html para luego restaurarlo en el nuevo td
            var id_0_celdaAnterior = $('#selNumerosTablaDinamica').parent('td').attr('id')[0];
            var id_1_celdaAnterior = $('#selNumerosTablaDinamica').parent('td').attr('id')[1];        
            var id_padre_todas_celdas = parseInt($('#selNumerosTablaDinamica').parent('td').parent('tr').attr('id'));

            var id_nueva_celda = id_0_celdaAnterior + id_1_celdaAnterior;//es el id de la celda donde estaba el selector de conteos,sumas etc.        
            var id_celda_calculos = numaLetra(parseInt(letraNum(id_0_celdaAnterior)) + 1) + id_1_celdaAnterior;        
            //copiando lo que habia dentro de la celda de calculos
            var celdaCalculos = $('#' + id_nueva_celda).html();        
            //eliminando la celda de calculos 
            $('#' + id_nueva_celda).remove();        
            //agregando al DOM las nuevas Celdas
            $('#' + id_padre_todas_celdas).append(
                                        '<td id="'+ id_nueva_celda +'" class="bordeIzqCeldas bordeAbajoCeldas">'+
                                            '<label><input id="rad' + id_nueva_celda +'_a" type="radio" name="grupoOpcionesCeldas_' + id_nueva_celda + '" value="etiq"/> Ver Etiquetas</label>'+
                                                '<br/>&Oacute;<br/>'+
                                            '<label><input id="rad' + id_nueva_celda +'_b" type="radio" name="grupoOpcionesCeldas_' + id_nueva_celda + '" value="calc" checked/> Ver C&aacute;lculo</label>'+
                                         '</td>' +
                                         '<td id="' + id_celda_calculos +'" class="bordeIzqCeldas bordeAbajoCeldas">'+ celdaCalculos +'</td>'
                                        ); 
        }
        var colspActual = parseInt($('.btn_generar').parent('td').attr('colspan'));
        colspActual++;
        colspActual++;
        $('.btn_generar').parent('td').attr('colspan', colspActual.toString());
        //haciendo el colspan del footer      
        $('#tdfooterTablaDinamica').attr('colspan',colspActual.toString());
    }
    function generarTablaDin()
    {
        var filtro_anio = $('#filtroGral_anio').val();
        var filtro_indicador = $('#filtroGral_indicador').val();
        var cantidad_columnas_proyectadas = $('[name|="columnaTablaDinamica"]').length;
        var request = "?" + "an=" + filtro_anio + "&ind=" + filtro_indicador;
        var cont = 1;
        if($("#btn_genTablaDinamica").length > 0)
        {
            cont = 1;
            cantidad_columnas_proyectadas--;
            for(var i = 0; i < cantidad_columnas_proyectadas; i++)
            {
                var tipo_dato = 'etiq';
                if(i > 0 && i < 4)
                {
                    if( $('#rad' + numaLetra(cont) + '1_a').attr('checked'))
                    {
                        tipo_dato = 'etiq';
                    }
                    else
                    {
                        tipo_dato = 'calc';
                    }
                }
                if(i == 4)
                {
                    tipo_dato = 'calc';
                }
                    
                request  += '&' +numaLetra(cont) + '0=' + $('#selColTablaDinamica_' + numaLetra(cont) + "0").val() + "-" + tipo_dato;
                cont++;
            }
        }
        else
        {
            cont = 1;
            for(var i = 0; i < cantidad_columnas_proyectadas; i++)
            {
                var tipo_dato = 'etiq';
                if(i > 0 && i < 4)
                {
                    if( $('#rad' + numaLetra(cont) + '1_a').attr('checked'))
                    {
                        tipo_dato = 'etiq';
                    }
                    else
                    {
                        tipo_dato = 'calc';
                    }
                }
                if(i == 4)
                {
                    tipo_dato = 'calc';
                }
                request  += '&' +numaLetra(cont) + '0=' + $('#selColTablaDinamica_' + numaLetra(cont) + "0").val() + "-" + tipo_dato;
                cont++;
            }                
        }
        cantidad_columnas_proyectadas++;
        for(; cantidad_columnas_proyectadas < 6; cantidad_columnas_proyectadas++)
        {
            request  += '&' +numaLetra(cantidad_columnas_proyectadas) + '0=_' + '-_';
        }
        request += '&clc=' + $('#celdasTablaDinamica_calculo').val() + '&dclc=' + $('#celdasTablaDinamica_dato').val();
        //alert(request);
        window.open('tablasDinamica.php' + request, '_blank');
    }
    function restableceTabla()
    {
        StringTablaInicial = '<table id="tablaDinamicaDatos" class="tablaReportes" style="width: auto; display: inline-table; opacity: 0.0; text-align: center;" cellspacing="0" cellpadding="0">'+
                                '<thead>'+
                                    '<tr id="0" style="height: inherit;">'+
                                        '<th id="A0" name="columnaTablaDinamica" class="bordeIzq">'+
                                            '<select id="selColTablaDinamica_A0" onchange="valuesColumnsChange(this.id)">'+
                                                '<option value="deptos" class="visible">Departamentos</option>'+
                                                '<option value="admon" class="visible">Administraci&oacute;n</option>'+
                                                '<option value="zona" class="visible">Zona</option>'+
                                                '<option value="grado" class="visible">Grados</option>'+ 
                                                '<option value="genero" class="visible">Genero</option>'+
                                            '</select>'+
                                        '</th>'+
                                        '<th id="B0" name="columnaTablaDinamica" class="bordeIzq" colspan="0">'+
                                            '<div id="btn_genTablaDinamica" class="btn_agregar" onclick="agregarColumna()">Agregar Columna</div>'+
                                        '</th>'+
                                    '</tr>'+
                                '</thead>'+
                                '<tbody style="text-align: center;">'+
                                    '<!--tr>aqui debe ir los datos de la nueva celda creada</tr-->'+
                                    '<tr id="1">'+
                                       '<td id="A1" class="bordeIzqCeldas bordeAbajoCeldas">'+
                                            '<span style="color: #999999;">Celda con Etiquetas</span>'+
                                        '</td>'+
                                        '<!--  INSERCION DE CODIGO DINAMICAMENTE -->'+
                                        '<td id="B1" class="bordeAbajoCeldas">'+
                                            '<div id="selNumerosTablaDinamica">'+
                                                '<div>'+
                                                    '<label>Calcular : </label>'+
                                                    '<select id="celdasTablaDinamica_calculo">'+
                                                        '<option value="sumar">La Suma</option>'+
                                                        '<!--option value="contar">Conteo</option>'+
                                                        '<option value="promedio">El Promedio</option-->'+                 
                                                    '</select>'+
                                                '</div>'+
                                                '<div>'+
                                                    '<label>del Dato : </label>'+
                                                    '<select id="celdasTablaDinamica_dato">'+
                                                        '<option value="totalGral">Total General</option>'+
                                                        '<!--option value="precocidad">Precocidad</option>'+
                                                        '<option value="taorica">Teorica</option>'+
                                                        '<option value="1_sobreedad">1 a&ntilde;o Sobre-edad</option>'+
                                                        '<option value="2_sobreedad">2 a&ntilde;o Sobre-edad</option>'+
                                                        '<option value="3_sobreedad">3 a&ntilde;o Sobre-edad</option-->'+
                                                        '<option value="0a3anios">Hasta 3 a&ntilde;os</option>'+
                                                        '<option value="4anios">4 a&ntilde;os</option>'+
                                                        '<option value="5anios">5 a&ntilde;os</option>'+
                                                        '<option value="6anios">6 a&ntilde;os</option>'+
                                                        '<option value="7anios">7 a&ntilde;os</option>'+
                                                        '<option value="8anios">8 a&ntilde;os</option>'+
                                                        '<option value="9anios">9 a&ntilde;os</option>'+
                                                        '<option value="10anios">10 a&ntilde;os</option>'+
                                                        '<option value="11anios">11 a&ntilde;os</option>'+
                                                        '<option value="12anios">12 a&ntilde;os</option>'+
                                                        '<option value="13anios">13 a&ntilde;os</option>'+
                                                    '</select>'+
                                                '</div>'+
                                            '</div>'+
                                        '</td>'+
                                    '</tr>'+
                                    '<tr id="2">'+
                                        '<td id="A2" class="bordeIzqCeldas bordeAbajoCeldas">'+
                                            '<!--div class="btn_agregar">Agregar fila</div-->'+
                                        '</td>'+
                                        '<td id="B2" class="bordeAbajoCeldas" colspan="1" style="text-align: right;">'+
                                            '<div class="btn_generar" onclick="generarTablaDin()">Generar Tabla</div>'+
                                        '</td>'+
                                    '</tr>'+
                                '</tbody>'+
                                '<tfoot>'+
                                    '<tr>'+
                                        '<td id="tdfooterTablaDinamica" colspan="2">&nbsp;</td>'+
                                    '</tr>'+
                                '</tfoot>'+
                            '</table>';                        
          $('#tablaDinamicaDatos').animate({
              'opacity'     :   '0.0'
          }, 200, function(){
              $('#tablaDinamicaDatos').remove();
              $('#tableSpace').html(StringTablaInicial + 
                                    '<div style="width: 100%; text-align: right;">'+
                                        '<div class="btn_restablecerTabla" onclick="restableceTabla()">Restablecer Tabla</div>'+
                                    '</div>');
              $('#tablaDinamicaDatos').animate({
                  'opacity'     :   '1.0'
              }, 200);
          });
    }
</script>
