<?php

require_once 'restrito.php';
require_once __DIR__.'/../config/database.php';

//$id_emp_default = $_SESSION['id_emp_default'];
$id_emp_default = $_SESSION["id_emp_default"];

//---------------------------------------------------------------------------------------------------------------------------------------------------------------

$sql = 'SELECT  nome FROM public."VW_ORGANOGRAMA" WHERE id_emp='.$id_emp_default.' order by nivel ASC';
$res = pg_exec($conn, $sql);

  while ($linha2 = pg_fetch_assoc($res)) {
    $consulta2 = $consulta2 . $linha2['nome'];
  }
      ?>

<html>
  <head>

  <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GESTOU ADMIN - Organograma</title>

  <script type='text/javascript' src='js/loader.js'></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {packages:['orgchart']});
      google.setOnLoadCallback(drawChart);


    function drawChart() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Name');
      data.addColumn('string', 'Manager');
      data.addColumn('string', 'ToolTip');
      data.addRows([       
        <?php  echo $consulta2; ?>
        
      ]);
      var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
      chart.draw(data, {allowHtml:true, allowCollapse:true});
    }

  </script>

  <style>

td{

user-select: none;

}

body{

  background-color: #f8f9fc;

}

  </style>

  </head>

  <body>
    <div id='chart_div'></div>
  </body>
</html>