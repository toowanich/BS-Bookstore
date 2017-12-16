<!DOCTYPE html>
<?php session_start();
require_once("navbar.php");
require_once('connect.php');
?>
<html lang="en">
<head>
  <title>BS Bookstore - Checkout</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css">
  <link rel="stylesheet" href="/vendor/bootstrap-combobox/css/bootstrap-combobox.css">
  <script src="/vendor/bootstrap-combobox/js/bootstrap-combobox.js"></script>
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
      <h1 ><br>Checkout</h1>
      <div>
		      <div id="content">

      <table class="table tablecolor table-hover" style="width:50%;font-size:16px;" align="center">
			<tr class="info">
				<th class="text-center" colspan="2">Product</th>
				<th class="text-center">Quantity</th>
				<th class="text-center">Price</th>

			</tr>
      <?php
      $sql="SELECT * FROM product WHERE product_id IN (";

                  foreach($_SESSION['cart'] as $id => $value) {
                      $sql.=$id.",";
                  }
                  $sql=substr($sql, 0, -1).") ORDER BY product_name ASC";
                  $query=$mysqli->query($sql);
                  $totalprice=0;
                  $totalquantity=0;
                  $totaldistinctproduct=0;
                  $quantitycheck=true;
                  while($row=$query->fetch_array()){
                      $subtotal=$_SESSION['cart'][$row['product_id']]['quantity']*($row['product_price']-($row['product_price']*$row['product_discount']/100));
                      $totalprice+=$subtotal;
                      $subquantity=$_SESSION['cart'][$row['product_id']]['quantity'];
                      $totalquantity+=$subquantity;
                      //$subdistinct=$_SESSION['cart']['product_id'];
                      //$totaldistinctproduct+=;
                      if($_SESSION['cart'][$row['product_id']]['quantity']>$row['quantity']) {
                        $quantitycheck=false;
                      }
                  ?>
                      <tr <?php if($quantitycheck==false) echo 'style="background:rgba(255, 213, 213,.4);"'; ?>>
                          <td class="text-center" style="width:100px;">
                              <img src="img/<?= $row['product_pic'] ?>" style="height:60px;">
                          </td>
                          <td class="text-left" style="vertical-align:middle;">
                            <?php echo $row['product_name'] ?>
                            <?php if($quantitycheck==false) echo '<br>Only '.$row['quantity'].' "'.$row['product_name'].'" left.'; ?>
                          </td>
                          <td class="text-center" style="vertical-align:middle;"><?php echo $_SESSION['cart'][$row['product_id']]['quantity'] ?></td>
                          <!--
                          <td><?php echo $row['product_price'] ?>$</td>
                          -->
                          <td class="text-center" style="vertical-align:middle;"><?php echo number_format($_SESSION['cart'][$row['product_id']]['quantity']*($row['product_price']-($row['product_price']*$row['product_discount']/100))) ?> THB</td>


                      </tr>

                  <?php
                  }
                  if($_SESSION['cartquantity']!=0){
                      $totalprice+=100;
                  }?>

      <tr>
          <th class="text-center" colspan="2">Shipping Fee (EMS)</th>
          <th class="text-center" colspan="3">100 THB</th>
      </tr>
      <tr>
        <th class="text-center" colspan="2">Total Quantity</th>
        <th class="text-center" colspan="2"><?php echo number_format($totalquantity) ?></th>
      </tr>
      <tr>
          <th class="text-center" colspan="2">Total Amount</th>
          <th class="text-center" colspan="2"><?php echo number_format($totalprice) ?> THB</th>
      </tr>
		</table>
    <?php
      if($quantitycheck==true){
     ?>
		<form action="purchasecomplete.php" method="POST" id="purchase">
      <?php
      $check=false;
      $addrchoice="SELECT * FROM address WHERE user_id=".$_SESSION['id'];
      $result=$mysqli->query($addrchoice);
      while ($row=$result->fetch_array()){
        if($row['address_details']!=""){
          $check=true;
        }
      }
      if($check==true){
       ?>
    <table align="center">
      <tr>
          <td>Saved address:&nbsp;</td>
          <td><select name="savedAddress" class="form-control" form="purchase">
          <?php
          $addrchoice="SELECT * FROM address WHERE user_id=".$_SESSION['id'];
          $result=$mysqli->query($addrchoice);
          while ($row=$result->fetch_array()){
            if($row['address_details']!=""){?>
              <option value="<?=$row['address_details']?>"><?=$row['address_details']?></option>
        <?php  }
        } ?>
      </select></td>
    </tr>
    <tr>
      <td colspan="2">Or</td>
    </tr>
    <tr>
      <td>New address:&nbsp;</td>
          <td><textarea rows="4" cols="40" style="resize:vertical;" class="form-control" id="comment" name="address" placeholder="Don't fill in this area if you want to use your saved address..." form="purchase"></textarea></td>
      </tr>
    </table>
  <?php }
  else { ?>
    <table align="center">
      <tr>
        <td>Your address:&nbsp;</td>
            <td><textarea rows="4" cols="40" style="resize:vertical;" class="form-control" id="comment" name="address" placeholder="Please enter your address here..." form="purchase" required></textarea></td>
        </tr>
      </table>
    <?php } ?>
      <br>
      <input type="hidden" name="tq" value="<?php echo $totalquantity; ?>">
      <input type="hidden" name="tp" value="<?php echo $totalprice; ?>">
		  <input type="submit" class="btn btn-success" name="confirm" value="Confirm purchase">
      <a href="cart.php" class="btn btn-default">Cancel</a>
		</form><?php }
    else if ($quantitycheck==false) {
      ?>
      <p>Your cart have some products more than we have. Please go back and edit your cart<p>
      <a href="cart.php" class="btn btn-default">Cancel</a>
    <?php } ?>
    </div>

  </div>
</div>
<br><br>
<!--
<footer class="container-fluid text-center">
  <p>BS Bookstore</p>
</footer>
-->
</body>
</html>
