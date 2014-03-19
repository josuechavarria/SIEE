<?php
include '../phpIncluidos/conexion.php';
include '../phpIncluidos/conexion_ee.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt_periodos= $conn_ee->query('SELECT distinct periodo_id from ee_resumen_matricula_inicial order by periodo_id;');
    $periodos_inicial_see = $stmt_periodos->fetchAll();
    $stmt_periodos->closeCursor();
    
    $stmt_periodos= $conn->query('select distinct periodo_id from siee_resumen_data_indicadores where es_inicial = 1 and tipo_indicador_id = 7 order by periodo_id;');
    $periodos_inicial_siee = $stmt_periodos->fetchAll();
    $stmt_periodos->closeCursor();
    
    $stmt_periodos= $conn_ee->query('SELECT distinct periodo_id from ee_resumen_matricula_final where periodo_id <> 2012 order by periodo_id;');
    $periodos_final_see = $stmt_periodos->fetchAll();
    $stmt_periodos->closeCursor();
    
    $stmt_periodos= $conn->query('select distinct periodo_id from siee_resumen_data_indicadores where es_inicial = 0 order by periodo_id;');
    $periodos_final_siee = $stmt_periodos->fetchAll();
    $stmt_periodos->closeCursor();
    
    
}
?>
<style>
    .barraProgreso div{
        width: 0%;
        transition: all 30s;
    }
</style>
<div class="encabezado" id="seccionEncabezadoReporteria">
    <div class="icono">
        <img src="recursos/iconos/preparaReporteIcon_48px.png">
    </div>
    <div class="lineaVertical">&nbsp;</div>
    <div class="descripcion" id="seccionDescripcionEncabezadoReporteria">
        <div class="titulo">
            Migración de datos estadísticos
            <div onclick="cerrarSeccionAdmin()" class="botonCerrarSeccion">Cerrar Sección</div> 
        </div>
        <div class="subTitulo">                                                    
        </div>                                                
    </div>
</div>
<div class="contenido">
    <br/>
    <div id="dialogWindow" title="" style="font-size: 10pt;">
    </div>
    <div id="tabsMigracionDatos">
        <ul>
            <li><a href="#tabsMigracionDatos-1" optionInd="1" >
                    <img class="tabIcons" src="recursos/iconos/database-insert.png" />
                    Migrar estadística inicial
                </a>
            </li>
            <li><a href="#tabsMigracionDatos-2" optionInd="2">
                    <img class="tabIcons" src="recursos/iconos/database-insert.png" />
                    Migrar estadística final
                </a>
            </li>
            <li><a href="#tabsMigracionDatos-3" optionInd="3">
                    <img class="tabIcons" src="recursos/iconos/database-delete.png" />
                    Eliminar todo
                </a>
            </li>
        </ul>
        <div id="tabsMigracionDatos-1">
            <div class="formularios">
                <div id="CamposFormulario">
                    <div class="itemsFormularios">
                        <div class="boxListasChkBx" id="AniosMigrados" style="display:inline-block;width: 222px;height:500px;">
                            <label>Periodos/Años disponibles en SIEE</label>
                            <ul>
                                <?php 
                                foreach ($periodos_inicial_siee as $periodo){
                                    echo '<li><label style="cursor:pointer;">Año '. $periodo['periodo_id'] .'</label></li>';
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="boxListasChkBx" id="AniosPorMigrar" style="display:inline-block;width:222px;height:500px;">
                            <label>Periodos/Años disponibles en SEE</label>
                            <ul>
                                <?php 
                                foreach ($periodos_inicial_see as $periodo){
                                    echo '<li><label style="cursor:pointer;">Año '. $periodo['periodo_id'] .'</label></li>';
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="boxListasChkBx" id="AniosMigrar" style="display:inline-block;width:222px;height:500px;">
                            <label>Seleccione el/los años a migrar</label>
                            <ul>
                                <?php 
                                foreach ($periodos_inicial_see as $periodo){
                                    if( !in_array($periodo, $periodos_inicial_siee) ){
                                        echo '<li><label style="cursor:pointer;"><input value="'.$periodo['periodo_id'].'" name="iniciales[]" type="checkbox"/>Año '. $periodo['periodo_id'] .'</label></li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="itemsFormularios">
                        <div id="progressBarInicial" class="barraProgreso"></div>
                    </div>
                    <div class="itemsFormularios">
                        <div class="optionPane">
                            <button class="ui-boton-inicial" onclick="MigrarEstadisticaInicial(this)">Iniciar la importación de datos (inicial)</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="tabsMigracionDatos-2">
            <div class="formularios">
                <div class="itemsFormularios">
                    <div class="boxListasChkBx" id="AniosMigrados" style="display:inline-block;width: 222px;height:500px;">
                        <label>Periodos/Años disponibles en SIEE</label>
                        <ul>
                            <?php
                            foreach ($periodos_final_siee as $periodo) {
                                echo '<li><label style="cursor:pointer;">Año ' . $periodo['periodo_id'] . '</label></li>';
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="boxListasChkBx" id="AniosPorMigrar" style="display:inline-block;width:222px;height:500px;">
                        <label>Periodos/Años disponibles en SEE</label>
                        <ul>
                            <?php
                            foreach ($periodos_final_see as $periodo) {
                                echo '<li><label style="cursor:pointer;">Año ' . $periodo['periodo_id'] . '</label></li>';
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="boxListasChkBx" id="AniosMigrar" style="display:inline-block;width:222px;height:500px;">
                        <label>Seleccione el/los años a migrar</label>
                        <ul>
                            <?php
                            foreach ($periodos_final_see as $periodo) {
                                if (!in_array($periodo, $periodos_final_siee)) {
                                    echo '<li><label style="cursor:pointer;"><input value="' . $periodo['periodo_id'] . '" name="finales[]" type="checkbox"/>Año ' . $periodo['periodo_id'] . '</label></li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="itemsFormularios">
                    <div id="progressBarFinal" class="barraProgreso"></div>
                </div>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button es-inicial="0" class="ui-boton-final" onclick="MigrarEstadisticaFinal(this)">Iniciar la importación de datos (final)</button>
                    </div>
                </div>
            </div>            
        </div>
        <div id="tabsMigracionDatos-3">
            <div class="formularios">
                <div class="itemsFormularios ui-state-error ui-corner-all">
                    <p>
                        <span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
                        <strong>NOTA!</strong>
                        Esta opción elimina toda la estadística previamente migrada al SIEE, use esta opción cuando se conozca movimiento de datos
                        en la estadística ya migrada para migrar nuevamente todos los años de estadística en el aplicativo SEE.
                    </p>
                </div>
                <div class="itemsFormularios">
                    <div id="progressBarMasiva" class="barraProgreso"></div>
                </div>
                <div class="itemsFormularios">
                    <div class="optionPane">
                        <button class="ui-boton-masivo" onclick="EliminarTodaEstadistica(this)">Eliminar todos los datos</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $( "#tabsMigracionDatos" ).tabs();
        $( ".ui-boton-inicial, .ui-boton-final, .ui-boton-masivo" ).button({
            icons: {
                primary: "ui-icon ui-icon-circle-triangle-e"
            } 
        });
        $('[name="radioOptions"]').buttonset();
        $( "#progressBarInicial, #progressBarFinal, #progressBarMasiva" ).progressbar({
            value: 0
        });
    });
    
    function MigrarEstadisticaInicial(elem){
        var esInicial = 1;        
        var aniosSeleccionados = Array();
        $.each($('input[name="iniciales[]"]:checked'), function(){
            aniosSeleccionados.push($(this).val());
        });
        if(aniosSeleccionados.length > 0){
            $(elem).attr('disabled','disabled').fadeOut('fast');
            $('#progressBarInicial div').css({'width':'70%','display':'block'});
            $.ajax({
                type: "POST",
                url: "administracion/migracion_procesos.php",
                cache: false,
                dataType: 'json',
                async: false,
                data: {
                    es_inicial      :   esInicial,
                    periodos        :   aniosSeleccionados,
                    opcion          : 1
                },
                error: function(){
                    var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexi&oacute;n. Porfavor, int&eacute;ntalo de nuevo.</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                                $(elem).removeAttr('disabled').fadeIn('fast');
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                    $('#progressBarInicial div').css('width','0');
                },
                success: function(_resp)
                {				
                    $(elem).removeAttr('disabled').fadeIn('fast');
                    if (_resp.refresh_error){
                        $('#progressBarInicial div').css('width','0');
                        $( "#dialogWindow" ).html(_resp.refresh_error);
                        $( "#dialogWindow" ).dialog({
                            title   : 'Ups! error al tratar de realizar la tarea',
                            modal   : true,
                            buttons : {
                                "Ok": function() {
                                    $(this).dialog("close");
                                    $('#PageTitle').trigger('click');
                                    abrirSeccionAdmin(16,1);
                                }
                            },
                            minWidth: 600,
                            resizable: false
                        });
                    }else{
                        $('#progressBarInicial div').css({'width':'100%','transition':'1s'});
                        $( "#dialogWindow" ).html('<p>' + _resp.success +'</p>');
                        $( "#dialogWindow" ).dialog({
                            title   : 'Transaci&oacute;n Exitosa!',
                            modal   : true,
                            buttons : {
                                "Perfecto": function() {
                                    $(this).dialog("close");
                                    $('#PageTitle').trigger('click');
                                    abrirSeccionAdmin(16,1);
                                }
                            },
                            minWidth: 600,
                            resizable: false
                        });
                    }
                }
            });
        }else{
            var _html = "<p>Debe seleccionar al menos 1 año para migrar.</p>";
            $( "#dialogWindow" ).html(_html);
            $( "#dialogWindow" ).dialog({
                title   : 'Nota!',
                modal   : true,
                buttons : {
                    "Ok": function() {
                        $(this).dialog("close");
                        $(elem).removeAttr('disabled').fadeIn('fast');
                    }
                },
                minWidth: 600,
                resizable: false
            });
        }
    }
    
    function MigrarEstadisticaFinal(elem){
        var esInicial = 0;        
        var aniosSeleccionados = Array();
        $.each($('input[name="finales[]"]:checked'), function(){
            aniosSeleccionados.push($(this).val());
        });
        if(aniosSeleccionados.length > 0){
            $(elem).attr('disabled','disabled').fadeOut('fast');
            $('#progressBarFinal div').css({'width':'70%','display':'block'});
            $.ajax({
                type: "POST",
                url: "administracion/migracion_procesos.php",
                cache: false,
                dataType: 'json',
                async: false,
                data: {
                    es_inicial      :   esInicial,
                    periodos        :   aniosSeleccionados,
                    opcion          : 1
                },
                error: function(){
                    var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexi&oacute;n. Porfavor, int&eacute;ntalo de nuevo.</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                                $(elem).removeAttr('disabled').fadeIn('fast');
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                    $('#progressBarFinal div').css('width','0');
                },
                success: function(_resp)
                {				
                    $(elem).removeAttr('disabled').fadeIn('fast');
                    if (_resp.refresh_error){
                        $('#progressBarFinal div').css('width','0');
                        $( "#dialogWindow" ).html(_resp.refresh_error);
                        $( "#dialogWindow" ).dialog({
                            title   : 'Ups! error al tratar de realizar la tarea',
                            modal   : true,
                            buttons : {
                                "Ok": function() {
                                    $(this).dialog("close");
                                    $('#PageTitle').trigger('click');
                                    abrirSeccionAdmin(16,2);
                                }
                            },
                            minWidth: 600,
                            resizable: false
                        });
                    }else{
                        $('#progressBarFinal div').css({'width':'100%','transition':'1s'});
                        $( "#dialogWindow" ).html('<p>' + _resp.success +'</p>');
                        $( "#dialogWindow" ).dialog({
                            title   : 'Transaci&oacute;n Exitosa!',
                            modal   : true,
                            buttons : {
                                "Perfecto": function() {
                                    $(this).dialog("close");
                                    $('#PageTitle').trigger('click');
                                    abrirSeccionAdmin(16,2);
                                }
                            },
                            minWidth: 600,
                            resizable: false
                        });
                    }
                }
            });
        }else{
            var _html = "<p>Debe seleccionar al menos 1 año para migrar.</p>";
            $( "#dialogWindow" ).html(_html);
            $( "#dialogWindow" ).dialog({
                title   : 'Nota!',
                modal   : true,
                buttons : {
                    "Ok": function() {
                        $(this).dialog("close");
                        $(elem).removeAttr('disabled').fadeIn('fast');
                    }
                },
                minWidth: 600,
                resizable: false
            });
        }
    }
    
    function EliminarTodaEstadistica(){
        $( "#dialogWindow" ).html('<p>¿Seguro(a) que desea eliminar los datos de estadística de todos los años?</p>');
        $( "#dialogWindow" ).dialog({
            title   : 'Confirmación',
            modal   : true,
            buttons : {
                "Si, estoy seguro(a)": function() {
                    $(this).dialog("close");
                    ConfirmarEliminar();
                },
                "Cancelar": function() {
                    $(this).dialog("close");
                }
            },
            minWidth: 600,
            resizable: false
        });
    }
    
    function ConfirmarEliminar(elem){
        $('#progressBarMasiva div').css({'width':'70%','display':'block'});
        $.ajax({
                type: "POST",
                url: "administracion/migracion_procesos.php",
                cache: false,
                dataType: 'json',
                async: false,
                data: {
                    opcion : 2
                },
                error: function(){
                    var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexi&oacute;n. Porfavor, int&eacute;ntalo de nuevo.</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                                $(elem).removeAttr('disabled').fadeIn('fast');
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                    $('#progressBarMasiva div').css('width','0');
                },
                success: function(_resp)
                {
                    if (_resp.refresh_error){
                        $('#progressBarMasiva div').css('width','0');
                        $( "#dialogWindow" ).html(_resp.refresh_error);
                        $( "#dialogWindow" ).dialog({
                            title   : 'Ups! error al tratar de realizar la tarea',
                            modal   : true,
                            buttons : {
                                "Ok": function() {
                                    $(this).dialog("close");
                                    $('#PageTitle').trigger('click');
                                    abrirSeccionAdmin(16,1);
                                }
                            },
                            minWidth: 600,
                            resizable: false
                        });
                    }else{
                        $('#progressBarMasiva div').css({'width':'100%','transition':'1s'});
                        $( "#dialogWindow" ).html('<p>' + _resp.success +'</p>');
                        $( "#dialogWindow" ).dialog({
                            title   : 'Transaci&oacute;n Exitosa!',
                            modal   : true,
                            buttons : {
                                "Perfecto": function() {
                                    $(this).dialog("close");
                                    $('#PageTitle').trigger('click');
                                    abrirSeccionAdmin(16,1);
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
