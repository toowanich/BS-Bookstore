<!DOCTYPE html>
<?php session_start();
$_SESSION['currentpage']='account';
$_SESSION['lp']='orderhistory.php';
require_once("navbar.php");
require_once('connect.php');

?>

<html lang="en">
<head>
  <title>BS Bookstore - Order List</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css">
  <link rel="stylesheet" href="btnoutline.css" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default rounded borders and increase the bottom margin */
    .navbar {
      margin-bottom: 50px;
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
      position: absolute;
      left:0;
      right:0;
      bottom:0;
    }



    .panel{
      border-color:#6B6A6A ;
      border-width:1.5px;
    }

    .panel-footer{
      background-color: #D7D7D7;
    }
  </style>
</head>
<body>

  <!-- =============================== jumbotron ==================================== -->
  <?php //show_jumbotron(); ?>
  <!-- ////////////////////////////////////////////////////////////////////////////// -->

  <!-- =============================== navbar ======================================= -->
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <?php show_navbar(); ?>
  </nav>
    <!-- /////////////////////////////////////////////////////////////////////////// -->
    <div class="container-fluid text-center">
      <div class="row content">
        <br><br><br>
        <h2>Order History</h2>
        <table class="table table-hover" style="width:60%;" align="center">
          <tr class="info">
            <th class="text-center">Order No.</th>
            <th class="text-center">Quantity</th>
            <th class="text-center">Total amount</th>
            <th class="text-center">Date and time</th>
            <th class="text-center">Status</th>
            <th class="text-center">Details</th>
            <th></th>
          </tr>
        <?php
          $q='SELECT * FROM orderheader WHERE orderheader.user_id='.$_SESSION['id'].' ORDER BY order_date DESC,order_time DESC';
          $res=$mysqli->query($q);
          while ($row=$res->fetch_array()) {

         ?>
          <tr >
            <td style="vertical-align:middle;" class="text-center"><?= $row['order_id'] ?></td>
            <td style="vertical-align:middle;" class="text-center"><?= $row['quantity'] ?></td>
            <td style="vertical-align:middle;" class="text-center"><?= $row['total_amount'] ?></td>
            <td style="vertical-align:middle;" class="text-center">
            <?php
            $date=date_create($row['order_date']);
            echo date_format($date,"Y/m/d").', '.$row['order_time'];
            ?>
            </td>
            <td style="vertical-align:middle;
              <?php if($row['order_status']=='PAID'){echo "color:#20CA00;";}
                    else if($row['order_status']=='SHIPPED'){echo "color:#7A00BF;";}
                    else if($row['order_status']=='PENDING'){echo "color:#0073E1";}
                    else if($row['order_status']=='CANCELED'){echo "color:#8B8B8B;";}
                    else{echo "color:red;";}?>"
                    class="text-center">
              <?= $row['order_status'] ?>
            </td>
            <form action="orderdetail.php" method="POST">
              <input type="hidden" name="orderid" value="<?=$row['order_id']?>">
              <td style="vertical-align:middle;"><input class="btn btn-outline-primary" type="submit" name="detail" value="View"></td>
            </form>
            <form action="cancelorder.php" method="POST">
              <input type="hidden" name="orderid" value="<?=$row['order_id']?>">
              <input type="hidden" name="lastpage" value="orderhistory.php">
              <td style="vertical-align:middle;"><input class="btn btn-outline-danger" onclick="return confirm('Do you want to CANCEL this order ?')" type="submit" name="cancel" value="Cancel"
                <?php if($row['order_status']!='UNPAID' && $row['order_status']!='INVALID') echo 'disabled'; ?>>
              </td>
            </form>
          </tr>
      <?php } ?>
    </table><br>
      <a href="account.php" class="btn btn-default" >Go back</a>
      </div>
    </div>
<br>
</body>
</html>
