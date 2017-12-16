<!DOCTYPE html>
<?php session_start();
$_SESSION['currentpage']='account';
$_SESSION['lp']='account.php';
require_once("navbar.php");
require_once('connect.php');

// ========================================= Edit account ===============================
if(isset($_POST['account_update'])){
    $id=$_SESSION['id'];
    $fname=$_POST['user_fname'];
    $lname=$_POST['user_lname'];
    $email=$_POST['user_email'];

    $qr = "SELECT * FROM user WHERE USER_ID =".$_SESSION['id'];
    $checkuser = $mysqli->query($qr);
    $row = $checkuser->fetch_array();
    if($_POST['user_currentpassword']==$row['USER_PASSWORD']){
        if(isset($_POST['user_newpassword']) && $_POST['user_newpassword']!=""){
          $newpw=$_POST['user_newpassword'];
          $q="UPDATE user SET USER_PASSWORD='$newpw' WHERE USER_ID='$id'";
          $result = $mysqli->query($q);
        }
        $q="UPDATE user SET USER_FNAME='$fname', USER_LNAME='$lname',
        USER_EMAIL='$email' WHERE USER_ID='$id'";
        $result = $mysqli->query($q);
    }else{
        $_SESSION['currentpwdcheck'] = '1';
        header("Location:account_edit.php");
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(move_uploaded_file($_FILES["filUpload"]["tmp_name"],"profile/".$_SESSION['id'].$_FILES["filUpload"]["name"]))
  {
  echo "Copy/Upload Complete<br>";
  //*** Insert Record ***//
  $strSQL = "UPDATE user SET propic='".$_SESSION['id'].$_FILES['filUpload']['name']."' WHERE USER_ID=".$_SESSION['id'];
  $objQuery = $mysqli->query($strSQL);
  }
}

/////////////////////////////////////////// END edit account ///////////////////////////////////////


?>

<html lang="en">
<head>
  <title>BS Bookstore - Account</title>
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
          <br><br><br>
          <h2>My Account</h2>
          <?php
          $id=$_SESSION['id'];
          $q="SELECT propic from user where USER_ID='$id';";
          $res=$mysqli->query($q);
          $row=$res->fetch_array()
           ?>
          <img src="profile/<?=$row['propic'] ?>" alt="<?=$row['propic'] ?>" style="width:150px;height:150px;border-radius: 50%;">

          <?php
          $q='SELECT * FROM user WHERE user.USER_ID='.$_SESSION['id'];
          $res=$mysqli->query($q);
          $row=$res->fetch_array();
          ?>
          <br><br>

          <p class="margin-top:20%;">Name: <?= $row['USER_FNAME'].' '.$row['USER_LNAME'] ?> </p>
          <p>E-mail: <?= $row['USER_EMAIL'] ?></p>
          <a href="account_edit.php">Edit profile</a><br><br>
          <h1>Addresses</h1>
          <?php
          $i=1;
          $addrchoice="SELECT * FROM address WHERE user_id=".$_SESSION['id'];
          $result=$mysqli->query($addrchoice);
          while ($row=$result->fetch_array()){
            if($row['address_details']!=""){
           ?>
           <p>Address<?=$i?>: <?=$row['address_details']?><br><p>

         <?php }
         $i+=1;
       }
       ?>
       <a href="address.php">Edit address</a><br>
      </div>
      <!-- ////////////////////////////////// END profile ////////////////////////////////// -->
      <!-- ================================= order history ================================== -->
      <div>
        <?php
          $qc='SELECT * FROM orderheader WHERE orderheader.user_id='.$_SESSION['id'];
          $resc=$mysqli->query($qc);
          $numrow = $resc->num_rows;
          ?>
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
          $q='SELECT * FROM orderheader WHERE orderheader.user_id='.$_SESSION['id'].' ORDER BY order_date DESC,order_time DESC LIMIT 3';
          $res=$mysqli->query($q);
          while ($row=$res->fetch_array()) {
            $orderid=$row['order_id'];

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
                    else if($row['order_status']=='CANCELED'){echo "color:#8B8B8B;";}
                    else if($row['order_status']=='SHIPPED'){echo "color:#7A00BF;";}
                    else if($row['order_status']=='PENDING'){echo "color:#0073E1;";}
                    else{echo "color:red;";}?>"
                    class="text-center">
              <?= $row['order_status'] ?>
            </td>
            <form action="orderdetail.php" method="POST">
              <input type="hidden" name="orderid" value="<?=$row['order_id']?>">
              <td style="vertical-align:middle;"><input class="btn btn-outline-primary" type="submit" name="detail" value="View"></td>
            </form>
            <form action="cancelorder.php" method="POST">
              <input type="hidden" name="lastpage" value="account.php">
              <input type="hidden" name="orderid" value="<?=$row['order_id']?>">
              <td style="vertical-align:middle;"><input class="btn btn-outline-danger" onclick="return confirm('Do you want to CANCEL this order ?')" type="submit" name="cancel" value="Cancel"
                <?php if($row['order_status']!='UNPAID' && $row['order_status']!='INVALID') echo 'disabled'; ?>>
              </td>
            </form>
          </tr>
      <?php }
      if($numrow>3){ ?>
      <tr>
        <td colspan="7" class="text-center"><a href="orderhistory.php">view all</a></td>
      </tr>
    <?php } ?>
      </table>
      </div>
      <!-- ////////////////////////////////// END order history ////////////////////////////////// -->
      <br>
  </div>
<!-- <div style="margin-left:4%;margin-top:3%;">
  <h3>BS Bookstore</h3>
  <p>Tel: 081-2345678<br>Facebook Page: BS Bookstore: Board Game Cafe<br>Line ID: BGStore</p>
</div> -->
</body>
</html>
