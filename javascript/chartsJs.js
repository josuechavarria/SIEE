$(document).ready(function () {
    Highcharts.theme = {
        //colors: ['#B5CA92', '#A47D7C', '#92A8CD', '#DB843D', '#3D96AE', '#80699B', '#89A54E', '#AA4643', '#4572A7'],
        //colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
        lang: {
            months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            weekdays: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
            downloadPNG     :   'Descargar Imagen en .PNG',
            downloadJPEG    :   'Descargar Imagen en .JPEG',
            downloadPDF     :   'Desscargar Imagen en .PDF' ,
            downloadSVG     :   'Descargar en Formato Vectorizado .SVG',
            exportButtonTitle       :   'Descarga el Gráfico en formato de Imagen o Vetor Rasterizado.',
            printButtonTitle        :   'Imprimir solamente este Grafico.',
            loading         :   'Cargando...',
            resetZoom       :   'Restaurar Zoom',
            resetZoomTitle  :   'Restaurar Zoom a 1:1'
        },
        chart: {
            backgroundColor: {
                linearGradient: [0, 0, 500, 500],
                stops: [
                [0, 'rgb(255, 255, 255)'],
                [1, 'rgb(240, 240, 255)']
                ]
            }
            ,
            //borderWidth: 2,
            plotBackgroundColor: 'rgba(255, 255, 255, .9)',
            plotShadow: true,
            plotBorderWidth: 1
        },
        title: {
            style: { 
                color: '#395362',
                font: 'bold 14px "Tahoma", Verdana, sans-serif'
            }
        },
        subtitle: {
            style: { 
                color: '#666666',
                font: '11px "Tahoma", Verdana, sans-serif'
            }
        },
        xAxis: {
            gridLineWidth: 1,
            lineColor: '#000',
            tickColor: '#000',
            labels: {
                style: {
                    color: '#777',
                    font: '11px Tahoma, Verdana, sans-serif'
                }
            },
            title: {
                style: {
                    color: '#333',
                    fontWeight: 'bold',
                    fontSize: '12px',
                    fontFamily: 'Tahoma, Verdana, sans-serif'

                }            
            }
        },
        yAxis: {
            minorTickInterval: 'auto',
            lineColor: '#000',
            lineWidth: 1,
            tickWidth: 1,
            tickColor: '#000',
            labels: {
                style: {
                    color: '#000',
                    font: '11px Tahoma, Verdana, sans-serif'
                }
            },
            title: {
                style: {
                    color: '#777',
                    fontWeight: 'bold',
                    fontSize: '12px',
                    fontFamily: 'Tahoma, Verdana, sans-serif'
                }            
            }
        },
        legend: {
            itemStyle: {         
                font: '9pt Tahoma, Verdana, sans-serif',
                color: 'black'

            },
            itemHoverStyle: {
                color: '#039'
            },
            itemHiddenStyle: {
                color: 'gray'
            }
        },
        labels: {
            style: {
                color: '#99b'
            }
        }
    };
    // Apply the theme
    var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
    
    /**
     * funciona de uso general que lee una tabla html y genera la grafica degault de highcharts
     */
    // On document ready, call visualize on the datatable.
    $(document).ready(function() {
        /**
         * Visualize an HTML table using Highcharts. The top (horizontal) header
         * is used for series names, and the left (vertical) header is used
         * for category names. This function is based on jQuery.
         * @param {Object} table The reference to the HTML table to visualize
         * @param {Object} options Highcharts options
         */
        Highcharts.visualize = function(table, options) {
            // the categories
            options.xAxis.categories = [];
            $('tbody th', table).each( function(i) {
                options.xAxis.categories.push(this.innerHTML);
            });
    
            // the data series
            options.series = [];
            $('tr', table).each( function(i) {
                var tr = this;
                $('th, td', tr).each( function(j) {
                    if (j > 0) { // skip first column
                        if (i == 0) { // get the name and init the series
                            options.series[j - 1] = {
                                name: this.innerHTML,
                                data: []
                            };
                        } else { // add values
                            var value = this.innerHTML.toString().replace(',', '');
                            options.series[j - 1].data.push(parseFloat(value));
                            //options.series[j - 1].data.push(parseFloat(this.innerHTML));
                        }
                    }
                });
            });
    
            var chart = new Highcharts.Chart(options);
        }
    });
    
});