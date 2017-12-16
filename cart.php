<?php session_start();
$_SESSION['lastpage']="cart.php";
$_SESSION['currentpage']='cart';
require_once("navbar.php");
require_once('connect.php');

   if(isset($_POST['update_price'])){
          foreach($_POST['quantity'] as $key => $val) {
              if($val==0||$val==NULL) {
                  unset($_SESSION['cart'][$key]);
              }else{
                  $_SESSION['cart'][$key]['quantity']=$val;
              }
          }
          header("Location:cart.php");
    }
    if(isset($_POST['clear'])&&$_POST['clear']=='Yes'){
        $_SESSION['cartquantity']=0;
        unset($_SESSION['cart']);
    }
    if(isset($_POST['deleteItem'])){
      $_SESSION['cartquantity']-=$_SESSION['cart'][$_POST['deleteItem']]['quantity'];
      unset($_SESSION['cart'][$_POST['deleteItem']]);
    }

 ?>
<html lang="en">
<head>
  <title>BS Bookstore - Cart</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css">
  <link rel="stylesheet" type="text/css" href="modal.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
  .qty{
    width:20px;
    height:20px;
  }

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
      background-color: #2A2A2A;
      color: #E0E0E0;
      height: 60px;
      padding: 1.5%;
      margin-top:15px;
      /*left:0;
      right:0;
      bottom:0;
      position: absolute;*/
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
      <br><br><br>
      <h1>Your cart</h1><br>
      <div>
		      <div id="content">
		          <?php
              if(!isset($_SESSION['id'])){?>
                  <p>Please log in first.</p>
                  <a href="login.php">Go to log in</a>&nbsp;&nbsp;or&nbsp;&nbsp;<a href="register.php">Register here</a>
              <?php }
          		else if(!isset($_SESSION['cart'])){	?>
              		<p>You don't have anything in your cart.</p>
              		<a href="product.php">Go shopping!</a>
              		<?php
              }

              else if($_SESSION['cart']==NULL){
                  echo "<p>You don't have anything in your cart.</p>";
              		echo '<a href="product.php">Go shopping!</a>';
              }
          		else{?>

                			<table class="table tablecolor table-hover center" style="width:70%;" align="center">
                    			<tr class="info">
                            <!-- <th></th> -->
                    				<th class="text-center" colspan="2">Product</th>
                    				<th class="text-center">Quantity</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Delete</th>
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
                              $totaldistinctproduct=0;?>
                              <form id="normal" action="cart.php" method="POST">
                                <?php
                              while($row=$query->fetch_array()){
                                  $subtotal=$_SESSION['cart'][$row['product_id']]['quantity']*($row['product_price']-($row['product_price']*$row['product_discount']/100));
                                  $totalprice+=$subtotal;
                                  $subquantity=$_SESSION['cart'][$row['product_id']]['quantity'];
                                  $totalquantity+=$subquantity;
                                  $_SESSION['cartquantity']=$totalquantity;
                                  $pid=$row['product_id'];
                                  //$subdistinct=$_SESSION['cart']['product_id'];
                                  //$totaldistinctproduct+=;
                                  ?>
                                  <tr>
                                      <td class="text-center" style="width:100px;">
                                          <img src="img/<?= $row['product_pic'] ?>" style="height:60px;">
                                      </td>
                                      <td class="text-left" style="vertical-align:middle;">
                                        <a href="product_details.php?pid=<?=$pid?>">
                                          <?php echo $row['product_name']; ?>
                                        </a>
                                      </td>
                                      <td class="text-center" style="width:5%;vertical-align:middle;">
                                        <input class="text-center" type="number" style="width: 50px;" min="1" max="<?= $row['quantity']; ?>" name="quantity[<?= $row['product_id'] ?>]" value="<?= $_SESSION['cart'][$row['product_id']]['quantity'] ?>">
                                      </td>
                                      <td class="text-center" style="width:20%;vertical-align:middle;">
                                        <?php echo number_format($_SESSION['cart'][$row['product_id']]['quantity']*($row['product_price']-($row['product_price']*$row['product_discount']/100))) ?> THB
                                      </td>
                                      <td class="text-center" style="width:5%;vertical-align:middle;">
                                        <input type="image" src="img/close_red.png" class="qty" name="deleteItem" value="<?php echo $row['product_id'];?>">
                                      </td>
                                  </tr><?php
                              }
                              if($_SESSION['cartquantity']!=0){
                                  $totalprice+=100;
                              }?>
                			<!-- </table>
                      <table class="table tablecolor table-hover center" style="width:70%;margin-top:-1%;" align="center"> -->
                          <tr>
                              <th class="text-center" colspan="3">Shipping Fee (EMS)</th>
                              <td class="text-center" colspan="2">100 THB</th>
                          </tr>
                          <tr>
                              <th class="text-center" colspan="3">Total Quantity</th>
                              <td class="text-center" colspan="2"><?php echo number_format($totalquantity) ?></th>
                          </tr>
                          <tr>
                              <th class="text-center" colspan="3">Total Amount</th>
                              <td class="text-center" colspan="2"><?php echo number_format($totalprice) ?> THB</th>
                          </tr>
                      </table>
                      <button class="btn-default btn" type="submit" name="update_price">Update Cart</button><br><br>
              		</form>

                  <form action="checkout.php" method="POST" style="margin-right:10px;display:inline-block;">
              		    <input class="btn-success btn" type="submit" name="checkout" value="Proceed to checkout">
              		</form>
                  <!-- ========= Trigger/Open The Modal ================ -->
                  <button id="myBtn" class="btn-danger btn" style="display:inline-block;">Clear the cart</button>
                  <br><br><br><br>
                  <!-- ========================== The Modal ==================================== -->
                  <div id="myModal" class="modal">
                      <!-- Modal content -->
                      <div class="modal-content">
                          <div class="modal-header">
                              <span class="close">&times;</span>
                              <h2>Confirmation</h2>
                          </div>
                          <div class="modal-body">
                              <p>Do you want to clear the cart ?</p>
                          </div>
                          <div class="modal-body">
                              <form action="cart.php" method="POST">
                                  <input class="btn-default btn" style="width:50px;" type="submit" name="clear" value="Yes">
                                  &nbsp;&nbsp;&nbsp;
                                  <input class="btn-default btn" style="width:50px;" type="submit" name="clear" value="No">
                          		</form>
                          </div>
                      </div>
                  </div>
                  <!-- ////////////////////////////// END modal ////////////////////////////////////// -->
          		<?php
          		}?>

	        </div>

      </div>

  </div>
</div>



<script src="modal.js"></script>

</body>
</html>
