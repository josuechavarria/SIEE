<?php
include '../phpIncluidos/conexion.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $no_hay_errores = FALSE;

    if (ISSET($_GET['id'])) {
        $queryGlosario_id = $_GET['id'];
        $id_de_Glosario = -1;

        try {
            $id_de_glosario = (int) $queryGlosario_id;
            $no_hay_errores = TRUE;
        } catch (Exception $e) {
            $no_hay_errores = FALSE;
        }

        if ($no_hay_errores) {
            $stmt_Glosario_indicadores = $conn->query('SELECT * FROM siee_glosario WHERE id = ' . $id_de_glosario . ' AND activo = 1');
            $queryGlosario = $stmt_Glosario_indicadores->fetch();
            $stmt_Glosario_indicadores->closeCursor();

            $stmt_Glosario_indicadores_referencia = $conn->query('SELECT * FROM siee_glosario_referencias WHERE glosario_id = ' . $id_de_glosario);
            $queryGlosarioRerefencia = $stmt_Glosario_indicadores_referencia->fetchall();
            $stmt_Glosario_indicadores_referencia->closeCursor();


            $no_hay_errores = (sizeof($queryGlosario) > 1);
        }
    } else {
        $no_hay_errores = false;
    }
}

if ($no_hay_errores) {
    ?>
    <div id="PanelModificacionDeGlosario" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
        <div class="headerFromularios">
            Panel de modificaci&oacute;n de Glosario
        </div>
        <div id="CamposFormulario">
            <div class="itemsFormularios">
                <ul class="errores_por_campo" id="errors_TituloGlosario_mod">
                </ul>
                <label for="TituloGlosario_mod">Titulo del Glosario:</label>
                <input id="TituloGlosario_mod" name="TituloGlosario_mod"  type="text" maxlength="512" value="<?php echo htmlentities($queryGlosario['titulo']) ?>" />
            </div>

            <div class="itemsFormularios">
                <ul class="errores_por_campo" id="errors_DescripcionGlosario_mod">
                </ul>
                <label for="DescripcionGlosario_mod">Descripci&oacute;n:</label>
                <textarea id="DescripcionGlosario_mod" name="DescripcionGlosario_mod" maxlength="2048" ><?php echo htmlentities($queryGlosario['descripcion']) ?></textarea>
            </div>

            <div id="CampoDeReferenciaMod" style="background-color:#fcfcfc;">
                <div id="referenciasMod">
                    <?php
                    foreach ($queryGlosarioRerefencia as $referencia) {
                        echo '<div class="itemsFormularios"><hr class="punteado"/>' .
                        '<label>Referencia:</label>' .
                        '<input value="' . $referencia['referencia'] . '"type="text" name="referenciaMod" maxlength="2048" style="width:464px"/>' .
                        '<a name="QuitarFormula" onclick="eliminarEstaReferencia(this)" style="display:inline-block;left:4px;top:2px;height:20px"></a>' .
                        '</div>';
                    }
                    ?>
                    </hr>
                </div>
                <div class="itemsFormularios" style="text-align:right;" id="EspacioBotonAgregarReferenciaMod">
                    <input type ="button" class="ui-boton-guardar" onclick="AgregarReferenciaMod()" value ="Agregar nuevo campo de referencia"/>
                </div>

            </div>

            <input style="display: none;" type="text" id="GlosarioId_mod" value="<?php echo $queryGlosario['id'] ?>"/>
        </div>
        <div class="itemsFormularios">
            <div class="optionPane">
                <button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionDeGlosario')">Cerrar sin guardar</button>
                <button class="ui-boton-guardar" onclick="guardarModificacionGlosario()">Guardar cambios</button>
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
        });
        
        
        
        function AgregarReferenciaMod() {
        var htmlCampoGlosario = '<div class="itemsFormularios"><hr class="punteado"/>'+
            '<label>Referencia:</label>'+
            '<input type="text" name="referenciaMod" maxlength="2048" style="width:464px"/>'+
            '<a name="QuitarFormula" onclick="eliminarEstaReferenciaMod(this)" style="display:inline-block;left:4px;top:2px;height:20px"></a>'+
            '</div>'+
            '</div>';
        var htmlbtn = '<div class="itemsFormularios" style="text-align:right;" id="EspacioBotonAgregarReferenciaMod">'+
            '<input type="button" class="ui-boton-guardar" onclick="AgregarReferenciaMod()"value ="Agregar nuevo campo de referencia"/>'+
            '</div>';
        var divButton ='<div class="itemsFormularios" style="text-align:right;" id="EspacioBotonAgregarReferenciaMod"></div>'
                    
        $('#EspacioBotonAgregarReferenciaMod').slideUp('fast', function(){
            $(this).remove();
            
        
            $('#referenciasMod').append(htmlCampoGlosario);
            $('#CampoDeReferenciaMod').append(divButton);
            $('#EspacioBotonAgregarReferenciaMod').append(htmlbtn);
            
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
    
    function eliminarEstaReferenciaMod(elem){
        $(elem).parent().slideUp('fast', function(){
            $(this).remove();
        });
    }
    
        
    </script>
    <?php
} else {
//si se encontraron errores
    ?>
    <div id="PanelModificacionDeGlosario" class="formularios" style="box-shadow: 0px 0px 10px #999; display: none; margin-top: 20px;">
        <div class="headerFromularios">
            No se encontr&oacute; el Glosario
        </div>
        <div id="CamposFormulario">
            <div class="itemsFormularios">
                El Glosario que tratas de modificar no ha sido encontrada en el SIEE,
                refresca la pagina, vuelve a entrar a esta secci&oacute;n y realiza la tarea de nuevo.
            </div>
            <div class="itemsFormularios">
                <div class="optionPane">
                    <button class="ui-boton-cerrar" onclick="cerrarPanelModificaciones('PanelModificacionDeGlosario')">Cerrar panel</button>
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
