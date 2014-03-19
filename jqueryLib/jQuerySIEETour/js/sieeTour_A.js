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
        "tour_step" 	: "siee_tour_0",
        "position"	: "T",
        "titleHtml"     : "BIENVENIDO!",
        "contentHtml"	: "Antes de comenzar queremos que sepas que eres Bienvenido al SIEE. Esperamos saques provecho de todas las bondades que el sistema ofrece las cuales ser&aacute;n mostradas durante el desarrollo de este paseo.",
        "footerHtml"    : "Unidad de Infotecnolog&iacute;a, Secretaria de Educaci&oacute;n - Tegucigalpa, Honduras",
        "time" 		: 5000
    },
    {
        "tour_step" 	: "siee_tour_1",
        "position"	: "B",
        "titleHtml"     : "¿Que es el SIEE?",
        "contentHtml"	: "El SIEE es un Sistema que procesa los datos estad&iacute;sticos de educaci&oacute;n y los muestra en indicadores.",
        "footerHtml"    : "",
        "time" 		: 5000
    },
    {
        "tour_step" 	: "siee_tour_3",
        "position"	: "B",
        "titleHtml"     : "Subsitios del SIEE",
        "contentHtml"	: "El SIEE se compone de 6 Subsitios, los cuales contienen datos estad&iacute;sticos e indicadores.",
        "footerHtml"    : "",
        "time" 		: 5000
    },
    {
        "tour_step" 	: "siee_tour_4",
        "position"	: "BR",
        "titleHtml"     : "Subsitio SEH",
        "contentHtml"	: 'Contiene reportes con el dato en "bruto", los cuales son utilizados en todos las demas secciones.',
        "footerHtml"    : "",
        'bgcolor'       : '#174480',
        'tcolor'        : '#ccc',
        'bcolor'        : '#fff',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "siee_tour_5",
        "position"	: "B",
        "titleHtml"     : "Subsitio Indicadores CC",
        "contentHtml"	: 'Contiene Indicadores Estad&iacute;sticos de Cobertura y calidad.',
        "footerHtml"    : "",
        'bgcolor'       : '#395362',
        'tcolor'        : '#ccc',
        'bcolor'        : '#fff',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "siee_tour_6",
        "position"	: "BL",
        "titleHtml"     : "Subsitio Indicadores EFA",
        "contentHtml"	: 'Aqu&iacute; encuentras indicadores estad&iacute;sticos que responden a las metas EFA.',
        "footerHtml"    : '<a style="font-size: 10pt;" class="links" href="http://www.se.gob.hn/content_htm/EFA_objetivos.htm" target="_blank">¿Qu&eacute; son las Metas EFA?</a>',
        'bgcolor'       : '#d97623',
        'fcolor'        : '#fff',
        'tcolor'        : '#ccc',
        'bcolor'        : '#fff',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "siee_tour_7",
        "position"	: 'BR',
        "titleHtml"     : 'Subsitio Indicadores ECI',
        "contentHtml"	: 'Contiene los indicadores Educativos de comparaci&oacute;n internacional.',
        "footerHtml"    : '',
        'bgcolor'       : '#979418',
        'tcolor'        : '#ccc',
        'bcolor'        : '#fff',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "siee_tour_8",
        "position"	: 'B',
        "titleHtml"     : 'Subsitio Indicadores OE',
        "contentHtml"	: 'Muestra lo indicadores de Oportunidades Educativas.',
        "footerHtml"    : '',
        'bgcolor'       : '#6b882f',
        'tcolor'        : '#ccc',
        'bcolor'         : '#fff',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "siee_tour_9",
        "position"	: 'BL',
        "titleHtml"     : 'Subsitio Indicadores OI',
        "contentHtml"	: 'Y finalmente, aqu&iacute; encontraras indicadores de Oferas e Insumos.',
        "footerHtml"    : '',
        'tcolor'        : '#ccc',
        'bgcolor'       : '#2889a3',
        'bcolor'        : '#fff',
        "time" 		: 5000
    },
    {
        "tour_step" 	: "siee_tour_10",
        "position"	: "B",
        "titleHtml"     : "Men&uacute; de Navegaci&oacute;n",
        "contentHtml"	: "Desde las opciones en esta barra de men&uacute;, tambi&eacute;n puedes llegar a las diferentes secciones que conforman al SIEE.",
        "footerHtml"    : "",
        "bgcolor"	: "#f1f1f1",
        "bcolor"	: "#333",
        "time" 		: 5000
    },
    {
        "tour_step" 	: "siee_tour_11",
        "position"	: "TL",
        "titleHtml"     : "Enlace al Subsitio SEH",
        "contentHtml"	: "Porfavor cliquea el Menu resaltados para continuar con la &uacute;ltima parte del paseo.",
        "footerHtml"    : 'En el siguiente paso te mostraremos las bondades del Sistema.',
        'bgcolor'       : '#174480',
        'tcolor'        : '#ccc',
        'bcolor'        : '#fff',
        'fcolor'        : '#72A4E5',
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
        $('#tourcontrols').animate({'opacity':'0.2'},'slow');
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
        $($elem).css('position','relative');
					
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
        $tourcontrols += '<p class="controlTourTitle">¿Primera vez en el SIEE?</p>\n\
                          <p class="controlTourContent">Te recomendamos realices este "paseo", para que entiendas como navegar por el SIEE y como utilizar las bondades que ofrece el sistema.</p>';
        $tourcontrols += '<span class="button" id="activatetour">Comenzar paseo</span><span class="noVolverMostrar" id="noMostrarDeNuevo" onclick="noCorrerNuncaTour()">No mostrarme esto de nuevo</span>';
        if(!autoplay){
            $tourcontrols += '<div class="navigationTour"><span class="button" id="prevstep" style="display:none;">&#171; Atras</span>';
            $tourcontrols += '<span class="button" id="nextstep" style="display:none;">Avanzar &#187;</span></div>';
        }
        $tourcontrols += '<a id="restarttour" style="display:none;">Reiniciar el paseo</span>';
        $tourcontrols += '<a id="endtour" style="display:none;visibility:hidden;" onclick="noCorrerNuncaTour()">Finalizar el paseo</a>';
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
        $(this).stop().animate({'opacity':'1'},'fast');
    });
    $('#tourcontrols').mouseleave(function (){
        $(this).stop().animate({'opacity':'0.2'},'slow');
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
            }
        });
    });
});