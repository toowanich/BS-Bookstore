<?php session_start();
// $_SESSION['lastpage']="cart.php";
$_SESSION['currentpage']='account';
require_once("navbar.php");
require_once('connect.php');

// ================================= remove from wishlist =================================
if(isset($_POST['remove'])){
    $qr = 'DELETE FROM wishlist WHERE product_id='.$_POST['remove'].' AND user_id='.$_SESSION['id'];
    $remove = $mysqli->query($qr);
}

// ======================== ADD to Cart ==================================
if(isset($_POST['addToCart'])){
    if($_SESSION['logstat']=='Log In'){
        header("Location:cart.php");
    }else{
        $id=$_POST['addToCart'];

        if(isset($_SESSION['cart'][$id])){
            $_SESSION['cart'][$id]['quantity']++;
            $_SESSION['cartquantity']++;
        }else{
            $sql_s="SELECT * FROM product
                WHERE product_id=$id";
            $query_s=$mysqli->query($sql_s);
            if($query_s!=null){
                $row_s=$query_s->fetch_array();
                $_SESSION['cart'][$row_s['product_id']]=array(
                        "quantity" => 1,
                        "price" => $row_s['product_price']
                    );
                $_SESSION['cartquantity']++;
            }else{
                $message="This product id it's invalid!";
            }
        }
    }
}
// //////////////////////////////////////////////////////////////////////////
////////////////////////////////// END remove from wishlist ////////////////////////////////
 ?>
<html lang="en">
<head>
  <title>BG Store - Wishlist</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css">
  <link rel="stylesheet" href="btnoutline.css" type="text/css">
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
      <h1>Your Wishlist</h1><br>
      <div>
		      <div id="content">
                			<table class="table tablecolor table-hover center" style="width:70%;" align="center">
                    			<tr class="info">
                    				<th class="text-center" colspan="2">Product</th>
                            <th class="text-center">Price</th>
                            <th class="text-center"></th>
                            <th class="text-center">Remove</th>
                    			</tr>
                			    <?php
                              $q = 'SELECT wishlist.product_id,product.product_discount,product.product_name,product.product_pic,product.product_price
                                    FROM product JOIN wishlist WHERE wishlist.product_id = product.product_id AND wishlist.user_id='.$_SESSION['id'];
                              $wishlist = $mysqli->query($q);
                              // $check = $mysqli->query($q);
                              if($wishlist){
                                  while($row=$wishlist->fetch_array()){
                                      if($row['product_discount']!=0){
                                          $pprice = ((100-$row['product_discount'])/100)*$row['product_price'];
                                      }else{
                                          $pprice = $row['product_price'];
                                      }
                                      ?>
                                      <tr>
                                          <td class="text-center" style="width:100px;">
                                              <img src="img/<?= $row['product_pic'] ?>" style="height:60px;">
                                          </td>
                                          <td class="text-left" style="vertical-align:middle;">
                                            <form id="detail_form<?=$row['product_id']?>" target="_blank" action="product_details.php" method="get">
                                              <input type="hidden" form="detail_form<?=$row['product_id']?>" name="pid" value="<?=$row['product_id']?>">
                                            </form>
                                            <a href="javascript:{}" onclick="document.getElementById('detail_form<?=$row['product_id']?>').submit(); return false;">
                                            <?php echo $row['product_name']; ?></a></td>
                                          <td class="text-center" style="width:15%;vertical-align:middle;">
                                            <?php if($row['product_discount']!=0){echo '<strike style="color:#C5C5C5;">'.number_format($row['product_price']).' THB</strike><br>';} ?>
                                            <?php echo number_format($pprice) ?> THB
                                          </td>
                                          <form action="account_wishlist.php" method="POST">
                                          <td class="text-center" style="width:15%;vertical-align:middle;">
                                                  <button class="glyphicon glyphicon-shopping-cart btn btn-outline-dark btn-sm" type="submit" name="addToCart" value="<?= $row['product_id']?>">
                                                      <span style="font-family:sans-serif;margin-left:-10px;">Add to cart</span>
                                                  </button>
                                          </td>
                                        </form>
                                        <form action="account_wishlist.php" method="POST">
                                          <td class="text-center" style="width:10%;vertical-align:middle;">
                                                  <button type="submit" style="background-color:transparent;border:none;" name="remove" value="<?= $row['product_id']?>">
                                                      <img src="img/close_red.png" style="height:20px;">
                                                  </button>
                                          </td>
                                        </form>
                                      </tr><?php
                                  }
                              }?>

	        </div>

      </div>

  </div>
</div>



<script src="modal.js"></script>

</body>
</html>
