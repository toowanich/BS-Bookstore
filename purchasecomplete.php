UNPAID<!DOCTYPE html>
<?php session_start();
require_once("navbar.php");
require_once('connect.php');
$_SESSION['cartquantity'] = 0;
?>
<html lang="en">
<head>
  <title>BG Store - Purchase completed</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }

    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}

    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }

    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: #E0E0E0;
      padding: 1.5%;
      /*position: absolute;*/
      left:0;
      right:0;
      bottom:0;
    }

    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;}
    }
	body{
	font-family: sans-serif;
}
.sidenav{
	background-color:white;
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
  <div class="row content">
    <!-- <div class="col-sm-2 sidenav">
    </div> -->
    <?php
    $sql="SELECT * FROM product WHERE product_id IN (";
                foreach($_SESSION['cart'] as $id => $value) {
                    $sql.=$id.",";
                }
                $sql=substr($sql, 0, -1).") ORDER BY product_name ASC";
                $query=$mysqli->query($sql);
                $quantitycheck=true;
                while($row=$query->fetch_array()){
                      if($_SESSION['cart'][$row['product_id']]['quantity']>$row['quantity']) {
                        $quantitycheck=false;
                      }
                }
    if($quantitycheck==true){
    ?>
    <br>
      <h1><br>Your purchase is completed!</h1>
  	  <p>Your products will be arrived within 2 days after payment confirmation</p>
      <br>
        <?php
          if($_POST['address']!=""){
            $q="INSERT INTO `orderheader`(`user_id`, `quantity`, `total_amount`, `order_date`, `order_time`,`to_address`, `order_status`)
            VALUES (".$_SESSION['id'].",".$_POST['tq'].",".$_POST['tp'].",curdate(),curtime(),'".$_POST['address']."','UNPAID')";
          }
          else {
            $q="INSERT INTO `orderheader`(`user_id`, `quantity`, `total_amount`, `order_date`, `order_time`,`to_address`, `order_status`)
            VALUES (".$_SESSION['id'].",".$_POST['tq'].",".$_POST['tp'].",curdate(),curtime(),'".$_POST['savedAddress']."','UNPAID')";
          }
          $res=$mysqli->query($q);
          $findorderid='SELECT orderheader.order_id FROM orderheader
          WHERE orderheader.user_id='.$_SESSION['id'].' ORDER BY orderheader.order_date DESC,orderheader.order_time DESC';
          $res = $mysqli->query($findorderid);
          $row = $res->fetch_array();
          $orderid=$row['order_id'];
            $sql="SELECT * FROM product WHERE product_id IN (";
              foreach($_SESSION['cart'] as $id => $value) {
                  $sql.=$id.",";
              }
          $sql=substr($sql, 0, -1).") ORDER BY product_name ASC";
          $query=$mysqli->query($sql);
          while($row=$query->fetch_array()){
              $q='INSERT INTO `orderdetail`(`order_id`, `product_id`, `quantity`, `total_price`)
              VALUES ('.$orderid.','.$row['product_id'].','.$_SESSION['cart'][$row['product_id']]['quantity'].','.
              $_SESSION['cart'][$row['product_id']]['quantity']*($row['product_price']-($row['product_price']*$row['product_discount']/100)).')';
              $res=$mysqli->query($q);
          }
          $q="SELECT * FROM user JOIN orderheader WHERE user.user_id = orderheader.user_id AND orderheader.order_id=".$orderid;
          $res=$mysqli->query($q);
          if($res!=null){
            $row=$res->fetch_array();
            ?>
            <h1>Order Information:</h1>
            <table class="table" align="center" style="width:60%;margin-left:20%;">
              <tr>
                <td class="text-left" colspan="2">Order No.<?php echo $row['order_id']; ?></td>
                <td class="text-left" colspan="2">Order date: <?php echo $row['order_date']; ?></td>
              </tr>
              <tr>
                <td class="text-left" colspan="2">Your name: <?php echo $row['USER_FNAME'].' '.$row['USER_LNAME']; ?></td>
                <td class="text-left" colspan="2">Order time: <?php echo $row['order_time']; ?></td>
              </tr>
              <tr>
                <td class="text-left" colspan="2">Quantity: <?php echo $row['quantity']; ?></td>
                <td class="text-left" colspan="2">Address: <?php echo $row['to_address']; ?></td>
              </tr>
              <tr>
                <td class="text-left" colspan="2">Total amount: <?php echo number_format($row['total_amount']); ?></td>
                <td class="text-left" colspan="2">Order status: <?php echo $row['order_status']; ?></td>
              </tr>
            </table>
            <table class="table tablecolor table-hover" style="width:60%;margin-left:20%;">
      			<tr class="info">
      				<th class="text-center" colspan="2">Name</th>
      				<th class="text-center">Quantity</th>
      				<th class="text-center">Price</th>
      			</tr>
            <?php
              $q='SELECT product_name,orderdetail.quantity,total_price,product_pic FROM orderdetail JOIN product WHERE orderdetail.product_id=product.product_id AND orderdetail.order_id='.$orderid;
              $res=$mysqli->query($q);
              while($row=$res->fetch_array()){
                ?>
                <tr>
                  <td class="text-center" style="width:120px;"><img src="img/<?= $row['product_pic'] ?>" style="height:60px;"></td>
                  <td class="text-left" style="vertical-align:middle;"><?php echo $row['product_name'] ?></td>
                  <td class="text-center" style="vertical-align:middle;"><?php echo $row['quantity'] ?></td>
                  <td class="text-center" style="vertical-align:middle;"><?php echo $row['total_price'] ?></td>
                </tr>
              <?php
              }
              $q='select * from orderheader where order_id='.$orderid;
              $res=$mysqli->query($q);
              $row=$res->fetch_array();
              ?>
              <tr>
                <th class="text-center" colspan="2">Shipping Fee(EMS)</th>
                <!-- <th></th> -->
                <th class="text-center" colspan="2">100 THB</th>
              </tr>
              <tr>
                <th class="text-center" colspan="2">Total Quantity</th>
                <!-- <th></th> -->
                <th class="text-center" colspan="2"><?php echo number_format($row['quantity']); ?></th>
              </tr>
              <tr>
                  <th class="text-center" colspan="2">Total Amount</th>
                  <!-- <th></th> -->
                  <th class="text-center" colspan="2"><?php echo number_format($row['total_amount']); ?> THB</th>
              </tr>
            </table>
              <form id="toorderdetail" action="orderdetail.php" method="POST">
                  <input type="hidden" name="orderid" value="<?=$orderid?>">
                  <input type="hidden" name="frompurchase" value="1">
              </form>
              <a href="javascript:{}" onclick="document.getElementById('toorderdetail').submit();">Upload your payment receipt</a>
              <br><br>
              <a href="index.php">Return to Home</a>
              <br>
            <?php
          }
          else{
            echo "Failed";
          }
         ?>
<?php $_SESSION['cart']=NULL;
}
else{
  echo '<p>Some products in your cart have quantity exceeded those in our stock.</p>';
  echo '<a href="checkout">Go back to Checkout page.</a>';
}
?>

<br><br><br>

    </div>

  </div>


</body>
</html>
