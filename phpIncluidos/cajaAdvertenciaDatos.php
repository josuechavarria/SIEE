<?php
if ($existenDatosCero) {
    ?>
    <div class="cajaAmarillaAlertas" style="margin-top: 10px; margin-bottom: 10px; width: 97%;">
        <div class="encabezado">
            <div class="titulo">Advertencia :</div>
        </div>
        <div class="descripcion">
            Se ha detectado irregularidad al calcular el indicador, no existe toda la informaci&oacute;n
            necesaria para su contrucci&oacute;n, posiblemente : 
            <br/>
            <ul>
                <li>Aun no tenemos datos para el A&ntilde;o seleccionado.</li>
                <li>El C&aacute;lculo para el Universo seleccionado contiene valores negat&iacute;vos.</li>
                <li>El indicador necesita datos de 2 años.</li>
            </ul>
        </div>
    </div>
    <?php
}
?>