<!DOCTYPE html>
<?php
  session_start();
  // $_SESSION['lastpage']="index.php";
  $_SESSION['currentpage']='promotion';
  require_once("connect.php");
  require_once("navbar.php");

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

<html lang="en">
<head>
  <title>BG Store - Promotion</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css">
  <link rel="stylesheet" href="btnoutline.css" type="text/css">
  <link rel="stylesheet" href="btnhoverextend.css" type="text/css">
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
      border-color:inherit ;
      border-style:none ;
      border-width:0px;
      background-color: inherit;
      border-bottom-left-radius: 0px;
      border-bottom-right-radius: 0px;
      box-shadow:0 0px 0px rgba(0,0,0,0)
    }

    .panel-footer{
      background-color: white;
      border-bottom: 0px;
      border-bottom-left-radius: 13px;
      border-bottom-right-radius: 13px;
      border-top-left-radius: 13px;
      border-top-right-radius: 0px;
      box-shadow:5px 5px 0px rgba(204,204,204,0.5);
      /*font-size: 14px ;*/
    }

    #promotion{
      border-style:double;
      border-color: #E7E7E7;
      border-width: 1px;
      border-bottom-left-radius: 5px;
      border-bottom-right-radius: 5px;
      border-top-left-radius: 5px;
      border-top-right-radius: 5px;
      box-shadow:6px 6px 0px rgba(211,211,211,0.5);
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


<!-- =============================== jumbotron ==================================== -->
<?php show_jumbotron(); ?>
<!-- ///////////////////////////// END jumbotron ////////////////////////////////////// -->

<!-- =============================== navbar ======================================= -->
<nav class="navbar navbar-inverse navbar-fixed-top">
  <?php show_navbar(); ?>
</nav>
  <!-- /////////////////////////// END navbar /////////////////////////////////// -->


</head>
<body>



<!-- =============================== Promotion NEW ARRIVAL =================================== -->
<?php
    if(isset($_POST['new'])){
          $loopNo = 0;
          $rowcount = 0;
          $goto = 'n'.$rowcount;
          $q = 'SELECT * FROM product ORDER BY add_date DESC LIMIT 9';
          $resulto = $mysqli->query($q);
          $resultforcheck = $mysqli->query($q);;
          $check=$resultforcheck->fetch_array();
          if($check!=NULL){ ?>
            <div class="panel-heading" id="npromotion" style="vertical-align:middle;">
                <h1 style="vertical-align:middle;color:black;display:inline-block;">New Arrivals</h1>
            </div>
        <?php }
         ////////////////////////////// END Promotion NEW ARRIVAL ///////////////////////////////
      }else if(isset($_POST['sale'])){
    ?>
        <!-- =============================== Promotion SALE =================================== -->
        <?php
          $loopNo = 0;
          $rowcount = 0;
          $goto = 's'.$rowcount;
          $q = 'SELECT * FROM product WHERE product_discount != 0';
          $resulto = $mysqli->query($q);
          $resultforcheck = $mysqli->query($q);
          $check=$resultforcheck->fetch_array();
          if($check!=NULL){ ?>
            <div class="panel-heading" id="npromotion" style="vertical-align:middle;">
                <h1 style="vertical-align:middle;color:black;display:inline-block;">Sales</h1>
            </div>
        <?php }
      ////////////////////////////// END Promotion SALE /////////////////////////////// -->
    } ?>
    <div id="<?=$rowcount?>" class="container-fluid text-center">
        <div class="row">
          <?php
            while($row=$resulto->fetch_array()){
              if($loopNo%4==0 && $loopNo!=0){
                $rowcount++; ?>
                  </div>
                  </div><br>
                <div id=<?=$rowcount?> class="container-fluid text-center">
                    <div class="row">
              <?php
              }
        ?>
            <div class="col-sm-3">
                <div class="panel panel-primary text-center">
                    <div class="panel-body" style="height:200px;">
                      <form id="detail_form<?=$row['product_id']?>" target="_blank" action="product_details.php" method="get">
                        <input type="hidden" name="pid" value="<?= $row['product_id']?>">
                      </form>
                      <a href="javascript:{}" onclick="document.getElementById('detail_form<?=$row['product_id']?>').submit(); return false;">
                      <img id="promotion" src="img/<?= $row['product_pic']?>" class="img-responsive center-block" style="height:150px;" alt="<?= $row['product_name']?>">
                      <!--=== Insert SALE sign ===-->
                        <?php
                          if($row['product_discount']!= 0){?>
                              <h3><span class="label label-danger"
                              style="position:absolute;
                              top:2%;
                              left:7%;
                              box-shadow:2px 2px 0px rgba(211,211,211,0.8);
                              margin-bottom:3px;
                              margin-right:78%;"
                               alt="sale">
                               SALE</span></h3>
                               <?php
                          } ?>
                          <!-- /////////////////////// -->
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
                              <form action="promotion.php#<?=$row['product_id']?>" method="POST" style="display:inline-block;">
                                  <span style="position:absolute;top:2%;right:8%;box-shadow:2px 2px 0px rgba(211,211,211,0.8);margin-bottom:3px;margin-left:78%;" id="wishlist">
                                  <?php
                                  if($contain){ //---------------- product already in wishlist ?>
                                              <button  class="btn btn-success btn-sm" type="submit" name="removewishlist" value="<?= $row['product_id']?>">
                                                  <span class="glyphicon glyphicon-star" ></span>
                                                  <span style="font-family:sans-serif;">In wishlist</span>
                                              </button>
                                      <?php
                                  }else{ //---------------------- product not in wishlist?>
                                              <button  class="btn btn-outline-warning btn-sm" type="submit" name="addwishlist" value="<?= $row['product_id']?>">
                                                  <span class="glyphicon glyphicon-star" ></span>
                                                  <span id="ext" style="font-family:sans-serif;">Add to wishlist</span>
                                              </button>
                                  <?php } ?>
                                </span>
                                <?php
                                  if(isset($_POST['new'])){ ?>
                                      <input type="hidden" name="new" value="1">
                                      <?php
                                  }else if(isset($_POST['sale'])){?>
                                      <input type="hidden" name="sale" value="1">
                                  <?php } ?>
                              </form>
                            <?php } ?>
                          <!-- //////////////////////////////////////////////////////////////////////////////// -->

                    </div>
                    <div class="panel-footer center-block" style="width:80%;border-top-right-radius: 13px;">
                      <form id="detail_form<?=$row['product_id']?>" style="display:inline-block;" target="_blank" action="product_details.php" method="get">
                        <input type="hidden" name="pid" value="<?= $row['product_id']?>">
                      </form>
                      <a style="color:black;" href="javascript:{}" onclick="document.getElementById('detail_form<?=$row['product_id']?>').submit(); return false;"><?= $row['product_name']?></a>
                      <br>
                      <!-- ============= Cross out the not-yet discount price ================= -->
                      <?php
                          if($row['product_discount']!= 0){
                            echo '<strike style="color:#C5C5C5;">';
                          }
                      ?>
                      <?= number_format($row['product_price']).' THB' ?>
                      <?php
                          if($row['product_discount']!= 0){
                            echo '</strike><br>';
                          }
                      ?>
                      <?php
                      if($row['product_discount']!= 0){
                        $dis_price = $row['product_price']*((100-$row['product_discount'])/100);
                        echo number_format($dis_price).' THB<br>';
                      }
                      ?>
                       <!-- ///////////////////////////////////////////////////////// -->
                    </div>
                    <!-- // echo '<div class="panel-footer">'.number_format($row['product_price']).'</div>'; -->
                    <!-- <div> -->
                    <?php
                    if($row['quantity']<=0){
                    ?>
                    <div class="panel-footer center-block" style="border-width:0px;margin-top:-13px;width:80%;">
                      <span style="color:red;">Out of stock</span>
                    </div>
                    <?php }
                    else{
                    ?>
                    <form action="promotion.php#<?=$rowcount?>" method="POST">
                        <input type="hidden" name="checkcart" value="first">
                        <?php
                          if(isset($_POST['new'])){ ?>
                              <input type="hidden" name="new" value="1">
                              <?php
                          }else if(isset($_POST['sale'])){?>
                              <input type="hidden" name="sale" value="1">
                          <?php } ?>
                        <!-- </div> -->
                          <!-- //- send check variable to show items in cart -// -->
                        <div class="panel-footer center-block" style="width:80%;border-width:0px;margin-top:-13px;">
                        <button class="glyphicon glyphicon-shopping-cart btn btn-outline-dark btn-sm" type="submit" name="addToCart" value="<?= $row['product_id']?>">
                              <span style="font-family:sans-serif;margin-left:-10px;">Add to cart</span></button>
                        </div>
                              <!-- //- Add Cart button -// -->
                    </form>
                    <?php
                    }
                    ?>
                </div>
            </div>
        <?php
          $loopNo+=1;
        } ?>
        </div>
      </div>
<br><br>
<!-- =============================== footer ======================================= -->
<!-- <footer class="container-fluid text-center">
  <p>BG Store</p>
</footer> -->
<!-- ////////////////////////////////////////////////////////////////////////////// -->

</body>
</html>
