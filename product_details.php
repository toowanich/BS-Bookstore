<!DOCTYPE html>
<?php
  session_start();
  $_SESSION['lastpage']="product.php";
  $_SESSION['currentpage']='product';
  require_once("connect.php");
  require_once("navbar.php");
  // ======================== ADD to Cart ==================================
  if(isset($_GET['addToCart'])){
      if($_SESSION['logstat']=='Log In'){
          header("Location:cart.php");
      }else{
          $id=$_GET['addToCart'];

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
  // ========================================== ADD to wishlist =================================
  if(isset($_POST['addwishlist'])){
      $qry = 'INSERT INTO wishlist(user_id,product_id) VALUES('.$_SESSION["id"].','.$_POST['addwishlist'].')';
      $addwish = $mysqli->query($qry);
  }
  ///////////////////////////////////// END add wishlist ////////////////////////////////////////

  // ========================================== REMOVE to wishlist =================================
  if(isset($_POST['removewishlist'])){
      $qry = 'DELETE FROM wishlist WHERE product_id='.$_POST['removewishlist'].' AND user_id='.$_SESSION['id'];
      $removewish = $mysqli->query($qry);
  }
  ///////////////////////////////////// END remove wishlist ////////////////////////////////////////

?>
<?php if( $_GET["pid"]){
  $pid=$_GET["pid"];
  $q="SELECT * FROM product WHERE product_id='$pid'";
  $res=$mysqli->query($q);
  $row=$res->fetch_array();
  $pname=$row['product_name'];
  $pprice=$row['product_price'];
  $tag=$row['product_tag'];
  $quantity=$row['quantity'];
  $pdes=$row['description'];
  $img=$row['product_pic'];
  $authorid=$row['author_id'];
?>
<html lang="en">
<head>
  <title>BG Store - <?=$pname?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css">
  <link rel="stylesheet" href="btnoutline.css" type="text/css">
  <!-- <link rel="stylesheet" type="text/css" href="slideshow.css"> -->
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
      /*position: absolute;*/
      left:0;
      right:0;
      bottom:0;
    }

    .panel{
      background-color:transparent ;
      /*border-width:1.5px;*/
      border:none;
      box-shadow:0 0 0 0 rgba(0,0,0,0);
    }

    .panel-footer{
      background-color: transparent;
      border:none;
    }

    #spromotion,#npromotion{
      border-bottom-left-radius: 8px;
      border-bottom-right-radius: 8px;
      border-top-left-radius: 8px;
      border-top-right-radius: 8px;
      padding-left:2%;
      height:52px;
      /*background-color:#4E3535;*/
      margin-bottom:2%;;
      margin-left:5%;
      margin-right:5%;
    }

    body {
        /*font-family: 'Poppins', sans-serif;*/
        background: #fafafa;
    }


  </style>
</head>
<body>

<!-- =============================== navbar ======================================= -->
<nav class="navbar navbar-inverse navbar-fixed-top">
  <?php show_navbar(); ?>
</nav>
  <!-- /////////////////////////// END navbar /////////////////////////////////// -->


</head>
<body>

  <!-- ================================= START description ============================== -->
    <div class="container">
    <div class="row">
      <br><br><br><br>
      <!-- blank -->
      <div class="col-sm-1 text-right"></div>
      <!-- image -->
      <div class="col-sm-4 text-right"><br>
        <img src="img/<?=$img?>" alt="<?=$pname?>" style="width: 350px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);text-align: center;">
      </div>
      <!-- blank -->
      <div class="col-sm-1 text-right"></div>
      <!-- details -->
      <div class="col-sm-5 text-left">
        <h1><?=$pname?></h1>
        <p><b>Tag: </b><?=$tag?></p>
        <?php
        if($quantity<=20 && $quantity>0){
        ?>
        <p style="color:orange;">Only <?=$quantity?> left in stock. Order soon!</p>
      <?php }
      else if($quantity==0){ ?>
        <p style="color:red;">Out of stock.</p>
      <?php }
      else { ?>
        <p><?=$quantity?> left in stock.</p>
      <?php }
       ?>
        <details open>
        <summary><b>Description:</b> </summary>
        <p style="text-align:justify;"><?=$row['description']?></p>
      </details><br>
      <?php
          if($row['product_discount']!= 0){
            echo '<strike style="color:#C5C5C5;">';
          }
      ?>
      <?= '<b>Price:</b> '.number_format($row['product_price']).' THB' ?>
      <?php
          if($row['product_discount']!= 0){
            echo '</strike><br>';
          }
      ?>
      <?php
      if($row['product_discount']!= 0){
        $dis_price = $row['product_price']*((100-$row['product_discount'])/100);
        echo '<b>Price:</b> '.number_format($dis_price).' THB';
      }
      ?><br><br>

      <!-- ============================= wishlist button ================================== -->
      <?php
      if($_SESSION['logstat']=='Log Out'){
          $query = 'SELECT * FROM wishlist WHERE user_id='.$_SESSION['id'];
          $checkwish = $mysqli->query($query);
          $contain = false;
          while($check = $checkwish->fetch_array()){
              if($row['product_id'] == $check['product_id']){
                  $contain = true;
              }
          }?>
          <form action="product_details.php<?php if(isset($_GET['pid'])){echo "?pid=".$_GET['pid'];} ?>" method="POST" style="display:inline-block;margin-bottom:5px;">
          <span style="margin-bottom:3px;">
          <?php
          if($contain){ //---------------- product already in wishlist ?>
                      <button  class="btn btn-success btn-sm" type="submit" name="removewishlist" value="<?= $row['product_id']?>">
                          <span class="glyphicon glyphicon-star" ></span>
                          <span style="font-family:sans-serif;font-size:14px;">In wishlist</span>
                      </button>
              <?php
          }else{ //---------------------- product not in wishlist?>
                      <button  class="btn btn-outline-warning btn-sm" type="submit" name="addwishlist" value="<?= $row['product_id']?>">
                          <span class="glyphicon glyphicon-star" ></span>
                          <span style="font-family:sans-serif;font-size:13px;">Add to wishlist</span>
                      </button>
          <?php } ?>
          </span>
          </form>
        <?php } ?>
      <!-- //////////////////////////////////////////////////////////////////////////////// -->

        <?php
        if($row['quantity']<=0){
        ?>
          <br><span style="color:red;">Out of stock</span>
        <?php
        }else{
        ?><br>
          <form action="product_details.php?pid=<?=$pid?>" method="GET">
              <input type="hidden" name="pid" value="<?=$pid?>">
              <button class="glyphicon glyphicon-shopping-cart btn btn-outline-dark btn-sm" type="submit" name="addToCart" value="<?= $row['product_id']?>">
                    <span style="font-family:sans-serif;margin-left:-10px;">Add to cart</span></button>
          </form>
        <?php
        }
      }
  ?>

  </div>
    </div>
    <!-- ///////////////////////////// END description //////////////////////////// -->


    <!-- =================== Start recommended product ============================== -->
    <div class="row">
      <br>
      <div class="col-sm-1"></div>
      <!-- Also Recommend -->
      <h3 style="display:inline-block;">Also Recommend</h3><br>
      <div class="col-sm-1"></div>
      <div class="row">
        <?php
          // $loopNo = 0;
          // $rowcount = 0;
          $qrs = "SELECT * FROM product WHERE product_tag = '".$tag."' AND product_name != '".$mysqli->real_escape_string($pname)."' ORDER BY quantity DESC LIMIT 5";
          $resulto = $mysqli->query($qrs);
          $numrow = $resulto->num_rows;
          while($row=$resulto->fetch_array()){ ?>
              <div class="col-sm-2">
                  <div class="panel panel-primary text-center">
                      <div class="panel-body" style="height:120px;">
                        <form id="detail_form<?=$row['product_id']?>" target="_blank" action="product_details.php" method="get">
                          <input type="hidden" name="pid" value="<?= $row['product_id']?>">
                        </form>
                        <a href="javascript:{}" onclick="document.getElementById('detail_form<?=$row['product_id']?>').submit(); return false;">
                        <img id="promotion" src="img/<?= $row['product_pic']?>" class="img-responsive center-block" style="height:100px;" alt="<?= $row['product_name']?>">
                      </a>
                      </div>
                      <div class="panel-footer">
                        <a href="javascript:{}" style="color:black;" onclick="document.getElementById('detail_form<?=$row['product_id']?>').submit(); return false;"><?= $row['product_name']?></a>
                      </div>
                  </div>
              </div>
              <?php
          }

        if($numrow < 5){
          $limit = 5-$numrow;
          $qrs = 'SELECT * FROM product WHERE author_id = '.$authorid.' AND product_tag NOT IN (SELECT product_tag FROM product WHERE product_tag = "'.$tag.'")
                ORDER BY quantity DESC LIMIT '.$limit;
          $resulto = $mysqli->query($qrs);
          while($row=$resulto->fetch_array()){ ?>
              <div class="col-sm-2">
                  <div class="panel panel-primary text-center">
                      <div class="panel-body" style="height:120px;">
                        <form id="detail_form<?=$row['product_id']?>" target="_blank" action="product_details.php" method="get">
                          <input type="hidden" name="pid" value="<?= $row['product_id']?>">
                        </form>
                        <a href="javascript:{}" onclick="document.getElementById('detail_form<?=$row['product_id']?>').submit(); return false;">
                        <img id="promotion" src="img/<?= $row['product_pic']?>" class="img-responsive center-block" style="height:100px;" alt="<?= $row['product_name']?>">
                      </a>
                      </div>
                      <div class="panel-footer">
                        <a href="javascript:{}" style="color:black;" onclick="document.getElementById('detail_form<?=$row['product_id']?>').submit(); return false;"><?= $row['product_name']?></a>
                      </div>
                  </div>
              </div>
              <?php
          }
        }

      ?>
    </div>
    <!-- //////////////////// END recommend //////////////////////////// -->

  </div>
</div>


<br><br><br><br><br>
</body>
</html>
