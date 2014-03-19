<div class="cajaOpciones" tour-step="subsite_tour_21">
    <div class="headerTitle"><br/>Mas Opciones&nbsp;</div> 
    <?php
        if($subSitioId == 1)
        {    
    ?>
    <div class="items" tour-step="subsite_tour_22" style="background-color:#fff;">
        <div class="espacioIcono"><img src="recursos/iconos/reports.png"/></div>
        <div class="espacioDescripcion" onclick="abrirPreparaReportes()">Preparar Reportes</div>
    </div>
    <div class="items" tour-step="subsite_tour_23" style="background-color:#fff;">
        <div class="espacioIcono"><img src="recursos/iconos/tables-stacks.png"/></div>
        <div class="espacioDescripcion" onclick="abrirPreparaTablaDinamica()">Preparar Tabla de Datos</div>
    </div>
    <?php
        }
    ?>
    <div class="items">
        <div class="espacioIcono"><img src="recursos/iconos/search.png"/></div>
        <div class="espacioDescripcion" onClick="mostrarBuscadorIndicadores(this)">Buscar Indicador</div>
    </div>
     <div class="items">
        <div class="espacioIcono"><img src="recursos/iconos/search.png"/></div>
        <div class="espacioDescripcion" onclick="abrirPanelBusquedaCentrosEdu('titulo_panelRealizarBusqueda')">B&uacute;squeda de Centros Educativos</div>
    </div>
    <!--div class="items">
        <div class="espacioIcono"><img src="recursos/iconos/printer.png"/></div>
        <div class="espacioDescripcion" onClick="alert('En Construcción...')">Imprimir Contenido Actual</div>
    </div-->
    <div class="items">
        <div class="espacioIcono"><img src="recursos/iconos/world.png"/></div>
        <div class="espacioDescripcion" onclick="abrirPanelBusquedaCentrosEdu('titulo_panelSelUniversoBusqueda')">
            Selecci&oacute;n de Universo de Datos</div>
    </div>
    <div class="items">
        <div class="espacioIcono"><img src="recursos/iconos/downloadsBlue2.png"/></div>
        <div class="espacioDescripcion" onclick="javascript:window.open('seccionDescargas.php', '_blank')">Descargas</div>
    </div>                                                                                
    <div class="items">
        <div class="espacioIcono"><img src="recursos/iconos/books-brown.png"/></div>
        <div class="espacioDescripcion" onclick="MostrarGlosarioPalabras()">Glosario</div>
    </div>
    <div class="items">
        <div class="espacioIcono"><img src="recursos/iconos/question-balloon.png"/></div>
        <div class="espacioDescripcion" onClick="alert('En Construcción...')">Preguntas Frecuentes</div>
    </div>
    <br/>
</div>
<br/>
