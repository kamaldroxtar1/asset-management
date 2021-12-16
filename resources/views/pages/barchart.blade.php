@extends('dashboard')
@section('kamal')
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
         ['Status', 'Numbers', { role: 'style' }],
         ['Active',<?=$active?>,'green'],
         ['Inactive',<?=$inactive?>,'red']
      ]);
        var options = {
          title: 'Number of active assets & inactive assets'
        };

        var chart = new google.visualization.BarChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="curve_chart" class="container text-center" style="width: 900px; height: 500px"></div>
  </body>
</html>
@endsection