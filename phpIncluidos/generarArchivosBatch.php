<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9, IE=8"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>
        <h3>
            Q pedos fiero? Admin
        </h3>
        <p>
           Con esta opcion se puede regenerar los archivos de los indicadores a la version por default que se define en el momento
           que se registra un indicador.
        </p>
        <p>
            La funcionalidad va a "overwrite" los archivos de indicadores ya generados y los reemplazará con el diseño inicial de cada archivo.
        </p>
        <p>
            Tenes que estar seguro de esto ya que se pierden todo el HTML escrito manualmente en cada archivo. (podes modificar el select del query para hacer en especial a algunos indicadores)
        </p>
        <br/>

        <form method="POST" action="generarArchivosBatch.php">
            <input type ="submit" value="Comenzar proceso de desmadre" />
        </form>

        <hr/>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include 'conexion.php';
            include 'generarArchivoIndicador.php';
            $indicadores_convertidos = 0;

            $stmt_datos_indicadores = $conn->query('SELECT id, titulo, url_archivo_indicador FROM siee_indicador WHERE id not in (8,9,10,11) ORDER BY titulo');
            $datos_indicadores = $stmt_datos_indicadores->fetchAll();
            $stmt_datos_indicadores->closeCursor();

            echo '<h5>Resultados:</h5>';
            echo '<ul>';
            foreach ($datos_indicadores as $datos) {
                try {
                    generarArchivoIndicador($datos['id'], $datos['url_archivo_indicador']);
                    $indicadores_convertidos += 1;
                    echo '<li>' . htmlentities($datos['titulo']) . ' - - - <strong>OK</strong></li>';
                } catch (Exception $e) {
                    echo '<li>' . htmlentities($datos['titulo']) . '<strong>ERROR: ' . $e->getMessage() . '</strong></li>';
                }
            }
            echo '</ul>';

            echo '<em><strong>' . $indicadores_convertidos . '</strong> indicadores convertidos exitosamente</em>';
        }
        ?>

    </body>
</html>
