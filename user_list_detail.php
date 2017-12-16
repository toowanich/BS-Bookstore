<!DOCTYPE html>
<?php session_start();
$_SESSION['currentpage']='account';
$_SESSION['lp']='user_list_detail.php';

require_once("navbar.php");
require_once('connect.php');

if(!isset($_SESSION['keepid'])){
    $_SESSION['keepid']=1;
}

if(isset($_POST['detail'])){
    $_SESSION['keepid']=$_POST['detail'];
}
?>

<html lang="en">
<head>
  <title>BG Store - User List</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css">
  <link rel="stylesheet" href="btnoutline.css" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default rounded borders and increase the bottom margin */
    .navbar {
      margin-bottom: 0;
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


  <!-- =============================== navbar ======================================= -->
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <?php show_navbar(); ?>
  </nav>
    <!-- /////////////////////////////////////////////////////////////////////////// -->


  <div class="container-fluid text-center">
    <!-- ====================================== profile ================================== -->
      <div class="row content">
          <?php
          $id=$_SESSION['keepid'];
          $q="SELECT USER_NAME from user where USER_ID='$id';";
          $res=$mysqli->query($q);
          $row=$res->fetch_array()
           ?>
          <br><br><br>
          <h2>User :&nbsp;<?=$row['USER_NAME']?></h2>
          <?php
          $q="SELECT propic from user where USER_ID='$id';";
          $res=$mysqli->query($q);
          $row=$res->fetch_array()
           ?>
          <img src="profile/<?=$row['propic'] ?>" alt="<?=$row['propic'] ?>" style="width:150px;height:150px;border-radius: 50%;">

          <?php
          $q='SELECT * FROM user WHERE user.USER_ID='.$id;
          $res=$mysqli->query($q);
          $row=$res->fetch_array();
          ?>
          <br><br>
          <p class="margin-top:20%;"><labeL>Name:</label> <?= $row['USER_FNAME'].' '.$row['USER_LNAME'] ?> </p>
          <p><label>E-mail:</label> <?= $row['USER_EMAIL'] ?></p>
          <!-- <a href="account_edit.php">Edit</a> -->
      </div>
      <!-- ////////////////////////////////// END profile ////////////////////////////////// -->
      <!-- ================================= order history ================================== -->
      <div>
        <h2>Order History</h2>
        <table class="table table-hover" style="width:60%;" align="center">
          <tr class="info">
            <th class="text-center">Order No.</th>
            <th class="text-center">Order Date</th>
            <th class="text-center">Confirmed Date</th>
            <th class="text-center">Quantity</th>
            <th class="text-center">Total amount</th>
            <th class="text-center">Status</th>
            <th class="text-center">Details</th>
          </tr>
        <?php
          $q='SELECT * FROM orderheader WHERE orderheader.user_id='.$_SESSION['keepid'].' ORDER BY order_date DESC,order_time DESC';
          $res=$mysqli->query($q);
          while ($row=$res->fetch_array()) {
            $orderid=$row['order_id'];
            $_SESSION['orderid']=$orderid;
         ?>
          <tr >
            <td style="vertical-align:middle;" class="text-center"><?= $row['order_id'] ?></td>
            <td style="vertical-align:middle;" class="text-center">
            <?php
            $date=date_create($row['order_date']);
            echo date_format($date,"Y/m/d").', '.$row['order_time'];
            ?>
            </td>
            <td style="vertical-align:middle;" class="text-center">
              <?php $date=date_create($row['confirm_date']);
              echo date_format($date,"Y/m/d, H:i:s"); ?>
            </td>
            <td style="vertical-align:middle;" class="text-center"><?= $row['quantity'] ?></td>
            <td style="vertical-align:middle;" class="text-center"><?= number_format($row['total_amount']) ?></td>
            <td style="vertical-align:middle;
              <?php if($row['order_status']=='PAID'){echo "color:#20CA00;";}
                    else if($row['order_status']=='CANCELED'){echo "color:#8B8B8B;";}
                    else if($row['order_status']=='SHIPPED'){echo "color:#7A00BF;";}
                    else if($row['order_status']=='PENDING'){echo "color:#0073E1;";}
                    else{echo "color:red;";}?>"
                    class="text-center">
              <?= $row['order_status'] ?>
            </td>
            <form action="order_list_detail.php" method="POST">
              <input type="hidden" name="orderid" value="<?=$row['order_id']?>">
              <td style="vertical-align:middle;"><input class="btn btn-outline-primary" type="submit" name="detail" value="View"></td>
            </form>
            <!-- <form action="cancelorder.php" method="POST">
              <input type="hidden" name="lastpage" value="account.php">
              <td style="vertical-align:middle;"><input class="btn btn-outline-danger" type="submit" name="cancel" value="Cancel"
                <?php if($row['order_status']!='UNPAID') echo 'disabled'; ?>>
              </td>
            </form> -->
          </tr>
      <?php }?>

      </table>
        <a href="user_list.php" class="btn btn-default" >Go back</a>
      </div>
      <!-- ////////////////////////////////// END order history ////////////////////////////////// -->
      <br>
  </div>
<!-- <div style="margin-left:4%;margin-top:3%;">
  <h3>BG Store</h3>
  <p>Tel: 081-2345678<br>Facebook Page: BG Store: Board Game Cafe<br>Line ID: BGStore</p>
</div> -->
</body>
</html>
