<!DOCTYPE html>
<?php session_start();
$_SESSION['currentpage']='account';
require_once("navbar.php");
require_once('connect.php');
if(isset($_POST['frompurchase'])){
    $_SESSION['lp']='account.php';
}
?>

<html lang="en">
<head>
  <title>BS Bookstore - Order</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css">
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
        <h1>Order Information</h1><br>
        <?php
        if(isset($_POST['orderid'])){
          $_SESSION['orderid']=$_POST['orderid'];
        }
        $orderid=$_SESSION['orderid'];
        $id=$_SESSION['id'];
        $q="SELECT * FROM user JOIN orderheader WHERE user.user_id = orderheader.user_id AND orderheader.order_id=".$orderid;
        $res=$mysqli->query($q);
          $row=$res->fetch_array()
          ?>
          <table class="table" align="center" style="width:60%;margin-left:20%;">
            <tr>
              <td class="text-left" colspan="2"><label>Order No.&nbsp;<?php echo $row['order_id']; ?></label></td>
              <td class="text-left" colspan="2"><label>Order date:&nbsp;</label><?php echo $row['order_date']; ?></td>
            </tr>
            <tr>
              <td class="text-left" colspan="2"><label>Your name:&nbsp;</label><?php echo $row['USER_FNAME'].' '.$row['USER_LNAME']; ?></td>
              <td class="text-left" colspan="2"><label>Order time:&nbsp;</label><?php echo $row['order_time']; ?></td>
            </tr>
            <tr>
              <td class="text-left" colspan="2"><label>Quantity:&nbsp;</label><?php echo $row['quantity']; ?></td>
              <td class="text-left" colspan="2"><label>Address:&nbsp;</label><?php echo $row['to_address']; ?></td>
            </tr>
            <tr>
              <td class="text-left" colspan="2"><label>Total amount:&nbsp;</label><?php echo number_format($row['total_amount']); ?>&nbsp;THB</td>
              <td class="text-left" style="<?php if($row['order_status']=='PAID'){echo "color:#20CA00;";}
                    if($row['order_status']=='PAID'){echo "color:#20CA00;";}
                    else if($row['order_status']=='SHIPPED'){echo "color:#7A00BF;";}
                    else if($row['order_status']=='PENDING'){echo "color:#0073E1";}
                    else if($row['order_status']=='CANCELED'){echo "color:#8B8B8B;";}
                    else{echo "color:red;";}?>" colspan="2"><label>Order status:&nbsp;</label><?php echo $row['order_status']; ?></td>
            </tr>
          </table>

          <table class="table tablecolor table-hover" style="width:60%;margin-left:20%;">
          <tr class="info">
            <th class="text-center" colspan="2">Name</th>
            <th class="text-center">Quantity</th>
            <th class="text-center">Price</th>
          </tr>
          <?php
          $qq='SELECT product_name,orderdetail.quantity,total_price,product_pic FROM orderdetail JOIN product WHERE orderdetail.product_id=product.product_id AND orderdetail.order_id='.$orderid;
          $ress=$mysqli->query($qq);
          while($roww=$ress->fetch_array()){
            ?>
            <tr >
              <td class="text-center" style="width:100px;">
                  <img src="img/<?= $roww['product_pic'] ?>" style="height:60px;">
              </td>
              <td style="vertical-align:middle;" class="text-left"><?php echo $roww['product_name'] ?></td>
              <td style="vertical-align:middle;" ><?php echo $roww['quantity'] ?></td>
              <td style="vertical-align:middle;" ><?php echo number_format($roww['total_price']) ?></td>
            </tr>
          <?php
          }
          $qss='select * from orderheader where order_id='.$orderid;
          $resss=$mysqli->query($qss);
          $rowss=$resss->fetch_array();
          ?>
          <tr>
              <th class="text-center" colspan="2">Shipping Fee (EMS)</th>
              <th class="text-center" colspan="3">100 THB</th>
          </tr>
          <tr>
            <th class="text-center" colspan="2" >Total Quantity</th>
            <!-- <th></th> -->
            <th class="text-center" colspan="3"><?php echo number_format($rowss['quantity']); ?></th>
          </tr>
          <tr>
              <th class="text-center" colspan="2" >Total Amount</th>
              <!-- <th></th> -->
              <th class="text-center" colspan="3"><?php echo number_format($rowss['total_amount']); ?> THB</th>
          </tr>
        </table>

        <p>Your payment receipt: </p>
        <?php if($row['order_status']=='INVALID'){
            echo "<span style='color:red;'> The receipt is invalid. Please re-upload  the valid one or contact us.</span><br>";
        } ?>
        <img src="payment/<?=$row['payment'] ?>" alt="<?=$row['payment'] ?>" style="height:300px;"><br><br>
        <?php
        if($rowss['order_status']!='PAID' && $rowss['order_status']!='SHIPPED' && $rowss['order_status']!='CANCELED'){ ?>
            <form action="uploadpaymentcheck.php" method="POST" enctype="multipart/form-data">

                Upload your payment receipt: <input type="file" name="payUpload" style="display: inline-block;"><br><br>
                <input type="hidden" name="orderid" value="<?=$orderid?>">
                <input type="submit" class="btn btn-success" name="payment" value="Submit">
                <a href="<?=$_SESSION['lp']?>" class="btn btn-default" >Go back</a>
            </form>
      <?php } ?>
      </div>
      <br><br>
    </div>

</body>

</html>
