<!DOCTYPE html>
<?php session_start();
$_SESSION['currentpage']='account';
$_SESSION['orderadmin']=$_GET['orderadmin'];
$_SESSION['lp']='order_list_history.php?orderadmin='.$_GET['orderadmin'];
require_once("navbar.php");
require_once('connect.php');
if(isset($_POST['account_update'])){
  $id=$_SESSION['id'];
  $fname=$_POST['user_fname'];
  $lname=$_POST['user_lname'];
  $email=$_POST['user_email'];
  $newpw=$_POST['user_newpassword'];
  $q="UPDATE user SET USER_FNAME='$fname', USER_LNAME='$lname',
  USER_EMAIL='$email' WHERE USER_ID='$id'";
  $result = $mysqli->query($q);
  if(isset($_POST['user_newpassword'])){
    $q='UPDATE user SET USER_PASSWORD='.$newpw;
    $result = $mysqli->query($q);
  }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(move_uploaded_file($_FILES["filUpload"]["tmp_name"],"profile/".$_FILES["filUpload"]["name"]))
  {
  echo "Copy/Upload Complete<br>";
  //*** Insert Record ***//
  $strSQL = "UPDATE user SET propic='".$_FILES['filUpload']['name']."' WHERE USER_ID=".$_SESSION['id'];
  $objQuery = $mysqli->query($strSQL);
  }
}
?>

<html lang="en">
<head>
  <title>BG Store - Order</title>
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

<?php
    if($_SESSION['orderadmin']=='unpaid'){
        $q = 'SELECT * FROM orderheader WHERE order_status="PENDING" OR order_status="UNPAID" OR order_status="INVALID" ORDER BY  CASE
        WHEN order_status="PENDING" THEN 1
        WHEN order_status="INVALID" THEN 2
        ELSE 3 END, order_status ASC,order_date DESC,order_time DESC';
        $result = $mysqli->query($q);
        $head = 'Unpaid Orders';
    }
    else if($_SESSION['orderadmin']=='paid'){
        $q = 'SELECT * FROM orderheader WHERE order_status="PAID" OR order_status="SHIPPED" ORDER BY order_status ASC,order_date DESC,order_time DESC';
        $result = $mysqli->query($q);
        $head = 'Paid Orders';
    }
    else if($_SESSION['orderadmin']=='cancel'){
        $q = 'SELECT * FROM orderheader WHERE order_status="CANCELED" ORDER BY order_status ASC,order_date DESC,order_time DESC';
        $result = $mysqli->query($q);
        $head = 'Canceled Orders';
    }
    if($result){
?>
        <br><br><br>
        <div id="edit" class="text-center">
            <h1><?=$head?></h1><br>
        </div>

            <table align="center" class="table table-hover center" style="width:70%;">
                <tr class="info">
                    <th class="text-center">Order No.</th>
                    <th class="text-center">Ordered Date</th>
                    <th class="text-center">Username</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Total amount</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Detais</th>
                </tr>
                <!-- ================= START while ================ -->
                <?php
                while($row=$result->fetch_array()){?>
                      <tr>
                          <td style="vertical-align:middle;" class="text-center"><?= $row['order_id'] ?></td>
                          <td style="vertical-align:middle;" class="text-center">
                            <?php
                            $date=date_create($row['order_date']);
                            echo date_format($date,"Y/m/d").', '.$row['order_time'];
                            ?>
                          </td>
                          <?php
                          $qry = 'SELECT * from user JOIN orderheader
                               WHERE orderheader.user_id = user.USER_ID
                               AND orderheader.user_id='.$row['user_id'];
                          $fetch = $mysqli->query($qry);
                          $uname = $fetch->fetch_array();
                          ?>
                          <td style="vertical-align:middle;" class="text-center"><?= $uname['USER_NAME'] ?></td>
                          <td style="vertical-align:middle;" class="text-center"><?= $row['quantity'] ?></td>
                          <td style="vertical-align:middle;" class="text-center"><?= number_format($row['total_amount']) ?></td>
                          <td style="vertical-align:middle;
                            <?php if($row['order_status']=='PENDING'){echo "color:#0073E1";}
                                  else if($row['order_status']=='PAID'){echo "color:#20CA00;";}
                                  else if($row['order_status']=='SHIPPED'){echo "color:#7A00BF";}
                                  else if($row['order_status']=='CANCELED'){echo "color:#8B8B8B;";}
                                  else{echo "color:red;";}?>"
                                  class="text-center">
                            <?= $row['order_status'] ?>
                          </td>
                          <td class="text-center">
                          <form action="order_list_detail.php" method="POST">
                             <input type="hidden" name="orderid" value="<?=$row['order_id']?>">
                             <input class="btn btn-outline-info" type="submit" name="view" value="view">
                          </form>
                        </td>
                      </tr>
                      <?php
                  }  ////////////////////////////////////////////////// END while //////////////////////
                        ?>
                      </table><br>
                      <div class="container-fluid text-center">
                        <a href="order_list.php" class="btn btn-default" >Go back</a>
                      </div>
        <?php
    }?>

<br>
</body>
</html>
