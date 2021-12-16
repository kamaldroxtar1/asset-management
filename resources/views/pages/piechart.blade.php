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
    <div id="piechart" class="container" style="width: 900px; height: 500px;"></div>
  </body>
</html>

@endsection