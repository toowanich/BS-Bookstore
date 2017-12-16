<!DOCTYPE html>
<?php session_start(); ?>
<?php
    // $_SESSION['lastpage']='account';
    require_once('connect.php');
    require_once("navbar.php");
  ?>
<html lang="en">
<head>
  <title>BG Store - Statistics</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css">
  <link rel="stylesheet" href="modal.css" type="text/css">
  <link rel="stylesheet" href="btnoutline.css" type="text/css">
  <link rel="stylesheet" href="alert.css" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default rounded borders and increase the bottom margin */
    .navbar {
      margin-bottom: 0px;
      border-radius: 0;
    }

    /* Remove the jumbotron's default bottom margin */
     .jumbotron {
      margin-bottom: 0;
      padding-top: 100px;
      margin-bottom: 20px;
    }

    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #2A2A2A;
      color: #E0E0E0;
      padding: 1.5%;
      /*position: absolute;*/
      left:0;
      right:0;
      bottom:0;
      margin-top:15px;
    }

    .panel{
      border-color:#6B6A6A ;
      border-width:1.5px;
    }

    .panel-footer{
      background-color: #D7D7D7;
    }

/*----------------------------------------------------------*/
  </style>
</head>
<body>


  <!-- =============================== jumbotron ==================================== -->
  <!-- <?php show_jumbotron(); ?> -->
  <!-- ////////////////////////////////////////////////////////////////////////////// -->

<!-- =============================== navbar ======================================= -->
<nav class="navbar navbar-inverse navbar-fixed-top">
  <?php show_navbar(); ?>
</nav>
<br><br><br>
  <!-- /////////////////////////////////////////////////////////////////////////// -->

  <center>
    <h1>Statistics<h1>
  <div class="text-center" style="width: 80%;">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <div id="chart_div"></div>
  <hr>
  <table align="center" class="table table-hover center row-add" style="width:98%;">
    <form action ='statistics.php' method='get'>
    <tr>
    <td>
      <select class="form-control" name="product">
        <option value = 'a'>All</option>
        <?php
        $q = 'SELECT product_name,product_id FROM product';
        $result = $mysqli->query($q);
        while($row = $result->fetch_array()){ ?>
            <option <?php
            if(isset($_GET['product']) and $_GET['product'] == $row['product_id']){
              echo 'selected';
            }
            ?>
            value="<?=$row['product_id']?>"><?=$row['product_name']?></option>
            <?php
        } ?>
      </select>
    </td>
  </tr>
  <tr>
    <td>
      <input class="btn-primary btn" style="margin-right:10px;display:inline-block;" type="submit"value="Filter">

    </td>
  </tr>

</form>
  </div>
  </center>

<script>
google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawCrosshairs);

function drawCrosshairs() {
      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'Sales');

      data.addRows([
        <?php
          $q = 'SELECT order_date as o, count(*) as c FROM orderheader,orderdetail WHERE orderheader.order_id = orderdetail.order_id';
          if(isset($_GET['product']) and $_GET['product'] != 'a'){
            $q = $q.' AND product_id = '.$_GET['product'];
          }
          $q = $q.' Group by order_date';
          $result = $mysqli->query($q);
          if($result->num_rows == 0){
            $q = 'SELECT order_date as o, count(*) as c FROM orderheader,orderdetail WHERE orderheader.order_id = orderdetail.order_id Group by order_date';
            $result = $mysqli->query($q);
            $trigger = 1;
          }
          $count = 0;
          while($rows = $result -> fetch_array()){
            if($count != 0){
              echo ', ';
            }
            $explosion = explode('-',$rows['o']);

            echo "[new Date(".$explosion['0'].",".$explosion['1'].",".$explosion['2']."),".$rows['c']."]";
            $count = $count + 1;
          }
         ?>
      ]);

      var options = {

        fontSize: '20',
        chart: {
          title:<?php
          if(isset($trigger)){
            echo "'Total Sales'";
          }elseif(isset($_GET['product']) and $_GET['product'] != 'a'){
            echo '"Sales of ';
            $q = 'SELECT product_name FROM product WHERE product_id = '.$_GET['product'];
            $result = $mysqli->query($q);
            $row = $result->fetch_array();
            echo $row[0].'"';
            ;
          }else{
            echo "'Total Sales'";
          }

          ?>

        },

        hAxis: {
          title: 'Date',
           textStyle : {
          fontSize: '15'
          }
        },
        vAxis: {
          title: 'Sales',
          textStyle : {
         fontSize: '15'
         }

        },
        legend: {position: 'none'}
        // colors: ['#a52714', '#097138']

      };

      var chart = new google.charts.Line(document.getElementById('chart_div'));

      chart.draw(data, google.charts.Line.convertOptions(options));

    }
</script>
</body>
</html>
