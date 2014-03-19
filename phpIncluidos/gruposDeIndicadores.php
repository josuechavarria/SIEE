<div id="irAlIndicador" class="botonSubir2" onclick="subiraPosInicial()">
    Subir<img src="/SIEE/recursos/iconos/back2TopIcon.png" />
</div>

<div class="controlExpColTodo" tour-step="subsite_tour_12" style="background-color:#fff; text-align:center;">
    <a href="#expandirTodo">Expandir Todo</a>&nbsp;&nbsp;&#124;&nbsp;&nbsp;
    <a href="#colapsarTodo">Colapsar Todo</a>
</div>

<ul class="listaIndicadores" tour-step="subsite_tour_13">

    <?php
    $en_tour = false;
    $stmt_grupos_indicadores = $conn->query('SELECT G.*
                                            FROM siee_grupo_indicadores AS G, siee_subsitio AS S
                                            WHERE G.subsitio_id = S.id AND CHARINDEX(S.url,\'' . $_SERVER['REQUEST_URI'] . '\') > 0
                                            AND G.activo = 1
                                            ORDER BY G.ordenamiento_grupo;');

    $grupos_indicadores = $stmt_grupos_indicadores->fetchAll();
    $stmt_grupos_indicadores->closeCursor();

    foreach ($grupos_indicadores as $grupo) {
        ?>

        <li>
            <div class="tituloGrupo" onclick="expandirGrupoIndicadores(this);" title="<?php echo htmlentities( strtoupper($grupo['titulo_completo'])) . ":\n" . htmlentities($grupo['descripcion']);?>" grav="w">
                <a for="contenidoGrupo_<?php echo $grupo['id']; ?>" class="expCol">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                <?php echo htmlentities($grupo['etiqueta_titulo']); ?>
            </div>

            <div id="contenidoGrupo_<?php echo $grupo['id']; ?>" class="contenidoGrupo">
                <ul>
                    <?php
                    $stmt_indicadores = $conn->query('SELECT I.* FROM siee_indicador AS I, "siee_rel-indicador__grupo_indicadores" AS R WHERE R.indicador_id = I.id AND R.grupo_indicador_id = ' . $grupo['id'] . ' AND I.activo = 1 AND I.publicado = 1 ORDER BY R.ordenamiento_indicador;');
                    //print_r($conn->errorInfo());
                    $indicadores = $stmt_indicadores->fetchAll();
                    $stmt_indicadores->closeCursor();

                    foreach ($indicadores as $indicador) {                        
                        ?>
                        <li titulo-indicador="<?php echo utf8_encode(strtolower($indicador['titulo'])); ?>" codigo-indicador="<?php echo trim($indicador['codigo_indicador']); ?>">
                            <div>
                                <a onclick="cargarIndicador('<?php echo trim($indicador['url_archivo_indicador']); ?>','0')" title="<?php echo trim( utf8_encode($indicador['descripcion'])); ?>" grav="w">
                                    <?php echo htmlentities($indicador['titulo']); ?>
                                </a>
                            </div>
                            <div class="opcionesListaIndicadores">
                                <div style="float:left;">&nbsp;</div>
                                <div class="fichaInfo" title="Haga clic en este icono para ver la ficha técnica del indicador." grav="nw">&nbsp;</div>

                                <div style="float:left; color:#cccccc;">&nbsp;|&nbsp;</div>
                                <div class="verIndsRelacionados" onclick="VerIndicadoresRelacionados('<?php echo $indicador['codigo_indicador'] ?>')" title="Haga clic en este icono para ver los Indicadores Relacionados." grav="nw">&nbsp;</div>

                                <div style="float:left; color:#cccccc;">&nbsp;|&nbsp;</div>
                                <div onclick="agregarIndicador('<?php echo trim($indicador['url_archivo_indicador']); ?>','<?php echo $indicador['codigo_indicador'] ?>')" class="agregarInd" title="Haga clic en este icono para cargar este indicador sin remover los indicadores ya cargados." grav="nw">&nbsp;</div>
                                
                                <div style="float:left; color:#cccccc;">&nbsp;|&nbsp;</div>
                                <div onclick="verOtrosTitulo('<?php echo $indicador['codigo_indicador'] ?>')" class="Aliases" title="Ver los otros titulo con los que se conoce este indicador." grav="nw">&nbsp;</div>

                                <div for="<?php echo $indicador['url_archivo_indicador'] ?>" class="loadingInfo">&nbsp;</div>
                            </div>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </li>
        <?php
    }
    ?>

</ul>
<div class="controlExpColTodo" tour-step="subsite_tour_12" style="background-color:#fff; text-align:center;">
    <a href="#expandirTodo">Expandir Todo</a>&nbsp;&nbsp;&#124;&nbsp;&nbsp;
    <a href="#colapsarTodo">Colapsar Todo</a>
</div>

