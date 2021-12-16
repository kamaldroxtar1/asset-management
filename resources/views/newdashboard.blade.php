@extends('dashboard')
@section('kamal')

<div class="row">
    <div class="col-6">
    <html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Asset type', 'Total asset'],
          <?php echo $chardatapie?>
        ]);

        var options = {
          title: 'No of Assets'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart" class="container" style="width: 600px; height: 400px;"></div>
    <div class="text-center"><h3>Pie chart</h3></div>
  </body>
</html>
    </div>
    <div class="col-5">
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
    <div id="curve_chart" class="container text-center" style="width: 600px; height: 400px"></div>
    <div class="text-center"><h3>Bar chart</h3></div>
  </body>
</html>
    </div>
</div>
@endsection