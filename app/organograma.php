<?php

require_once 'restrito.php';
require_once 'conexao.php';

//$id_emp_default = $_SESSION['id_emp_default'];
require "util.php";

//---------------------------------------------------------------------------------------------------------------------------------------------------------------

foreach (select_organograma($id_emp_default) as $organograma) {

  $consulta2 = $consulta2 . $organograma['nome'];

}

// while ($linha2 = pg_fetch_assoc($res)) {
//   $consulta2 = $consulta2 . $linha2['nome'];
// }
?>

<html>

<head>

  <meta charset="utf-8">
  <link rel="icon" type="image/png" href="../img/logo.ico" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>GESTOU ADMIN - Organograma</title>

  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
  <!-- <link href="css/ruang-admin.min.css" rel="stylesheet"> -->
  <link href="css/ruang-admin.css" rel="stylesheet">

  <script type='text/javascript' src='js/loader.js'></script>
  <script type='text/javascript'>
    google.load('visualization', '1', {
      packages: ['orgchart']
    });
    google.setOnLoadCallback(drawChart);


    function drawChart() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Name');
      data.addColumn('string', 'Manager');
      data.addColumn('string', 'ToolTip');
      data.addRows([
        <?php echo $consulta2; ?>

      ]);
      var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
      chart.draw(data, {
        allowHtml: true,
        allowCollapse: true
      });
    }
  </script>

  <style>
    td {

      user-select: none;

    }

    body {

      background-color: #f8f9fc;
      color: #000 !important;

    }

    #chart_div {
    height: 300px;
    /* overflow-x: scroll; */
  }
  </style>

</head>

<body>

  <!-- DIV CONTENT WRAPPER -->
  <div id="content-wrapper" class="d-flex flex-column">

    <!-- DIV MENU CONTENT -->
    <div id="content">

      <!-- DIV CONTAINER FLUID-->
      <div class="container-fluid" id="container-wrapper">

        <div class="iconedireita mb-4 user-select-none">

          <!-- <i class="fas fa-chevron-circle-left fa-2x"></i><span class="h3 mb-0 text-gray-800" aria-current="page">&nbsp; Benefícios<span> -->

          <ol class="breadcrumb" style="position: fixed; z-index: 996;">
            <li class="breadcrumb-item h5"><a href="empresa_organograma"><i class="fas fa-chevron-circle-left fa-1x"></i></a></li>
            <!-- <li class="breadcrumb-item">Bootstrap UI</li> -->
            <li class="breadcrumb-item active h5" aria-current="page">Organograma</li>
          </ol>

        </div>
        <div class="row">
          <!-- DataTable with Hover -->
          <div class="col-lg-12 mt-5">
            <div id='chart_div'></div>
          </div>

        </div>
      </div>
    </div>
  </div>
</body>

</html>