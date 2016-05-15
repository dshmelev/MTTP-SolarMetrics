$(document).ready(function() {
  Highcharts.setOptions({ global: { useUTC : false} })
  $.getJSON('/_api/get_metrics/?num=100', function (data) {
    $('#indicators_8h').highcharts({
      credits: { enabled: false },
      colors: ['#ffaa30'],
      chart: { type: 'column', backgroundColor: null },
      title: { text: null },
      xAxis: { type: 'datetime', labels: { enabled: false }, tickColor: 'transparent'},
      yAxis: { title: { text: '' }, labels: { enabled: false }, gridLineColor: 'transparent', lineColor: 'transparent'},
      legend: { enabled: false },
      series: [{ name: 'Energy', data: data }]
    });
  });
});

