function requestData(chartToUpdate,url) {
    $.getJSON('http://sosvetom.ru/_api/get_metrics/?offset='+url,
        function(data){
            var chart = chartToUpdate.series[0];
            chart.setData(data);
            chartToUpdate.redraw();
        }
    );
}

$(document).ready(function() {
    Highcharts.setOptions({
        global: { useUTC : false},
        lang: {
            loading: 'Загрузка...',
            months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
            weekdays: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
            shortMonths: ['Янв', 'Фев', 'Март', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сент', 'Окт', 'Нояб', 'Дек'],
            rangeSelectorZoom: ['Увеличить:']
        }
    })
    //Кнопка на главной
    $('#chart-button').highcharts({
        credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        chart: {
            type: 'column',
            backgroundColor: null
        },
        title: {
            text:'',
            style: {
                display: 'none'
            }
        },
        tooltip: {
            enabled: false
        },
        xAxis: {
            type: 'datetime',
            gridLineWidth: 0,
            tickWidth: 0,
            lineWidth: 0,
            labels: {enabled: false}
        },
        yAxis: {
            title: {
                text: '',
                style: {
                    display: 'none'
                }
            },
            gridLineWidth: 0,
            labels: {enabled: false}
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                groupPadding: 0
            }
        },
        series: [{
            color: '#fff',
            data: [[1478642402000,1],[1478646002000,1],[1478649602000,2],[1478653208000,3],[1478656802000,5],[1478660402000,8],[1478664001000,13],[1478667602000,21],[1478671201000,34],[1478674802000,55],[1478678402000,89],[1478682002000,144],[1478685602000,233],[1478689201000,337],[1478692802000,233],[1478696402000,144],[1478700002000,89],[1478703602000,55],[1478707202000,34],[1478710801000,21],[1478714402000,13],[1478718001000,8],[1478721615000,5],[1478725211000,3]]
        }]
    });

    /*function (chart) {
        var request = 'month'
        if (!chart.renderer.forExport) {
            requestData(chart,request);
            setInterval(function () {
                requestData(chart,request);
            }, 60000);
        }
    });*/

    //Онлайн профиль генерации
    $('#chart_24h').highcharts('StockChart',{
        credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        chart: {
            type: 'spline',
            backgroundColor: null
        },
        rangeSelector: {
                buttons: [{
                    type: 'hour',
                    count: 24,
                    text: '1 день'
                }, {
                    type: 'all',
                    text: 'Показать всё'
                }],
                buttonTheme: {
                    width: 100
                },
                selected: 1,
                inputEnabled: false
        },
        title: {
            text: 'Онлайн профиль генерации'
        },
        xAxis: {
            type: 'datetime',
            tickInterval: 3600 * 1000
        },
        yAxis: {
            opposite: false,
            title: {
                text: 'Мощность генерации (Вт)'
            },
            labels: {enabled: false}
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            spline: {
                lineWidth: 3,
                marker: {
                    enabled: false
                }
            },
        },
        navigator: {
            enabled: false
        },
        series: [{
            name: 'Мощность генерации',
            color: '#ffaa30'
        }]
    },
    // Обновление значений
    function (chart) {
        var request = '3day'
        if (!chart.renderer.forExport) {
            requestData(chart,request);
            setInterval(function () {
                requestData(chart,request);
            }, 60000);
        }
    });

    //Посуточный график генерации
    $('#chart_month').highcharts({
        credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        chart: {
            type: 'column',
            backgroundColor: null
        },
        title: {
            text: 'Посуточный график генерации (Вт*Ч/день)'
        },
        xAxis: {
            type: 'datetime'
        },
        yAxis: {
            title: {text: 'Мощность генерации (Вт)'},
            labels: {enabled: false}
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                groupPadding: 0
            }
        },
        series: [{
            name: 'Мощность генерации',
            color: '#9ac361'
        }]
    },

    function (chart) {
        var request = 'month'
        if (!chart.renderer.forExport) {
            requestData(chart,request);
            setInterval(function () {
                requestData(chart,request);
            }, 60000);
        }
    });

    //Статистика с момента запуска сервиса
    $('#chart_year').highcharts({
        credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        chart: {
            type: 'column',
            backgroundColor: null
        },
        title: {
            text: 'Статистика с момента запуска сервиса'
        },
        xAxis: {
            type: 'datetime'
        },
        yAxis: {
            title: {text: 'Мощность генерации (Вт)'},
            labels: {enabled: false}
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                groupPadding: 0
            }
        },
        series: [{
            name: 'Мощность генерации',
            color: '#554176'
        }],
    },

    function (chart) {
        var request = 'all'
        if (!chart.renderer.forExport) {
            requestData(chart,request);
            setInterval(function () {
                requestData(chart,request);
            }, 60000);
        }
    });
})
