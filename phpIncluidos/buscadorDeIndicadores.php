<?php ?>
<div id="buscadorDeIndicadores" class="buscadorDeIndicadores" tour-step="subsite_tour_5">
    <div id="flechaBuscadorIndicadores" class="flecha"><img src="./recursos/imagenes/flechaBuscadorIndicadores.png"/></div>
    <a tour-step="subsite_tour_5_1" class="cerrarBuscador" onclick="cerrarBuscadorIndicadores()">Esconder</a>
    <div class="headerBuscador">
        Buscador de Indicadores - SIEE
    </div>
    <div class="contenidoBuscador">
        <label for="tituloIndicadorParaBusqueda">¿Que indicador buscas? </label>
        <input tabindex="0" id="tituloIndicadorParaBusqueda" type="text" maxlength="256"/>
        <div class="buscarGlobal">¿No encuentras el indicador? prueba <a onclick="buscarIndicadorEnSIEE('<?php echo $subSitioId ?>')">buscar en todo el SIEE</a>.</div>
    </div>
    <div class="footerBuscador">
        <div class="resultadoBusquedaGlobal">
            <div class="titulo">
                Resultado Busqueda en todo el SIEE:
                <a onclick="$('.resultadoBusquedaGlobal').slideUp('fast')">cerrar</a>
            </div>
            <div class="resultado">
            </div>
        </div>
        <div>
            * Para obtener mejores resultados en tu b&uacute;squeda, usa palabras clave que mejor describan el titulo del indicador que necesitas.
        </div>
    </div>
</div>