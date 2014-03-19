$(function(){
    /*
text: the text inside the tooltip
time: if automatic tour, then this is the time in ms for this step
position: the position of the tip. Possible values are
        TL	top left
        TR  top right
        BL  bottom left
        BR  bottom right
        LT  left top
        LB  left bottom
        RT  right top
        RB  right bottom
        T   top
        R   right
        B   bottom
        L   left
 */
    var config = [
    {
        "tour_step" 	: 'subsite_tour_0',
        "position"	: 'T',
        "titleHtml"     : 'Sistema Escolar de Honduras',
        "contentHtml"	: 'Subsitio: "Sistema Escolar de Honduras", a continuaci&oacute;n se mostrar&aacute; la distribuci&oacute;n de las zona de los Sistemas del SIEE.',
        "footerHtml"    : 'Es importante mencionar que todos los sistemas del SIEE tiene la misma distribuci&oacute;n de zonas.',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_1",
        "position"	: "B",
        "titleHtml"     : 'Encabezado',
        "contentHtml"	: 'Esta zona se define como "Encabezado" de los sistemas, contiene el men&uacute; de navegaci&oacute;n, el nombre/titulo del subsitio en el que te encuentras, as&iacute; como un color que te ayuda a distinguir cada sistema (azul en este caso).',
        "footerHtml"    : '',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_2",
        "position"	: "T",
        "titleHtml"     : 'Men&uacute; de Opciones y Navegaci&oacute;n',
        "contentHtml"	: 'El men&uacute; contiene diferentes opciones de navegaci&oacute;n, desde aqu&iacute; podr&aacute;s llegar a la p&aacute;gina principal (inicio), as&iacute; como a los diferentes subsitios que componen al SIEE, esto lo puedes lograr posicionando el cursor sobre la opci&oacute;n del men&uacute; "Ir a".<br/><br/>Cuando pierdas el buscador puedes cliquear la opci&oacute;n del men&uacute; "¿Que indicador buscas?" para volver a obtener el buscador de indicadores."',
        "footerHtml"    : '',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_3",
        "position"	: "LT",
        "titleHtml"     : 'Panel de Trabajo',
        "contentHtml"	: 'Toda esta zona que ves iluminada se llama "Panel de Trabajo", este panel es una de las zonas m&aacute;s importantes en el SIEE, ya que aqu&iacute; es donde encuentras la mayor parte de las funcionalidades que te ofrece en el sistema.<br/><br/>M&aacute;s adelante se mostrar&aacute; cada elemento del panel de trabajo.',
        "footerHtml"    : '',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_4",
        "position"	: "T",
        "titleHtml"     : 'Zona de Contenido',
        "contentHtml"	: 'El Zona de Contenido, es el lugar en el cual se muestran los indicadores que selecciones del Panel de Trabajo, todo cambio a indicadores se ve reflejado en esta zona.',
        "footerHtml"    : '',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_5",
        "position"	: "B",
        "titleHtml"     : 'Buscador de Indicadores',
        "contentHtml"	: 'El buscador de indicadores te ayudar&aacute; a encontrar f&aacute;cilmente los indicadores que se encuentran en cada subsitio, cuando lo uses veras que te posiciona de forma interactiva en el indicador que contiene el texto que has escrito.',
        "footerHtml"    : '',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_5",
        "position"	: "BR",
        "titleHtml"     : 'Esconder el buscador',
        "contentHtml"	: 'Puedes presionar este bot&oacute;n cuando veas que el buscador molesta en la Zona de Contenido. <span style="font-weight:bold;">Por favor cliquea el bot&oacute;n para ver su acci&oacute;n y luego presiona el boton azul "Avanzar &#187;" del Control del paseo para continuar.</span>.',
        "footerHtml"    : '',
        "bgcolor"       : '#F9EDBE',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_6",
        "position"	: "LT",
        "titleHtml"     : 'Bot&oacute;n Minimizar/Maximizar',
        "contentHtml"	: 'Este bot&oacute;n te ayudar&aacute; a maximizar o minimizar el panel de trabajo, de esta manera podr&aacute;s disponer de m&aacute;s espacio en la Zona de Contenido.',
        "footerHtml"    : '',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_7",
        "position"	: "LT",
        "titleHtml"     : 'Caja de Notas Importantes',
        "contentHtml"	: 'En esta caja amarilla te notificar&aacute; de diferentes temas que se consideran importantes.',
        "footerHtml"    : '',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_8",
        "position"	: "LT",
        "titleHtml"     : 'Caja de Universo de Datos',
        "contentHtml"	: 'Es la caja del panel de trabajo que te informa sobre los datos que est&aacute;s viendo reflejado en los indicadores, puedes entenderlo como filtraciones en la informaci&oacute;n.<br/><br/>Al hacer clic en una de las etiquetas amarillas el SIEE te posicionara en el panel donde cambias el universo de datos.',
        "footerHtml"    : '*Es importante mencionar que "TODOS" los "INDICADORES" que solicites al sistema posterior a esta acci&oacute;n se calculan con los datos seg&uacute;n la selecci&oacute;n de las diferentes opciones del universo.',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_9",
        "position"	: "LT",
        "titleHtml"     : 'para continuar...',
        "contentHtml"	: 'Por favor cliquea el rect&aacute;ngulo que contiene la etiqueta del a&ntilde;o para continuar explicando este funcionamiento. Luego de esto presiona el bot&oacute;n azul "Avanzar &#187;" en el control del paseo.',
        "footerHtml"    : '',        
        "bgcolor"       : '#F9EDBE',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_10",
        "position"	: "T",
        "titleHtml"     : 'Panel de Selecci&oacute;n de Universo',
        "contentHtml"	: 'En este panel podr&aacute;s cambiar todas las opciones del Universo de datos como ser: el a&ntilde;o, departamento, municipio.',
        "footerHtml"    : '',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_11",
        "position"	: "R",
        "titleHtml"     : 'Cerrar Panel Selecci&oacute;n Universo',
        "contentHtml"	: 'Al hacer clic aqu&iacute; cierras el panel de selecci&oacute;n de universo.<br/><br/><span style="font-weight:bold;">Por favor cliquea "CERRAR" y luego presionas el bot&oacute;n azul "Avanzar &#187;"</span>.',
        "footerHtml"    : '',        
        "bgcolor"       : '#F9EDBE',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_12",
        "position"	: "LT",
        "titleHtml"     : 'Opciones Expandir/Colapsar',
        "contentHtml"	: 'Al Hacer clic en una de estas 2 opciones podr&aacute;s Expandir o Colapsar todas las cajas que contiene indicadores.',
        "footerHtml"    : 'El siguiente paso te mostrar&aacute; cuales son estas cajas de indicadores.',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_13",
        "position"	: "LT",
        "titleHtml"     : 'Cajas de Indicadores',
        "contentHtml"	: 'Cliquea la barra GRIS de esta caja, aqu&iacute; encontrar&aacute;s el listado de diferentes indicadores definidos para cada subsitio del SIEE y cada grupo de indicadores.',
        "footerHtml"    : '<span style="font-weight:bold;">*Luego presionas el bot&oacute;n azul "Avanzar &#187;" para explicarte el contenido de esta caja.</span>',
        "bgcolor"       : '#F9EDBE',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_14",
        "position"	: "LT",
        "titleHtml"     : 'Indicador',
        "contentHtml"	: 'De esta manera se listan los indicadores en el SIEE.',
        "footerHtml"    : 'Este indicador no pertence a esta secci&oacute;n, se esta usando solo para ejemplo del paseo.',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_15",
        "position"	: "LT",
        "titleHtml"     : 'Nombre/T&iacute;tulo del indicador',
        "contentHtml"	: 'Esta etiqueta es el nombre o t&iacute;tulo del indicador, al hacer clic en su t&iacute;tulo autom&aacute;ticamente se muestra el indicador a la Zona de Contenido.',
        "footerHtml"    : '',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_16",
        "position"	: "LT",
        "titleHtml"     : 'Opci&oacute;n: Ver Ficha T&eacute;cnica',
        "contentHtml"	: 'Al hacer clic en este icono el SIEE te mostrar&aacute; Informaci&oacute;n T&eacute;cnica sobre este Indicador, como ser Descripci&oacute;n, Interpretaci&oacute;n, la Formula, etc.',
        "footerHtml"    : '',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_17",
        "position"	: "LT",
        "titleHtml"     : 'Opci&oacute;n: Agregar Indicador',
        "contentHtml"	: 'Cuando hagas clic en este icono el SIEE agregar&aacute; el indicador a la Zona de Contenido "sin eliminar" el/los indicador(es) previamente agregados.',
        "footerHtml"    : '',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_15",
        "position"	: "LT",
        "titleHtml"     : 'para continuar...',
        "contentHtml"	: 'Cliquea el t&iacute;tulo del indicador, "espera que se muestre en la Zona de Contenido" y seguido de esto presiona el bot&oacute;n azul "Avanzar &#187;" en el control del paseo.',
        "footerHtml"    : '',
        "bgcolor"       : '#F9EDBE',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_14_1",
        "position"	: "B",
        "titleHtml"     : 'Indicador (En la Zona de Contenido)',
        "contentHtml"	: 'Este es el aspecto que toman los indicadores al momento de mostrarlos en la Zona de Contenido. Este por ejemplo usa un tipo de Grafica de pastel.',
        "footerHtml"    : 'Presiona el bot&oacute;n "Avanzar &#187;" para avanzar el paseo y explicarte cada una de las opciones del indicador.',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_14_2",
        "position"	: "B",
        "titleHtml"     : 'Panel de Informaci&oacute;n',
        "contentHtml"	: 'Desde este panel podes agregar informaci&oacute;n t&eacute;cnica que ayuda al entendimiento del indicador.<br/><br/>Si quieres puedes presionar los diferentes botones para que entiendas mejor el funcionamiento.',
        "footerHtml"    : 'Es la misma informaci&oacute;n que se muestra al presionar el icono de "Ficha T&eacute;cnica".',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_14_3",
        "position"	: "B",
        "titleHtml"     : 'Paginador',
        "contentHtml"	: 'Los iconos redondos te sirven para poder cambiar entre paneles del Panel de Informaci&oacute;n, cliqu&eacute;alos para que veas lo que sucede.',
        "footerHtml"    : '',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_14_4",
        "position"	: "B",
        "titleHtml"     : 'Bot&oacute;n Desagregaciones',
        "contentHtml"	: 'Cuando presionas este bot&oacute;n, autom&aacute;ticamente se abrir&aacute; el panel en el cual encuentras diferentes botones de desagregaci&oacute;n que le puedes aplicar a los indicadores.',
        "footerHtml"    : '',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_14_5",
        "position"	: "B",
        "titleHtml"     : 'Bot&oacute;n Actualizar',
        "contentHtml"	: 'Cuando cambies el "Universo de los datos" (como se mostr&oacute; en pasos anteriores), debes presionar este bot&oacute;n para aplicar los cambios a los indicadores.',
        "footerHtml"    : 'TIP: Este cambio lo puedes aplicar directamente a una desagregaci&oacute;n, esto lo logras haciendo clic en el bot&oacute;n de desagregaciones y luego en el bot&oacute;n de la desagregaci&oacute;n que deseas aplicar.',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_14_4",
        "position"	: "LB",
        "titleHtml"     : 'para continuar...',
        "contentHtml"	: 'Presiona este bot&oacute;n "Desagregaciones" para explicarte este funcionamiento, luego de esto presiona el bot&oacute;n azul "Avanzar &#187;" del control del paseo.',
        "footerHtml"    : '',
        "bgcolor"       : '#F9EDBE',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_14_6",
        "position"	: "B",
        "titleHtml"     : 'Panel de Desagregaciones',
        "contentHtml"	: 'Como puedes ver el SIEE te muestra botones que puedes presionar para aplicar la desagregaci&oacute;n que necesites.<br/><br/><span style="font-weight:bold;">Puede presionar cualquier bot&oacute;n de desagregaci&oacute;n pero espera a que el indicador cargue los datos y despues presionas el bot&oacute;n "Avanzar &#187;" del cotrol del paseo.</span>',
        "footerHtml"    : 'TIP: El bot&oacute;n verde "Ver Global" realiza la misma acci&oacute;n que el bot&oacute;n "Actualizar"',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_14_7",
        "position"	: "LT",
        "titleHtml"     : 'Bot&oacute;n Ver Ficha T&eacute;cnica',
        "contentHtml"	: 'Si no quieres agregar la informaci&oacute;n t&eacute;cnica con los botones del Panel de Informaci&oacute;n porque te quita espacio, puedes presionar este bot&oacute;n para ver la misma informaci&oacute;n en un ventana flotante, la cual la puedes mover donde quieras.',
        "footerHtml"    : 'TIP: Al hacer esto realizas la misma acci&oacute;n de cuando cliqueas el Icono "Ver Ficha T&eacute;cnica."',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_14_8",
        "position"	: "T",
        "titleHtml"     : 'Bot&oacute;n Ver Tabla de Datos',
        "contentHtml"	: 'Al presionar este bot&oacute;n automatic&aacute;mente agregar la tabla de los datos con la los que se calcul&oacute; el indicador.',
        "footerHtml"    : '',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_14_8",
        "position"	: "L",
        "titleHtml"     : 'para continuar...',
        "contentHtml"	: 'Presiona este bot&oacute;n para ver la tabla de los datos, luego avanza con el paseo presionando el bot&oacute;n azul "Avanzar &#187;".',
        "footerHtml"    : '',
        "bgcolor"       : '#F9EDBE',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_14_9",
        "position"	: "T",
        "titleHtml"     : 'Tabla de Datos',
        "contentHtml"	: 'Esa es la tabla de los datos utilizados para calcular el indicador.',
        "footerHtml"    : '',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_14_10",
        "position"	: "R",
        "titleHtml"     : 'Descargar Tabla Datos',
        "contentHtml"	: 'Al presionar este bot&oacute;n el SIEE autom&aacute;ticamente descarga la tabla de los datos en formato Excel para que puedas guardarla en tu computadora o cualquier dispositivo de almacenamiento (como USB).',
        "footerHtml"    : '',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_21",
        "position"	: "LT",
        "titleHtml"     : 'Caja de M&aacute;s Opciones',
        "contentHtml"	: 'En esta caja encuentras diferentes opciones extras que puedes realizar en el SIEE como ser: <ul style="list-style:square inside none;margin:6px;"><li>Selecci&oacute;n del Universo de los datos.</li><li>B&uacute;squeda de centros educativos</li><li>El Glosario de palabras</li><li>Preguntas Frecuentes</li></ul> Entre otras opciones m&aacute;s.',
        "footerHtml"    : '',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_22",
        "position"	: "LT",
        "titleHtml"     : 'Especial PREPARAR REPORTES',
        "contentHtml"	: 'Esta opci&oacute;n es solamente para este subsitio, aqu&iacute; podr&aacute;s generar diferentes reportes, al finalizar el pase porfavor visita esta secci&oacute;n del sistema escolar de Honduras (SEH).',
        "footerHtml"    : '',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "subsite_tour_23",
        "position"	: "LT",
        "titleHtml"     : 'Especial PREPARAR TABLA DINAMICA',
        "contentHtml"	: 'Esta otra opci&oacute;n tambi&eacute;n es solo para este subsitio, aqu&iacute; podr&aacute;s armar una tabla de datos como mejor consideres.',
        "footerHtml"    : '',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "final",
        "position"	: "B",
        "titleHtml"     : 'PASEO COMPLETADO!',
        "contentHtml"	: 'El paseo por el SIEE ha terminado, esperamos hayas comprendido como navegar y obtener informaci&oacute;n es este Sistema de Indicadores Estad&iacute;sticos.<br/><br/><span style="font-weight:bold;">Gracias!</span>',
        "footerHtml"    : 'Unidad de Infotecnolog&iacute;a, Secretaria de Educaci&oacute;n - Tegucigalpa, Honduras.',
        "time" 		: 5000
    }
    ],
    //define if steps should change automatically
    autoplay	= false,
    //timeout for the step
    showtime,
    //current step of the tour
    step    = 0,
    //total number of steps
    total_steps	= config.length;
					
    //show the tour controls
    showControls();
				
    /*
    we can restart or stop the tour,
    and also navigate through the steps
     */
    $('#activatetour').live('click',startTour);
    $('#canceltour').live('click',endTour);
    $('#endtour').live('click',endTour);
    $('#restarttour').live('click',restartTour);
    $('#nextstep').live('click',nextStep);
    $('#prevstep').live('click',prevStep);
				
    function startTour(){
        $('#tourcontrols').animate({
            'opacity':'0.2'
        },'slow');
        $('#activatetour').remove();
        $('#noMostrarDeNuevo').hide();
        $('#endtour,#restarttour').show();
        if(!autoplay && total_steps > 1)
            $('#nextstep').show();
        showOverlay();
        nextStep();
    }
				
    function nextStep(){
        if(!autoplay){
            if(step > 0)
                $('#prevstep').show();
            else
                $('#prevstep').hide();
            if(step == total_steps-1)
                $('#nextstep').hide();
            else
                $('#nextstep').show();	
        }	
        if(step >= total_steps){
            //if last step then end tour
            endTour();
            return false;
        }
        ++step;
        showTooltip();
    }
				
    function prevStep(){
        if(!autoplay){
            if(step > 2)
                $('#prevstep').show();
            else
                $('#prevstep').hide();
            if(step == total_steps)
                $('#nextstep').show();
        }		
        if(step <= 1)
            return false;
        --step;
        showTooltip();
    }
				
    function endTour(){
        step = 0;
        if(autoplay) clearTimeout(showtime);
        removeTooltip();
        hideControls();
        hideOverlay();
    }
				
    function restartTour(){
        var step_config	= config[step-1];
        var $elem       = $('[tour-step="' + step_config.tour_step + '"]');
        if( $($elem).css('position') != 'absolute')
        {
            $($elem).css('position','');
        }
        $($elem).css('z-index','');
        step = 0;
        if(autoplay) clearTimeout(showtime);
        nextStep();
    }
				
    function showTooltip(){
        //remove current tooltip
        removeTooltip();
					
        var step_config	= config[step-1];
        var $elem       = $('[tour-step="' + step_config.tour_step + '"]');//el elemento al que se le asigono un determinado tour
        $($elem).css('z-index','777');
        if( $($elem).css('position') != 'absolute')
        {
            $($elem).css('position','relative');
        }
					
        if(autoplay)
            showtime    = setTimeout(nextStep,step_config.time);
					
        var bgcolor = step_config.bgcolor;
        var color   = step_config.bcolor;
        var titleColor = step_config.tcolor;
        var footerColor = step_config.fcolor;
					
        var $tooltip		= $('<div>',{
            id			: 'tour_tooltip',
            html		: '<div class="tourContent"><div class="title" style="color: '+ titleColor +'">'
            + step_config.titleHtml +'</div><div class="body">' 
            + step_config.contentHtml + '</div><div class="footer" style="color: '+ footerColor +'">'
            + step_config.footerHtml +'</div></div><span class="tooltip_arrow"></span>'
        }).css({
            'display'		: 'none',
            'background-color'	: bgcolor,
            'color'		: color
        }).addClass('tooltip'); 
					
        //position the tooltip correctly:
					
        //the css properties the tooltip should have
        var properties	= {};
					
        var tip_position = step_config.position;
					
        //append the tooltip but hide it
        $('#ContenedorGlobal').prepend($tooltip);
					
        //get some info of the element
        var e_w	= $elem.outerWidth();
        var e_h	= $elem.outerHeight();
        var e_l	= $elem.offset().left;
        var e_t	= $elem.offset().top;
					
					
        switch(tip_position){
            case 'TL'	:
                properties = {
                    'left'  : e_l,
                    'top'   : e_t + e_h + 'px'
                };
                $tooltip.find('span.tooltip_arrow').addClass('tooltip_arrow_TL');
                break;
            case 'TR'	:
                properties = {
                    'left'  : e_l + e_w - $tooltip.width() + 'px',
                    'top'   : e_t + e_h + 'px'
                };
                $tooltip.find('span.tooltip_arrow').addClass('tooltip_arrow_TR');
                break;
            case 'BL'	:
                properties = {
                    'left'  : e_l + 'px',
                    'top'   : e_t - $tooltip.height() + 'px'
                };
                $tooltip.find('span.tooltip_arrow').addClass('tooltip_arrow_BL');
                break;
            case 'BR'	:
                properties = {
                    'left'  : e_l + e_w - $tooltip.width() + 'px',
                    'top'   : e_t - $tooltip.height() + 'px'
                };
                $tooltip.find('span.tooltip_arrow').addClass('tooltip_arrow_BR');
                break;
            case 'LT'	:
                properties = {
                    'left'	: e_l + e_w + 'px',
                    'top'	: e_t + 'px'
                };
                $tooltip.find('span.tooltip_arrow').addClass('tooltip_arrow_LT');
                break;
            case 'LB'	:
                properties = {
                    'left'	: e_l + e_w + 'px',
                    'top'	: e_t + e_h - $tooltip.height() + 'px'
                };
                $tooltip.find('span.tooltip_arrow').addClass('tooltip_arrow_LB');
                break;
            case 'RT'	:
                properties = {
                    'left'	: e_l - $tooltip.width() + 'px',
                    'top'	: e_t + 'px'
                };
                $tooltip.find('span.tooltip_arrow').addClass('tooltip_arrow_RT');
                break;
            case 'RB'	:
                properties = {
                    'left'	: e_l - $tooltip.width() + 'px',
                    'top'	: e_t + e_h - $tooltip.height() + 'px'
                };
                $tooltip.find('span.tooltip_arrow').addClass('tooltip_arrow_RB');
                break;
            case 'T'	:
                properties = {
                    'left'	: e_l + e_w/2 - $tooltip.width()/2 + 'px',
                    'top'	: e_t + e_h + 'px'
                };
                $tooltip.find('span.tooltip_arrow').addClass('tooltip_arrow_T');
                break;
            case 'R'	:
                properties = {
                    'left'	: e_l - $tooltip.width() + 'px',
                    'top'	: e_t + e_h/2 - $tooltip.height()/2 + 'px'
                };
                $tooltip.find('span.tooltip_arrow').addClass('tooltip_arrow_R');
                break;
            case 'B'	:
                properties = {
                    'left'	: e_l + e_w/2 - $tooltip.width()/2 + 'px',
                    'top'	: e_t - $tooltip.height() + 'px'
                };
                $tooltip.find('span.tooltip_arrow').addClass('tooltip_arrow_B');
                break;
            case 'L'	:
                properties = {
                    'left'	: e_l + e_w  + 'px',
                    'top'	: e_t + e_h/2 - $tooltip.height()/2 + 'px'
                };
                $tooltip.find('span.tooltip_arrow').addClass('tooltip_arrow_L');
                break;
        }
					
					
        /*
        if the element is not in the viewport
        we scroll to it before displaying the tooltip
         */
        var w_t	= $(window).scrollTop();
        var w_b = $(window).scrollTop() + $(window).height();
        //get the boundaries of the element + tooltip
        var b_t = parseFloat(properties.top,10);
					
        if(e_t < b_t)
            b_t = e_t;
					
        var b_b = parseFloat(properties.top,10) + $tooltip.height();
        if((e_t + e_h) > b_b)
            b_b = e_t + e_h;
						
					
        if((b_t < w_t || b_t > w_b) || (b_b < w_t || b_b > w_b)){
            $('html, body').stop()
            .animate({
                scrollTop: b_t
            }, 500, 'easeInOutExpo', function(){
                //need to reset the timeout because of the animation delay
                if(autoplay){
                    clearTimeout(showtime);
                    showtime = setTimeout(nextStep,step_config.time);
                }
                //show the new tooltip
                $tooltip.css(properties).show();
            });
        }
        else
            //show the new tooltip
            $tooltip.css(properties).fadeIn('slow');
    }
				
    function removeTooltip(){
        $('#tour_tooltip').remove();
        var _prev_step = 0;
        var _elem = null;
        if(step > 1)
        {
            _prev_step	= config[step-2];
            _elem       = $('[tour-step="' + _prev_step.tour_step + '"]');
            $(_elem).css('z-index','');
            $(_elem).css('position','');
        }
    }
				
    function showControls(){
        /*
        we can restart or stop the tour,
        and also navigate through the steps
         */
        var $tourcontrols  = '<div id="tourcontrols" class="tourcontrols">';
        $tourcontrols += '<p class="controlTourTitle">PASEO SIEE (paso 2)</p>\n\
                          <p class="controlTourContent">Este es el paso mas importante, al finalizar este paso tendras la capacidad de obtener informaci&oacute;n aplicando todas las opciones de filtros y demas que se ofresen en el SIEE.<br/><br/><span style="font-weight:bold;">ESTO ES IMPORTANTE: sigue "al pie de la letra" las instrucciones de las cajas amarillas, en estos casos se necesita de tu ayuda para continuar.</span></p>';
        $tourcontrols += '<span class="button" id="activatetour">Continuar...</span><span class="noVolverMostrar" id="noMostrarDeNuevo" onclick="noCorrerNuncaTour()">No mostrarme esto de nuevo</span>';
        if(!autoplay){
            $tourcontrols += '<div class="navigationTour"><span class="button" id="prevstep" style="display:none;">&#171; Atras</span>';
            $tourcontrols += '<span class="button" id="nextstep" style="display:none;">Avanzar &#187;</span></div>';
        }
        $tourcontrols += '<a id="restarttour" style="display:none;">Reiniciar el paseo</span>';
        $tourcontrols += '<a id="endtour" style="display:none;" onclick="noCorrerNuncaTour()">Finalizar el paseo</a>';
        $tourcontrols += '<span class="close" id="canceltour"></span>';
        $tourcontrols += '</div>';
					
        $('#ContenedorGlobal').prepend($tourcontrols);
        $('#tourcontrols').animate({
            'right':'30px'
        },500);
    }
				
    function hideControls(){
        $('#tourcontrols').remove();
    }
				
    function showOverlay(){
        var $overlay	= '<div id="tour_overlay" class="overlay"></div>';
        $('BODY').prepend($overlay);
    }
				
    function hideOverlay(){
        $('#tour_overlay').remove();
    }
    
    $('#tourcontrols').mouseenter(function (){
        $(this).stop().animate({
            'opacity':'1'
        },'fast');
    });
    $('#tourcontrols').mouseleave(function (){
        $(this).stop().animate({
            'opacity':'0.1'
        },'slow');
    });
    $( "#tourcontrols" ).draggable({
        cancel : ('.button, .noVolverMostrar')
    });
    $( "#tourcontrols").mouseenter(function()
    {
        $(this).css('cursor','-moz-grab');
    });
    $( "#tourcontrols").mousedown(function()
    {
        $(this).css('cursor','-moz-grabbing');
    });
    $( "#tourcontrols").mouseup(function()
    {
        $(this).css('cursor','-moz-grab');
    });
    $('#canceltour').click(function(){
        $.ajax({
            type: "GET",
            url: "phpIncluidos/ajaxGetSiee.php",
            data: {
                opcion          :   4,
                tipo            :   2
            },
            error: function(){
                $('#espacioJavascript').remove();
                var _script = ' <script type="text/javascript" id="espacioJavascript" >'+
                '_html = "<p>Parece que has perdido la coneccion, Porfavor refresca la pagina e intenta esta accion de nuevo.</p>";'+
                '$( "#dialogWindow_contenido" ).html(_html);'+
                '$( "#dialogWindow_contenido" ).dialog({'+
                'title   : \'Error.\','+
                'modal   : true,'+
                'buttons : { "ok": function() { $(this).dialog("close"); } },'+
                'minWidth: 600,'+
                'resizable: false'+
                '});'+
                '</script>';
                $('#cuerpo').append(_script);
            },
            success: function(){
                $('[tour-step="subsite_tour_14"]').remove();
            }
        });
    });
});