<!DOCTYPE html>
<?php
  session_start();
  $_SESSION['lastpage']="index.php";
  $_SESSION['currentpage']='main';
  require_once("connect.php");
  require_once("navbar.php");

  // $_SESSION['logout']=0;
  // if(!isset($_SESSION['logstat'])){
  //   require_once('checklogin.php');
  // }



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
  <title>BS Bookstore - Home</title>
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
      border-color:#6B6A6A ;
      border-width:1.5px;
    }

    .panel-footer{
      background-color: #D7D7D7;
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
  $loopNo = 0;
  $rowcount = 0;
  $goto = 'n'.$rowcount;
  $q = 'SELECT * FROM product ORDER BY add_date DESC LIMIT 3';
  $result = $mysqli->query($q);
  $resultforcheck = $mysqli->query($q);;
  $check=$resultforcheck->fetch_array();
  if($check!=NULL){ ?>
    <div class="panel-heading" id="npromotion" style="background-color:#ADB4D1;vertical-align:middle;">
        <form action="promotion.php" method="POST" id="new">
            <input type="hidden" name="new" value="new">
            <span style="vertical-align:middle;color:white;font-size:30px;display:inline-block;">New Arrivals</span>
            <span style="position:absolute;right:7%;padding-top:8px;">
                <a href="javascript:{}" onclick="document.getElementById('new').submit(); return false;" style="font-size:16px;"> See all new arrivals >></a>
            </span>
        </form>

    </div>
          <div class="container">
            <div class="row">
            <?php
            // ----------------- START while --------------------------------
            while($row=$result->fetch_array()){
                if($loopNo%3 == 0 && $loopNo != 0){ ?>
                  </div></div>
                  <div class="container">
                  <div class="row">
          <?php } ?>

              <div class="col-sm-4">
                <div class="panel panel-primary">
                  <!--=========================== HEAD panel ========================-->
                  <div class="panel-heading" style="background-color:#404040;">
                      <form id="detail_form<?=$row['product_id']?>" target="_blank" action="product_details.php" method="get">
                          <input type="hidden" name="pid" value="<?= $row['product_id']?>">
                      </form>
                      <a href="javascript:{}" style="color: white; text-decoration: none;" onclick="document.getElementById('detail_form<?=$row['product_id']?>').submit(); return false;"><?= $row['product_name']?></a>
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
                          <form action="index.php#npromotion" method="POST" style="display:inline-block;">
                            <span style="position:absolute;right:3.5%;top:25%;">
                            <?php
                            if($contain){ //---------------- product already in wishlist ?>
                                        <button  class="btn btn-success btn-sm" type="submit" name="removewishlist" value="<?= $row['product_id']?>">
                                            <span class="glyphicon glyphicon-star" style="font-size:15px;"></span>
                                            <span style="font-family:sans-serif;font-size:13px;">In wishlist</span>
                                        </button>
                                <?php
                            }else{ //---------------------- product not in wishlist?>
                                        <button  class="btn btn-outline-warning btn-sm"  type="submit" name="addwishlist" value="<?= $row['product_id']?>">
                                            <span class="glyphicon glyphicon-star" style="font-size:15px;" ></span>
                                            <span id="ext" style="font-family:sans-serif;font-size:13px;">Add to wishlist</span>
                                        </button>
                            <?php } ?>
                            </span>
                          </form>
                        <?php } ?>
                      <!-- //////////////////////////////////// END wishlist button //////////////////////////////////// -->
                  </div>
                  <!-- /////////////////////// END HEAD panel ///////////////////////// -->
                  <!--=========================== Product Picture ========================-->
                  <div class="panel-body">
                    <h3><span class="label label-primary"
                      style="position:absolute;
                      top:16%;
                      right:3.5%;
                      box-shadow:3px 5px 0px rgba(222,222,222,0.5);
                      margin-bottom:3px;
                      margin-left:78%;
                      font-size:17px;"
                       alt="sale">
                     NEW</span></h3>
                     <form id="detail_form<?=$row['product_id']?>" target="_blank" action="product_details.php" method="get">
                       <input type="hidden" name="pid" value="<?= $row['product_id']?>">
                     </form>
                     <a href="javascript:{}" onclick="document.getElementById('detail_form<?=$row['product_id']?>').submit(); return false;">
                    <img src="img/<?= $row['product_pic']?>" class="img-responsive center-block" style="height:150px;" alt="<?= $row['product_name']?>"></a>
                  </div>
                  <!-- /////////////////////// END Product Picture ///////////////////////// -->
                  <!--================================ Description =============================-->
                  <div class="panel-footer">
                        <!-- ============= Show price ================= -->
                        <?php
                        if($row['product_discount']!=0){?>
                          Buy now for&nbsp;<?= $row['product_discount'] ?>&nbsp;% discount !<br>
                          <strike style="color:#FF2323;"><?= number_format($row['product_price']).' THB' ?>
                          </strike>
                          <?php $dis_price = $row['product_price']*((100-$row['product_discount'])/100); ?>
                          &nbsp;<?=number_format($dis_price)?>&nbsp;THB<br>
                          <?php
                        }else{?>
                        Buy now for&nbsp;<?= number_format($row['product_price']) ?>&nbsp;THB !<br>
                      <?php } ?>
                         <!-- //////////////////// END show price ///////////////////////////// -->

                         <!--========== SHOW cart button ===========-->
                         <?php
                         if($row['quantity']<=0){ ?>
                           <span style="right:8%;bottom:11%;position:absolute;color:red">Out of stock</span>
                           <?php
                         }else{ ?>
                             <form action="index.php#npromotion" method="POST">
                                  <!-- //- send check variable to show items in cart -// -->
                                  <input type="hidden" name="checkcart" value="first">
                                  <span style="right:8%;bottom:9.5%;position:absolute;">
                                     <!-- //- Add Cart button -// -->
                                     <button class="btn btn-outline-dark btn-sm" type="submit" name="addToCart" value="<?= $row['product_id']?>">
                                         <span class="glyphicon glyphicon-shopping-cart">
                                             <span style="font-family:sans-serif;margin-left:-10px;"> Add to cart
                                             </span>
                                         </span>
                                     </button>
                                  </span>
                              </form>
                         <?php
                         } ?>
                         <!-- //////////////// END show cart ///////////// -->
                  </div>
                  <!-- /////////////////////////// END Description ////////////////////////////// -->
                </div>
              </div>
            <?php }
            // ----------------------------- END while -------------------------
            ?>
            </div>
          </div>
<?php } ?><br>
<!-- ////////////////////////////// END Promotion NEW ARRIVAL /////////////////////////////// -->



<!-- =============================== Promotion SALE =================================== -->
<?php
  $loopNo = 0;
  $rowcount = 0;
  $goto = 's'.$rowcount;
  $q = 'SELECT * FROM product WHERE product_discount != 0 LIMIT 3';
  $result = $mysqli->query($q);
  $resultforcheck = $mysqli->query($q);
  $check=$resultforcheck->fetch_array();
  if($check!=NULL){ ?>
    <div class="panel-heading" id="spromotion" style="background-color:#D1ADAD;">
      <form action="promotion.php" method="POST" id="sale">
          <input type="hidden" name="sale" value="sale">
          <span style="vertical-align:middle;color:white;font-size:30px;display:inline-block;">Sales</span>
          <span style="position:absolute;right:7%;padding-top:8px;">
              <a href="javascript:{}" onclick="document.getElementById('sale').submit(); return false;" style="font-size:16px;"> See all sales >></a>
          </span>
      </form>
    </div>
          <div class="container">
            <div class="row">
            <?php
            // ----------------------- START while --------------------------
            while($row=$result->fetch_array()){
                if($loopNo%3 == 0 && $loopNo != 0){ ?>
                  </div></div>
                  <div class="container">
                  <div class="row">
          <?php } ?>

              <div class="col-sm-4">
                <div class="panel panel-primary">
                  <!--================== HEAD panel: product name =================-->
                  <div class="panel-heading" style="background-color:#404040;">
                      <form id="detail_form<?=$row['product_id']?>" target="_blank" action="product_details.php" method="get">
                        <input type="hidden" name="pid" value="<?= $row['product_id']?>">
                      </form>
                      <a href="javascript:{}" style="color: white; text-decoration: none;"   onclick="document.getElementById('detail_form<?=$row['product_id']?>').submit(); return false;"><?= $row['product_name']?></a>
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
                          <form action="index.php#spromotion" method="POST" style="display:inline-block;">
                            <span style="position:absolute;right:3.5%;top:25%;">
                            <?php
                            if($contain){ //---------------- product already in wishlist ?>
                                        <button  class="btn btn-success btn-sm" type="submit" name="removewishlist" value="<?= $row['product_id']?>">
                                            <span class="glyphicon glyphicon-star" style="font-size:15px;"></span>
                                            <span style="font-family:sans-serif;font-size:13px;">In wishlist</span>
                                        </button>
                                <?php
                            }else{ //---------------------- product not in wishlist?>
                                        <button  class="btn btn-outline-warning btn-sm"  type="submit" name="addwishlist" value="<?= $row['product_id']?>">
                                            <span class="glyphicon glyphicon-star" style="font-size:15px;" ></span>
                                            <span id="ext" style="font-family:sans-serif;font-size:13px;">Add to wishlist</span>
                                        </button>
                            <?php } ?>
                            </span>
                          </form>
                        <?php } ?>
                      <!-- //////////////////////////////////// END wishlist button //////////////////////////////////// -->
                  </div>
                  <!-- /////////////////////// END HEAD panel ///////////////////////// -->
                  <!--=========================== Product Picture ========================-->
                  <div class="panel-body">
                    <h3><span class="label label-danger"
                      style="position:absolute;
                      top:15%;
                      right:3.5%;
                      box-shadow:3px 5px 0px rgba(222,222,222,0.5);
                      margin-bottom:3px;
                      margin-left:78%;
                      height:25px;"
                       alt="sale">
                     SALE</span></h3>
                     <form id="detail_form<?=$row['product_id']?>" target="_blank" action="product_details.php" method="get">
                       <input type="hidden" name="pid" value="<?= $row['product_id']?>">
                     </form>
                     <a href="javascript:{}" onclick="document.getElementById('detail_form<?=$row['product_id']?>').submit(); return false;"><img src="img/<?= $row['product_pic']?>" class="img-responsive center-block" style="height:150px;" alt="<?= $row['product_name']?>"></a>
                  </div>
                  <!-- /////////////////////// END Product Picture ///////////////////////// -->
                  <!--================================ Description =============================-->
                  <div class="panel-footer">
                        <!-- ============= Cross out the not-yet discount price ================= -->
                        Buy now for&nbsp;<?= $row['product_discount'] ?>&nbsp;% discount !<br>
                        <strike style="color:#FF2323;"><?= number_format($row['product_price']).' THB' ?>
                        </strike>
                        <?php $dis_price = $row['product_price']*((100-$row['product_discount'])/100); ?>
                        &nbsp;<?=number_format($dis_price)?>&nbsp;THB<br>
                         <!-- ///////////////////////////////////////////////////////// -->

                         <!--========== SHOW cart button ===========-->
                         <?php
                         if($row['quantity']<=0){ ?>
                           <span style="right:8%;bottom:12%;position:absolute;color:red">Out of stock</span>
                           <?php
                         }else{ ?>
                             <form action="index.php#spromotion" method="POST">
                                  <!-- //- send check variable to show items in cart -// -->
                                  <input type="hidden" name="checkcart" value="first">
                                  <span style="right:8%;bottom:11%;position:absolute;">
                                     <!-- //- Add Cart button -// -->
                                     <button class="btn btn-outline-dark btn-sm" type="submit" name="addToCart" value="<?= $row['product_id']?>">
                                         <span class="glyphicon glyphicon-shopping-cart">
                                             <span  style="font-family:sans-serif;margin-left:-10px;"> Add to cart
                                             </span>
                                         </span>
                                     </button>
                                  </span>
                              </form>
                         <?php
                         } ?>
                         <!-- //////////////// END show cart ///////////// -->
                  </div>
                  <!-- /////////////////////////// END Description ////////////////////////////// -->
                </div>
              </div>
            <?php }
            //--------------------------------- END while ---------------------------------
            ?>
            </div>
          </div>
<?php } ?>
<!-- ////////////////////////////// END Promotion SALE /////////////////////////////// -->
<br><br>
<!-- =============================== footer ======================================= -->
<!-- <footer class="container-fluid text-center">
  <p>BS Bookstore</p>
</footer> -->
<!-- ////////////////////////////////////////////////////////////////////////////// -->

</body>
</html>
