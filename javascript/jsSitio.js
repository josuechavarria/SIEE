var PosPuntero_X = 0;
var PosPuntero_Y = 0;
var AlturaActual = 0;
var TamanioDeEstaPantalla = $(window).width();
TamanioDeEstaPantalla = (TamanioDeEstaPantalla - 960) / 2;
var PosInicialIzqBuscadorIndicadores = TamanioDeEstaPantalla + 200;
var PosInicialArribaBuscadorIndicadores = 400;
//inicializando la posicion del buscador de indicadores, segun el tamaño de la página
$('#buscadorDeIndicadores').css('left', PosInicialIzqBuscadorIndicadores);
$('#buscadorDeIndicadores').css('top', PosInicialArribaBuscadorIndicadores);
//poniendo las etiquetas de universo de datos.
$('#etiquetaDataAnioGlobal').html($('#selectorDataAnioGlobal').val());
//para hacer el scroll de la páginas de indicadores y esconder el titulo
if(window.location.pathname.split('/')[2].split('.')[0] !== 'inicio'){
    $('html, body').scrollTop(130);
}
$('#contenedorInternoGlobal').click( function(e) {
    PosPuntero_X = e.pageX;
    PosPuntero_Y = e.pageY;
});
//Detectando si la aplicaion corre en Ipad, iPhone
var ua = navigator.userAgent;
var isiPad = /iPad/i.test(ua) || /iPhone OS 3_1_2/i.test(ua) || /iPhone OS 3_2_2/i.test(ua);
if(isiPad){
    //arreglando problemas de CSS 
    $('#panelBusquedas .liFinal').css('width','65.4%');    
}
//Arreglos UI para que se vea en IE igual a los otros navegadores
var IE_verNumb = 0;
if( navigator.appName === 'Microsoft Internet Explorer'){
    var _ua = navigator.userAgent;
    var MSIEOffset = _ua.indexOf("MSIE ");
    if (MSIEOffset !== -1) {  
        IE_verNumb = parseFloat(_ua.substring(MSIEOffset + 5, _ua.indexOf(";", MSIEOffset)));
        if(IE_verNumb <= 8)
        {
            $('#flechaBuscadorIndicadores > img').attr('src','./recursos/imagenes/flechaBuscadorIndicadores_noShadow.png');
        }
        if(IE_verNumb === 9)
        {
            $('#panelBusquedas .liFinal').css('width','66%');
        }
    }
}
$(document).ready(function () {
    //Suaviza la aparicion de los Titulos de los subsitios del SIEE
    $("#PageTitle").slideUp(1).delay(800).fadeIn(400);
    $('button[name="ComentarIndicador"]').live('click', function(){
        var indicador_id = $(this).attr('ind-id');
        //hacer el ajax que obtenda los comentarios de este indicador, o ver is ya estan cargados desde inicio
        //el el success agregar la siugiente line
        $('#' + indicador_id + '_comentarios').fadeIn('fast');
    });
    //hacer el guardado en la base de datos 
    $('button[name="EnviarComentario"]').live('click',function(){
        //hacer el POST que ingrese el comentario a la base de datos
        var indicador_id = $(this).attr('ind-id');
        var txtcomentario = $('#' + indicador_id + '_txtComentario').val();
        //hacer el ajax que guarda el comentario en la base de datos
        $('#' + indicador_id + '_comentarios ul').prepend(txtcomentario);
    });
    //mostrar metadata de indicadores
    $('div[name="InformacionIndicador"]').live('click', function(){
        var para = $(this).attr('for');
        $('#' + para).fadeIn('fast');
    });
    $('div[name="EsconderInformacionIndicador"]').live('click', function(){
        $(this).parent().parent().slideUp('fast');
    });
    //mostrar toda la metadata de los indicadores
    $('div[name="MostrarTodaMetadata"]').live('click', function(){
        var para = $(this).attr('for');
        $('#' + para + ' div[name="InformacionIndicador"]').trigger('click');
        $(this).slideUp('fast', function(){
            $(this).next().fadeIn('fast');
        });
    });
    //esconder toda la metadata de un indicador
    $('div[name="EsconderTodaMetadata"]').live('click', function(){
        var para = $(this).attr('for');
        $('#' + para + ' div[name="EsconderInformacionIndicador"]').trigger('click');
        $(this).slideUp('fast', function(){
            $('#' + para + ' div[name="MostrarTodaMetadata"]').fadeIn('fast');
        });
    });
    //animacion de contracción de los paneles de colores de cada subsitio
    $("#contenedorColores").animate({
        height: "98px"
    }, function(){
        $('#LoadingSiteBar').fadeOut('fast', function(){
            $("#buscadorDeIndicadores").fadeIn("slow", function(){
                //que el cursos inicie en el buscador de Indicadores
                $('#tituloIndicadorParaBusqueda').focus();
            }); 
        });
    }); 
    //al presionar desagregaciones cerrar el panel automaticamente
    $('.botonResetDesagreacion, .botonesDesagreacion').live('click', function(){
        $(this).parent().parent().find('.cerrarPanel').trigger('click');
    });
    //tooltip 
    $('[title]').live('mouseover',function(){
        var grav = $(this).attr('grav');
        if (typeof grav !== 'undefined' && grav !== false) {
            grav = $.trim(grav.toLowerCase());
        }else{
            grav = 's';
        }
        $(this).tipsy({
            gravity : (grav.lenght === 0 ? 's' : grav),
            delayIn: 777,
            fade : true,
            opacity :   0.7
        });
    });
    //Fancy boxes del SIEE
    $("a#fancyCreditos").fancybox({
        'overlayShow': true,
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'overlayColor': '#000',
        'easingIn': 'swing',
        'easingOut': 'swing',
        'autoDimensions': true,
        'centerOnScroll': true,
        'type' : 'inline'
    });     
    $('[name="linkEfa"]').fancybox({
        'overlayShow'   : true,
        'transitionIn'  : 'elastic',
        'transitionOut' : 'elastic',
        'overlayColor'  : '#000',
        'easingIn'      : 'swing',
        'easingOut'     : 'swing',
        'autoDimensions': true,
        'centerOnScroll': true,
        'type'          : 'iframe',
        'width'         : '98%',
        'height'        : '98%'
    }); 
    $("a#fancyPorcentajeAvance").fancybox({
        'overlayShow': true,
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'overlayColor': '#000',
        'easingIn': 'swing',
        'easingOut': 'swing',
        'autoDimensions': true,
        'centerOnScroll': true
    });
    $("a#verCentroEnMapaEducativo").fancybox({
        'overlayShow': true,
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'overlayColor': '#000',
        'easingIn': 'swing',
        'easingOut': 'swing',
        'autoDimensions': true,
        'centerOnScroll': true,
        'type'          : 'iframe',
        'width'         : '98%',
        'height'        : '98%'
        
    });
    $("a#masInformacionDeCentroeducativo").fancybox({
        'overlayShow': true,
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'overlayColor': '#000',
        'easingIn': 'swing',
        'easingOut': 'swing',
        'autoDimensions': true,
        'centerOnScroll': true,
        'type'          : 'iframe',
        'width'         : '98%',
        'height'        : '98%'
        
    });
    $("a#informePoblacionEstimada").fancybox({
        'overlayShow': true,
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'overlayColor': '#000',
        'easingIn': 'swing',
        'easingOut': 'swing',
        'autoDimensions': true,
        'centerOnScroll': true
    });
    $("#irAlIndicador").click(function(){
        $(this).stop().slideUp('fast');
    });
    $("#btn_iniciarSesion").fancybox({
        'overlayShow'	: true,
        'transitionIn'	: 'elastic',
        'transitionOut'	: 'elastic',
        'overlayColor'  :   '#000',
        'easingIn'      :   'swing',
        'easingOut'     :   'swing',
        'autoDimensions':   true,
        'centerOnScroll':   true,
        'href'          :   'login.php'
    });
    $("#btn_perfil").fancybox({
        'overlayShow'	: true,
        'transitionIn'	: 'elastic',
        'transitionOut'	: 'elastic',
        'overlayColor'  :   '#000',
        'easingIn'      :   'swing',
        'easingOut'     :   'swing',
        'autoDimensions':   true,
        'centerOnScroll':   true,
        'href'          :   'panel_perfil_usuario.php'
    });
});
$(document).scroll(function(){
    //"use strict";
    if( $(document).scrollTop() > 1200){
        $("#BotonSubirTope").css({
            'display' :   'block'
        });
    }else{
        $("#BotonSubirTope").css({
            'display' :   'none'
        });
    }
});
function subiraPosInicial(){
    $('html, body').animate({
        scrollTop:130
    }, 'fast');    
}
function obtenerCodigoCentro(){
    var _codigo_centro = $.trim($('#centroEducativoGlobal').val().split('-')[0]);
    var ind_patt = /^[0-9]+$/;
    var _lon = 0;
    var _lat = 0;
    if(ind_patt.test(_codigo_centro) && (_codigo_centro.length === 9) ){
        var _nombre_centro = $.trim($('#centroEducativoGlobal').val().split('-')[1]);
        $.ajax({
            type: "GET",
            url: "phpIncluidos/ajaxGetSiee.php",
            dataType: 'json',
            cache : false,
            data: {
                opcion          :   5,
                codigo_centro   :   _codigo_centro
            },
            error: function(){
                _html = "<p>Parece que hay un problema de conexi&oacute;n, Por favor refresca la p&aacute;gina e intenta esta acci&oacute;n de nuevo.</p>";
                $( "#dialogWindow_contenido" ).html(_html);
                $( "#dialogWindow_contenido" ).dialog({
                    'title'     : 'Error.',
                    'modal'     : true,
                    'buttons'   : {
                        "ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    'minWidth'  : 600,
                    'resizable' : false
                });
            },
            success: function(_resp){                
                _lon = _resp.lon;
                _lat = _resp.lat;
                $('#separadorOpcionesCE').css('visibility','visible');
                /*
                 *ZOOM del mapa = [1-20]
                 *donde 1 es mas alejado y 20 el mas cercano
                 *solo usar numeros enteros
                 */
                var _zoom = 14;
                $('#verCentroEnMapaEducativo').css('visibility','visible');
                $('#verCentroEnMapaEducativo').attr('href','http://190.5.81.197/mapa_ol/mapa/app_ext/mapa.html?codigo=' + _codigo_centro + '&lon=' + _lon + '&lat=' + _lat + '&zoom=' + _zoom); 
                $('#verCentroEnMapaEducativo').attr('title','Centro Educativo : ' + _nombre_centro); 
        
                $('#masInformacionDeCentroeducativo').css('visibility','visible');
                $('#masInformacionDeCentroeducativo').attr('href','http://190.5.81.199/SEE/centro_educativo.php?codigo=' + _codigo_centro); 
                $('#masInformacionDeCentroeducativo').attr('title','Centro Educativo : ' + _nombre_centro);
            }
        });
    }
    else{
        $('#separadorOpcionesCE, #verCentroEnMapaEducativo, #masInformacionDeCentroeducativo').css('visibility','hidden');
    }
}
function noCorrerNuncaTour(){
    $.ajax({
        type: "GET",
        url: "phpIncluidos/ajaxGetSiee.php",
        data: {
            opcion          :   4,
            tipo            :   1
        },
        error: function(){
            var _html = "<p>Por favor refresca la p&aacute;gina e intenta esta acci&oacute;n de nuevo.</p>";
            $( "#dialogWindow_contenido" ).html(_html);
            $( "#dialogWindow_contenido" ).dialog({
                'title'     : 'Error',
                'modal'     : true,
                'buttons'   : {
                    "ok": function() {
                        $(this).dialog("close");
                    }
                },
                'minWidth'  : '600',
                'resizable' : false
            });
        },
        success: function(_resp){
            jQuery.globalEval(_resp);
        }
    });
}
function cambiarAnioGlobal(elem){
    var reg = new RegExp("^[1-2]{1}[0-9]{3}$");
    var AnioGlobal = $.trim($(elem).val());
    if(reg.test(AnioGlobal)){
        $('#etiquetaDataAnioGlobal').html(AnioGlobal);
    }else{
        $( "#dialogWindow_contenido" ).html("<p>Parece que el año ha sido alterado, la p&aacute;gina ser&aacute; refrescada en este momento para consistencia del SIEE.</p>").dialog({
            'title'     : 'Error',
            'modal'     : true,
            'buttons'   : {
                "ok": function() {
                    window.location.reload();
                }
            },
            'minWidth'  : '600',
            'resizable' : false
        });
    }
}
function cambiarDepartamentoGlobal(elem){
    var DepartamentoId = $.trim($(elem).val());
    var DepartamentoDescripcion = $('#' + $(elem).attr('id') + ' option[value="' + DepartamentoId + '"]').text();
    var reg = new RegExp("^[0-9]{1,2}$");
    if(reg.test(DepartamentoId)){
        DepartamentoId = parseInt(DepartamentoId, 10);
        if(-1 < DepartamentoId && DepartamentoId < 19){				
            $.ajax({
                type: "GET",
                url: "phpIncluidos/ajaxGetSiee.php",
                cache: false,
                contentType : 'application/json; charset=utf-8',
                dataType: 'json',
                data: {
                    opcion          :   1,
                    departamento_id :   DepartamentoId
                },
                error: function(){
                    var _html = "<p>Parece que hay un error de conexi&oacute;n. Por favor refresca la p&aacute;gina, e intenta esta acci&oacute;n de nuevo.</p>";
                    $( "#dialogWindow_contenido" ).html(_html).dialog({
                        'title'     : 'Error',
                        'modal'     : true,
                        'buttons'   : {
                            "ok": function() {
                                $(this).dialog("close");
                            }
                        },
                        'minWidth'  : '600',
                        'resizable' : false
                    });
                },
                success: function(resp){
                    if( resp.error === undefined){
                        var html = '<option value="0">Todos</option>';
                        $.each(resp.municipios, function (key, val) {
                            html += '<option value="' + val.id + '">' + val.descripcion_municipio + '</option>';
                        });
                        $('#selectorDataMunicipioGlobal').stop(true, true).fadeOut('fast', function(){
                            $(this).html(html).fadeIn('fast').removeAttr('disabled');
                        });
                        $('#etiquetaDataDeptoGlobal').html(DepartamentoDescripcion).attr('etiqueta-grafico', 'departamento de ' + DepartamentoDescripcion);
                        $('#etiquetaDataMuniGlobal').html('Todos').attr('etiqueta-grafico','todos los Municipios');
                        //Resetenado los selectores del centro educativo Global
                        $('#etiquetaDataCentroEdGlobal').html('Todos').attr('etiqueta-grafico','Todos los centros educativos');
                        $('#BuscadorDeCentroEducativo').attr({
                            'value'     : '',
                            'cod-ce'	: '',
                            'desc-ce'	: '',
                            'centro-id' : '0',
                            'placeholder' : 'Escriba aqui el código o nombre del centro educativo que necesita.'
                        });
                    }
                    else{
                        //reseteando los datos de los selectores de Departamento
                        $('#etiquetaDataDeptoGlobal').html('Todos').attr('etiqueta-grafico','de todos los Departamentos');
                        //restiando los datos de los selectores de municipio global
                        $('#selectorDataMunicipioGlobal').stop().fadeOut('fast', function(){
                            $(this).html('<option value="0">- - -</option>').attr('disabled', 'disabled').fadeIn('fast');
                        });
                        $('#etiquetaDataMuniGlobal').html('Todos').attr('etiqueta-grafico','todos los Municipios');
                        //Resetenado los selectores del centro educativo Global
                        $('#etiquetaDataCentroEdGlobal').html('Todos').attr('EtiquetaDeDescarga','Todos los Centros educativos.');
                        $('#BuscadorDeCentroEducativo').attr({
                            'value'	: '',
                            'cod-ce'	: '',
                            'desc-ce'	: '',
                            'centro-id' : '0',
                            'placeholder'	: 'Escriba aqui el código o nombre del centro educativo que necesita.'
                        });						
                        if(resp.error !== ''){
                            $( "#dialogWindow_contenido" ).html('<p>' + resp.error + '</p>').dialog({
                                'title'     : 'Error',
                                'modal'     : true,
                                'buttons'   : {
                                    "ok": function() {
                                        $(this).dialog("close");
                                    }
                                },
                                'minWidth'  : '600',
                                'resizable' : false
                            });
                        }
                    }
                }
            });
        }else{
            var _html = "<p>Se encontraron codigo de departamentos inconsistentes, la p&aacute;gina sera refrescada en este momento.</p>";
            $( "#dialogWindow_contenido" ).html(_html).dialog({
                'title'     : 'Error',
                'modal'     : true,
                'buttons'   : {
                    "ok": function() {
                        window.location.reload();
                    }
                },
                'minWidth'  : '600',
                'resizable' : false
            });	
        }
    }
    else{
        $( "#dialogWindow_contenido" ).html("<p>Se detect&oacute; inconsistencia en algunos parametros cargados en el Sistema, la p&aacute;gina ser&aacute; recargada en este momento.</p>").dialog({
            'title'     : 'Error',
            'modal'     : true,
            'buttons'   : {
                "ok": function() {
                    window.location.reload();
                }
            },
            'minWidth'  : '600',
            'resizable' : false
        });
    }
}
function cambiarMunicipioGlobal(elem){
    var DepartamentoId = $.trim($('#selectorDataDepartamentoGlobal').val());
    var MunicipioId = $.trim($(elem).val());
    var MunicipioDescripcion = $('#' + $(elem).attr('id') + ' option[value="' + MunicipioId + '"]').text();
    var reg = new RegExp("^[0-9]{1,3}$");
	
    if(reg.test(MunicipioId) && reg.test(DepartamentoId)){
        MunicipioId = parseInt(MunicipioId, 10);
        DepartamentoId = parseInt(DepartamentoId, 10);
        if(MunicipioId === 0){
            $('#etiquetaDataMuniGlobal').html('Todos').attr('etiqueta-grafico','todos los Municipios');
            $('#etiquetaDataCentroEdGlobal').html('Todos').attr('EtiquetaDeDescarga','Todos los centros educativos.');
            $('#BuscadorDeCentroEducativo').attr({
                'value'		: '',
                'cod-ce'	: '',
                'desc-ce'	: '',
                'centro-id' : '0',
                'placeholder'	: 'Escriba aqui el código o nombre del centro educativo que necesita.'
            });
        }else{
            if(0 < MunicipioId && MunicipioId < 300){				
                $.ajax({
                    type: "GET",
                    url: "phpIncluidos/ajaxGetSiee.php",
                    cache: false,
                    contentType : 'application/json; charset=utf-8',
                    dataType: 'json',
                    data: {
                        opcion          : 2,
                        departamento_id : DepartamentoId,
                        municipio_id    : MunicipioId
                    },
                    error: function(){
                        $( "#dialogWindow_contenido" ).html("<p>Parece que hay un error de conexi&oacute;n. Por favor refresca la p&aacute;gina, e intenta esta acci&oacute;n de nuevo.</p>").dialog({
                            'title'     : 'Error',
                            'modal'     : true,
                            'buttons'   : {
                                "ok": function() {
                                    $(this).dialog("close");
                                }
                            },
                            'minWidth'  : '600',
                            'resizable' : false
                        });
                    },
                    success: function(resp){
                        if( resp.error === undefined){
                            $('#etiquetaDataMuniGlobal').html(MunicipioDescripcion).attr('etiqueta-grafico',' del municipio ' + MunicipioDescripcion);
                            $('#etiquetaDataCentroEdGlobal').html('Todos').attr('EtiquetaDeDescarga','Todos los centros educativos.');
                            $('#etiquetaDataCentroEdGlobal').html('Todos').attr('etiqueta-grafico','Todos los centros educativos');
                            $('#BuscadorDeCentroEducativo').attr({
                                'value'		: '',
                                'cod-ce'	: '',
                                'desc-ce'	: '',
                                'centro-id' : '0',
                                'placeholder'	: 'Escriba aqui el código o nombre del centro educatívo que necesita.'
                            });
                        }
                        else{
                            //Resetenado los selectores del centro educativo Global
                            $('#etiquetaDataCentroEdGlobal').html('Todos').attr('EtiquetaDeDescarga','Todos los Centros educativos.');
                            $('#etiquetaDataCentroEdGlobal').html('Todos').attr('etiqueta-grafico','Todos los centros educativos');
                            $('#BuscadorDeCentroEducativo').attr({
                                'value'		: '',
                                'cod-ce'	: '',
                                'desc-ce'	: '',
                                'centro-id' : '0',
                                'placeholder'	: 'Escriba aqui el código o nombre del centro educatívo que necesita.'
                            });
                            $( "#dialogWindow_contenido" ).html('<p>' + resp.error + '</p>').dialog({
                                'title'     : 'Error',
                                'modal'     : true,
                                'buttons'   : {
                                    "ok": function() {
                                        $(this).dialog("close");
                                    }
                                },
                                'minWidth'  : '600',
                                'resizable' : false
                            });
                        }
                    }
                });
            }else{
                $( "#dialogWindow_contenido" ).html("<p>Se ha detectado incosistencia en algunos parametros del SIEE, la p&aacute;gina ser&aacute; refrescada en este momento.</p>").dialog({
                    'title'     : 'Error',
                    'modal'     : true,
                    'buttons'   : {
                        "ok": function() {
                            window.location.reload();
                        }
                    },
                    'minWidth'  : '600',
                    'resizable' : false
                });	
            }
			
        }
    }
    else{
        $( "#dialogWindow_contenido" ).html("<p>Se ha detectado inconsistencia en algunos parametros del SIEE, la p&aacute;gina ser&aacute; recargada en este momento.</p>").dialog({
            'title'     : 'Error',
            'modal'     : true,
            'buttons'   : {
                "ok": function() {
                    window.location.reload();
                }
            },
            'minWidth'  : '600',
            'resizable' : false
        });
    }
}
function centroEducativoGlobal(){
    var textoActual = $.trim($('#etiquetaDataCentroEdGlobal').attr('EtiquetaDeDescarga'));
    //alert(textoActual);
    if(textoActual !== 'Todos los centros educativos'){
        var _codigo_centro = $.trim($('#BuscadorDeCentroEducativo').val().split('-')[0]).replace(/^\s+|\s+$/g, '');
        var patt_codigo = /^[0-9]+$/;
    
        if( (_codigo_centro.length === 9) && patt_codigo.test(_codigo_centro) ){
            //alert('En construccion, filtro centro educativo.');
            $('#etiquetaDataCentroEdGlobal').html($('#BuscadorDeCentroEducativo').attr('desc-ce'));
            $('#etiquetaDataCentroEdGlobal').attr('EtiquetaDeDescarga',$('#BuscadorDeCentroEducativo').attr('desc-ce'));
            $('#etiquetaDataCentroEdGlobal').attr('etiqueta-grafico',' Centro educativo '+ $('#BuscadorDeCentroEducativo').attr('cod-ce') + ' - ' + $('#BuscadorDeCentroEducativo').attr('desc-ce'));
            $('#etiquetaDataMuniGlobal').attr('etiqueta-grafico',"");
            $('#etiquetaDataDeptoGlobal').attr('etiqueta-grafico',"");
        }
        else{            
            var _html = "<p>Parece que el código del Centro Educativo fue alterado, por favor vuelve a escribir el nombre del Centro Educativo.</p>";
            $( "#dialogWindow_contenido" ).html(_html);
            $( "#dialogWindow_contenido" ).dialog({
                'title'     : 'Advertencia',
                'modal'     : true,
                'buttons'   : {
                    "ok": function() {
                        $(this).dialog("close");
                    }
                },
                'minWidth'  : '600',
                'resizable' : false
            });
        }        
    }
    else{
        var _html = "<p>Escribe en la entrada de texto el c&oacute;digo o nombre del Centro Educativo que buscas.</p>";
        $( "#dialogWindow_contenido" ).html(_html);
        $( "#dialogWindow_contenido" ).dialog({
            'title'     : 'Nota',
            'modal'     : true,
            'buttons'   : {
                "ok": function() {
                    $(this).dialog("close");
                }
            },
            'minWidth'  : '600',
            'resizable' : false
        });
    }     
}
function cambiarDeptoReportesDinamicos(deptoId){
    if(deptoId !== undefined){
        var filterDepto = $('#'+ deptoId).val();        
        var muniId = deptoId.split('_')[0] + '_muni';
        
        $('#' + muniId).fadeOut('fast');
        
        if(filterDepto === 0){
            $('#' + muniId).html('<option value="0">Todos</option>');
            $('#' + muniId).attr('disabled','disabled');
            $('#' + muniId).fadeIn('fast');
        }
        else{
            $.ajax({
                type: "GET",
                url: "phpIncluidos/ajaxGetSiee.php",
                data: {
                    opcion          : 1,
                    departamento_id : filterDepto,
                    tipo            : 2, //el tipo de proceso que quiero hacer dentro de la opcion 1
                    prefijo         : deptoId.split('_')[0]                 
                },
                error: function(){
                    var _html = "<p>Por favor refresca la p&aacute;gina e intenta esta acci&oacute;n de nuevo.</p>";
                    $( "#dialogWindow_contenido" ).html(_html);
                    $( "#dialogWindow_contenido" ).dialog({
                        'title'     : 'Error',
                        'modal'     : true,
                        'buttons'   : {
                            "ok": function() {
                                $(this).dialog("close");
                            }
                        },
                        'minWidth'  : '600',
                        'resizable' : false
                    });
                },
                success: function(_resp){
                    $('#espacioJavascript').remove();
                    $('#cuerpo').append(_resp);
                }
            });
        }
    }
}
/**
 *Encoge y Expande el Panel Derecho de Opciones
 *parametros: id del contenedor, id del boton de acción->ExpCol
 **/
function ExpandirPanelTrabajo(){
    
}
function expandirGrupoIndicadores(elem){
    $(elem).next().find('ul').stop(true,true).fadeIn('slow', function() {
        $(elem).attr('onclick','colapsarGrupoIndicadores(this)');
    });
    $(elem).find('a').css("background-position", "-32px");
}
function colapsarGrupoIndicadores(elem){
    $(elem).next().find('ul').stop(true,true).fadeOut('fast', function(){
        $(elem).attr('onclick','expandirGrupoIndicadores(this)');
    });
    $(elem).find('a').css("background-position", "0");
}
$('.controlExpColTodo a').click(function(){
    var opcion = $.trim($(this).attr('href').split('#')[1].toLowerCase());
    var listaGruposIndicadores = $('ul.listaIndicadores').find('div.tituloGrupo');
    if(opcion === 'expandirtodo'){
        $.each(listaGruposIndicadores, function(){
            expandirGrupoIndicadores(this);
        });
    }
    if(opcion === 'colapsartodo'){
        $.each(listaGruposIndicadores, function(){
            colapsarGrupoIndicadores(this);
        });
    }
    
});
function cambioChkBxDesagr(idElementoCambio){
    if( $('#' + idElementoCambio).attr('checked') != undefined){
        $('#' + idElementoCambio + 'Data').attr('value', $('#' + idElementoCambio).val() );
    }
    else{
        $('#' + idElementoCambio + 'Data').attr('value', '');
    }
}
function VerIndicadoresRelacionados(_codigo_indicador){
    var id_ventana = _codigo_indicador + '-IndicadoresRelacionados';
    var html_header = 'Relaciones entre indicadores';
    $.ajax({
        type: "GET",
        url: "phpIncluidos/ajaxGetSiee.php",
        dataType: 'json',
        data: {
            opcion              :   7,
            codigo_indicador   :   _codigo_indicador
        },
        error: function(){
            var _html = "<p>Parece que hay un problema de conexi&oacute;n, Por favor refresca la p&aacute;gina e intenta esta acci&oacute;n de nuevo.</p>";
            $( "#dialogWindow_contenido" ).html(_html);
            $( "#dialogWindow_contenido" ).dialog({
                'title'     : 'Error.',
                'modal'     : true,
                'buttons'   : {
                    "ok": function() {
                        $(this).dialog("close");
                    }
                },
                'minWidth'  : 600,
                'resizable' : false
            });
        },
        success: function(response){
            var html_contenido = '<div style="width:500px;">No se encontraron indicadores relacionados con este indicador.</div>';
            if(response.IndicadoresRelacionados === undefined){
                obtenerDialogoFlotante(id_ventana, html_header, html_contenido);
            }else{
                html_contenido = '<div style="width:500px;" class="ListaIndicadoresRelacionados"><div class="titulo">"'+ response.TituloPadre.titulo +'" <span class="subtitulo">se relaciona con:</span></div><ul>';
                if(response.IndicadoresRelacionados.length > 0){
                    $.each(response.IndicadoresRelacionados, function(key, val){
                        html_contenido += '<li><a href="javascript:cargarIndicador(\'' + val.url_archivo_indicador + '\',\'0\')" >' + val.titulo + '</a><div class="loadingInfo" for="' + val.url_archivo_indicador + '" style="display:none;float:right;font-size:8pt;">Cargando ...</div></li>';
                    });
                }else{
                    html_contenido += 'No se encontraron indicadores relacionados con "'+ response.TituloPadre.titulo +'".'
                }
                html_contenido += '</ul></div>';
                obtenerDialogoFlotante(id_ventana, html_header, html_contenido);
            }
        }
    });	
}
function verOtrosTitulo(_codigo_indicador){
    var id_ventana = _codigo_indicador + '-Aliases';
    var html_header = 'Otros títulos que recibe este indicador';
    $.ajax({
        type: "GET",
        url: "phpIncluidos/ajaxGetSiee.php",
        dataType: 'json',
        data: {
            opcion              :   8,
            codigo_indicador   :   _codigo_indicador
        },
        error: function(){
            var _html = "<p>Parece que hay un problema de conexi&oacute;n, Por favor refresca la p&aacute;gina e intenta esta acci&oacute;n de nuevo.</p>";
            $( "#dialogWindow_contenido" ).html(_html);
            $( "#dialogWindow_contenido" ).dialog({
                'title'     : 'Error.',
                'modal'     : true,
                'buttons'   : {
                    "ok": function() {
                        $(this).dialog("close");
                    }
                },
                'minWidth'  : 600,
                'resizable' : false
            });
        },
        success: function(response){
            var html_contenido = '<div style="width:500px;">No se encontraron otros titulo para este indicador.</div>';
            if(response.titulos === undefined){
                obtenerDialogoFlotante(id_ventana, html_header, html_contenido);
            }else{
                html_contenido = '<ul style="width:500px;">';
                if(response.titulos.length > 0){
                    $.each(response.titulos, function(key, val){
                        html_contenido += '<li>' + val.titulo + '.</li>';
                    });
                }else{
                    html_contenido += 'No se encontraron otros titulo para este indicador.';
                }
                html_contenido += '</ul>';
                obtenerDialogoFlotante(id_ventana, html_header, html_contenido);
            }
        }
    });	
}
function cargarIndicador(archivo, desagregacion){
    $('#loadingGif').stop(true,true).fadeIn('fast');
    $('div.loadingInfo[for="' + archivo + '"]').stop(true,true).fadeIn('fast' , function() {
        var funcion = '$(\'div.loadingInfo[for="' + archivo + '"], #loadingGif\').stop(true,true).fadeOut(\'fast\');'+
                        '$(\'#loadingGif\').stop(true,true).fadeOut(\'fast\');';
        obtenerIndicador(archivo, desagregacion, funcion, 1);
    });
}
function agregarIndicador(archivo, codigo){
    var desagregacion = 0;
    $('#loadingGif').stop(true,true).fadeIn('fast');
    $('div.loadingInfo[for="' + archivo + '"]').stop(true,true).fadeIn('fast', function() {
        var funcion = "if ($('#contenedorIndicador-" + codigo + "').length > 0){"+
                        "$('#contenedorIndicador-" + codigo + "').remove();"+
                        "$('div.loadingInfo[for=\"" + archivo + "\"]').stop(true,true).fadeOut('fast');"+
                        "$('#loadingGif').stop(true,true).fadeOut('fast');"+
                    "}";
        obtenerIndicador(archivo, desagregacion, funcion, 2);
    });
}
$('[name="DesagregaIndicador"]').live('click',function(){
    $(this).fadeOut('fast', function(){
        $(this).parent().css('padding-top','6px').html('Recargando el indicador, por favor espere...')
    });
});
function recargarIndicador(archivo, desagregacion){
    $('div.loadingInfo[for="' + archivo + '"]').stop(true,true).fadeIn('fast', function() {
        var funcion = '$(\'div.loadingInfo[for="' + archivo + '"], #loadingGif\').stop(true,true).fadeOut("fast");';
        obtenerIndicador(archivo, desagregacion, funcion, 3);
    });

}
function mostrarLoadingIndicadores(idElem){
    $('#' + idElem).html(
        '<div id="LoadingIndicadores" style="text-align: center; width: 100%; vertical-align: middle; background-color: #fff; height: 290px; padding-top: 280px;'+
        'color: #bbbbbb; border-top: 1px solid #cccccc; border-bottom: 1px solid #cccccc; font-size: 11pt;">'+
        'Aplicando cambios al Indicador . . . <br/><br/>'+
        '<img src="recursos/imagenes/loading1.gif" />'+
        '</div><br/>'
        );
			
    $("#loading-" + _codigo_indicador).css("background-position","0px 0px");
    if( $(document).scrollTop() > 850 ){
        mostrarBotonIrAlIndicador(_codigo_indicador);
    }
}
function obtenerIndicador(archivo, desagregacion, funcion, tipo_carga){
    var _anio		= $.trim($('#selectorDataAnioGlobal').val());
    var _filtroDepto	= $.trim($('#selectorDataDepartamentoGlobal').val());
    var _filtroMuni	= $.trim($('#selectorDataMunicipioGlobal').val());
    var _filtroCeduc	= $.trim($('#BuscadorDeCentroEducativo').attr('centro-id'));;
    var regExpAnio	= new RegExp("^[1-9]{1}[0-9]{3}$");
    var regExpDepto	= new RegExp("^[0-9]{1,2}$");
    var regExpMunicipio = new RegExp("^[0-9]{1,3}$");
    var ind_patt	= /^IND_[123456789][0-9]*$/i;

    if(regExpAnio.test(_anio) && regExpDepto.test(_filtroDepto) && regExpMunicipio.test(_filtroMuni)){
        $.ajax({
            type: "POST",
            url: "indicadores/" + archivo + ".php",
            cache: false,
            dataType: 'html',
            data: {
                anio			:	_anio,
                departamento		:	_filtroDepto,
                municipio		:	_filtroMuni,
                centro			:	_filtroCeduc,
                desagregacion		:	desagregacion
            },
            error: function(){
                $( "#dialogWindow_contenido" ).html("<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>").dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
                jQuery.globalEval(funcion);
            },
            success: function(response){
                jQuery.globalEval(funcion);
                switch(tipo_carga){
                    case 1: //cargar el indicador
                        $('#contenedorIndicadores').html(response);
                        break;
                    case 2: //agregar indicador
                        $('#contenedorIndicadores').prepend(response);
                        break;
                    case 3: //recargar el indicador
                            var id = $(response).attr('id');
                            var js = $(response).last();
                            $('#contenedorIndicadores #' + id).slideUp('fast', function(){
                                $(this).html( $(response).html() ).append( js ).slideDown('slow');
                                if ($("#BuscadorDeCentroEducativo").attr("centro-id")!=0){
                                        $("#DesagregarZona").hide();
                                        $("#DesagregarAdministracion").hide();
                                }
                            });
                        break;
                    default: $('#contenedorIndicadores').html(response);
                }
                if ($("#BuscadorDeCentroEducativo").attr("centro-id")!=0){
                        $("#DesagregarZona").hide();
                        $("#DesagregarAdministracion").hide();
                }
            }
        });
    }else{
        var _html = "<p>Se ha encontrado inconsistencia en algunos parametros del SIEE, la p&aacute;gina sera refrescada en este momento.</p>";
        $( "#dialogWindow_contenido" ).html(_html).dialog({
            title   : 'Ups! error',
            modal   : true,
            buttons : {
                "Ok": function() {
                    window.location.reload();
                }
            },
            minWidth: 600,
            resizable: false
        });
    }
}

$('div[name="btnDesagregacion"]').live('click', function() {
});
function removerIndicadorDeContenido(codigo_indicador){
    $('#' + codigo_indicador).slideUp('slow', function(){
        $("#contenedorIndicador-" + codigo_indicador).remove();
        if($.trim($('#contenedorIndicadores').html()) === ''){
            $('#seccionEncabezadoGeneralSitios').fadeIn('fast');
        }
    });
}
function obtenerDialogoFlotante(_id, _html_header, _html_contenido){
    if( $('#' + _id).length > 0){
        $('#' + _id + ' .contenidoVentana').stop(true,true).slideUp('fast', function(){
            $(this).html(_html_contenido);
            $('#' + _id).stop(true,true).animate({
                'top'    :   PosPuntero_Y - 50
            },'fast', function(){
                $('#' + _id + ' .contenidoVentana').stop(true,true).fadeIn('fast'); 
            });
        });
    }
    else{
        $.get("ventana_flotante.php", { 
            id_ventana: _id, 
            html_header: _html_header, 
            html_contenido: _html_contenido 
        }, function(data){
            $('#cuerpo').append(data); 
            $('#' + _id).css({
                'left'   :   PosPuntero_X + 26,
                'top'    :   PosPuntero_Y - 50
            }).fadeIn('fast', function(){
                dragDialogoFlotante(_id);
            });
        });
    }    
}
function dragDialogoFlotante(id){    
    $( "#" + id ).draggable({
        cancel  : '#' + id + ' .contenidoVentana'
    });
}
function eliminarDialogoFlotante(id, js){
    $('#' + id).slideUp('fast', function(){
        $(this).remove();
    });
    jQuery.globalEval(js);
}
function descargarTablaIndicador(id_para_indicador){    
    var str_nombre_arch = id_para_indicador;
    var _anio = $('#anioGlobalDeData').val();
    var _filtroDepto = $('#departamentoGlobalDeData').val();
    var _filtroMuni = $('#municipioGlobalDeData').val();
    var _filtroCE = 'Todos';
    
    var _tablaDatos = $('#' + id_para_indicador + '_tablaExportExcel').val();
    
    $('#iframeDownloader').attr('src', 'descargadorTablaIndicadores.php?anio=' + _anio + '&departamento=' + _filtroDepto + 
        '&municipio=' + _filtroMuni + '&centroEducativo=' + _filtroCE + '&fileName=' + str_nombre_arch + '&tablaDatos=' + _tablaDatos);
}
function paginarPanelInfoInd(elem){
    var para = $(elem).attr('for');
    var id_indicador = para.split('-')[0];
    $(elem).parent().find('a').css({
        opacity	:	'0.5'
    });
    $(elem).css('opacity','0.7');
    $('#OpcionesIndicador-' + id_indicador + ' div[name="paginasOpciones"]').stop(true,true).fadeOut('fast', function(){
        $('#' + para).stop(true,true).fadeIn('fast');
    });
}
function mostrarPanelUniversoGlobalDatos(idTituloPanel){
    if( $('#' + idTituloPanel).attr('class') != 'liSelected'){
        var idTituloPanelActivo = $('#panelBusquedas .liSelected').attr('id');
        var idPanelActivo = idTituloPanelActivo.split('titulo_')[1];
        var idPanelInactivo = idTituloPanel.split('titulo_')[1];
        
        $('#' + idPanelInactivo).stop();
        $('#' + idPanelInactivo + ' [name|="mostrarSiempre"]').stop();
        $('#' + idPanelInactivo + ' [name|="mostrarSiempre"] *').stop();
        $('#' + idPanelInactivo + ' [name|="mostrarParcialmente"]').stop();
        $('#selectorDataMunicipioGlobal').stop();
        $('#selectorDataMunicipioGlobal *').stop();
        
        $('#' + idTituloPanelActivo).removeClass('liSelected');
        $('#' + idTituloPanel).addClass('liSelected');         
        $('#' + idPanelActivo).css('display','none');
        $('#' + idPanelActivo + ' *').css('display','none'); 
        
        $('#' + idPanelInactivo).fadeIn('fast');
        $('#' + idPanelInactivo + ' [name|="mostrarSiempre"]').fadeIn('fast');
        $('#' + idPanelInactivo + ' [name|="mostrarSiempre"] *').fadeIn('fast');
        $('#' + idPanelInactivo + ' [name|="mostrarParcialmente"]').fadeIn('fast');
        $('#selectorDataMunicipioGlobal').fadeIn('fast');
        $('#selectorDataMunicipioGlobal *').fadeIn('fast');
    }
}
function abrirPanelBusquedaCentrosEdu(idTabClick){
    $('html, body, #panelBusquedas').stop();    
    $('#' + idTabClick).trigger('click');
    $('html, body').animate({
        scrollTop:130
    }, 'slow');
    $('#panelBusquedas').fadeIn('fast');
    $('#panelBusquedas').animate({
        height  : '99px'
    }, function(){
        $('#centroEducativoGlobal').focus();
    });
}
function cerrarPanelSeleccionUniversos(){
    $('#panelBusquedas').stop();
    
    $('#panelBusquedas').animate({
        height  : '0px'
    }, function(){        
        $('#panelBusquedas').css('display','none');
    }); 
}
$('#btnBusquedaCentros img').mouseover(function(){
    $(this).stop().animate({
        opacity: 1.0 
    });
});

$('#btnBusquedaCentros img').mouseout(function(){
    $(this).stop().animate({
        opacity: 0.4 
    });
});
$('#inputBusqCodCentro').focus(function(){
    if($('#inputBusqCodCentro').val() == 'Escriba el Código aqui.'){
        $('#inputBusqCodCentro').val('');        
    }
    else{
        $(this).click(function(){
            $('#inputBusqCodCentro').caretToEnd();
        });                
    }
    $('#inputBusqCodCentro').css('color', '#333333');
});
$('#inputBusqCodCentro').mouseout(function(){    
    if($('#inputBusqCodCentro').val().length == 0)
    {
        $('#inputBusqCodCentro').val('Escriba el Código aqui.');
    }
    $('#inputBusqCodCentro').css('color', '#999999');
});
$('#centroEducativoGlobal').focus(function(){
    if($('#centroEducativoGlobal').val() == 'Todos los centros educativos')
    {
        $('#centroEducativoGlobal').val('');        
    }
    else
    {        
        $('#centroEducativoGlobal').click(function(){
            $('#centroEducativoGlobal').select();            
        })
    }
    $('#centroEducativoGlobal').css('color', '#333333');
});
$('#centroEducativoGlobal').mouseout(function(){
    if($('#centroEducativoGlobal').val().length == 0)
    {
        $('#centroEducativoGlobal').val('Todos los centros educativos');
    }
    if($('#centroEducativoGlobal').val() != 'Todos los centros educativos')
    {
        $('#centroEducativoGlobal').css('color', '#333333');
    }    
});
function obtenerTablaDatos(codigo_indicador)
{
    $('#' + codigo_indicador + '-tablaDatos').stop(true,true).fadeIn('fast');
}
function MostrarGlosarioPalabras(){
    var id_ventana = 'GlosarioPalabras';
    var html_header = 'Glosario de palabras';
    $.ajax({
        type: "GET",
        url: "phpIncluidos/ajaxGetSiee.php",
        dataType: 'json',
        data: {
            opcion              :   7
        },
        error: function(){
            var _html = "<p>Parece que hay un problema de conexi&oacute;n, Por favor refresca la p&aacute;gina e intenta esta acci&oacute;n de nuevo.</p>";
            $( "#dialogWindow_contenido" ).html(_html);
            $( "#dialogWindow_contenido" ).dialog({
                'title'     : 'Error.',
                'modal'     : true,
                'buttons'   : {
                    "ok": function() {
                        $(this).dialog("close");
                    }
                },
                'minWidth'  : 600,
                'resizable' : false
            });
        },
        success: function(response){
            var html_contenido = '<div style="width:500px;">No se encontraron palabras en el sistema.</div>';
            if(response.ListaDePalabras === undefined){
                obtenerDialogoFlotante(id_ventana, html_header, html_contenido);
            }else{
                html_contenido = '<div style="width:600px;" class="Glosario">';
                if(response.ListaDePalabras.length > 0){
                    $.each(response.ListaDePalabras, function(key, val){
                        html_contenido += '';
                    });
                }else{
                    html_contenido += 'No se encontraron palabras en el sistema.';
                }
                html_contenido += '</div>';
                obtenerDialogoFlotante(id_ventana, html_header, html_contenido);
            }
        }
    });	
}
function abrirPanelDesagregaciones(elemBtn){
    var altura = 70;   
    var idPanelDesagregaciones = $(elemBtn).attr('for');
    $(elemBtn).parent().parent().children('.botonDesagregaciones, .botonRecargaIndicador').stop().hide('fast', function(){
        $('#' + idPanelDesagregaciones).parent('td').stop().animate({
            height  :   altura + 'px'
        },60, function(){
            $('#' + idPanelDesagregaciones).stop().fadeIn('slow');
        });
    });
}
function cerrarPanelDesagregaciones(elemBtn){
    var altura = 46;
    var idPanelDesagregaciones = $(elemBtn).attr('for');
    $('#' + idPanelDesagregaciones).stop().fadeOut('fast', function(){
        $('#' + idPanelDesagregaciones).parent('td').stop().animate({
            height  :   altura + 'px'
        },60, function(){
            $(elemBtn).parent().parent().parent('td')
            .children('.botonDesagregaciones, .botonRecargaIndicador')
            .stop().fadeIn('fast');
        });
    });
}
function abrirPreparaReportes(){
    for(i = 0; i < document.getElementById('espacioReportesDinamicos').childNodes.length; i++)
    {
        if (document.getElementById('espacioReportesDinamicos').childNodes[i].id == 'seccionGeneraReportes')
        {
            document.getElementById('espacioReportesDinamicos').removeChild(document.getElementById('seccionGeneraReportes'));
        }
    }
    cerrarBuscadorIndicadores();
    $('#espacioReportesDinamicos').html(
        '<div style="text-align: center; width: 100%; vertical-align: middle; background-color: #fff; margin-top: 20px; padding-top: 20px;'+
        'color: #bbbbbb; border-top: 1px solid #cccccc; border-bottom: 1px solid #cccccc; font-size: 11pt; padding-bottom: 16px;">'+
        'Cargando secci&oacute;n de Reportes . . . <br/><br/>'+
        '<img src="recursos/imagenes/loading1.gif" />'+
        '</div><br/>'
        );
    var _request = $.ajax({
        type: "GET",
        url: "generarReportes.php",
        error: function(){
            var _html = "<p>Parece que hay un problema de conexi&oacute;n, Por favor refresca la p&aacute;gina e intenta esta acci&oacute;n de nuevo.</p>";
            $( "#dialogWindow_contenido" ).html(_html);
            $( "#dialogWindow_contenido" ).dialog({
                'title'     : 'Error.',
                'modal'     : true,
                'buttons'   : {
                    "ok": function() {
                        $(this).dialog("close");
                    }
                },
                'minWidth'  : 600,
                'resizable' : false
            });
        },
        success: function(_respHTML){
            $('#espacioReportesDinamicos').html(_respHTML);
            $('#espacioReportesDinamicos').show();
            if(_respHTML.split('<!DOCTYPE HTML>').length > 1)
            {
                _request.abort();
                $('#espacioReportesDinamicos').html('');
                var _html = "<p>Parece que hay un problema de conexi&oacute;n, Por favor refresca la p&aacute;gina e intenta esta acci&oacute;n de nuevo.</p>";
                $( "#dialogWindow_contenido" ).html(_html);
                $( "#dialogWindow_contenido" ).dialog({
                    'title'     : 'Error.',
                    'modal'     : true,
                    'buttons'   : {
                        "ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    'minWidth'  : 600,
                    'resizable' : false
                });
            }
            else
            {
                $('#espacioMapaHn').html(_respHTML);
                
            }
        }
    });
}
function cerrarPrepararReportes()
{
    for(i = 0; i < document.getElementById('espacioReportesDinamicos').childNodes.length; i++)
    {
        if (document.getElementById('espacioReportesDinamicos').childNodes[i].id == 'seccionGeneraReportes')
        {
            document.getElementById('espacioReportesDinamicos').removeChild(document.getElementById('seccionGeneraReportes'));
            $('#seccionEncabezadoGeneralSitios').fadeIn('fast');
            $('#seccionEncabezadoGeneralSitios').css('height','auto');
            $('#controlMinMax').attr('onclick', "minMaxPanelTrabajo('leftPanel','controlMinMax')");
            $('#controlMinMax').click();
            $('#controlMinMax').tipsy({
                fallback: "Cliquea para Minimizar este panel.",
                gravity :   'w'
            });
        }
    }
}
function abrirPreparaTablaDinamica()
{
    for(i = 0; i < document.getElementById('espacioTablasDinamicas').childNodes.length; i++)
    {
        if (document.getElementById('espacioTablasDinamicas').childNodes[i].id == 'seccionGeneraTablasDinamicas')
        {
            document.getElementById('espacioTablasDinamicas').removeChild(document.getElementById('seccionGeneraTablasDinamicas'));
        }
    }
    cerrarBuscadorIndicadores();
    $('#espacioTablasDinamicas').html(
        '<div style="text-align: center; width: 100%; vertical-align: middle; background-color: #fff; margin-top: 20px; padding-top: 20px;'+
        'color: #bbbbbb; border-top: 1px solid #cccccc; border-bottom: 1px solid #cccccc; font-size: 11pt; padding-bottom: 16px;">'+
        'Cargando secci&oacute;n de Tabla Din&aacute;mica . . . <br/><br/>'+
        '<img src="recursos/imagenes/loading1.gif" />'+
        '</div><br/>'
        );
    var _request = $.ajax({
        type: "GET",
        url: "generarTablaDinamica.php",
        error: function(){
            var _html = "<p>Parece que hay un problema de conexi&oacute;n, Por favor refresca la p&aacute;gina e intenta esta acci&oacute;n de nuevo.</p>";
            $( "#dialogWindow_contenido" ).html(_html);
            $( "#dialogWindow_contenido" ).dialog({
                'title'     : 'Error.',
                'modal'     : true,
                'buttons'   : {
                    "ok": function() {
                        $(this).dialog("close");
                    }
                },
                'minWidth'  : 600,
                'resizable' : false
            });
        },
        success: function(_respHTML){
            if(_respHTML.split('<!DOCTYPE HTML>').length > 1)
            {
                _request.abort();
                $('#espacioTablasDinamicas').html('');
                $("#espacioJavascript").remove();
                var _script = '<script type="text/javascript" id="espacioJavascript" >'+
                '_html = "<p>Parece que hay un problema con la conexi&oacute;n, Por favor refresca la p&aacute;gina e intenta esta acci&oacute;n de nuevo.</p>";'+
                '$( "#dialogWindow_contenido" ).html(_html);'+
                '$( "#dialogWindow_contenido" ).dialog({'+
                'title   : \'Error.\','+
                'modal   : true,'+
                'buttons : { "ok": function() { $(this).dialog("close"); mostrarBuscadorIndicadores(); } },'+
                'minWidth: 600,'+
                'resizable: false'+
                '});'+
                '</script>';
                $('#cuerpo').append(_script);
            }
            else
            {
                $('#espacioTablasDinamicas').html(_respHTML);
                $('#seccionEncabezadoGeneralSitios').animate({
                    'height'    :   '0px'
                }, 100, function(){
                    $('#controlMinMax').click();
                    $('#controlMinMax').attr('onclick','');
                    $('#seccionEncabezadoGeneralSitios').css('display','none');
                    $('#espacioTablasDinamicas').fadeIn('fast');
                    $('.reporteria').fadeIn('slow');
                    cerrarPanelSeleccionUniversos();
                    $('#controlMinMax').tipsy({
                        fallback: "Para ABRIR el Panel de Trabajo, antes debes CERRAR la Sección de Tabla Dinámica.",
                        gravity :   'w'
                    });
                });
            }
        }
    });
}
function cerrarPreparaTablaDinamica()
{
    for(i = 0; i < document.getElementById('espacioTablasDinamicas').childNodes.length; i++)
    {
        if (document.getElementById('espacioTablasDinamicas').childNodes[i].id == 'seccionGeneraTablasDinamicas')
        {
            document.getElementById('espacioTablasDinamicas').removeChild(document.getElementById('seccionGeneraTablasDinamicas'));
            $('#seccionEncabezadoGeneralSitios').fadeIn('fast');
            $('#seccionEncabezadoGeneralSitios').css('height','auto');
            $('#controlMinMax').attr('onclick', "minMaxPanelTrabajo('leftPanel','controlMinMax')");
            $('#controlMinMax').click();
            $('#controlMinMax').tipsy({
                fallback: "Haga clic aqui para minimizar este panel.",
                gravity :   'w'
            });
        }
    }
}
function excelExporter_1_0(url, excelFileName)
{
    url = "tablasDinamicaExportarExcel.php?fileName=" + excelFileName + "&" + url.toString().split('?')[1];
    window.location = url;
}
function excelExporterReportes_1_0(url, excelFileName)
{
    excelFileName = excelFileName.replace(/\s/g,'_');
    url = url.toString().split('SIEE/')[1].split('.php')[0] + "ExportarExcel.php?fileName=" + excelFileName + "&" + url.toString().split('?')[1];
    window.location = url;
}
function abrirSeccionAdmin(groupNumber, optionNumber)
{
    subiraPosInicial();
    switch(groupNumber)
    {
        case 1:
            $('#loadingGif').fadeIn('fast');
            $.ajax({
                type: "GET",
                url: "administracion/admon_series_indicadores.php",
                context: document.body,
                error: function(){
                    $('#loadingGif').fadeOut('fast');
                    _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                },
                success: function(_html){
                    $('#loadingGif').fadeOut('fast');
                    if($('#seccionEncabezadoGeneralSitios').css('display') != 'none')
                    {
                        $('#espacioProcesosAdministrativos').html(_html);
                        $('#tabsSerieIndicadores a[optionInd="' + optionNumber + '"]').trigger('click');
                        $('#seccionEncabezadoGeneralSitios').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#seccionEncabezadoGeneralSitios').css('display','none');
                            $('#espacioProcesosAdministrativos').fadeIn('fast');
                        });
                    }
                    else
                    {
                        $('#espacioProcesosAdministrativos').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#espacioProcesosAdministrativos').html(_html);
                            $('#tabsSerieIndicadores a[optionInd="' + optionNumber + '"]').trigger('click');
                            $('#espacioProcesosAdministrativos').css('height','auto');
                        });
                    }
                }
            });
            break;
        case 2:
            $('loadingGif').fadeIn('fast');
            $.ajax({
                type: "GET",
                url: "administracion/admon_indicadores.php",
                context: document.body,
                error: function(){
                    _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                },
                success: function(_html){
                    $('loadingGif').fadeOut('fast');
                    if($('#seccionEncabezadoGeneralSitios').css('display') != 'none')
                    {
                        $('#espacioProcesosAdministrativos').html(_html);
                        $('#tabsIndicadores a[optionInd="' + optionNumber + '"]').trigger('click');
                        $('#seccionEncabezadoGeneralSitios').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#seccionEncabezadoGeneralSitios').css('display','none');
                            $('#espacioProcesosAdministrativos').fadeIn('fast');
                        });
                    }
                    else
                    {
                        $('#espacioProcesosAdministrativos').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#espacioProcesosAdministrativos').html(_html);
                            $('#tabsIndicadores a[optionInd="' + optionNumber + '"]').trigger('click');
                            $('#espacioProcesosAdministrativos').css('height','auto');
                        });
                    }
                }
            });
            break;
        case 3:
            $('#loadingGif').fadeIn('fast');
            $.ajax({
                type: "GET",
                url: "administracion/admon_grupo_indicadores.php",
                context: document.body,
                error: function(){
                    var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                },
                success: function(_html){
                    $('#loadingGif').fadeOut('fast');
                    if($('#seccionEncabezadoGeneralSitios').css('display') != 'none')
                    {
                        $('#espacioProcesosAdministrativos').html(_html);
                        $('#tabsGrupoIndicadores a[optionInd="' + optionNumber + '"]').trigger('click');
                        $('#seccionEncabezadoGeneralSitios').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#seccionEncabezadoGeneralSitios').css('display','none');
                            $('#espacioProcesosAdministrativos').fadeIn('fast');
                        });
                    }
                    else
                    {
                        $('#espacioProcesosAdministrativos').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#espacioProcesosAdministrativos').html(_html);
                            $('#tabsGrupoIndicadores a[optionInd="' + optionNumber + '"]').trigger('click');
                            $('#espacioProcesosAdministrativos').css('height','auto');
                        });
                    }
                }
            });
            break;
        case 4:
            $('#loadingGif').fadeIn('fast');
            $.ajax({
                type: "GET",
                url: "administracion/admon_usuario.php",
                context: document.body,
                error: function(){
                    $('#loadingGif').fadeOut('fast');
                    _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                },
                success: function(_html){
                    $('#loadingGif').fadeOut('fast');
                    if($('#seccionEncabezadoGeneralSitios').css('display') != 'none')
                    {
                        $('#espacioProcesosAdministrativos').html(_html);
                        $('#tabsUsuario a[optionInd="' + optionNumber + '"]').trigger('click');
                        $('#seccionEncabezadoGeneralSitios').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#seccionEncabezadoGeneralSitios').css('display','none');
                            $('#espacioProcesosAdministrativos').fadeIn('fast');
                        });
                    }
                    else
                    {
                        $('#espacioProcesosAdministrativos').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#espacioProcesosAdministrativos').html(_html);
                            $('#tabsUsuario a[optionInd="' + optionNumber + '"]').trigger('click');
                            $('#espacioProcesosAdministrativos').css('height','auto');
                        });
                    }
                }
            });
            break;
        case 5:
            //subsitio
            $('#loadingGif').fadeIn('fast');
            $.ajax({
                type: "GET",
                url: "administracion/admon_subsitio.php",
                context: document.body,
                error: function(){
                    var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                },
                success: function(_html){
                    $('#loadingGif').fadeOut('fast');
                    if($('#seccionEncabezadoGeneralSitios').css('display') != 'none')
                    {
                        $('#espacioProcesosAdministrativos').html(_html);
                        $('#tabsSubsitio a[optionInd="' + optionNumber + '"]').trigger('click');
                        $('#seccionEncabezadoGeneralSitios').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#seccionEncabezadoGeneralSitios').css('display','none');
                            $('#espacioProcesosAdministrativos').fadeIn('fast');
                        });
                    }
                    else
                    {
                        $('#espacioProcesosAdministrativos').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#espacioProcesosAdministrativos').html(_html);
                            $('#tabsSubsitio a[optionInd="' + optionNumber + '"]').trigger('click');
                            $('#espacioProcesosAdministrativos').css('height','auto');
                        });
                    }
                }
            });
            break;
        case 6:
            //tipos de desagregaci&oacute;n
            $('#loadingGif').fadeIn('fast');
            $.ajax({
                type: "GET",
                url: "administracion/admon_tipo_desagregacion.php",
                context: document.body,
                async: false,
                error: function(){
                    $('#loadingGif').fadeOut('fast');
                    _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                },
                success: function(_html){
                    $('#loadingGif').fadeOut('fast');
                    if($('#seccionEncabezadoGeneralSitios').css('display') != 'none')
                    {
                        $('#espacioProcesosAdministrativos').html(_html);
                        $('#tabsTipoDesagregacion a[optionInd="' + optionNumber + '"]').trigger('click');
                        $('#seccionEncabezadoGeneralSitios').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#seccionEncabezadoGeneralSitios').css('display','none');
                            $('#espacioProcesosAdministrativos').fadeIn('fast');
                        });
                    }
                    else
                    {
                        $('#espacioProcesosAdministrativos').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#espacioProcesosAdministrativos').html(_html);
                            $('#tabsTipoDesagregacion a[optionInd="' + optionNumber + '"]').trigger('click');
                            $('#espacioProcesosAdministrativos').css('height','auto');
                        });
                    }
                }
            });
            break;
        case 7:
            //tipos de matricula
            $('#loadingGif').fadeIn('fast');
            $.ajax({
                type: "GET",
                url: "administracion/admon_tipo_matricula.php",
                context: document.body,
                async: false,
                error: function(){
                    $('#loadingGif').fadeOut('fast');
                    _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                },
                success: function(_html){
                    $('#loadingGif').fadeOut('fast');
                    if($('#seccionEncabezadoGeneralSitios').css('display') != 'none')
                    {
                        $('#espacioProcesosAdministrativos').html(_html);
                        $('#tabsTipoMatricula a[optionInd="' + optionNumber + '"]').trigger('click');
                        $('#seccionEncabezadoGeneralSitios').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#seccionEncabezadoGeneralSitios').css('display','none');
                            $('#espacioProcesosAdministrativos').fadeIn('fast');
                        });
                    }
                    else
                    {
                        $('#espacioProcesosAdministrativos').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#espacioProcesosAdministrativos').html(_html);
                            $('#tabsTipoMatricula a[optionInd="' + optionNumber + '"]').trigger('click');
                            $('#espacioProcesosAdministrativos').css('height','auto');
                        });
                    }
                }
            });
            break;
        case 8:
            //tipos de educaci&oacute;
            $('#loadingGif').fadeIn('fast');
            $.ajax({
                type: "GET",
                url: "administracion/admon_tipo_educacion.php",
                context: document.body,
                async: false,
                error: function(){
                    $('#loadingGif').fadeOut('fast');
                    _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                },
                success: function(_html){
                    $('#loadingGif').fadeOut('fast');
                    if($('#seccionEncabezadoGeneralSitios').css('display') != 'none')
                    {
                        $('#espacioProcesosAdministrativos').html(_html);
                        $('#tabsTipoEducacion a[optionInd="' + optionNumber + '"]').trigger('click');
                        $('#seccionEncabezadoGeneralSitios').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#seccionEncabezadoGeneralSitios').css('display','none');
                            $('#espacioProcesosAdministrativos').fadeIn('fast');
                        });
                    }
                    else
                    {
                        $('#espacioProcesosAdministrativos').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#espacioProcesosAdministrativos').html(_html);
                            $('#tabsTipoEducacion a[optionInd="' + optionNumber + '"]').trigger('click');
                            $('#espacioProcesosAdministrativos').css('height','auto');
                        });
                    }
                }
            });
            break;
        case 9:
            //anos de referencia
            break;
        case 10:
            //nivel educativo
            $('#loadingGif').fadeIn('fast');
            $.ajax({
                type: "GET",
                url: "administracion/admon_nivel_educativo.php",
                context: document.body,
                async: false,
                error: function(){
                    $('#loadingGif').fadeOut('fast');
                    _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                },
                success: function(_html){
                    $('#loadingGif').fadeOut('fast');
                    if($('#seccionEncabezadoGeneralSitios').css('display') != 'none')
                    {
                        $('#espacioProcesosAdministrativos').html(_html);
                        $('#tabsNivelEducativo a[optionInd="' + optionNumber + '"]').trigger('click');
                        $('#seccionEncabezadoGeneralSitios').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#seccionEncabezadoGeneralSitios').css('display','none');
                            $('#espacioProcesosAdministrativos').fadeIn('fast');
                        });
                    }
                    else
                    {
                        $('#espacioProcesosAdministrativos').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#espacioProcesosAdministrativos').html(_html);
                            $('#tabsNivelEducativo a[optionInd="' + optionNumber + '"]').trigger('click');
                            $('#espacioProcesosAdministrativos').css('height','auto');
                        });
                    }
                }
            });
            break;
        case 11:
            //tipos de perfil/rol
            $('#loadingGif').fadeIn('fast');
            $.ajax({
                type: "GET",
                url: "administracion/admon_rol.php",
                context: document.body,
                async: false,
                error: function(){
                    $('#loadingGif').fadeOut('fast');
                    _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                },
                success: function(_html){
                    $('#loadingGif').fadeOut('fast');
                    if($('#seccionEncabezadoGeneralSitios').css('display') != 'none')
                    {
                        $('#espacioProcesosAdministrativos').html(_html);
                        $('#tabsRol a[optionInd="' + optionNumber + '"]').trigger('click');
                        $('#seccionEncabezadoGeneralSitios').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#seccionEncabezadoGeneralSitios').css('display','none');
                            $('#espacioProcesosAdministrativos').fadeIn('fast');
                        });
                    }
                    else
                    {
                        $('#espacioProcesosAdministrativos').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#espacioProcesosAdministrativos').html(_html);
                            $('#tabsRol a[optionInd="' + optionNumber + '"]').trigger('click');
                            $('#espacioProcesosAdministrativos').css('height','auto');
                        });
                    }
                }
            });
            break;
        case 12:
            //poblacion estimada
            $('#loadingGif').fadeIn('fast');
            $.ajax({
                type: "GET",
                url: "administracion/admon_poblacion_estimada.php",
                context: document.body,
                async: false,
                error: function(){
                    $('#loadingGif').fadeOut('fast');
                    $( "#dialogWindow" ).html("<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>").dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                },
                success: function(_html){
                    $('#loadingGif').fadeOut('fast');
                    if($('#seccionEncabezadoGeneralSitios').css('display') !== 'none')
                    {
                        $('#espacioProcesosAdministrativos').html(_html);
                        $('#seccionEncabezadoGeneralSitios').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#seccionEncabezadoGeneralSitios').css('display','none');
                            $('#espacioProcesosAdministrativos').fadeIn('fast');
                        });
                    }
                    else
                    {
                        $('#espacioProcesosAdministrativos').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#espacioProcesosAdministrativos').html(_html);
                            $('#espacioProcesosAdministrativos').css('height','auto');
                        });
                    }
                }
            });
            break;
        case 13:
            $('#loadingGif').fadeIn('fast');
            $.ajax({
                type: "GET",
                url: "administracion/admon_archivo.php",
                context: document.body,
                async: false,
                error: function(){
                    $('#loadingGif').fadeOut('fast');
                    _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                },
                success: function(_html){
                    $('#loadingGif').fadeOut('fast');
                    if($('#seccionEncabezadoGeneralSitios').css('display') != 'none')
                    {
                        $('#espacioProcesosAdministrativos').html(_html);
                        $('#tabsArchivo a[optionInd="' + optionNumber + '"]').trigger('click');
                        $('#seccionEncabezadoGeneralSitios').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#seccionEncabezadoGeneralSitios').css('display','none');
                            $('#espacioProcesosAdministrativos').fadeIn('fast');
                        });
                    }
                    else
                    {
                        $('#espacioProcesosAdministrativos').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#espacioProcesosAdministrativos').html(_html);
                            $('#tabsArchivo a[optionInd="' + optionNumber + '"]').trigger('click');
                            $('#espacioProcesosAdministrativos').css('height','auto');
                        });
                    }
                }
            });
            break;
        case 14:
            $('#loadingGif').fadeIn('fast');
            $.ajax({
                type: "GET",
                url: "administracion/admon_fuente_dato.php",
                context: document.body,
                async: false,
                error: function(){
                    $('#loadingGif').fadeOut('fast');
                    _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                },
                success: function(_html){
                    $('#loadingGif').fadeOut('fast');
                    if($('#seccionEncabezadoGeneralSitios').css('display') != 'none')
                    {
                        $('#espacioProcesosAdministrativos').html(_html);
                        $('#tabsFuenteDato a[optionInd="' + optionNumber + '"]').trigger('click');
                        $('#seccionEncabezadoGeneralSitios').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#seccionEncabezadoGeneralSitios').css('display','none');
                            $('#espacioProcesosAdministrativos').fadeIn('fast');
                        });
                    }
                    else
                    {
                        $('#espacioProcesosAdministrativos').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#espacioProcesosAdministrativos').html(_html);
                            $('#tabsFuenteDato a[optionInd="' + optionNumber + '"]').trigger('click');
                            $('#espacioProcesosAdministrativos').css('height','auto');
                        });
                    }
                }
            });
            break;
                        
        case 16:
            $('#loadingGif').fadeIn('fast');
            $.ajax({
                type: "GET",
                url: "administracion/migracion_datos.php",
                context: document.body,
                async: false,
                error: function(){
                    $('#loadingGif').fadeOut('fast');
                    _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                },
                success: function(_html){
                    $('#loadingGif').fadeOut('fast');
                    if($('#seccionEncabezadoGeneralSitios').css('display') != 'none')
                    {
                        $('#espacioProcesosAdministrativos').html(_html);
                        $('#tabsGlosario a[optionInd="' + optionNumber + '"]').trigger('click');
                        $('#seccionEncabezadoGeneralSitios').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#seccionEncabezadoGeneralSitios').css('display','none');
                            $('#espacioProcesosAdministrativos').fadeIn('fast');
                        });
                    }
                    else
                    {
                        $('#espacioProcesosAdministrativos').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#espacioProcesosAdministrativos').html(_html);
                            $('#tabsGlosario a[optionInd="' + optionNumber + '"]').trigger('click');
                            $('#espacioProcesosAdministrativos').css('height','auto');
                        });
                    }
                }
            });
            break;
            case 15:
            $('#loadingGif').fadeIn('fast');
            $.ajax({
                type: "GET",
                url: "administracion/admon_glosario.php",
                context: document.body,
                async: false,
                error: function(){
                    $('#loadingGif').fadeOut('fast');
                    _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                },
                success: function(_html){
                    $('#loadingGif').fadeOut('fast');
                    if($('#seccionEncabezadoGeneralSitios').css('display') != 'none')
                    {
                        $('#espacioProcesosAdministrativos').html(_html);
                        $('#tabsGlosario a[optionInd="' + optionNumber + '"]').trigger('click');
                        $('#seccionEncabezadoGeneralSitios').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#seccionEncabezadoGeneralSitios').css('display','none');
                            $('#espacioProcesosAdministrativos').fadeIn('fast');
                        });
                    }
                    else
                    {
                        $('#espacioProcesosAdministrativos').animate({
                            'height'    :   '0px'
                        }, 100, function(){
                            $('#espacioProcesosAdministrativos').html(_html);
                            $('#tabsGlosario a[optionInd="' + optionNumber + '"]').trigger('click');
                            $('#espacioProcesosAdministrativos').css('height','auto');
                        });
                    }
                }
            });
            break;
        default:
            $('#seccionEncabezadoGeneralSitios').animate({
                'height'    :   '0px'
            }, 100, function(){
                $('#seccionEncabezadoGeneralSitios').fadeIn('fast');
                $('#espacioProcesosAdministrativos').html('');
                $('#espacioProcesosAdministrativos').css('display','none');
            });
    }
}
function cerrarSeccionAdmin()
{    
    $('#seccionEncabezadoGeneralSitios').animate({
        'height'    :   '0px'
    }, 100, function(){
        $('#seccionEncabezadoGeneralSitios').fadeIn('fast');
        $('#espacioProcesosAdministrativos').html('');
        $('#espacioProcesosAdministrativos').css('display','none');
    });
}
function filtroDeSeriesIndicadores(str)
{
    $('#listadoModificarIndicadores li').css('display', 'none');
    str = $.trim(str);	
	
    if (str == "")
    {
        $('#listadoModificarIndicadores li').fadeIn('fast');
    }
    else
    {
        $('#listadoModificarIndicadores [titulo_serie*="'+ str +'"]').fadeIn('fast');
    }
}
function filtroDeSeriesIndicadoresMod(estado_serie)
{
    $('#listadoActDesactIndicadores li').css('display', 'none');
    	
    if ( (estado_serie == '0') || (estado_serie == '1') )
    {
        $('#listadoActDesactIndicadores [esta_activa="'+ estado_serie +'"]').fadeIn('fast');
    }
    else
    {
        $('#listadoActDesactIndicadores li').fadeIn('fast');
    }
}
function filtroDeIndicadoresMod(estado_serie)
{
    $('#listadoActDesactIndicadores li').css('display', 'none');
    	
    if ( (estado_serie == '0') || (estado_serie == '1') )
    {
        $('#listadoActDesactIndicadores [esta_eliminada="'+ estado_serie +'"]').fadeIn('fast');
    }
    else
    {
        $('#listadoActDesactIndicadores li').fadeIn('fast');
    }
}
function guardarSerieIndicadores()
{
    var _titulo = $('#TituloSerie').val();
    var _descripcion = $('#DescripcionSerie').val();
    var _cant_indicadores = $('#CantidadDeIndicadores').val();
    var _observaciones = $('#ObservacionSerie').val();
        
    $.ajax({
        type: "POST",
        url: "administracion/guardar_serie_indicadores.php",
        cache: false,
        dataType : 'json',
        data: {
            titulo                  : _titulo,
            descripcion             : _descripcion,
            cantidadIndicadores     : _cant_indicadores,
            observaciones           : _observaciones
        },
        error: function(){
            var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, es posible que se halla perdido la conexi&oacute;n. Por favor, referscar la p&aacute;gina e intenta esta acci&oacute;n de nuevo.</p>";
            $( "#dialogWindow" ).html(_html);
            $( "#dialogWindow" ).dialog({
                title   : 'Ups! error',
                modal   : true,
                buttons : {
                    "Ok": function() {
                        $(this).dialog("close");
                    }
                },
                minWidth: 600,
                resizable: false
            });
        },
        success: function(_resp)
        {
            if (_resp.refresh_error){
                var _html = "<p>" + _resp.refresh_error + "</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            location.reload();
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            }else if (_resp.errores){
                $('ul[id^="errors"]').html('');
                $('#CamposFormulario input').removeClass('campo_error');
                $('#errores_generales_nuevaSerie, #exito_generales_nuevaSerie').remove();
                $('#tabsSerieIndicadores-1 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_nuevaSerie', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                $('#errores_generales_nuevaSerie').fadeIn('fast');
                for(var key in _resp.errores){
                    $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                    $('#' + key).addClass('campo_error');					
                }
            }else{
                $('ul[id^="errors"]').html('');
                $('input:text, textarea').attr('value','').removeClass('campo_error');
                $('#CamposFormulario input, #CamposFormulario select').attr('value','').removeClass('campo_error');
                $('#errores_generales_nuevaSerie, #exito_generales_nuevaSerie').remove();
                $('#tabsSerieIndicadores-1 #CamposFormulario').prepend(CajaExitoErrores(1, 'exito_generales_nuevaSerie', 'La serie se guardo exitosamente.'));
                $('#exito_generales_nuevaSerie').fadeIn('fast');
                $('a[href="#tabsSerieIndicadores-3"]').attr('onclick','abrirSeccionAdmin(1,3)');
            }
            
        }
    });
}
function guardarSerieIndicadoresActivarDesactivar()
{
    var listaIdsSeriesInd = new Array();
    var index = 0;
    $('#listadoActDesactIndicadores [name="estatusSerieIndicadores"]:checked').each(function(){
        listaIdsSeriesInd.push($(this).val());
    });
    
    $.ajax({
        type: "POST",
        url: "administracion/cambiar_estado_serie_indicadores.php",
        cache: false,
        data: {
            listaIdsSeriesIndicadores      :    listaIdsSeriesInd
        },
        error: function(){
            _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexi&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
            $( "#dialogWindow" ).html(_html);
            $( "#dialogWindow" ).dialog({
                title   : 'Ups! error',
                modal   : true,
                buttons : {
                    "Ok": function() {
                        $(this).dialog("close");
                    }
                },
                minWidth: 600,
                resizable: false
            });
        },
        success: function(_resp)
        {
            if (_resp.refresh_error){
                $( "#dialogWindow" ).html(_resp.refresh_error);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! Error!',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                            $('#PageTitle').trigger('click');
                            abrirSeccionAdmin(1,3);
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            }else{
                $( "#dialogWindow" ).html('<p>Los cambios en el estado de el/las Series fu&eacute; realizado con &eacute;xito.</p>');
                $( "#dialogWindow" ).dialog({
                    title   : 'Transacci&oacute;n Exitosa!',
                    modal   : true,
                    buttons : {
                        "Perfecto": function() {
                            $(this).dialog("close");
                            $('#PageTitle').trigger('click');
                            abrirSeccionAdmin(1,3);
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            }
        }
    });
}
function guardarModificacionSerieIndicadores()
{
    var _titulo             =   $('#TituloSerie_mod').val();
    var _descripcion        =  $('#DescripcionSerie_mod').val();
    var _cant_indicadores   =   $('#CantidadDeIndicadores_mod').val();
    var _observaciones      =   $('#ObservacionSerie_mod').val();
    var _serie_id           =   $('#SerieIndicadorId_mod').val();
        
    $.ajax({
        type: "POST",
        url: "administracion/guardar_modificacion_series_indicadores.php",
        cache: false,
        dataType : 'json',
        data: {
            serie_id                : _serie_id,
            titulo                  : _titulo,
            descripcion             : _descripcion,
            cantidadIndicadores     : _cant_indicadores,
            observaciones           : _observaciones
        },
        error: function(){
            var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, es posible que se halla perdido la conexi&oacute;n. Por favor, referscar la p&aacute;gina e intenta esta acci&oacute;n de nuevo.</p>";
            $( "#dialogWindow" ).html(_html);
            $( "#dialogWindow" ).dialog({
                title   : 'Ups! error',
                modal   : true,
                buttons : {
                    "Ok": function() {
                        $(this).dialog("close");
                    }
                },
                minWidth: 600,
                resizable: false
            });
        },
        success: function(_resp)
        {
            if (_resp.refresh_error){
                var _html = "<p>" + _resp.refresh_error + "</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            location.reload();
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            }else if (_resp.errores){
                $('ul[id^="errors"]').html('');
                $('#CamposFormulario input').removeClass('campo_error');
                $('#errores_generales_modificarSerie, #exito_generales_modificarSerie').remove();
                $('#tabsSerieIndicadores-2 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_modificarSerie', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                $('#errores_generales_modificarSerie').fadeIn('fast');
                for(var key in _resp.errores){
                    $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                    $('#' + key).addClass('campo_error');					
                }
            }else{
                $( "#dialogWindow" ).html('<p>Los datos de la serie fueron actualizados correctamente.</p>');
                $( "#dialogWindow" ).dialog({
                    title   : "Actualización exitosa!",
                    modal   : true,
                    position		: '50px',
                    buttons : {
                        "Ok": function() { 
                            $("#PageTitle").trigger("click");
                            abrirSeccionAdmin(1,2);	
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });				
            }
        }
    });
}
function cargarPanelModificacionSeries(id_serie_indicadores)
{
    var flag = false;
    try
    {
        parseInt(id_serie_indicadores);
        flag = true;
    }
    catch (error)
    {
        flag = false;
    }    
    if(flag)
    {
        $.ajax({
            type: "GET",
            url: "administracion/modificar_serie_indicadores.php",
            data: {
                serie_indicadores_id    :   id_serie_indicadores
            },
            error: function(){
                _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(msg)
            {
                $("#PanelModificacionDeSeries").remove();
                $('#tabsSerieIndicadores-2').append(msg);
                $('#PanelModificacionDeSeries').fadeIn('fast');                
                $('html, body').animate({
                    scrollTop:940
                }, 'slow');
            }
        });
    }    
}
function cerrarPanelModificaciones(idPanel)
{
    $('#' + idPanel).animate({
        'height'    :'1px',
        opacity     :'0'
    }, 400, function(){
        $('#' + idPanel).remove();
    });
}
function FormatoComas(numero){
    return numero.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
var esconder = setTimeout('',10);
function mostrarBotonIrAlIndicador(cod_indicador)
{
    var posXYElem = $('li[codigo-indicador="'+ cod_indicador +'"]').position();
    var offSet = 142;
    $('#irAlIndicador').stop().animate({
        'top'     :   posXYElem.top,
        'left'    :   posXYElem.left + offSet
    },'fast', function(){
        if(esconder)
        {
            clearTimeout(esconder)
        }
        esconder = setTimeout("$('#irAlIndicador').css('display','none')", 8000);
    });   
    $('#irAlIndicador').fadeIn('fast');    
}
/**
 * buscador de indicadores en el contenido
 **/
$('#tituloIndicadorParaBusqueda').keyup(function(){
    $('html, body, #buscadorDeIndicadores, #flechaBuscadorIndicadores').stop(true, true);
    var substr = $.trim($(this).val().toLowerCase());
    //resetear todo
    $('.contenidoGrupo li').css('font-weight','normal');
    $('#flechaBuscadorIndicadores').css({
        'opacity'   : '0',
        'left'      :   '150px'
    });
    
    if(substr.length > 3){
        var elemMatch = $('li[titulo-indicador*="'+ substr +'"]').first();
        var IdPadreElemEncontrado = elemMatch.parent().parent().attr('id');
        if(IdPadreElemEncontrado !== undefined){
            elemMatch.css('font-weight','bold');
            if( !$('#' + IdPadreElemEncontrado).find('ul').first().is(":visible") ){
                $('#' + IdPadreElemEncontrado).prev().trigger('click');
            }
            var posXY_elemento_match = elemMatch.position();
            var srchboxHeight = 180;
            var center = srchboxHeight/2;            
            $('html, body').stop(true,true).animate({
                scrollTop: posXY_elemento_match.top - 150 //posScroll porque alli inicia el espacio del menu de cada subsitio
            }, 'fast', function(){
                $('#buscadorDeIndicadores').stop(true, true).animate({
                    'top'  : (posXY_elemento_match.top - center) + 4
                }, function(){
                    $('#flechaBuscadorIndicadores').stop(true, true).animate({
                        'opacity'   :   '1',
                        'left'      :   '-35'
                    }, 200);
                });
            });
        }else{
            $('#PageTitle').trigger('click');
            $('#buscadorDeIndicadores').stop(true, true).animate({
                'top'  : '400px'
            },'slow', function(){
                $('.controlExpColTodo a[href="#colapsarTodo"]').trigger('click');
            });
        }
    }else{
        $('#PageTitle').trigger('click');
        $('#buscadorDeIndicadores').stop(true, true).animate({
            'top'  : '400px'
        },'slow', function(){
            $('.controlExpColTodo a[href="#colapsarTodo"]').trigger('click');
        });
    }
});
function buscarIndicadorEnSIEE(_subsitio_id)
{
    var _substr_titulo = $.trim($('#tituloIndicadorParaBusqueda').val().toLowerCase());
    if(_substr_titulo.length > 0){
        $('.resultadoBusquedaGlobal').stop(true, true).fadeIn('fast');    
        var loading =   '<div style="text-align: center; width: 100%;">'+
        'Buscando en el Sistema . . . <br/><br/>'+
        '<img src="recursos/imagenes/loading1.gif" />'+
        '</div>';                
        $('.resultadoBusquedaGlobal .resultado').html(loading);
        $.ajax({
            type: "GET",
            url: "phpIncluidos/ajaxGetSiee.php",
            data: {
                opcion          : 6,
                substr_titulo   : _substr_titulo,
                subsitio_id     : _subsitio_id
            },
            cache: false,
            dataType : 'json',
            error: function(){
                $('.resultadoBusquedaGlobal .resultado').slideUp('fast', function(){
                    $(this).html('');
                });
                var _html = "<p>Parece que hay un problema con la conexi&oacute;n. Por favor refrescala p&aacute;gina y realiza esta acc&oacute;n de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_response){
                if(_response.error){
                    console.log('viene error');
                    $('.resultadoBusquedaGlobal .resultado').slideUp('fast', function(){
                        $(this).html('');
                    });
                }else{
                    $('.resultadoBusquedaGlobal .resultado').html(_response.ListaIndicadores);
                }
            }
        });
    }
}
function mostrarBuscadorIndicadores(){
    if( $('#buscadorDeIndicadores').is(':visible') ){
    //poner animacion
    }else{
        $('#buscadorDeIndicadores').stop();
        $('#buscadorDeIndicadores').css({
            opacity:'1'
        });
        $('#buscadorDeIndicadores').fadeIn('fast');
        $('.resultadoBusquedaGlobal .resultado').fadeIn('fast');
        $('.contenidoGrupo li').css('font-weight','normal');
    
        if( $(document).scrollTop() < 208 )
        {
            $('#buscadorDeIndicadores').animate({
                'top'  : PosInicialArribaBuscadorIndicadores
            }, function(){
                $('#tituloIndicadorParaBusqueda').focus();
            });
        }
        else
        {
            var elem = arguments[0];
            var position = $(elem).position().top;
            var offset = - 95;
            $('#buscadorDeIndicadores').animate({
                'top'  : position + (offset)
            }, function(){
                $('#tituloIndicadorParaBusqueda').focus();
            });
        }
        
    }
	
}
function cerrarBuscadorIndicadores()
{
    $('html, body').stop();
    $('#buscadorDeIndicadores').stop();
    $('#flechaBuscadorIndicadores').stop();
    
    $('#buscadorDeIndicadores').animate({
        'top'   : PosInicialArribaBuscadorIndicadores,
        'opacity' : 0
    }, function(){
        TamanioDeEstaPantalla = $(window).width();
        TamanioDeEstaPantalla = (TamanioDeEstaPantalla - 960) / 2;
        PosInicialIzqBuscadorIndicadores = TamanioDeEstaPantalla + 200;        
        $(this).css({
            'left'  : PosInicialIzqBuscadorIndicadores
        });
    });
    $('#buscadorDeIndicadores').fadeOut('slow');
    $('.contenidoGrupo li').css('font-weight','normal');
    $('#flechaBuscadorIndicadores').css('opacity','0');
    $('#flechaBuscadorIndicadores').css('left','150');
}
function getEtiquetaDepto(id)
{
    switch(id)
    {
        case '0':
            this.filtroDeptoTexto = "de todos los departamentos";
            break;
        case '1':
            this.filtroDeptoTexto = "del departamento Atlántida";
            break;
        case '2':
            this.filtroDeptoTexto = "del departamento Colón";
            break;
        case '3':
            this.filtroDeptoTexto = "del departamento Comayagua";
            break;
        case '4':
            this.filtroDeptoTexto = "del departamento Copán";
            break;
        case '5':
            this.filtroDeptoTexto = "del departamento CortÃƒÂ©s";
            break;
        case '6':
            this.filtroDeptoTexto = "del departamento Choluteca";
            break;
        case '7':
            this.filtroDeptoTexto = "del departamento El ParaÃƒÂ­so";
            break;
        case '8':
            this.filtroDeptoTexto = "del departamento Francisco Morazán";
            break;
        case '9':
            this.filtroDeptoTexto = "del departamento Gracias a Dios";
            break;
        case '10':
            this.filtroDeptoTexto = "del departamento Intibucá";
            break;
        case '11':
            this.filtroDeptoTexto = "del departamento Islas de la BahÃƒÂ­a";
            break;
        case '12':
            this.filtroDeptoTexto = "del departamento La Paz";
            break;
        case '13':
            this.filtroDeptoTexto = "del departamento Lempira";
            break;
        case '14':
            this.filtroDeptoTexto = "del departamento Ocotepeque";
            break;
        case '15':
            this.filtroDeptoTexto = "del departamento Olancho";
            break;
        case '16':
            this.filtroDeptoTexto = "del departamento Santa Bárbara";
            break;
        case '17':
            this.filtroDeptoTexto = "del departamento Valle";
            break;
        case '18':
            this.filtroDeptoTexto = "del departamento Yoro";
            break;
    }
}
function numaLetra(num)
{
    var letra = null;
    switch(num)
    {
        case 1:
            letra = 'A';
            break;
        case 2:
            letra = 'B';
            break;
        case 3:
            letra = 'C';
            break;
        case 4:
            letra = 'D';
            break;
        case 5:
            letra = 'E';
            break;
        case 6:
            letra = 'F';
            break;
        case 7:
            letra = 'G';
            break;
        case 8:
            letra = 'H';
            break;
        case 9:
            letra = 'I';
            break;
        case 10:
            letra = 'J';
            break;
        case 11:
            letra = 'K';
            break;
        case 12:
            letra = 'L';
            break;
        case 13:
            letra = 'M';
            break;
        case 14:
            letra = 'N';
            break;
        case 15:
            letra = 'O';
            break;
        case 16:
            letra = 'P';
            break;
        case 17:
            letra = 'Q';
            break;
    }
    return letra;
}
function letraNum(letra)
{
    var num = 0;
    switch(letra)
    {
        case 'A':
            num = 1;
            break;
        case 'B':
            num = 2;
            break;
        case 'C':
            num = 3;
            break;
        case 'D':
            num = 4;
            break;
        case 'E':
            num = 5;
            break;
        case 'F':
            num = 6;
            break;
        case 'G':
            num = 7;
            break;
        case 'H':
            num = 8;
            break;
        case 'I':
            num = 9;
            break;
        case 'J':
            num = 10;
            break;
        case 'K':
            num = 11;
            break;
        case 'L':
            num = 12;
            break;
        case 'M':
            num = 13;
            break;
        case 'N':
            num = 14;
            break;
        case 'O':
            num = 15;
            break;
        case 'P':
            num = 16;
            break;
        case 'Q':
            num = 17;
            break;
    }
    return num;
}
/* PROCESOS_ DEL USUARIO */
function filtroDeUsuario(str)
{
    $('#listadoModificarUsuario li').css('display', 'none');
    str = $.trim(str);	
	
    if (str == "")
    {
        $('#listadoModificarUsuario li').fadeIn('fast');
    }
    else
    {
        $('#listadoModificarUsuario [nombre_usuario*="'+ str +'"]').fadeIn('fast');
    }
}
function filtroDeUsuarioMod(estado_Usuario)
{
    $('#listadoActDesactUsuario li').css('display', 'none');
    	
    if ( (estado_Usuario == '0') || (estado_Usuario == '1') )
    {
        $('#listadoActDesactUsuario [esta_activa="'+ estado_Usuario +'"]').fadeIn('fast');
    }
    else
    {
        $('#listadoActDesactUsuario li').fadeIn('fast');
    }
}
function guardarAdminUsuario() {
   
    var _primerNombre = $.trim($('#PrimerNombreUsuario').val());
    var _segundoNombre = $.trim($('#SegundoNombreUsuario').val());
    var _primerApellido = $.trim($('#PrimerApellidoUsuario').val());
    var _segundoApellido = $.trim($('#SegundoApellidoUsuario').val());
    var _nombreUsuario = $.trim($('#NombreUsuario').val());
    var _rol = $('#RolUsuario').val();
    var _telefonoFijo = $.trim($('#TelefonoFijoUsuario').val());
    var _telefonoMovil = $.trim($('#TelefonoMovilUsuario').val());
    var _correoElectronico = $.trim($('#CorreoElectronicoUsuario').val());
    var errores = 0;
    if(errores === 0){
        //hacer ajax
        $.ajax({
            type: "POST",
            url: "administracion/guardar_usuario.php",
            cache: false,
            dataType : 'json',
            data: {
                primer_nombre      :_primerNombre,
                segundo_nombre     :_segundoNombre, 
                primer_apellido    :_primerApellido,     
                segundo_apellido   :_segundoApellido,    
                nombre_usuario     :_nombreUsuario,
                rol_id			   :_rol,
                telefono_fijo      :_telefonoFijo ,      
                telefono_movil     :_telefonoMovil,      
                correo_electronico :_correoElectronico
            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp)
            {
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input').removeClass('campo_error');
                    $('#errores_generales_nuevoUsuario, #exito_generales_nuevoUsuario').remove();
                    $('#tabsUsuario-1 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_nuevoUsuario', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_nuevoUsuario').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');					
                    }
                }else{
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input, #CamposFormulario select').attr('value','').removeClass('campo_error');
                    $('#errores_generales_nuevoUsuario, #exito_generales_nuevoUsuario').remove();
                    $('#tabsUsuario-1 #CamposFormulario').prepend(CajaExitoErrores(1, 'exito_generales_nuevoUsuario', 'El usuario se guardo exitosamente.'));
                    $('#exito_generales_nuevoUsuario').fadeIn('fast');
                    $('a[href="#tabsUsuario-3"]').attr('onclick','abrirSeccionAdmin(4,3)');
                }
            }
        });
    
    }
}
function guardarUsuarioActivarDesactivar(){
    var listaIdsUsuarios = new Array();
    var index = 0;
    $.each( $('#listadoActDesactUsuario [name="estatusUsuario"]:checked'), function(key, val){
        listaIdsUsuarios[index] = $(val).val();
        index++;
    });
    
    if(index === 0){
        $( "#dialogWindow" ).html("<p>Debe seleccionar a lo menos un(1) usuario del listado para poder realizar esta acci&oacute;n.</p>");
        $( "#dialogWindow" ).dialog({
            title   : 'Nota',
            modal   : true,
            buttons : {
                "Ok": function() {
                    $(this).dialog("close");
                }
            },
            minWidth: 600,
            resizable: false
        });
    }else{
        $.ajax({
            type: "POST",
            url: "administracion/cambiar_estado_usuario.php",
            cache: false,
            dataType: 'json',
            data: {
                listaIdsUsuarios      :    listaIdsUsuarios
            },
            error: function(){
                _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexi&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp)
            {
                if (_resp.refresh_error){
                    $( "#dialogWindow" ).html(_resp.refresh_error);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error al tratar de guardar',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                                $('#PageTitle').trigger('click');
                                abrirSeccionAdmin(4,3);
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else{
                    $( "#dialogWindow" ).html('<p>Los cambios en el estado de lo(s) Usuario(s) fue realizado con &eacute;xito.</p>');
                    $( "#dialogWindow" ).dialog({
                        title   : 'Transaci&oacute;n Exitosa!',
                        modal   : true,
                        buttons : {
                            "Perfecto": function() {
                                $(this).dialog("close");
                                $('#PageTitle').trigger('click');
                                abrirSeccionAdmin(4,3);
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }
            }
        });
    }	
}
function guardarModificacionUsuario()
{
    
    var _primerNombre		=   $('#PrimerNombreUsuario_mod').val();
    var _segundoNombre		=   $('#SegundoNombreUsuario_mod').val();
    var _primerApellido		=   $('#PrimerApellidoUsuario_mod').val();
    var _segundoApellido	=   $('#SegundoApellidoUsuario_mod').val();
    var _nombreUsuario		=   $('#NombreUsuario_mod').val();
    var _rol				= $('#RolUsuario_mod').val();
    var _telefonoFijo		=   $('#TelefonoFijoUsuario_mod').val();
    var _telefonoMovil		=   $('#TelefonoMovilUsuario_mod').val();
    var _correoElectronico	=   $('#CorreoElectronicoUsuario_mod').val();
    var _idUsuario			=   $('#IdUsuario_mod').val();
    var errores = 0;
    if(errores === 0){
        //hacer ajax
        $.ajax({
            type: "POST",
            url: "administracion/guardar_modificacion_usuario.php",
            cache: false,
            dataType : 'json',
            data: {
                id				:_idUsuario,
                primer_nombre	:_primerNombre,
                segundo_nombre	:_segundoNombre, 
                primer_apellido	:_primerApellido,     
                segundo_apellido	:_segundoApellido,    
                nombre_usuario	:_nombreUsuario,
                rol_id			:_rol,
                telefono_fijo	:_telefonoFijo ,      
                telefono_movil	:_telefonoMovil,      
                correo_electronico	:_correoElectronico
            },
            error: function(){
                //alert('err');
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp)
            {
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input').removeClass('campo_error');
                    $('#errores_generales_modificarUsuario, #exito_generales_modificarUsuario').remove();
                    $('#tabsUsuario-2 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_modificarUsuario', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_modificarUsuario').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');					
                    }
                }else{
                    $( "#dialogWindow" ).html('<p>Los datos del usuario fueron actualizados correctamente.</p>');
                    $( "#dialogWindow" ).dialog({
                        title   : "Actualizaci&oacute;n exitosa!",
                        modal   : true,
                        position		: '50px',
                        buttons : {
                            "Ok": function() { 
                                $("#PageTitle").trigger("click");
                                abrirSeccionAdmin(4,2);	
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });				
                }
            }
        });
    
    }else{
    ///agregar el mensaje general aqui
    }   
}
function cargarPanelModificacionUsuario(id_usuario)
{
    // alert("Entro");   
    var flag = false;
    try
    {
        parseInt(id_usuario);
        flag = true;
    }
    catch (error)
    {
        flag = false;
    }    
    if(flag)
    {
        $.ajax({
            type: "GET",
            url: "administracion/modificar_usuario.php",
            data: {
                id    :   id_usuario
            },
            error: function(){
                _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(msg)
            {
                $("#PanelModificacionDeUsuarios").remove();
                $('#tabsUsuario-2').append(msg);
                $('#PanelModificacionDeUsuarios').fadeIn('fast');                
                $('html, body').animate({
                    scrollTop:940
                }, 'slow');
            }
        });
    }   
}
function CajaExitoErrores(tipo, id, mensaje){
    var html = '<div id="' + id + '" class="';
	
    if (tipo == 1){
        html += 'exito_generales_formulario">' + '<span style="font-weight: bold;">Registro Exitoso!</span>';
    }else{
        html += 'errores_generales_formulario">' + '<span style="font-weight: bold;">Errores Encontrados</span>';
    }
	
    html += '<br/><p style="text-indent: 6px;">' + mensaje + '</p><p style="text-align: right;"><button class="ui-boton-cerrar" onclick="$(\'#' + id + '\').animate({height : \'0\'}, 150, function(){$(\'#' + id + '\').remove();})">Cerrar</button></p></div>';
	
    x = setTimeout('$(\'#' + id + '\').fadeOut(\'fast\', function(){$(this).remove();});', 6000);
    return html;
}
//CAMBIOS 2DA PARTE
function filtroDeRol(str)
{
    $('#listadoModificarRol li').css('display', 'none');
    str = $.trim(str);	
	
    if (str == "")
    {
        $('#listadoModificarRol li').fadeIn('fast');
    }
    else
    {
        $('#listadoModificarRol [titulo_rol*="'+ str +'"]').fadeIn('fast');
    }
}
function guardarAdminRol() {
    var _tituloRol = $.trim($('#TituloRol').val());
    var _descripcionRol = $.trim($('#DescripcionRol').val());
    var _es_administrador = $('input:radio[name=administrador]:checked').val();
    var _ver_alertas_desviaciones = $('input:radio[name=alertas_de_desviaciones]:checked').val();
    var _ver_indicadores_privados = $('input:radio[name=indicadores_privados]:checked').val();
    var _ver_proyecciones = $('input:radio[name=proyecciones]:checked').val();
    var _moderador = $('input:radio[name=moderador]:checked').val();
    var errores = 0;  
    if(errores === 0){
        //hacer ajax
        $.ajax({
            type: "POST",
            url: "administracion/guardar_rol.php",
            cache: false,
            dataType : 'json',
            data: {
                titulo_rol              :_tituloRol,
                descripcion_rol         :_descripcionRol,
                administrador        :_es_administrador,
                alertas_de_desviaciones :_ver_alertas_desviaciones,
                indicadores_privados    :_ver_indicadores_privados,
                proyecciones        :_ver_proyecciones,
                moderador            :_moderador
                   
            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp)
            {
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input').removeClass('campo_error');
                    $('#errores_generales_nuevoRol, #exito_generales_nuevoRol').remove();
                    $('#tabsRol-1 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_nuevoRol', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_nuevoRol').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');                   
                    }
                }else{
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input, textarea').attr('value','').removeClass('campo_error');
                    $('#errores_generales_nuevoRol, #exito_generales_nuevoRol').remove();
                    $('#tabsRol-1 #CamposFormulario').prepend(CajaExitoErrores(1, 'exito_generales_nuevoRol', 'El rol se guardo exitosamente.'));
                    $('#exito_generales_nuevoRol').fadeIn('fast');
                    $('a[href="#tabsRol-3"]').attr('onclick','abrirSeccionAdmin(11,3)');
                }
            }
        });
    }
}
function cargarPanelModificacionRol(id_rol)
{
    var flag = false;
    try
    {
        parseInt(id_rol);
        flag = true;
    }
    catch (error)
    {
        flag = false;
    }    
    if(flag)
    {
        $.ajax({
            type: "GET",
            url: "administracion/modificar_rol.php",
            data: {
                rol_id    :   id_rol
            },
            error: function(){
                _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(msg)
            {
                $("#PanelModificacionDeRol").remove();
                $('#tabsRol-2').append(msg);
                $('#PanelModificacionDeRol').fadeIn('fast');                
                $('html, body').animate({
                    scrollTop:940
                }, 'slow');
            }
        });
    }    
}
function filtroDeSeriesRolMod(estado_rol)
{
    $('#listadoActDesactRol li').css('display', 'none');
    	
    if ( (estado_rol == '0') || (estado_rol == '1') )
    {
        $('#listadoActDesactRol [esta_activa="'+ estado_rol +'"]').fadeIn('fast');
    }
    else
    {
        $('#listadoActDesactRol li').fadeIn('fast');
    }
}
function guardarRolActivarDesactivar()
{
    var listaIdsRol = new Array();
    var index = 0;
    $.each( $('#listadoActDesactRol [name="estatusRol"]:checked'), function(key, val){
        listaIdsRol[index] = $(val).val();
        index++;
    });
    if(index === 0){
        $( "#dialogWindow" ).html('<p>Debe seleccionar a lo menos un(1) ROL para poder realizar esta acci&oacute;n.</p>');
        $( "#dialogWindow" ).dialog({
            title   : 'Nota',
            modal   : true,
            buttons : {
                "Ok": function() {
                    $(this).dialog("close");
                }
            },
            minWidth: 600,
            resizable: false
        });
    }else{
        $.ajax({
            type: "POST",
            url: "administracion/cambiar_estado_rol.php",
            cache: false,
            data: {
                listaIdsRoles     :    listaIdsRol
            },
            error: function(){
                _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexi&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp)
            {
                if (_resp.refresh_error){
                    $( "#dialogWindow" ).html(_resp.refresh_error);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error al tratar de guardar',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                                $('#PageTitle').trigger('click');
                                abrirSeccionAdmin(11,3);
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else{
                    $( "#dialogWindow" ).html('<p>Los cambios en el estado de el/los Roles fue realizado con &eacute;xito.</p>');
                    $( "#dialogWindow" ).dialog({
                        title   : 'Transaci&oacute;n Exitosa!',
                        modal   : true,
                        buttons : {
                            "Perfecto": function() {
                                $(this).dialog("close");
                                $('#PageTitle').trigger('click');
                                abrirSeccionAdmin(11,3);
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }
            }
        });
    }
	
}
function guardarModificacionRol()
{
   
    var _tituloRol = $.trim($('#TituloRol_mod').val());
    var _descripcionRol = $.trim($('#DescripcionRol_mod').val());
    var _es_administrador = $('input:radio[name=administrador_mod]:checked').val();
    var _ver_alertas_desviaciones = $('input:radio[name=alertas_de_desviaciones_mod]:checked').val();
    var _ver_indicadores_privados = $('input:radio[name=indicadores_privados_mod]:checked').val();
    var _ver_proyecciones = $('input:radio[name=proyecciones_mod]:checked').val();
    var _moderador = $('input:radio[name=moderador_mod]:checked').val();
    var _id = $.trim($('#RolId_mod').val());
    var errores = 0;
    if(errores === 0){
        //hacer ajax
        $.ajax({
            type: "POST",
            url: "administracion/guardar_modificacion_rol.php",
            cache: false,
            dataType : 'json',
            data: {
                id                :_id,
                titulo_rol      :_tituloRol,
                descripcion_rol :_descripcionRol,
                administrador    :_es_administrador,
                alertas_de_desviaciones :_ver_alertas_desviaciones,
                indicadores_privados    :_ver_indicadores_privados,
                proyecciones    :_ver_proyecciones,
                moderador        :_moderador
            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp)
            {
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input, textarea').removeClass('campo_error');
                    $('#errores_generales_modificarRol, #exito_generales_modificarRol').remove();
                    $('#tabsRol-2 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_modificarRol', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_modificarRol').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');                   
                    }
                }else{
                    $( "#dialogWindow" ).html('<p>Los datos del rol fueron actualizados correctamente.</p>');
                    $( "#dialogWindow" ).dialog({
                        title   : "Actualizaci&oacute;n exitosa!",
                        modal   : true,
                        position        : '50px',
                        buttons : {
                            "Ok": function() {
                                $("#PageTitle").trigger("click");
                                abrirSeccionAdmin(11,2);
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });               
                }
            }
        });
   
    }else{
    ///agregar el mensaje general aqui
    }
}
function guardarAdminNivelEducativo() {

    var _tituloNivelEducativo = $.trim($('#TituloNivelEducativo').val());
    var _descripcionNivelEducativo = $.trim($('#DescripcionNivelEducativo').val());
    var errores = 0;
    if(errores === 0){
        $.ajax({
            type: "POST",
            url: "administracion/guardar_nivel_educativo.php",
            cache: false,
            dataType : 'json',
            data: {
                titulo          :_tituloNivelEducativo,
                descripcion      :_descripcionNivelEducativo

            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp)
            {
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input').removeClass('campo_error');
                    $('#errores_generales_nuevoNivelEducativo, #exito_generales_nuevoNivelEducativo').remove();
                    $('#tabsNivelEducativo-1 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_nuevoNivelEducativo', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_nuevoNivelEducativo').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');
                    }
                }else{
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input, textarea').attr('value','').removeClass('campo_error');
                    $('#errores_generales_nuevoNivelEducativo, #exito_generales_nuevoNivelEducativo').remove();
                    $('#tabsNivelEducativo-1 #CamposFormulario').prepend(CajaExitoErrores(1, 'exito_generales_nuevoNivelEducativo', 'El Nivel Educativo se guardo exitosamente.'));
                    $('#exito_generales_nuevoNivelEducativo').fadeIn('fast');
                    $('a[href="#tabsNivelEducativo-3"]').attr('onclick','abrirSeccionAdmin(10,3)');
                }
            }
        });

    }



}
function filtroDeNivelEducativo(str)
{
    $('#listadoModificarNivelEducativo li').css('display', 'none');
    str = $.trim(str);

    if (str == "")
    {
        $('#listadoModificarNivelEducativo li').fadeIn('fast');
    }
    else
    {
        $('#listadoModificarNivelEducativo [titulo_NivelEducativo*="'+ str +'"]').fadeIn('fast');
    }
}
function cargarPanelModificacionNivelEducativo(id_NivelEducativo)
{
    var flag = false;
    try
    {
        parseInt(id_NivelEducativo);
        flag = true;
    }
    catch (error)
    {
        flag = false;
    }
    if(flag)
    {
        $.ajax({
            type: "GET",
            url: "administracion/modificar_nivel_educativo.php",
            data: {
                id    :   id_NivelEducativo
            },
            error: function(){
                _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(msg)
            {
                $("#PanelModificacionDeNivelEducativo").remove();
                $('#tabsNivelEducativo-2').append(msg);
                $('#PanelModificacionDeNivelEducativo').fadeIn('fast');
                $('html, body').animate({
                    scrollTop:940
                }, 'slow');

            }
        });
    }


}
function filtroDeNivelEducativoMod(estado_NivelEducativo)
{
    $('#listadoActDesactNivelEducativo li').css('display', 'none');

    if ( (estado_NivelEducativo == '0') || (estado_NivelEducativo == '1') )
    {
        $('#listadoActDesactNivelEducativo [esta_activa="'+ estado_NivelEducativo +'"]').fadeIn('fast');
    }
    else
    {
        $('#listadoActDesactNivelEducativo li').fadeIn('fast');
    }
}
function guardarNivelEducativoActivarDesactivar(){

    var listaIdsNivelEducativo = new Array();
    var index = 0;
    $.each( $('#listadoActDesactNivelEducativo [name="estatusNivelEducativo]:checked'), function(key, val){
        listaIdsNivelEducativo[index] = $(val).val();
        index++;
    });

    $.ajax({
        type: "POST",
        url: "administracion/cambiar_estado_nivel_educativo.php",
        cache: false,
        data: {
            listaIdsNivelesEducativos     :    listaIdsNivelEducativo
        },
        error: function(){
            _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexi&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
            $( "#dialogWindow" ).html(_html);
            $( "#dialogWindow" ).dialog({
                title   : 'Ups! error',
                modal   : true,
                buttons : {
                    "Ok": function() {
                        $(this).dialog("close");
                    }
                },
                minWidth: 600,
                resizable: false
            });
        },
        success: function(_resp)
        {
            if (_resp.refresh_error){
                $( "#dialogWindow" ).html(_resp.refresh_error);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error al tratar de guardar',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                            $('#PageTitle').trigger('click');
                            abrirSeccionAdmin(10,3);
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            }else{
                $( "#dialogWindow" ).html('<p>Los cambios en el estado de de nivel educativo fue realizado con &eacute;xito.</p>');
                $( "#dialogWindow" ).dialog({
                    title   : 'Transaci&oacute;n Exitosa!',
                    modal   : true,
                    buttons : {
                        "Perfecto": function() {
                            $(this).dialog("close");
                            $('#PageTitle').trigger('click');
                            abrirSeccionAdmin(10,3);
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            }
        }
    });

}
function guardarModificacionNivelEducativo()
{

    var _tituloNivelEducativo             = $('#TituloNivelEducativo_mod').val();
    var _descripcionNivelEducativo      = $('#DescripcionNivelEducativo_mod').val();
    var _idNivelEducativo             = $('#NivelEducativoId_mod').val();
    var errores = 0;
    if(errores === 0){
        $.ajax({
            type: "POST",
            url: "administracion/guardar_modificacion_nivel_educativo.php",
            cache: false,
            dataType : 'json',
            data: {
                id        :_idNivelEducativo,
                titulo    :_tituloNivelEducativo,
                descripcion :_descripcionNivelEducativo

            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp)
            {
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input').removeClass('campo_error');
                    $('#errores_generales_modificarNivelEducativo, #exito_generales_modificarNivelEducativo').remove();
                    $('#tabsNivelEducativo-2 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_modificarNivelEducativo', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_modificarNivelEducativo').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');
                    }
                }else{
                    $( "#dialogWindow" ).html('<p>Los datos del nivel educativo fueron actualizados correctamente.</p>');
                    $( "#dialogWindow" ).dialog({
                        title   : "Actualizaci&oacute;n exitosa!",
                        modal   : true,
                        position        : '50px',
                        buttons : {
                            "Ok": function() {
                                $("#PageTitle").trigger("click");
                                abrirSeccionAdmin(10,2);
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }
            }
        });

    }else{
    ///agregar el mensaje general aqui
    }
}
function guardarAdminTipoEducacion() {

    var _tituloTipoEducacion = $.trim($('#TituloTipoEducacion').val());
    var _descripcionTipoEducacion = $.trim($('#DescripcionTipoEducacion').val());
    var errores = 0;
    if(errores === 0){
        $.ajax({
            type: "POST",
            url: "administracion/guardar_tipo_educacion.php",
            cache: false,
            dataType : 'json',
            data: {
                titulo          :_tituloTipoEducacion,
                descripcion      :_descripcionTipoEducacion

            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp)
            {
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input').removeClass('campo_error');
                    $('#errores_generales_nuevoTipoEducacion, #exito_generales_nuevoTipoEducacion').remove();
                    $('#tabsTipoEducacion-1 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_nuevoTipoEducacion', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_nuevoTipoEducacion').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');
                    }
                }else{
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input, textarea').attr('value','').removeClass('campo_error');
                    $('#errores_generales_nuevoTipoEducacion, #exito_generales_nuevoTipoEducacion').remove();
                    $('#tabsTipoEducacion-1 #CamposFormulario').prepend(CajaExitoErrores(1, 'exito_generales_nuevoTipoEducacion', 'El tipo de educaci&oacute; se guardo exitosamente.'));
                    $('#exito_generales_nuevoTipoEducacion').fadeIn('fast');
                    $('a[href="#tabsTipoEducacion-3"]').attr('onclick','abrirSeccionAdmin(8,3)');
                }
            }
        });

    }



}
function cargarPanelModificacionTipoEducacion(id_TipoEducacion)
{
    var flag = false;
    try
    {
        parseInt(id_TipoEducacion);
        flag = true;
    }
    catch (error)
    {
        flag = false;
    }
    if(flag)
    {
        $.ajax({
            type: "GET",
            url: "administracion/modificar_tipo_educacion.php",
            data: {
                id    :   id_TipoEducacion
            },
            error: function(){
                _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(msg)
            {
                $("#PanelModificacionDeTipoEducacion").remove();
                $('#tabsTipoEducacion-2').append(msg);
                $('#PanelModificacionDeTipoEducacion').fadeIn('fast');
                $('html, body').animate({
                    scrollTop:940
                }, 'slow');

            }
        });
    }


}
function filtroDeTipoEducacion(str)
{
    $('#listadoModificarTipoEducacion li').css('display', 'none');
    str = $.trim(str);

    if (str == "")
    {
        $('#listadoModificarTipoEducacion li').fadeIn('fast');
    }
    else
    {
        $('#listadoModificarTipoEducacion [titulo_TipoEducacion*="'+ str +'"]').fadeIn('fast');
    }
}
function filtroDeTipoEducacionMod(estado_TipoEducacion)
{
    $('#listadoActDesactTipoEducacion li').css('display', 'none');

    if ( (estado_TipoEducacion == '0') || (estado_TipoEducacion == '1') )
    {
        $('#listadoActDesactNivelEducativo [esta_activa="'+ estado_TipoEducacion +'"]').fadeIn('fast');
    }
    else
    {
        $('#listadoActDesactTipoEducacion li').fadeIn('fast');
    }
}
function guardarTipoEducacionActivarDesactivar(){

    var listaIdsTipoEducacion = new Array();
    var index = 0;
    $.each( $('#listadoActDesactTipoEducacion [name="estatusTipoEducacion"]:checked'), function(key, val){
        listaIdsTipoEducacion[index] = $(val).val();
        index++;
    });

    $.ajax({
        type: "POST",
        url: "administracion/cambiar_estado_tipo_educacion.php",
        cache: false,
        data: {
            listaIdsTiposEducacion     :    listaIdsTipoEducacion
        },
        error: function(){
            _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexi&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
            $( "#dialogWindow" ).html(_html);
            $( "#dialogWindow" ).dialog({
                title   : 'Ups! error',
                modal   : true,
                buttons : {
                    "Ok": function() {
                        $(this).dialog("close");
                    }
                },
                minWidth: 600,
                resizable: false
            });
        },
        success: function(_resp)
        {
            if (_resp.refresh_error){
                $( "#dialogWindow" ).html(_resp.refresh_error);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error al tratar de guardar',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                            $('#PageTitle').trigger('click');
                            abrirSeccionAdmin(8,3);
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            }else{
                $( "#dialogWindow" ).html('<p>Los cambios en el estado los tipos de educaci&oacute; fue realizado con &eacute;xito.</p>');
                $( "#dialogWindow" ).dialog({
                    title   : 'Transaci&oacute;n Exitosa!',
                    modal   : true,
                    buttons : {
                        "Perfecto": function() {
                            $(this).dialog("close");
                            $('#PageTitle').trigger('click');
                            abrirSeccionAdmin(8,3);
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            }
        }
    });

}
function guardarModificacionTipoEducacion()
{

    var _tituloTipoEducacion            = $('#TituloTipoEducacion_mod').val();
    var _descripcionTipoEducacion      = $('#DescripcionTipoEducacion_mod').val();
    var _idTipoEducacion             = $('#TipoEducacionId_mod').val();
    var errores = 0;
    if(errores === 0){
        $.ajax({
            type: "POST",
            url: "administracion/guardar_modificacion_tipo_educacion.php",
            cache: false,
            dataType : 'json',
            data: {
                id        :_idTipoEducacion,
                titulo    :_tituloTipoEducacion,
                descripcion :_descripcionTipoEducacion

            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp)
            {
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input').removeClass('campo_error');
                    $('#errores_generales_modificarTipoEducacion, #exito_generales_modificarTipoEducacion').remove();
                    $('#tabsTipoEducacion-2 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_modificarTipoEducacion', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_modificarTipoEducacion').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');
                    }
                }else{
                    $( "#dialogWindow" ).html('<p>Los datos del tipo de educaci&oacute; fueron actualizados correctamente.</p>');
                    $( "#dialogWindow" ).dialog({
                        title   : "Actualizaci&oacute;n exitosa!",
                        modal   : true,
                        position        : '50px',
                        buttons : {
                            "Ok": function() {
                                $("#PageTitle").trigger("click");
                                abrirSeccionAdmin(8,2);
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }
            }
        });

    }else{
    ///agregar el mensaje general aqui
    }
}
function guardarAdminTipoMatricula() {
    var _tituloTipoMatricula = $.trim($('#TituloTipoMatricula').val());
    var _descripcionTipoMatricula = $.trim($('#DescripcionTipoMatricula').val());
    var errores = 0;
    if(errores === 0){
        $.ajax({
            type: "POST",
            url: "administracion/guardar_tipo_matricula.php",
            cache: false,
            dataType : 'json',
            data: {
                titulo          :_tituloTipoMatricula,
                descripcion      :_descripcionTipoMatricula

            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp){
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input').removeClass('campo_error');
                    $('#errores_generales_nuevoTipoMatricula, #exito_generales_nuevoTipoMatricula').remove();
                    $('#tabsTipoMatricula-1 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_nuevoTipoMatricula', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_nuevoTipoMatricula').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');
                    }
                }else{
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input, textarea').attr('value','').removeClass('campo_error');
                    $('#errores_generales_nuevoTipoMatricula, #exito_generales_nuevoTipoMatricula').remove();
                    $('#tabsTipoMatricula-1 #CamposFormulario').prepend(CajaExitoErrores(1, 'exito_generales_nuevoTipoMatricula', 'El tipo de Matricula se guardo exitosamente.'));
                    $('#exito_generales_nuevoTipoMatricula').fadeIn('fast');
                    $('a[href="#tabsTipoMatricula-3"]').attr('onclick','abrirSeccionAdmin(7,3)');
                }
            }
        });
    }
}
function cargarPanelModificacionTipoMatricula(id_TipoMatricula){
    var flag = false;
    try{
        parseInt(id_TipoMatricula);
        flag = true;
    }
    catch (error){
        flag = false;
    }
    if(flag){
        $.ajax({
            type: "GET",
            url: "administracion/modificar_tipo_matricula.php",
            data: {
                id    :   id_TipoMatricula
            },
            error: function(){
                _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(msg){
                $("#PanelModificacionDeTipoMatricula").remove();
                $('#tabsTipoMatricula-2').append(msg);
                $('#PanelModificacionDeTipoMatricula').fadeIn('fast');
                $('html, body').animate({
                    scrollTop:940
                }, 'slow');
            }
        });
    }
}
function filtroDeTipoMatricula(str){
    $('#listadoModificarTipoMatricula li').css('display', 'none');
    str = $.trim(str);
    if (str == ""){
        $('#listadoModificarTipoMatricula li').fadeIn('fast');
    }
    else{
        $('#listadoModificarTipoMatricula [titulo_TipoMatricula*="'+ str +'"]').fadeIn('fast');
    }
}
function filtroDeTipoMatriculaMod(estado_TipoMatricula){
    $('#listadoActDesactTipoMatricula li').css('display', 'none');
    if ( (estado_TipoMatricula == '0') || (estado_TipoMatricula == '1') ){
        $('#listadoActDesactNivelEducativo [esta_activa="'+ estado_TipoMatricula +'"]').fadeIn('fast');
    }
    else{
        $('#listadoActDesactTipoMatricula li').fadeIn('fast');
    }
}
function guardarTipoMatriculaActivarDesactivar(){
    var listaIdsTipoMatricula = new Array();
    var index = 0;
    $.each( $('#listadoActDesactTipoMatricula [name="estatusTipoMatricula"]:checked'), function(key, val){
        listaIdsTipoMatricula[index] = $(val).val();
        index++;
    });
    $.ajax({
        type: "POST",
        url: "administracion/cambiar_estado_tipo_matricula.php",
        cache: false,
        data: {
            listaIdsTiposMatricula     :    listaIdsTipoMatricula
        },
        error: function(){
            _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexi&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
            $( "#dialogWindow" ).html(_html);
            $( "#dialogWindow" ).dialog({
                title   : 'Ups! error',
                modal   : true,
                buttons : {
                    "Ok": function() {
                        $(this).dialog("close");
                    }
                },
                minWidth: 600,
                resizable: false
            });
        },
        success: function(_resp){
            if (_resp.refresh_error){
                $( "#dialogWindow" ).html(_resp.refresh_error);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error al tratar de guardar',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                            $('#PageTitle').trigger('click');
                            abrirSeccionAdmin(7,3);
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            }else{
                $( "#dialogWindow" ).html('<p>Los cambios en el estado los tipos de Matricula fue realizado con &eacute;xito.</p>');
                $( "#dialogWindow" ).dialog({
                    title   : 'Transaci&oacute;n Exitosa!',
                    modal   : true,
                    buttons : {
                        "Perfecto": function() {
                            $(this).dialog("close");
                            $('#PageTitle').trigger('click');
                            abrirSeccionAdmin(7,3);
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            }
        }
    });
}
function guardarModificacionTipoMatricula(){
    var _tituloTipoMatricula            = $('#TituloTipoMatricula_mod').val();
    var _descripcionTipoMatricula      = $('#DescripcionTipoMatricula_mod').val();
    var _idTipoMatricula             = $('#TipoMatriculaId_mod').val();
    var errores = 0;
    if(errores === 0){
        $.ajax({
            type: "POST",
            url: "administracion/guardar_modificacion_tipo_matricula.php",
            cache: false,
            dataType : 'json',
            data: {
                id        :_idTipoMatricula,
                titulo    :_tituloTipoMatricula,
                descripcion :_descripcionTipoMatricula

            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp){
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input').removeClass('campo_error');
                    $('#errores_generales_modificarTipoMatricula, #exito_generales_modificarTipoMatricula').remove();
                    $('#tabsTipoMatricula-2 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_modificarTipoMatricula', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_modificarTipoMatricula').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');
                    }
                }else{
                    $( "#dialogWindow" ).html('<p>Los datos del tipo de Matricula fueron actualizados correctamente.</p>');
                    $( "#dialogWindow" ).dialog({
                        title   : "Actualizaci&oacute;n exitosa!",
                        modal   : true,
                        position        : '50px',
                        buttons : {
                            "Ok": function() {
                                $("#PageTitle").trigger("click");
                                abrirSeccionAdmin(7,2);
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }
            }
        });
    }else{
    ///agregar el mensaje general aqui
    }
}
function guardarAdminTipoDesagregacion() {
    var _tituloTipoDesagregacion = $.trim($('#TituloTipoDesagregacion').val());
    var _descripcionTipoDesagregacion = $.trim($('#DescripcionTipoDesagregacion').val());
    var errores = 0;
    if(errores === 0){
        $.ajax({
            type: "POST",
            url: "administracion/guardar_tipo_desagregacion.php",
            cache: false,
            dataType : 'json',
            data: {
                titulo          :_tituloTipoDesagregacion,
                descripcion      :_descripcionTipoDesagregacion

            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp){
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input').removeClass('campo_error');
                    $('#errores_generales_nuevoTipoDesagregacion, #exito_generales_nuevoTipoDesagregacion').remove();
                    $('#tabsTipoDesagregacion-1 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_nuevoTipoDesagregacion', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_nuevoTipoDesagregacion').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');
                    }
                }else{
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input, textarea').attr('value','').removeClass('campo_error');
                    $('#errores_generales_nuevoTipoDesagregacion, #exito_generales_nuevoTipoDesagregacion').remove();
                    $('#tabsTipoDesagregacion-1 #CamposFormulario').prepend(CajaExitoErrores(1, 'exito_generales_nuevoTipoDesagregacion', 'El tipo de desagregaci&oacute;n se guardo exitosamente.'));
                    $('#exito_generales_nuevoTipoDesagregacion').fadeIn('fast');
                    $('a[href="#tabsTipoDesagregacion-3"]').attr('onclick','abrirSeccionAdmin(6,3)');             
                }
            }
        });
    }
}
function cargarPanelModificacionTipoDesagregacion(id_TipoDesagregacion){
    var flag = false;
    try{
        parseInt(id_TipoDesagregacion);
        flag = true;
    }
    catch (error){
        flag = false;
    }
    if(flag){
        $.ajax({
            type: "GET",
            url: "administracion/modificar_tipo_desagregacion.php",
            data: {
                id    :   id_TipoDesagregacion
            },
            error: function(){
                _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(msg){
                $("#PanelModificacionDeTipoDesagregacion").remove();
                $('#tabsTipoDesagregacion-2').append(msg);
                $('#PanelModificacionDeTipoDesagregacion').fadeIn('fast');
                $('html, body').animate({
                    scrollTop:940
                }, 'slow');

            }
        });
    }
}
function filtroDeTipoDesagregacion(str){
    $('#listadoModificarTipoDesagregacion li').css('display', 'none');
    str = $.trim(str);
    if (str == ""){
        $('#listadoModificarTipoDesagregacion li').fadeIn('fast');
    }
    else{
        $('#listadoModificarTipoDesagregacion [titulo_TipoDesagregacion*="'+ str +'"]').fadeIn('fast');
    }
}
function filtroDeTipoDesagregacionMod(estado_TipoDesagregacion){
    $('#listadoActDesactTipoDesagregacion li').css('display', 'none');
    if ( (estado_TipoDesagregacion == '0') || (estado_TipoDesagregacion == '1') ){
        $('#listadoActDesactTipoDesagregacion [esta_activa="'+ estado_TipoDesagregacion +'"]').fadeIn('fast');
    }
    else{
        $('#listadoActDesactTipoDesagregacion li').fadeIn('fast');
    }
}
function guardarTipoDesagregacionActivarDesactivar(){
    var listaIdsTipoDesagregacion = new Array();
    var index = 0;
    $.each( $('#listadoActDesactTipoDesagregacion [name="estatusTipoDesagregacion"]:checked'), function(key, val){
        listaIdsTipoDesagregacion[index] = $(val).val();
        index++;
    });
    $.ajax({
        type: "POST",
        url: "administracion/cambiar_estado_tipo_desagregacion.php",
        cache: false,
        data: {
            listaIdsTiposDesagregacion     :    listaIdsTipoDesagregacion
        },
        error: function(){
            _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexi&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
            $( "#dialogWindow" ).html(_html);
            $( "#dialogWindow" ).dialog({
                title   : 'Ups! error',
                modal   : true,
                buttons : {
                    "Ok": function() {
                        $(this).dialog("close");
                    }
                },
                minWidth: 600,
                resizable: false
            });
        },
        success: function(_resp){
            if (_resp.refresh_error){
                $( "#dialogWindow" ).html(_resp.refresh_error);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error al tratar de guardar',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                            $('#PageTitle').trigger('click');
                            abrirSeccionAdmin(6,3);
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            }else{
                $( "#dialogWindow" ).html('<p>Los cambios en el estado de los tipos de desagregaci&oacute;n fue realizado con &eacute;xito.</p>');
                $( "#dialogWindow" ).dialog({
                    title   : 'Transaci&oacute;n Exitosa!',
                    modal   : true,
                    buttons : {
                        "Perfecto": function() {
                            $(this).dialog("close");
                            $('#PageTitle').trigger('click');
                            abrirSeccionAdmin(6,3);
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            }
        }
    });
}
function guardarModificacionTipoDesagregacion(){
    var _tituloTipoDesagregacion            = $('#TituloTipoDesagregacion_mod').val();
    var _descripcionTipoDesagregacion      = $('#DescripcionTipoDesagregacion_mod').val();
    var _idTipoDesagregacion             = $('#TipoDesagregacionId_mod').val();
    var errores = 0;
    if(errores === 0){
        $.ajax({
            type: "POST",
            url: "administracion/guardar_modificacion_tipo_desagregacion.php",
            cache: false,
            dataType : 'json',
            data: {
                id        :_idTipoDesagregacion,
                titulo    :_tituloTipoDesagregacion,
                descripcion :_descripcionTipoDesagregacion

            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp){
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input').removeClass('campo_error');
                    $('#errores_generales_modificarTipoDesagregacion, #exito_generales_modificarTipoDesagregacion').remove();
                    $('#tabsTipoDesagregacion-2 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_modificarTipoDesagregacion', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_modificarTipoDesagregacion').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');
                    }
                }else{
                    $( "#dialogWindow" ).html('<p>Los datos del tipo de desagregaci&oacute;n fueron actualizados correctamente.</p>');
                    $( "#dialogWindow" ).dialog({
                        title   : "Actualizaci&oacute;n exitosa!",
                        modal   : true,
                        position        : '50px',
                        buttons : {
                            "Ok": function() {
                                $("#PageTitle").trigger("click");
                                abrirSeccionAdmin(6,2);
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }
            }
        });
    }else{
    ///agregar el mensaje general aqui
    }
}
function guardarAdminSubsitio() {
    var _tituloSubsitio = $.trim($('#TituloSubsitio').val());
    var _descripcionSubsitio = $.trim($('#DescripcionSubsitio').val());
    var _abreviaturaSubsitio = $.trim($('#AbreviaturaSubsitio').val());
    var _urlSubsitio = $.trim($('#UrlSubsitio').val());
    var errores = 0;
    if(errores === 0){
        $.ajax({
            type: "POST",
            url: "administracion/guardar_subsitio.php",
            cache: false,
            dataType : 'json',
            data: {
                titulo          :_tituloSubsitio,
                descripcion      :_descripcionSubsitio,
                abreviatura     :_abreviaturaSubsitio,
                url             :_urlSubsitio

            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp){
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input').removeClass('campo_error');
                    $('#errores_generales_nuevoSubsitio, #exito_generales_nuevoSubsitio').remove();
                    $('#tabsSubsitio-1 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_nuevoSubsitio', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_nuevoSubsitio').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');
                    }
                }else{
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input, textarea').attr('value','').removeClass('campo_error');
                    $('#errores_generales_nuevoSubsitio, #exito_generales_nuevoSubsitio').remove();
                    $('#tabsSubsitio-1 #CamposFormulario').prepend(CajaExitoErrores(1, 'exito_generales_nuevoSubsitio', 'El subsitio se guardo exitosamente.'));
                    $('#exito_generales_nuevoSubsitio').fadeIn('fast');
                    $('a[href="#tabsSubsitio-3"]').attr('onclick','abrirSeccionAdmin(5,3)');         
                }
            }
        });
    }
}
function cargarPanelModificacionSubsitio(id_Subsitio){
    var flag = false;
    try{
        parseInt(id_Subsitio);
        flag = true;
    }
    catch (error){
        flag = false;
    }
    if(flag){
        $.ajax({
            type: "GET",
            url: "administracion/modificar_subsitio.php",
            data: {
                id    :   id_Subsitio
            },
            error: function(){
                _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(msg){
                $("#PanelModificacionDeSubsitio").remove();
                $('#tabsSubsitio-2').append(msg);
                $('#PanelModificacionDeSubsitio').fadeIn('fast');
                $('html, body').animate({
                    scrollTop:940
                }, 'slow');
            }
        });
    }
}
function filtroDeSubsitio(str){
    $('#listadoModificarSubsitio li').css('display', 'none');
    str = $.trim(str);
    if (str == ""){
        $('#listadoModificarSubsitio li').fadeIn('fast');
    }
    else{
        $('#listadoModificarSubsitio [titulo_Subsitio*="'+ str +'"]').fadeIn('fast');
    }
}
function filtroDeSubsitioMod(estado_Subsitio){
    $('#listadoActDesactSubsitio li').css('display', 'none');
    if ( (estado_Subsitio == '0') || (estado_Subsitio == '1') ){
        $('#listadoActDesactSubsitio [esta_activa="'+ estado_Subsitio +'"]').fadeIn('fast');
    }
    else{
        $('#listadoActDesactSubsitio li').fadeIn('fast');
    }
}
function guardarSubsitioActivarDesactivar(){

    var listaIdsSubsitio = new Array();
    var index = 0;
    $.each( $('#listadoActDesactSubsitio [name="estatusSubsitio"]:checked'), function(key, val){
        listaIdsSubsitio[index] = $(val).val();
        index++;
    });
    if(index === 0){
        var _html = "<p>Debes seleccionar a lo menos 1 subsitio para poder presionar este bot&oacute;n.</p>";
        $( "#dialogWindow" ).html(_html);
        $( "#dialogWindow" ).dialog({
            title   : 'Nota',
            modal   : true,
            buttons : {
                "Ok": function() {
                    $(this).dialog("close");
                }
            },
            minWidth: 600,
            resizable: false
        });
    }else{
        $.ajax({
            type: "POST",
            url: "administracion/cambiar_estado_subsitio.php",
            cache: false,
            data: {
                listaIdsSubsitio     :    listaIdsSubsitio
            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexi&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp){
                if (_resp.refresh_error){
                    $( "#dialogWindow" ).html(_resp.refresh_error);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error al tratar de guardar',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                                $('#PageTitle').trigger('click');
                                abrirSeccionAdmin(5,3);
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else{
                    $( "#dialogWindow" ).html('<p>Los cambios en el estado subsitio fue realizado con &eacute;xito.</p>');
                    $( "#dialogWindow" ).dialog({
                        title   : 'Transaci&oacute;n Exitosa!',
                        modal   : true,
                        buttons : {
                            "Perfecto": function() {
                                $(this).dialog("close");
                                $('#PageTitle').trigger('click');
                                abrirSeccionAdmin(5,3);
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }
            }
        });		
    }
}
function guardarModificacionSubsitio(){
    var _tituloSubsitio		= $('#TituloSubsitio_mod').val();
    var _descripcionSubsitio	= $('#DescripcionSubsitio_mod').val();
    var _abreviaturaSubsitio    = $('#AbreviaturaSubsitio_mod').val();
    var _urlSubsitio            = $('#UrlSubsitio_mod').val();
    var _idSubsitio             = $('#SubsitioId_mod').val();
    var errores = 0;
    if(errores === 0){
        $.ajax({
            type: "POST",
            url: "administracion/guardar_modificacion_subsitio.php",
            cache: false,
            dataType : 'json',
            data: {
                id        :_idSubsitio,
                titulo    :_tituloSubsitio,
                descripcion :_descripcionSubsitio,
                abreviatura :_abreviaturaSubsitio,
                url         :_urlSubsitio
                    

            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp){
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input').removeClass('campo_error');
                    $('#errores_generales_modificarSubsitio, #exito_generales_modificarSubsitio').remove();
                    $('#tabsSubsitio-2 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_modificarSubsitio', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_modificarSubsitio').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');
                    }
                }else{
                    $( "#dialogWindow" ).html('<p>Los datos de subsitio fueron actualizados correctamente.</p>');
                    $( "#dialogWindow" ).dialog({
                        title   : "Actualizaci&oacute;n exitosa!",
                        modal   : true,
                        position        : '50px',
                        buttons : {
                            "Ok": function() {
                                $("#PageTitle").trigger("click");
                                abrirSeccionAdmin(5,2);
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }
            }
        });
    }else{
    ///agregar el mensaje general aqui
    }
}
function guardarAdminIndicadores() {
    var _tituloIndicadores = $.trim($('#TituloIndicador').val());
    var _url_archivo_indicador = $.trim($('#UrlArchivoIndicador').val());
    var _descripcionIndicador = $.trim($('#DescripcionIndicador').val());
    var _interpretacionIndicador = $.trim($('#InterpretacionIndicador').val());
    var _tipoDeEducacion = $.trim($('#TipoDeEducacionIndicador').val());
    var _tipoDeMatricula = $.trim($('#TipoDeMatriculaIndicador').val());
    var _observacionesGraficos = $.trim($('#ObservacionGraficos').val());
    var _observacionesGenerales = $.trim($('#ObservacionGenerales').val());
    var _privado = $('input[name=Privado]:checked').val();
    var _CodigoMathml  = $('#CodigoMathml').val()
    var listaVariables = new Array();
    $.each( $('#CampoDeVariables textarea[name="variables"]'), function(key, val){
        var value = $.trim($(this).val());
        if( value !== ''){
            listaVariables.push(value);
        }
    });
    var listaVariablesDescripcion = new Array();
    $.each( $('#CampoDeVariables input[name="variablesDescripcion"]'), function(key, val){
        var value = $.trim($(this).val());
        if( value !== ''){
            listaVariablesDescripcion.push(value);
        }
    });
    var listaIdsSeriesDeIndicadores = new Array();
    var index = 0;
    $.each( $('#SerieIndicadores [name="serieIndicadoresId"]:checked'), function(key, val){
        listaIdsSeriesDeIndicadores[index] = $(val).val();
        index++;
    });  
    var listaIdsNiveles = new Array();
    index = 0;
    $.each( $('#NivelesIndicador [name="NivelesId"]:checked'), function(key, val){
        listaIdsNiveles[index] = $(val).val();
        index++;
    }); 
    var listaIdsDesagregaciones = new Array();
    index = 0;  
    $.each( $('#GrupoDesagregaciones [name="tipoDesagregacionId"]:checked'), function(key, val){
        listaIdsDesagregaciones[index] = $(val).val();
        index++;
    });
    var listaIdsFuentesDatos = new Array();
    index = 0;
    $.each($('#FuentesDatos [name="fuenteDatoId"]:checked'), function(key, val){
        listaIdsFuentesDatos[index] = $(val).val();
        index++;
    });
    var listaAlias = new Array();
    index = 0;
    $.each($('input[name|="alias"][type="text"]'), function(key, val){
        listaAlias[index] = $(val).val();
        index++;
    });
    var errores = 0;
    if(errores === 0){
        $.ajax({
            type: "POST",
            url: "administracion/guardar_indicadores.php",
            cache: false,
            dataType : 'json',
            data: {
                titulo                   :_tituloIndicadores,
                url_archivo_indicador     :_url_archivo_indicador,
                descripcion              :_descripcionIndicador,
                interpretacion           :_interpretacionIndicador,
                tipo_educacion_id        :_tipoDeEducacion,
                tipo_matricula_id        :_tipoDeMatricula,
                SeriesIndicadoresIds     :listaIdsSeriesDeIndicadores,
                NivelesIds               :listaIdsNiveles,
                DesagregacionIds         :listaIdsDesagregaciones,
                fuentesDatosIds            :listaIdsFuentesDatos,
                observaciones_graficas   :_observacionesGraficos,
                observaciones_generales  :_observacionesGenerales,
                listaDeVariables        :listaVariables,
                listaDeVariablesDescripcion        :listaVariablesDescripcion,
                listaAlias                : listaAlias,
                privado                 :_privado,
                CodigoMathml            :_CodigoMathml
              
            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp){
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input').removeClass('campo_error');
                    $('#errores_generales_nuevoIndicadores, #exito_generales_nuevoIndicadores').remove();
                    $('#tabsIndicadores-1 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_nuevoIndicadores', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_nuevoIndicadores').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');
                    }
                }else{
                    $('a[name="QuitarFormula"],a[name="QuitarAlias"]').trigger('click');
                    $('ul[id^="errors"]').html('');
                    $('input:text, textarea').attr('value','').removeClass('campo_error');
                    $('input:checkbox').removeAttr('checked');
                    $('input:radio[value="0"]').attr('checked','checked');
                    $('input:radio[value="1"]').removeAttr('checked');
                    $('option[value="0"]').attr('selected','selected');
                    $('#errores_generales_nuevoIndicadores, #exito_generales_nuevoIndicadores').remove();
                    $('#tabsIndicadores-1 #CamposFormulario').prepend(CajaExitoErrores(1, 'exito_generales_nuevoIndicadores', 'El Indicador se guardo exitosamente.'));
                    $('#exito_generales_nuevoIndicadores').fadeIn('fast');
                    $('a[href="#tabsIndicadores-5"]').attr('onclick','abrirSeccionAdmin(2,5)');       
                }
            }
        });
    }
}
function cargarPanelModificacionIndicadores(id_Indicadores){
    var flag = false;
    try{
        parseInt(id_Indicadores);
        flag = true;
    }
    catch (error){
        flag = false;
    }
    if(flag){
        $.ajax({
            type: "GET",
            url: "administracion/modificar_Indicadores.php",
            data: {
                id    :   id_Indicadores
            },
            error: function(){
                _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(msg){
                $("#PanelModificacionDeIndicadores").remove();
                $('#tabsIndicadores-3').append(msg);
                $('#PanelModificacionDeIndicadores').fadeIn('fast');
                $('html, body').animate({
                    scrollTop:940
                }, 'slow');
            }
        });
    }
}
function guardarModificacionIndicadores(){
    var _tituloIndicadores = $.trim($('#TituloIndicador_mod').val());
    var _descripcionIndicador = $.trim($('#DescripcionIndicador_mod').val());
    var _interpretacionIndicador = $.trim($('#InterpretacionIndicador_mod').val());
    var _tipoDeEducacion = $.trim($('#TipoDeEducacionIndicador_mod').val());
    var _tipoDeMatricula = $.trim($('#TipoDeMatriculaIndicador_mod').val());
    var _observacionesGraficos = $.trim($('#ObservacionGraficos_mod').val());
    var _observacionesGenerales = $.trim($('#ObservacionGenerales_mod').val());
    var _privado = $('input[name=Privado_mod]:checked').val();
    var _CodigoMathml  = $('#CodigoMathml_mod').val()
    var listaVariables = new Array();
    $.each( $('#CampoDeVariables_mod textarea[name="variables_mod"]'), function(key, val){
        var value = $.trim($(this).val());
        if( value !== ''){
            listaVariables.push(value);
        }
    });
    var listaVariablesDescripcion = new Array();
    $.each( $('#CampoDeVariables_mod input[name="variablesDescripcion_mod"]'), function(key, val){
        var value = $.trim($(this).val());
        if( value !== ''){
            listaVariablesDescripcion.push(value);
        }
    });
    var _idIndicador = $.trim($('#IndicadoresId_mod').val());
    var listaIdsSeriesDeIndicadores = new Array();
    var index = 0;
    $.each( $('#SerieIndicadores_mod [name="serieIndicadoresId_mod"]:checked'), function(key, val){
        listaIdsSeriesDeIndicadores[index] = $(val).val();
        index++;
    });
    var listaIdsNiveles = new Array();
    index = 0;
    $.each( $('#NivelesIndicador_mod [name="NivelesId_mod"]:checked'), function(key, val){
        listaIdsNiveles[index] = $(val).val();
        index++;
    });
    var listaIdsDesagregaciones = new Array();
    index = 0;
    $.each( $('#GrupoDesagregaciones_mod [name="tipoDesagregacionId_mod"]:checked'), function(key, val){
        listaIdsDesagregaciones[index] = $(val).val();
        index++;
    });
    var listaIdsFuentesDatos = new Array();
    index = 0;
    $.each($('#FuentesDatos_mod [name="fuenteDatoId_mod"]:checked'), function(key, val){
        listaIdsFuentesDatos[index] = $(val).val();
        index++;
    });
    var listaAlias = new Array();
    index = 0;
    $.each($('input[name|="alias_mod"][type="text"]'), function(key, val){
        listaAlias[index] = $(val).val();
        index++;
    });   
    var errores = 0;
    if(errores === 0){
        $.ajax({
            type: "POST",
            url: "administracion/guardar_modificacion_indicadores.php",
            cache: false,
            dataType : 'json',
            data: {
                titulo                   :_tituloIndicadores,
                descripcion              :_descripcionIndicador,
                interpretacion           :_interpretacionIndicador,
                tipo_educacion_id        :_tipoDeEducacion,
                tipo_matricula_id        :_tipoDeMatricula,
                SeriesIndicadoresIds     :listaIdsSeriesDeIndicadores,
                NivelesIds               :listaIdsNiveles,
                DesagregacionIds         :listaIdsDesagregaciones,
                fuentesDatosIds            :listaIdsFuentesDatos,
                observaciones_graficas   :_observacionesGraficos,
                observaciones_generales  :_observacionesGenerales,
                id                       :_idIndicador,
                listaDeVariables            :listaVariables,
                listaDeVariablesDescripcion :listaVariablesDescripcion,
                listaAlias                : listaAlias,
                privado                 :_privado,
                CodigoMathml            :_CodigoMathml

            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp){
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input').removeClass('campo_error');
                    $('#errores_generales_modificarNivelEducativo, #exito_generales_modificarNivelEducativo').remove();
                    $('#tabsNivelEducativo-2 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_modificarNivelEducativo', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_modificarNivelEducativo').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');
                    }
                }else{
                    $( "#dialogWindow" ).html('<p>Los datos del indicador fueron actualizados correctamente.</p>');
                    $( "#dialogWindow" ).dialog({
                        title   : "Actualizaci&oacute;n exitosa!",
                        modal   : true,
                        position        : '50px',
                        buttons : {
                            "Ok": function() {
                                abrirSeccionAdmin(2,3);
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }
            }
        });
    }else{
    ///agregar el mensaje general aqui
    }
}
function guardarIndicadoresActivarDesactivar(){
    var listaIdsIndicadores = new Array();
    var index = 0;
    $.each( $('#listadoActDesactIndicadores [name="estatusIndicadores"]:checked'), function(key, val){
        listaIdsIndicadores[index] = $(val).val();
        index++;
    });
    $.ajax({
        type: "POST",
        url: "administracion/cambiar_estado_indicadores.php",
        cache: false,
        data: {
            listaIdsIndicador    :    listaIdsIndicadores
        },
        error: function(){
            _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexi&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
            $( "#dialogWindow" ).html(_html);
            $( "#dialogWindow" ).dialog({
                title   : 'Ups! error',
                modal   : true,
                buttons : {
                    "Ok": function() {
                        $(this).dialog("close");
                    }
                },
                minWidth: 600,
                resizable: false
            });
        },
        success: function(_resp){
            if (_resp.refresh_error){
                $( "#dialogWindow" ).html(_resp.refresh_error);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error al tratar de guardar',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                            abrirSeccionAdmin(2,5);
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            }else{
                $( "#dialogWindow" ).html('<p>Los cambios en el estado de los indicadores fueron realizados con &eacute;xito.</p>');
                $( "#dialogWindow" ).dialog({
                    title   : 'Transacci&oacute;n Exitosa!',
                    modal   : true,
                    buttons : {
                        "Perfecto": function() {
                            $(this).dialog("close");
                            abrirSeccionAdmin(2,5);
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            }
        }
    });
}
function guardarIndicadoresPublicarNoPublicar(){
    var listaIdsIndicadoresPublicar = new Array();
    var index = 0;
    $.each( $('#listadoPublicarNoPublicarIndicadores [name="estatusIndicadoresPublicacion"]:checked'), function(key, val){
        listaIdsIndicadoresPublicar[index] = $(val).val();
        index++;
    });
    $.ajax({
        type: "POST",
        url: "administracion/cambiar_estado_indicadores_publicados.php",
        cache: false,
        data: {
            listaIdsIndicador    :    listaIdsIndicadoresPublicar
        },
        error: function(){
            _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexi&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
            $( "#dialogWindow" ).html(_html);
            $( "#dialogWindow" ).dialog({
                title   : 'Ups! error',
                modal   : true,
                buttons : {
                    "Ok": function() {
                        $(this).dialog("close");
                    }
                },
                minWidth: 600,
                resizable: false
            });
        },
        success: function(_resp){
            if (_resp.refresh_error){
                $( "#dialogWindow" ).html(_resp.refresh_error);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error al tratar de guardar',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                            $('#PageTitle').trigger('click');
                            abrirSeccionAdmin(2,2);
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            }else{
                $( "#dialogWindow" ).html('<p>Los cambios del estado de publicaci&oacute;n del indicador fueron realizados con &eacute;xito.</p>');
                $( "#dialogWindow" ).dialog({
                    title   : 'Transacci&oacute;n Exitosa!',
                    modal   : true,
                    buttons : {
                        "Perfecto": function() {
                            $(this).dialog("close");
                            abrirSeccionAdmin(2,2);
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            }
        }
    });
}
function filtroDeIndicadoresMod(estado_indicadores){
    $('#listadoActDesactIndicadores li').css('display', 'none');
    if ( (estado_indicadores == '0') || (estado_indicadores == '1') ){
        $('#listadoActDesactIndicadores [esta_activa="'+ estado_indicadores +'"]').fadeIn('fast');
    }
    else{
        $('#listadoActDesactIndicadores li').fadeIn('fast');
    }
}
function filtroDeIndicadoresModPublicar(estado_indicador){
    $('#listadoPublicarNoPublicarIndicadores li').css('display', 'none');
    if ( (estado_indicador == '0') || (estado_indicador == '1') ){
        $('#listadoPublicarNoPublicarIndicadores [esta_publicada="'+ estado_indicador +'"]').fadeIn('fast');
    }
    else{
        $('#listadoPublicarNoPublicarIndicadores li').fadeIn('fast');
    }
}
function filtroDeIndicadores(str){
    $('#listadoModificarIndicador li').css('display', 'none');
    str = $.trim(str);
    if (str == ""){
        $('#listadoModificarIndicador li').fadeIn('fast');
    }
    else{
        $('#listadoModificarIndicador [titulo_Indicadores*="'+ str +'"]').fadeIn('fast');
    }
}
function cargarPanelModificacionIndicadoresRelaciones(id_Indicadores){
    var flag = false;
    try{
        parseInt(id_Indicadores);
        flag = true;
    }
    catch (error){
        flag = false;
    }
    if(flag){
        $.ajax({
            type: "GET",
            url: "administracion/modificar_indicadores_relacion.php",
            data: {
                id    :   id_Indicadores
            },
            error: function(){
                _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(msg){
                $("#PanelModificacionDeIndicadores").remove();
                $('#tabsIndicadores-4').append(msg);
                $('#PanelModificacionDeIndicadores').fadeIn('fast');
                
                $('html, body').animate({
                    scrollTop:940
                }, 'slow');
            }
        });
    }
}
function guardarModificacionIndicadoresRelacion(){
    var _idIndicador = $.trim($('#IndicadoresId_mod_rel').val());
    var _listaDeIndicador = $.trim($('#IndicadorGrupoIndicador_mod').val());
    var errores = 0;
    if(errores === 0){
        $.ajax({
            type: "POST",
            url: "administracion/guardar_modificacion_indicadores_relacion.php",
            cache: false,
            dataType : 'json',
            data: {
                id         :_idIndicador,
                listaIds  :_listaDeIndicador
                  
                    

            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp){
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input').removeClass('campo_error');
                    $('#errores_generales_modificarGrupoIndicadores, #exito_generales_modificarGrupoIndicadores').remove();
                    $('#tabsGrupoIndicadores-2 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_modificarGrupoIndicadores', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_modificarGrupoIndicadores').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');
                    }
                }else{
                    $( "#dialogWindow" ).html('<p>Las relaciones entre indicadores fueron actualizadas correctamente.</p>');
                    $( "#dialogWindow" ).dialog({
                        title   : "Actualizaci&oacute;n exitosa!",
                        modal   : true,
                        position        : '50px',
                        buttons : {
                            "Ok": function() {
                                abrirSeccionAdmin(2,4);
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }
            }
        });

    }else{
    ///agregar el mensaje general aqui
    }
}
function guardarAdminGrupoIndicadores() {
    var _etiquetaTituloGrupoIndicadores = $.trim($('#EtiquetaTituloGrupoIndicadores').val());
    var _tituloGrupoIndicadores = $.trim($('#TituloGrupoIndicadores').val());
    var _descripcionGrupoIndicadores = $.trim($('#DescripcionGrupoIndicadores').val());
    var _subsitioGrupoIndicadores = $.trim($('#SubsitioGrupoIndicadores').val());
    var _listaDeIndicadores = $.trim($('#IndicadorGrupoIndicador').val());
    var errores = 0;
    var listaIdsGrupo = new Array();
    $.each( $('li[name|="idsGrupoIndicadores"]'), function(key, val){
        listaIdsGrupo.push($(this).val());
    });
    if(errores === 0){
        $.ajax({
            type: "POST",
            url: "administracion/guardar_grupo_indicadores.php",
            cache: false,
            dataType : 'json',
            data: {
                etiqueta_titulo         :_etiquetaTituloGrupoIndicadores,
                titulo_completo         :_tituloGrupoIndicadores,
                descripcion             :_descripcionGrupoIndicadores,
                subsitio_id             :_subsitioGrupoIndicadores,
                listaIdsIndicadores     :_listaDeIndicadores,
                listaIdsGrupos          :listaIdsGrupo

            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp){
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input').removeClass('campo_error');
                    $('#errores_generales_nuevoGrupoIndicadores, #exito_generales_nuevoGrupoIndicadores').remove();
                    $('#tabsGrupoIndicadores-1 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_nuevoGrupoIndicadores', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_nuevoGrupoIndicadores').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');
                    }
                }else{
                    $('ul[id^="errors"]').html('');
                    $( "#ListaDeGrupoSortable" ).html('');
                    $('#CamposFormulario input, textarea').attr('value','').removeClass('campo_error');
                    $('#errores_generales_nuevoGrupoIndicadores, #exito_generales_nuevoGrupoIndicadores').remove();
                    $('#tabsGrupoIndicadores-1 #CamposFormulario').prepend(CajaExitoErrores(1, 'exito_generales_nuevoGrupoIndicadores', 'El GrupoIndicadores se guardo exitosamente.'));
                    $('#exito_generales_nuevoGrupoIndicadores').fadeIn('fast');
                    $('a[href="#tabsGrupoIndicadores-3"]').attr('onclick','abrirSeccionAdmin(3,3)');
                                
                }
            }
        });

    }
}
function cargarPanelModificacionGrupoIndicadores(id_GrupoIndicadores){
    var flag = false;
    try{
        parseInt(id_GrupoIndicadores);
        flag = true;
    }
    catch (error){
        flag = false;
    }
    if(flag){
        $.ajax({
            type: "GET",
            url: "administracion/modificar_grupo_indicadores.php",
            data: {
                id    :   id_GrupoIndicadores
            },
            error: function(){
                _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(msg){
                $("#PanelModificacionDeGrupoIndicadores").remove();
                $('#tabsGrupoIndicadores-2').append(msg);
                $('#PanelModificacionDeGrupoIndicadores').fadeIn('fast');
                $('html, body').animate({
                    scrollTop:940
                }, 'slow');

            }
        });
    }
}
function filtroDeGrupoIndicadores(str){
    $('#listadoModificarGrupoIndicadores li').css('display', 'none');
    str = $.trim(str);
    if (str == ""){
        $('#listadoModificarGrupoIndicadores li').fadeIn('fast');
    }
    else{
        $('#listadoModificarGrupoIndicadores [titulo_GrupoIndicadores*="'+ str +'"]').fadeIn('fast');
    }
}
function filtroDeGrupoIndicadoresMod(estado_GrupoIndicadores){
    $('#listadoActDesactGrupoIndicadores li').css('display', 'none');
    if ( (estado_GrupoIndicadores == '0') || (estado_GrupoIndicadores == '1') ){
        $('#listadoActDesactGrupoIndicadores [esta_activa="'+ estado_GrupoIndicadores +'"]').fadeIn('fast');
    }
    else{
        $('#listadoActDesactGrupoIndicadores li').fadeIn('fast');
    }
}
function guardarGrupoIndicadoresActivarDesactivar(){
    var listaIdsGrupoIndicadores = new Array();
    var index = 0;
    $.each( $('#listadoActDesactGrupoIndicadores [name="estatusGrupoIndicadores"]:checked'), function(key, val){
        listaIdsGrupoIndicadores[index] = $(val).val();
        index++;
    });
    $.ajax({
        type: "POST",
        url: "administracion/cambiar_estado_grupo_indicadores.php",
        cache: false,
        data: {
            listaIdsGruposIndicadores     :    listaIdsGrupoIndicadores
        },
        error: function(){
            _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexi&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
            $( "#dialogWindow" ).html(_html);
            $( "#dialogWindow" ).dialog({
                title   : 'Ups! error',
                modal   : true,
                buttons : {
                    "Ok": function() {
                        $(this).dialog("close");
                    }
                },
                minWidth: 600,
                resizable: false
            });
        },
        success: function(_resp){
            if (_resp.refresh_error){
                $( "#dialogWindow" ).html(_resp.refresh_error);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error al tratar de guardar',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                            $('#PageTitle').trigger('click');
                            abrirSeccionAdmin(5,3);
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            }else{
                $( "#dialogWindow" ).html('<p>Los cambios en el estado de Grupo de Indicadores fue realizado con &eacute;xito.</p>');
                $( "#dialogWindow" ).dialog({
                    title   : 'Transacci&oacute;n Exitosa!',
                    modal   : true,
                    buttons : {
                        "Perfecto": function() {
                            $(this).dialog("close");
                            $('#PageTitle').trigger('click');
                            abrirSeccionAdmin(3,3);
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            }
        }
    });
}
function guardarModificacionGrupoIndicadores(){

    var _etiquetaTituloGrupoIndicadores = $.trim($('#EtiquetaTituloGrupoIndicadores_mod').val());
    var _tituloGrupoIndicadores = $.trim($('#TituloGrupoIndicadores_mod').val());
    var _descripcionGrupoIndicadores = $.trim($('#DescripcionGrupoIndicadores_mod').val());
    var _subsitioGrupoIndicadores = $.trim($('#SubsitioGrupoIndicadores_mod').val());
    var _listaDeIndicadores = $.trim($('#IndicadorGrupoIndicador_mod').val());
    var _idGrupoIndicadores = $.trim($('#GrupoIndicadoresId_mod').val());
    
    var listaIdsGrupo = new Array();
    $.each( $('li[name|="idsGrupoIndicadores_mod"]'), function(key, val){
        listaIdsGrupo.push($(this).val());
    })
    var errores = 0;
    if(errores === 0){
        $.ajax({
            type: "POST",
            url: "administracion/guardar_modificacion_grupo_indicadores.php",
            cache: false,
            dataType : 'json',
            data: {
                etiqueta_titulo         :_etiquetaTituloGrupoIndicadores,
                titulo_completo         :_tituloGrupoIndicadores,
                descripcion             :_descripcionGrupoIndicadores,
                subsitio_id             :_subsitioGrupoIndicadores,
                listaIdsIndicadores     :_listaDeIndicadores,
                id                      :_idGrupoIndicadores,
                listaIdsGrupos          :listaIdsGrupo
                    

            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp){
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input').removeClass('campo_error');
                    $('#errores_generales_modificarGrupoIndicadores, #exito_generales_modificarGrupoIndicadores').remove();
                    $('#tabsGrupoIndicadores-2 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_modificarGrupoIndicadores', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_modificarGrupoIndicadores').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');
                    }
                }else{
                    $( "#dialogWindow" ).html('<p>Los datos de Grupo Indicadores fueron actualizados correctamente.</p>');
                    $( "#dialogWindow" ).dialog({
                        title   : "Actualizaci&oacute;n exitosa!",
                        modal   : true,
                        position        : '50px',
                        buttons : {
                            "Ok": function() {
                                $("#PageTitle").trigger("click");
                                abrirSeccionAdmin(3,2);
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }
            }
        });
    }else{
    ///agregar el mensaje general aqui
    }
}
function cargarPanelModificacionArchivo(id){
    $('#PanelModificacionDeArchivo').attr('src', 'administracion/modificar_archivo.php?id=' + id);
    $('#PanelModificacionDeArchivo').animate({
        'height':'450'
    },'fast');
    $('html, body').animate({
        scrollTop:940
    }, 'slow');
}
function cerrarPanelModificacionArchivo(){
}
function filtroDeArchivoMod(str){
    $('#listadoModificarArchivo li').css('display', 'none');
    str = $.trim(str);
    if (str == ""){
        $('#listadoModificarArchivo li').fadeIn('fast');
    }
    else{
        $('#listadoModificarArchivo [titulo_archivo*="'+ str +'"]').fadeIn('fast');
    }
}
function filtroDeArchivoActivarDesactivar(estado_archivo){
    $('#listadoActDesactArchivo li').css('display', 'none');
    if ( (estado_archivo == '0') || (estado_archivo == '1') ){
        $('#listadoActDesactArchivo [esta_activa="'+ estado_archivo +'"]').fadeIn('fast');
    }
    else{
        $('#listadoActDesactArchivo li').fadeIn('fast');
    }
}
function guardarArchivoActivarDesactivar(){
    var listaIdsArchivos = new Array();
    var index = 0;
    $.each( $('#listadoActDesactArchivo [name="estatusArchivo"]:checked'), function(key, val){
        listaIdsArchivos[index] = $(val).val();
        index++;
    });
    $.ajax({
        type: "POST",
        url: "administracion/cambiar_estado_archivo.php",
        cache: false,
        data: {
            listaIdsArchivos      :    listaIdsArchivos
        },
        error: function(){
            _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexi&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
            $( "#dialogWindow" ).html(_html);
            $( "#dialogWindow" ).dialog({
                title   : 'Ups! error',
                modal   : true,
                buttons : {
                    "Ok": function() {
                        $(this).dialog("close");
                    }
                },
                minWidth: 600,
                resizable: false
            });
        },
        success: function(_resp){
            if (_resp.refresh_error){
                $( "#dialogWindow" ).html(_resp.refresh_error);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error al tratar de guardar',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                            $('#PageTitle').trigger('click');
                            abrirSeccionAdmin(13,3);
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            }else{
                $( "#dialogWindow" ).html('<p>Los cambios en el estado de el/los Archivos fue realizado con &eacute;xito.</p>');
                $( "#dialogWindow" ).dialog({
                    title   : 'Transacci&oacute;n Exitosa!',
                    modal   : true,
                    buttons : {
                        "Perfecto": function() {
                            $(this).dialog("close");
                            $('#PageTitle').trigger('click');
                            abrirSeccionAdmin(13,3);
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            }
        }
    });
}
function guardarAdminFuenteDato() {
    var _tituloFuenteDato = $.trim($('#TituloFuenteDato').val()); 
    var _descripcionFuenteDato = $.trim($('#DescripcionFuenteDato').val()); 
    var errores = 0;
    if(errores === 0){
        $.ajax({
            type: "POST",
            url: "administracion/guardar_fuente_dato.php",
            cache: false,
            dataType : 'json',
            data: {
                titulo		:_tituloFuenteDato,
                descripcion	:_descripcionFuenteDato    
            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp){
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input').removeClass('campo_error');
                    $('#errores_generales_nuevaFuenteDato, #exito_generales_nuevaFuenteDato').remove();
                    $('#tabsFuenteDato-1 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_nuevaFuenteDato', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_nuevaFuenteDato').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');					
                    }
                }else{
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input, textarea').attr('value','').removeClass('campo_error');
                    $('#errores_generales_nuevaFuenteDato, #exito_generales_nuevaFuenteDato').remove();
                    $('#tabsFuenteDato-1 #CamposFormulario').prepend(CajaExitoErrores(1, 'exito_generales_nuevaFuenteDato', 'La fuente de datos se guardo exitosamente.'));
                    $('#exito_generales_nuevaFuenteDato').fadeIn('fast');
                    $('a[href="#tabsFuenteDato-3"]').attr('onclick','abrirSeccionAdmin(14,3)');
                }
            }
        });
    }
}
function filtroDeFuenteDato(str){
    $('#listadoModificarFuenteDato li').css('display', 'none');
    str = $.trim(str);	
    if (str == ""){
        $('#listadoModificarFuenteDato li').fadeIn('fast');
    }
    else{
        $('#listadoModificarFuenteDato [titulo_fuente*="'+ str +'"]').fadeIn('fast');
    }
}
function filtroDeFuenteDatoMod(estado){
    $('#listadoActDesactFuenteDato li').css('display', 'none');
    if ( (estado == '0') || (estado == '1') ){
        $('#listadoActDesactFuenteDato [esta_activa="'+ estado +'"]').fadeIn('fast');
    }else{
        $('#listadoActDesactFuenteDato li').fadeIn('fast');
    }
}
function cargarPanelModificacionFuenteDato(id){
    var flag = false;
    try{
        parseInt(id);
        flag = true;
    }
    catch (error){
        flag = false;
    }
    if(flag){
        $.ajax({
            type: "GET",
            url: "administracion/modificar_fuente_dato.php",
            data: {
                id    :   id
            },
            error: function(){
                _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(msg){
                $("#PanelModificacionDeFuenteDato").remove();
                $('#tabsFuenteDato-2').append(msg);
                $('#PanelModificacionDeFuenteDato').fadeIn('fast');                
                $('html, body').animate({
                    scrollTop:940
                }, 'slow');
            }
        });
    }    
}
function guardarModificacionFuenteDato(){
    var _titulo = $.trim($('#TituloFuenteDato_mod').val()); 
    var _descripcion = $.trim($('#DescripcionFuenteDato_mod').val()); 
    var _id = $.trim($('#FuenteDatoId_mod').val());
    var errores = 0;
    if(errores === 0){
        //hacer ajax
        $.ajax({
            type: "POST",
            url: "administracion/guardar_modificacion_fuente_dato.php",
            cache: false,
            dataType : 'json',
            data: {
                id			:_id,
                titulo      :_titulo,
                descripcion :_descripcion
            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp){
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input, textarea').removeClass('campo_error');
                    $('#errores_generales_modificarFuenteDato, #exito_generales_modificarFuenteDato').remove();
                    $('#tabsFuenteDato-2 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_modificarFuenteDato', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_modificarFuenteDato').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');					
                    }
                }else{
                    $( "#dialogWindow" ).html('<p>Los datos de la fuente de datos fueron actualizados correctamente.</p>');
                    $( "#dialogWindow" ).dialog({
                        title   : "Actualizaci&oacute;n exitosa!",
                        modal   : true,
                        position		: '50px',
                        buttons : {
                            "Ok": function() { 
                                $("#PageTitle").trigger("click");
                                abrirSeccionAdmin(14,2);
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });				
                }
            }
        });
    
    }else{
    ///agregar el mensaje general aqui
    }
}
function guardarFuenteDatoActivarDesactivar(){
    var listaIdsFuentesDatos = new Array();
    var index = 0;
    $.each( $('#listadoActDesactFuenteDato [name="estatusFuenteDato"]:checked'), function(key, val){
        listaIdsFuentesDatos[index] = $(val).val();
        index++;
    });
    if(index === 0){
        $( "#dialogWindow" ).html('<p>Debe seleccionar a lo menos una(1) fuente de datos para poder realizar esta acci&oacute;n.</p>');
        $( "#dialogWindow" ).dialog({
            title   : 'Nota',
            modal   : true,
            buttons : {
                "Ok": function() {
                    $(this).dialog("close");
                }
            },
            minWidth: 600,
            resizable: false
        });
    }else{
        $.ajax({
            type: "POST",
            url: "administracion/cambiar_estado_fuente_dato.php",
            cache: false,
            data: {
                listaIdsFuentesDatos     :    listaIdsFuentesDatos
            },
            error: function(){
                _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexi&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp){
                if (_resp.refresh_error){
                    $( "#dialogWindow" ).html(_resp.refresh_error);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error al tratar de guardar',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                                $('#PageTitle').trigger('click');
                                abrirSeccionAdmin(11,3);
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else{
                    $( "#dialogWindow" ).html('<p>Los cambios en el estado de la/las fuentes de datos fue realizado con &eacute;xito.</p>');
                    $( "#dialogWindow" ).dialog({
                        title   : 'Transaci&oacute;n Exitosa!',
                        modal   : true,
                        buttons : {
                            "Perfecto": function() {
                                $(this).dialog("close");
                                $('#PageTitle').trigger('click');
                                abrirSeccionAdmin(14,3);
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }
            }
        });
    }	
}
function guardarAdminGlosario(){
    var _tituloGlosario = $.trim($('#TituloGlosario').val());
    var _descripcionGlosario = $.trim($('#DescripcionGlosario').val());
    var _abreviaturaGlosario = $.trim($('#AbreviaturaGlosario').val());
    var _urlGlosario = $.trim($('#UrlGlosario').val());
    var errores = 0;
    var listaReferencia = new Array();
    $.each( $('textarea[name|="variables"]'), function(key, val){
        this.listaVariables.push($(this).val());
    });
    if(errores === 0){
        $.ajax({
            type: "POST",
            url: "administracion/guardar_glosario.php",
            cache: false,
            dataType : 'json',
            data: {
                titulo          :_tituloGlosario,
                descripcion      :_descripcionGlosario,
                abreviatura     :_abreviaturaGlosario,
                url             :_urlGlosario

            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp){
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input').removeClass('campo_error');
                    $('#errores_generales_nuevoGlosario, #exito_generales_nuevoGlosario').remove();
                    $('#tabsGlosario-1 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_nuevoGlosario', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_nuevoGlosario').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');
                    }
                }else{
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input, textarea').attr('value','').removeClass('campo_error');
                    $('#errores_generales_nuevoGlosario, #exito_generales_nuevoGlosario').remove();
                    $('#tabsGlosario-1 #CamposFormulario').prepend(CajaExitoErrores(1, 'exito_generales_nuevoGlosario', 'El Glosario se guardo exitosamente.'));
                    $('#exito_generales_nuevoGlosario').fadeIn('fast');
                    $('a[href="#tabsGlosario-3"]').attr('onclick','abrirSeccionAdmin(15,3)');             
                }
            }
        });
    }
}
function cargarPanelModificacionGlosario(id_Glosario){
    var flag = false;
    try{
        parseInt(id_Glosario);
        flag = true;
    }
    catch (error){
        flag = false;
    }
    if(flag){
        $.ajax({
            type: "GET",
            url: "administracion/modificar_glosario.php",
            data: {
                id    :   id_Glosario
            },
            error: function(){
                _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(msg){
                $("#PanelModificacionDeGlosario").remove();
                $('#tabsGlosario-2').append(msg);
                $('#PanelModificacionDeGlosario').fadeIn('fast');
                $('html, body').animate({
                    scrollTop:940
                }, 'slow');
            }
        });
    }
}
function filtroDeGlosario(str){
    $('#listadoModificarGlosario li').css('display', 'none');
    str = $.trim(str);
    if (str == ""){
        $('#listadoModificarGlosario li').fadeIn('fast');
    }
    else{
        $('#listadoModificarGlosario [titulo_Glosario*="'+ str +'"]').fadeIn('fast');
    }
}
function filtroDeGlosarioMod(estado_Glosario){
    $('#listadoActDesactGlosario li').css('display', 'none');

    if ( (estado_Glosario == '0') || (estado_Glosario == '1') ){
        $('#listadoActDesactGlosario [esta_activa="'+ estado_Glosario +'"]').fadeIn('fast');
    }
    else{
        $('#listadoActDesactGlosario li').fadeIn('fast');
    }
}
function guardarGlosarioActivarDesactivar(){
    var listaIdsGlosario = new Array();
    var index = 0;
    $.each( $('#listadoActDesactGlosario [name="estatusGlosario"]:checked'), function(key, val){
        listaIdsGlosario[index] = $(val).val();
        index++;
    });
    if(index === 0){
        var _html = "<p>Debes seleccionar a lo menos 1 Glosario para poder presionar este bot&oacute;n.</p>";
        $( "#dialogWindow" ).html(_html);
        $( "#dialogWindow" ).dialog({
            title   : 'Nota',
            modal   : true,
            buttons : {
                "Ok": function() {
                    $(this).dialog("close");
                }
            },
            minWidth: 600,
            resizable: false
        });
    }else{
        $.ajax({
            type: "POST",
            url: "administracion/cambiar_estado_glosario.php",
            cache: false,
            data: {
                listaIdsGlosario     :    listaIdsGlosario
            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexi&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp){
                if (_resp.refresh_error){
                    $( "#dialogWindow" ).html(_resp.refresh_error);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error al tratar de guardar',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                                $('#PageTitle').trigger('click');
                                abrirSeccionAdmin(15,3);
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else{
                    $( "#dialogWindow" ).html('<p>Los cambios en el estado Glosario fue realizado con &eacute;xito.</p>');
                    $( "#dialogWindow" ).dialog({
                        title   : 'Transaci&oacute;n Exitosa!',
                        modal   : true,
                        buttons : {
                            "Perfecto": function() {
                                $(this).dialog("close");
                                $('#PageTitle').trigger('click');
                                abrirSeccionAdmin(15,3);
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }
            }
        });		
    }
}
function guardarModificacionGlosario(){
    var _tituloGlosario		= $('#TituloGlosario_mod').val();
    var _descripcionGlosario	= $('#DescripcionGlosario_mod').val();
    var _abreviaturaGlosario    = $('#AbreviaturaGlosario_mod').val();
    var _urlGlosario            = $('#UrlGlosario_mod').val();
    var _idGlosario             = $('#GlosarioId_mod').val();
    var errores = 0;
    if(errores === 0){
        $.ajax({
            type: "POST",
            url: "administracion/guardar_modificacion_glosario.php",
            cache: false,
            dataType : 'json',
            data: {
                id        :_idGlosario,
                titulo    :_tituloGlosario,
                descripcion :_descripcionGlosario,
                abreviatura :_abreviaturaGlosario,
                url         :_urlGlosario
            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp)
            {
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input').removeClass('campo_error');
                    $('#errores_generales_modificarGlosario, #exito_generales_modificarGlosario').remove();
                    $('#tabsGlosario-2 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_modificarGlosario', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_modificarGlosario').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');
                    }
                }else{
                    $( "#dialogWindow" ).html('<p>Los datos de Glosario fueron actualizados correctamente.</p>');
                    $( "#dialogWindow" ).dialog({
                        title   : "Actualizaci&oacute;n exitosa!",
                        modal   : true,
                        position        : '50px',
                        buttons : {
                            "Ok": function() {
                                $("#PageTitle").trigger("click");
                                abrirSeccionAdmin(15,2);
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }
            }
        });

    }else{
    ///agregar el mensaje general aqui
    }
}
function cargarPanelDeComentarios(idIndicador){
    $.ajax({
        type: "POST",
        url: "phpIncluidos/controlador_de_comentarios.php",
        cache: false,
        dataType: "json",
        data: {
            solicitud:'panelDeComentarios',
            idIndicador:idIndicador
        },
        error: function(){
            _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexi&oacute;n. Por favor, intentalo de nuevo.</p>";
            $( "#dialogWindow" ).html(_html);
            $( "#dialogWindow" ).dialog({
                title   : 'Ups! error',
                modal   : true,
                buttons : {
                    "Ok": function() {
                        $(this).dialog("close");
                    }
                },
                minWidth: 600,
                resizable: false
            });
        },
        success: function(response)
        {
            $('#ContainerPanelDeComentarios_' + idIndicador).html(response.html).fadeIn('fast');
        }
    });
}
function cargarRespuestas(idComentario){
    $.ajax({
        type: "POST",
        url: "phpIncluidos/controlador_de_comentarios.php",
        cache: false,
        dataType: "json",
        data: {
            solicitud:'respuestas',
            idComentario:idComentario
        },
        error: function(){
            var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexi&oacute;n. Por favor, intentalo de nuevo.</p>";
            $( "#dialogWindow" ).html(_html);
            $( "#dialogWindow" ).dialog({
                title   : 'Ups! error',
                modal   : true,
                buttons : {
                    "Ok": function() {
                        $(this).dialog("close");
                    }
                },
                minWidth: 600,
                resizable: false
            });
        },
        success: function(response)
        {
            $('#PanelDeRespuesta_' + idComentario + ' ~ div').remove();
            $('#PanelDeRespuesta_' + idComentario).after(response.html);
        }
    });
}
function guardarComentario(idIndicador, texto){
    $.ajax({
        type: "POST",
        url: "phpIncluidos/controlador_de_comentarios.php",
        cache: false,
        dataType: "json",
        data: {
            solicitud:'guardarComentario',
            idIndicador:idIndicador,
            texto:texto
        },
        error: function(){
            var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexi&oacute;n. Por favor, intentalo de nuevo.</p>";
            $( "#dialogWindow" ).html(_html);
            $( "#dialogWindow" ).dialog({
                title   : 'Ups! error',
                modal   : true,
                buttons : {
                    "Ok": function() {
                        $(this).dialog("close");
                    }
                },
                minWidth: 600,
                resizable: false
            });
        },
        success: function(response)
        {
            $('#NuevoComentario').attr('value','');
            if (response.success == true){
                $('#ContainerPanelDeComentarios_' + idIndicador + ' div.PanelDeComentarios div.Pie div.Error').html(''); 
                $('#ContainerPanelDeComentarios_' + idIndicador + ' div.Comentarios').prepend(response.html);
            }else{
                if (response.errores.general){
                    var tipo_de_error = response.errores.tipo;
                    if(tipo_de_error){
                        if(tipo_de_error === 'dialogo'){
                            var _html = "<p>" + response.errores.general + "</p>";
                            $( "#dialogWindow" ).html(_html);
                            $( "#dialogWindow" ).dialog({
                                title   : 'Información',
                                modal   : true,
                                buttons : {
                                    "Iniciar mi sesión": function() {
                                        $(this).dialog("close");
                                        $('#btn_iniciarSesion').trigger('click');
                                    },
                                    "Voy a comentar luego": function() {
                                        $(this).dialog("close");
                                    }
                                },
                                minWidth: 600,
                                resizable: false
                            });
                        }
                    }else{
                        $('#ContainerPanelDeComentarios_' + idIndicador + ' .EspacioComentarIndicador div.Error').html(response.errores.general); 
                    }
                }else{
                    $('#ContainerPanelDeComentarios_' + idIndicador + ' .EspacioComentarIndicador div.Error').html(response.errores.texto); 
                }	
            }
        }
    });
}
function guardarNuevaRespuesta(idIndicador, idComentarioPadre, texto){
    $.ajax({
        type: "POST",
        url: "phpIncluidos/controlador_de_comentarios.php",
        cache: false,
        dataType: "json",
        data: {
            solicitud:'guardarNuevaRespuesta',
            idIndicador:idIndicador,
            idComentarioPadre:idComentarioPadre,
            texto:texto
        },
        error: function(){
            _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexi&oacute;n. Por favor, intentalo de nuevo.</p>";
            $( "#dialogWindow" ).html(_html);
            $( "#dialogWindow" ).dialog({
                title   : 'Ups! error',
                modal   : true,
                buttons : {
                    "Ok": function() {
                        $(this).dialog("close");
                    }
                },
                minWidth: 600,
                resizable: false
            });
        },
        success: function(response)
        {
            if (response.success == true){
                $('#PanelDeRespuesta_' + idComentarioPadre + ' div.Error').html('');
                $('#PanelDeRespuesta_' + idComentarioPadre + ' textarea').val('');
                $('#PanelDeRespuesta_' + idComentarioPadre).stop(true,true).fadeOut('fast', function (){
                    $('#PanelDeRespuesta_' + idComentarioPadre).after(response.html);
                });
            }else{
                if (response.errores.general){
                    $('#PanelDeRespuesta_' + idComentarioPadre + ' div.Error').html(response.errores.general); 
                }else{
                    $('#PanelDeRespuesta_' + idComentarioPadre + ' div.Error').html(response.errores.texto); 
                }	
            }
        }
    });
}
function guardarModificacion(idComentario, texto){
    $.ajax({
        type: "POST",
        url: "phpIncluidos/controlador_de_comentarios.php",
        cache: false,
        dataType: "json",
        data: {
            solicitud:'guardarModificacion',
            idComentario:idComentario,
            texto:texto
        },
        error: function(){
            _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexi&oacute;n. Por favor, intentalo de nuevo.</p>";
            $( "#dialogWindow" ).html(_html);
            $( "#dialogWindow" ).dialog({
                title   : 'Ups! error',
                modal   : true,
                buttons : {
                    "Ok": function() {
                        $(this).dialog("close");
                    }
                },
                minWidth: 600,
                resizable: false
            });
        },
        success: function(response)
        {
            if (response.success == true){
                $('#PanelDeModificacion_' + idComentario + ' div.Error').html('');
                $('#PanelDeModificacion_' + idComentario + ' textarea').val('');
                $('#PanelDeModificacion_' + idComentario).stop(true,true).fadeOut('fast', function (){
                    $('#c_' + idComentario).replaceWith(response.html);
                });
            }else{
                if (response.errores.general){
                    $('#PanelDeModificacion_' + idComentario + ' div.Error').html(response.errores.general); 
                }else{
                    $('#PanelDeModificacion_' + idComentario + ' div.Error').html(response.errores.texto); 
                }	
            }
        }
    });
}
function eliminarComentario(idComentario){
    $.ajax({
        type: "POST",
        url: "phpIncluidos/controlador_de_comentarios.php",
        cache: false,
        dataType: "json",
        data: {
            solicitud:'eliminarComentario',
            idComentario:idComentario
        },
        error: function(){
            _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexi&oacute;n. Por favor, intentalo de nuevo.</p>";
            $( "#dialogWindow" ).html(_html);
            $( "#dialogWindow" ).dialog({
                title   : 'Ups! error',
                modal   : true,
                buttons : {
                    "Ok": function() {
                        $(this).dialog("close");
                    }
                },
                minWidth: 600,
                resizable: false
            });
        },
        success: function(response)
        {
            if (response.success == true){
                $('#c_' + idComentario).stop(true,true).fadeOut('fast', function (){
                    $('#c_' + idComentario).replaceWith(response.html).fadeIn('fast');
                });
            }else{
                var error_msg; 
                if (response.errores.general){
                    error_msg = response.errores.general; 
                }else{
                    error_msg = response.errores.texto; 
                }
				
                $( "#dialogWindow" ).html(error_msg);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            }
        }
    });
}
function cargarPanelDeRespuesta(idComentario){
    $('#PanelDeRespuesta_' + idComentario).stop(true,true).fadeIn('fast');
}
function cerrarPanelDeRespuesta(idComentario){
    $('#PanelDeRespuesta_' + idComentario).stop(true,true).fadeOut('fast');
}
function cargarPanelDeModificacion(idComentario){
    $('#PanelDeModificacion_' + idComentario + ' textarea').val($('#c_' + idComentario + ' div.Cuerpo:first').html());
    $('#c_' + idComentario + ' div.Cuerpo:first').stop(true,true).fadeOut('fast', function (){
        $('#PanelDeModificacion_' + idComentario).stop(true,true).fadeIn('fast');
    });
}
function cerrarPanelDeModificacion(idComentario){
    $('#PanelDeModificacion_' + idComentario).stop(true,true).fadeOut('fast', function (){
        $('#c_' + idComentario + ' div.Cuerpo:first').stop(true,true).fadeIn('fast');
    });
}
function guardarAdminGlosario() {
    var _tituloGlosario			= $.trim($('#TituloGlosario').val());
    var _descripcionGlosario	= $.trim($('#DescripcionGlosario').val());
    var errores = 0;
    var listaReferencia = new Array();
    $.each( $('input[name|="referencia"]'), function(key, val){
        listaReferencia.push($(this).val());
    });
    if(errores === 0){
        $.ajax({
            type: "POST",
            url: "administracion/guardar_glosario.php",
            cache: false,
            dataType : 'json',
            data: {
                titulo          :_tituloGlosario,
                descripcion      :_descripcionGlosario,
                listaDeReferencia   :listaReferencia

            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp)
            {
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input').removeClass('campo_error');
                    $('#errores_generales_nuevoGlosario, #exito_generales_nuevoGlosario').remove();
                    $('#tabsGlosario-1 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_nuevoGlosario', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_nuevoGlosario').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');
                    }
                }else{
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input, textarea').attr('value','').removeClass('campo_error');
                    $('#errores_generales_nuevoGlosario, #exito_generales_nuevoGlosario').remove();
                    $('#tabsGlosario-1 #CamposFormulario').prepend(CajaExitoErrores(1, 'exito_generales_nuevoGlosario', 'El Glosario se guardo exitosamente.'));
                    $('#exito_generales_nuevoGlosario').fadeIn('fast');
                    $('a[href="#tabsGlosario-3"]').attr('onclick','abrirSeccionAdmin(15,3)');
                    $('#referencias').html('');
                    var htmlbtn = '<input type="button" class="ui-boton-guardar" onclick="AgregarReferencia()"value ="Agregar nuevo campo de referencia"/>';
                    $('#EspacioBotonAgregarReferencia').html(htmlbtn);           
                }
            }
        });
    }
}
function cargarPanelModificacionGlosario(id_Glosario)
{
    var flag = false;
    try
    {
        parseInt(id_Glosario);
        flag = true;
    }
    catch (error)
    {
        flag = false;
    }
    if(flag)
    {
        $.ajax({
            type: "GET",
            url: "administracion/modificar_glosario.php",
            data: {
                id    :   id_Glosario
            },
            error: function(){
                _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(msg)
            {
                $("#PanelModificacionDeGlosario").remove();
                $('#tabsGlosario-2').append(msg);
                $('#PanelModificacionDeGlosario').fadeIn('fast');
                $('html, body').animate({
                    scrollTop:940
                }, 'slow');
            }
        });
    }
}
function filtroDeGlosario(str)
{
    $('#listadoModificarGlosario li').css('display', 'none');
    str = $.trim(str);
    if (str == "")
    {
        $('#listadoModificarGlosario li').fadeIn('fast');
    }
    else
    {
        $('#listadoModificarGlosario [titulo_Glosario*="'+ str +'"]').fadeIn('fast');
    }
}
function filtroDeGlosarioMod(estado_Glosario)
{
    $('#listadoActDesactGlosario li').css('display', 'none');

    if ( (estado_Glosario == '0') || (estado_Glosario == '1') )
    {
        $('#listadoActDesactGlosario [esta_activa="'+ estado_Glosario +'"]').fadeIn('fast');
    }
    else
    {
        $('#listadoActDesactGlosario li').fadeIn('fast');
    }
}
function guardarGlosarioActivarDesactivar(){

    var listaIdsGlosario = new Array();
    var index = 0;
    $.each( $('#listadoActDesactGlosario [name="estatusGlosario"]:checked'), function(key, val){
        listaIdsGlosario[index] = $(val).val();
        index++;
    });
    if(index === 0){
        var _html = "<p>Debes seleccionar a lo menos 1 Glosario para poder presionar este bot&oacute;n.</p>";
        $( "#dialogWindow" ).html(_html);
        $( "#dialogWindow" ).dialog({
            title   : 'Nota',
            modal   : true,
            buttons : {
                "Ok": function() {
                    $(this).dialog("close");
                }
            },
            minWidth: 600,
            resizable: false
        });
    }else{
        $.ajax({
            type: "POST",
            url: "administracion/cambiar_estado_glosario.php",
            cache: false,
            data: {
                listaIdsGlosario     :    listaIdsGlosario
            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, posiblemente has perdido la conexi&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp)
            {				
                if (_resp.refresh_error){
                    $( "#dialogWindow" ).html(_resp.refresh_error);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error al tratar de guardar',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                                $('#PageTitle').trigger('click');
                                abrirSeccionAdmin(15,3);
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else{
                    $( "#dialogWindow" ).html('<p>Los cambios en el estado Glosario fue realizado con &eacute;xito.</p>');
                    $( "#dialogWindow" ).dialog({
                        title   : 'Transaci&oacute;n Exitosa!',
                        modal   : true,
                        buttons : {
                            "Perfecto": function() {
                                $(this).dialog("close");
                                $('#PageTitle').trigger('click');
                                abrirSeccionAdmin(15,3);
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }
            }
        });		
    }
}
function guardarModificacionGlosario(){
    var _tituloGlosario		= $('#TituloGlosario_mod').val();
    var _descripcionGlosario    = $('#DescripcionGlosario_mod').val();
    var _idGlosario             = $('#GlosarioId_mod').val();
    var listaReferencia = new Array();
    $.each( $('input[name|="referenciaMod"]'), function(key, val){
        listaReferencia.push($(this).val());
    });
    var errores = 0;
    if(errores === 0){
        $.ajax({
            type: "POST",
            url: "administracion/guardar_modificacion_glosario.php",
            cache: false,
            dataType : 'json',
            data: {
                id        :_idGlosario,
                titulo    :_tituloGlosario,
                descripcion :_descripcionGlosario,
                listaDereferencia   :listaReferencia
            },
            error: function(){
                var _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n, pueda que tu conexi&oacute;n este fallando. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp)
            {
                if (_resp.refresh_error){
                    var _html = "<p>" + _resp.refresh_error + "</p>";
                    $( "#dialogWindow" ).html(_html);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                location.reload();
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else if (_resp.errores){
                    $('ul[id^="errors"]').html('');
                    $('#CamposFormulario input').removeClass('campo_error');
                    $('#errores_generales_modificarGlosario, #exito_generales_modificarGlosario').remove();
                    $('#tabsGlosario-2 #CamposFormulario').prepend(CajaExitoErrores(0, 'errores_generales_modificarGlosario', 'Por favor arregla los errores en los campos coloreados en rojo.'));
                    $('#errores_generales_modificarGlosario').fadeIn('fast');
                    for(var key in _resp.errores){
                        $('#errors_' + key).html('<li>' + _resp.errores[key] + '</li>');
                        $('#' + key).addClass('campo_error');
                    }
                }else{
                    $( "#dialogWindow" ).html('<p>Los datos de Glosario fueron actualizados correctamente.</p>');
                    $( "#dialogWindow" ).dialog({
                        title   : "Actualizaci&oacute;n exitosa!",
                        modal   : true,
                        position        : '50px',
                        buttons : {
                            "Ok": function() {
                                $("#PageTitle").trigger("click");
                                abrirSeccionAdmin(15,2);
                                $(this).dialog("close");
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }
            }
        });

    }else{
    ///agregar el mensaje general aqui
    }
}
function filtroDeIndicadoresAnoBase(str)
{
    $('#listadoAnoBaseIndicador li').css('display', 'none');
    str = ($.trim(str)).toLowerCase();

    if (str == "")
    {
        $('#listadoAnoBaseIndicador li').fadeIn('fast');
    }
    else
    {
        $('#listadoAnoBaseIndicador [titulo_Indicadores*="'+ str +'"]').fadeIn('fast');
    }
}
function guardarIndicadoresAnoBase(){
    var cambios = new Array();
   
    $('select[id^="anio_base_"][cambiado="si"]').each(function() {
        var temp = ($(this).attr('id')).split("_");
        cambios[temp.pop()] = $(this).val();
    });
   
    if (cambios.length > 0){
        $.ajax({
            type: "POST",
            url: "administracion/guardar_modificacion_indicadores_anio_base.php",
            dataType: "json",
            data: {
                cambios:cambios
            },
            error: function(){
                _html = "<p>Parece que hubo un error al realizar esta acci&oacute;n. Por favor, int&eacute;ntalo de nuevo.</p>";
                $( "#dialogWindow" ).html(_html);
                $( "#dialogWindow" ).dialog({
                    title   : 'Ups! error',
                    modal   : true,
                    buttons : {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    },
                    minWidth: 600,
                    resizable: false
                });
            },
            success: function(_resp)
            {
                if (_resp.refresh_error){
                    $( "#dialogWindow" ).html(_resp.refresh_error);
                    $( "#dialogWindow" ).dialog({
                        title   : 'Ups! error al tratar de guardar',
                        modal   : true,
                        buttons : {
                            "Ok": function() {
                                $(this).dialog("close");
                                $('#PageTitle').trigger('click');
                                abrirSeccionAdmin(2,2);
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }else{

                    $( "#dialogWindow" ).html('<p>Los cambios del estado de publicaci&oacute;n del indicador fueron realizados con &eacute;xito.</p>');

                    $( "#dialogWindow" ).dialog({
                        title   : 'Transacci&oacute;n Exitosa!',
                        modal   : true,
                        buttons : {
                            "Perfecto": function() {
                                $(this).dialog("close");
                                abrirSeccionAdmin(2,6);
                            }
                        },
                        minWidth: 600,
                        resizable: false
                    });
                }
            }
        });
    }
}
//8,234