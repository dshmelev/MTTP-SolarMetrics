function requestData(chartToUpdate,url) {
    $.getJSON('http://sosvetom.ru/_api/get_metrics/?num=100'+url,
        function(data){
            var chart = chartToUpdate.series[0];
            chart.setData(data);
            chartToUpdate.redraw();
        }
    );
}

$(document).ready(function() {
    Highcharts.setOptions({ global: { useUTC : false} })
    $('#chart_24h').highcharts({
        credits: {
            enabled: false
        },
        chart: {
            type: 'column', 
            backgroundColor: null
        },
        title: {
            text: 'Статистика работы за день'
        },
        xAxis: {
            type: 'datetime',
            tickInterval: 3600 * 1000
        },
        yAxis: {
            title: {text: 'Мощность электроэнергии(Вт)'},
            labels: {enabled: false},
            gridLineColor: 'transparent', 
            lineColor: 'transparent'
        },
        legend: {
            enabled: false
        },
        series: [{ 
            name: 'Мощность',
            format: '{y} Вт'
        }]
    },
    // Обновление значений
    function (chart) {
        if (!chart.renderer.forExport) {
            requestData(chart,'&col=300');
            setInterval(function () {
                requestData(chart,'&col=300');
            }, 60000);
        }
    }); 
})
