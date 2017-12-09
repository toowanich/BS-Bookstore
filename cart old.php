<?php session_start();
$_SESSION['lastpage']="cart.php";
$_SESSION['currentpage']='cart';
require_once("navbar.php");
require_once('connect.php');
if(isset($_POST['checkcart'])){
     header("Location:product.php#".$_POST['checkcart']);
}
if(isset($_SESSION['id'])){
   $findcartid='SELECT cart.cart_id FROM cart
   WHERE cart.user_id='.$_SESSION['id'];

   $res = $mysqli->query($findcartid);
   while ($row = $res->fetch_array())
   {
     $cartid=$row['cart_id'];
   }
}
if(isset($_POST['increase'])){
  $pid=$_POST['increase'];
  $update="SET @op=''; CALL increase_quantity($cartid,$pid,@op); SELECT @op AS 'output';";
  $result = $mysqli->multi_query($update);
  sleep(1);
  if(!$result) {
    echo "Transaction Fail";
  }
  else {
    header("Location:cart.php");
  }
}
if(isset($_POST['decrease'])){
  $pid=$_POST['decrease'];
  $update="SET @op=''; CALL decrease_quantity($cartid,$pid,@op); SELECT @op AS 'output';";
  $result = $mysqli->multi_query($update);
  sleep(1);
  if(!$result) {
    echo "Transaction Fail";
  }
  else {
    header("Location:cart.php");
  }
}
?>
 <html lang="en">
 <head>
   <title>BG Store - Cart</title>
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
   <nav class="navbar navbar-inverse navbar-fixed-top">
     <?php show_navbar(); ?>
   </nav>

 <div class="container-fluid text-center">
   <div class="row content">

       <h1 ><br>Your cart</h1>
       <div>
 		      <div id="content">

<?php
if(isset($_SESSION['id'])){
  ?>
		<form action="cart.php" method="POST">
      <table class="table tablecolor table-hover" style="width:60%;margin-left:20%;">
			<tr>
				<th class="text-center">Name</th>
				<th class="text-center">Quantity</th>
        <th class="text-center">Price</th>
			</tr>
      <?php
      $q='SELECT cart.cart_id,cart.user_id,cart.total_amount,
      cartdetail.product_id,cartdetail.quantity,
      cartdetail.total_price,product.product_name
      FROM cart,cartdetail,product
    WHERE cart.cart_id=cartdetail.cart_id and
    cartdetail.product_id=product.product_id and
    cart.user_id='.$_SESSION['id'];
    $res = $mysqli->query($q);
    while ($row = $res->fetch_array())
    {
    	echo '<tr>';
    	echo '<td>'.$row['product_name'].'</td>';
      //Quantity
      echo '<td class="text-center"><button class="btn-default" type="submit" style="padding: 2px;" name="decrease" value="'.$row['product_id'].'"> - </button>';
      echo '&nbsp;';
      echo $row['quantity'];
      echo '&nbsp;';
      echo '<button class="btn-default" type="submit" style="padding: 2px;" name="increase" value="'.$row['product_id'].'"> + </button></td>';

    	echo '<td class="text-center">'.number_format($row['total_price']).'</td>';
    	echo '</tr>';
      $TOTAL=number_format($row['total_amount']);
    }
      ?>
      <th class="text-center">Total Amount</th>
      <th class="text-center"></th>
<?php
if(isset($TOTAL)) echo '<th class="text-center">'.$TOTAL.'</th>';
else echo '<th class="text-center">0</th>';
?>
		</table>
		<input class="btn-default" type="submit" name="clear" value="Clear the cart">
		</form>
		<hr>
		<form action="checkout.php" method="POST">
		<input class="btn-default" type="submit" name="checkout" value="Proceed to checkout">
		</form>
<?php }
else {
  echo 'Please log in first';
}
?>
</body>
</html>
