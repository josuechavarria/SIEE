<?php
//ESTE ARCHIVO ES SOLO PARA MANEJAR LOS GET DEL AJAX DEL SIEE

include '../phpIncluidos/conexion.php';

$str_retorno = "";  

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if(ISSET($_GET['opcion']))
        {            
            $opcion = $_GET['opcion'];
            $patron = '/^[[:digit:]]+$/';
            
            if(preg_match($patron, $opcion))
            {
                if($opcion == 1)
                {
                    $serie_id = $_GET['serie_id'];
                    
                    if( ISSET($_GET['serie_id']) && (preg_match($patron, $serie_id)) )
                    {
                        $stmt_cant_disponible= $conn->query('SELECT sum(cant_ingresados) + 1 as numero_indicador_actual, (sum(cantidad_indicadores) - sum(cant_ingresados) ) as total_disponible
                                                            FROM (
                                                                    SELECT cantidad_indicadores, 0 as cant_ingresados
                                                                    FROM siee_serie_indicadores 
                                                                    WHERE id = '. $serie_id .'
                                                                    UNION ALL
                                                                    SELECT 0 as cantidad_indicadores, count(DISTINCT id) as cant_ingresados
                                                                    FROM siee_indicador
                                                                    WHERE serie_indicadores_id = '. $serie_id .'
                                                            ) D');
                        
                        $cant_disponible = $stmt_cant_disponible->fetch();
                        $stmt_cant_disponible->closeCursor();
                        
                        $cant_disponible_ind = $cant_disponible['total_disponible'];
                        
                        if( $cant_disponible_ind > 0)
                        {
                            //si se pueden agregar mas indicadores a esta serie
                            $str_retorno = '<script type="text/javascript" id="espacioJavascript" >
                                                    $("#NumeroIndicador").val('. $cant_disponible['numero_indicador_actual'] .');
                                                    $("#tmp_NumeroIndicador").html('. $cant_disponible_ind .');
                                                    $( ".ui-boton-guardar" ).button({               
                                                        disabled: false
                                                    });
                                            </script>';
                        }
                        else
                        {
                            $str_retorno = '<script type="text/javascript" id="espacioJavascript" >
                                                _html = "<p>La serie ha alcanzado el máximo de indicadores, ingrese a la sección administrativa de Series y aumente la cantidad de indicadores de esta Serie, luego regresa a esta sección y agrega el nuevo indicador.</p>";
                                                $( "#dialogWindow" ).html(_html);
                                                $( "#dialogWindow" ).dialog({
                                                    title   : \'Advertencia!\',
                                                    modal   : true,
                                                    buttons : { "Entiendo": function() { $(this).dialog("close"); } },
                                                    minWidth: 600,
                                                    resizable: false
                                                });
                                                $( ".ui-boton-guardar" ).button({               
                                                    disabled: true
                                                });
                                                $("#NumeroIndicador").html(\'0\');
                                                $("#tmp_NumeroIndicador").html(\'0\');
                                        </script>';
                        }
                        
                    }
                    else
                    {
                        $str_retorno = '<script type="text/javascript" id="espacioJavascript" >
                                                _html = "<p>La Identidad de la Serie parece estar corrupta, porfavor recarga la pagina y realiza de nuevo esta accion.</p>";
                                                $( "#dialogWindow" ).html(_html);
                                                $( "#dialogWindow" ).dialog({
                                                    title   : \'Error.\',
                                                    modal   : true,
                                                    buttons : { "Ok": function() { $(this).dialog("close"); } },
                                                    minWidth: 600,
                                                    resizable: false
                                                });
                                                $( ".ui-boton-guardar" ).button({               
                                                    disabled: true
                                                });
                                        </script>';
                    }
                }
            }
            else
            {
                 $str_retorno = '<script type="text/javascript" id="espacioJavascript" >
                                        _html = "<p>La información parece estar corrupta, refresca la pagina y realiza esta accion de nuevo.</p>";
                                        $( "#dialogWindow" ).html(_html);
                                        $( "#dialogWindow" ).dialog({
                                            title   : \'Error.\',
                                            modal   : true,
                                            buttons : { "Ok": function() { $(this).dialog("close"); } },
                                            minWidth: 600,
                                            resizable: false
                                        });
                                        $( ".ui-boton-guardar" ).button({               
                                            disabled: true
                                        });
                                </script>';
            }
        }
        else
        {
            $str_retorno = '<script type="text/javascript" id="espacioJavascript" >
                        _html = "<p>La información parece estar corrupta, refresca la pagina y realiza esta accion de nuevo.</p>";
                        $( "#dialogWindow" ).html(_html);
                        $( "#dialogWindow" ).dialog({
                            title   : \'Error.\',
                            modal   : true,
                            buttons : { "Ok": function() { $(this).dialog("close"); } },
                            minWidth: 600,
                            resizable: false
                        });
                        $( ".ui-boton-guardar" ).button({               
                            disabled: true
                        });
                </script>';
        }
    }
    
    echo $str_retorno;
?>
