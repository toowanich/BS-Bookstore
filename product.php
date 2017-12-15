<?php
session_start();

$_SESSION['lastpage']="product.php";
$_SESSION['currentpage']='product';
require_once('connect.php');
require_once('navbar.php');

if(!isset($_SESSION['curppage'])){
    $_SESSION['curppage']='1'; //=======> tell what page we are in
}
if(!isset($_POST['addToCart'])){
    $_SESSION['curppage']='1';
}
if(isset($_GET['page'])){
    if((int)$_GET['page'] <= 0){
        $_SESSION['curppage']='1';
    }else{
        $_SESSION['curppage'] = $_GET['page'];
    }
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
  <title>BG Store - Products</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css">
  <link rel="stylesheet" href="btnoutline.css" type="text/css">
  <link rel="stylesheet" href="btnhoverextend.css" type="text/css">
  <script src="sidebarcss.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="sidebar style.css">
<!-- ====== Style ======= -->
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }

    .jumbotron {
     margin-bottom: 0;
     padding-top: 100px;
     margin-bottom: 20px;
    }

    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 100%}

    .table{

      border-style:solid;
      width:30%;
      height:40%;


    }

    body{
      /*padding-bottom:30px;*/
      font-family: 'Poppins', sans-serif;
      background: #fafafa;
    }

    /* Set black background color, white text and some padding */

    footer {
      background-color: #2A2A2A;
      color: #E0E0E0;
      padding: 1.5%;
      margin-top:25px;
      /*position: absolute;*/
      left:0;
      right:0;
      bottom:0;
    }


    /*.panel{
      min-height: 350px;
      padding-left: 40px;
      border: 0px;
      box-shadow:0 0px 0px rgba(0,0,0,0)
    }*/

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
      width:95%;
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

    #search{
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

    tr.fig td{
      width:25%;
      padding:25%;
      padding-bottom:2%;
    }

    tr.txt td{
      padding-bottom:0%

    }

    tr.txt2 td{
      padding-top:1%
    }

    .fontsize{
      font-size: 10px ;
    }

    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {

      .row.content {height:auto;}

      #sidebar {
        margin-left: -250px;
        position:fixed;
      }
      #sidebar.active {
          margin-left: 0;
      }
      #content {
          width: 100%;
      }
      #content.active {
          width: calc(100% - 250px);
      }
      #sidebarCollapse span {
          display: none;
      }
    }
  </style>
<!-- ///////////////////// -->
</head>

<body>



  <!-- =============================== navbar ======================================= -->
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <?php show_navbar(); ?>
  </nav>
    <!-- /////////////////////////////////////////////////////////////////////////// -->

<!-- ========================== SIDEBAR ============================= -->
    <!-- jQuery CDN --><script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <!-- Bootstrap Js CDN --><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Nice Scroll Js CDN --><script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.6.8-fix/jquery.nicescroll.min.js"></script>
  <div class="wrapper">

        <nav id="sidebar" class ="active" style="box-shadow:2px 2px 7px rgba(206,206,206,0.5);">
            <!-- Sidebar Header -->
            <div class="sidebar-header" style="height:20%;">
                <p style="font-size:21px;font-family:sans-serif;line-height:27px;">Choose Your Genres</p>
            </div>

            <!-- Sidebar Links -->
            <ul class="list-unstyled components">
                <li <?php if(!isset($_GET['keywordtype'])) {echo "class='active'";} ?>>
                    <a href="product.php">All</a>
                </li>
            <?php
                $q = 'SELECT * FROM product_tag ORDER BY tag_name ASC';
                $result = $mysqli->query($q);
                while($row = $result->fetch_array()){ ?>
                    <li <?php if(isset($_GET['keywordtype']) && $_GET['keywordtype']==$row['tag_name']) {echo "class='active'";} ?>>
                        <a href="javascript:{}" onclick="document.getElementById('my_form<?=$row['id']?>').submit();"><?=$row['tag_name']?></a>
                    </li>
                    <?php
                } ?>
                <?php
                $q = 'SELECT * FROM product_tag ORDER BY tag_name ASC';
                $result = $mysqli->query($q);
                while($row = $result->fetch_array()){ ?>
                    <form id="my_form<?=$row['id']?>" style="display:inline-block;" action="product.php" method="GET" >
                        <input type="hidden" name="keywordtype" value="<?=$row['tag_name']?>">
                    </form>
                    <?php
                } ?>
            </ul>
        </nav>

        <div id="content">
            <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn"
                    style="position:fixed;
                            left:-2.5%;top:12%;
                            background-color:#6E6E6E;
                            border-color:#6E6E6E;
                            transform:rotate(90deg);">
                <p style="margin-bottom:3px;"><i class="glyphicon glyphicon-align-left" id="dismiss"></i>
                   Genres</p>
            </button>
        </div>
        <div class="overlay"></div>

    <script type="text/javascript">
      $(document).ready(function () {

        $('#sidebar').niceScroll({
            cursorcolor: '#6E6E6E', // Changing the scrollbar color
            cursorwidth: 4, // Changing the scrollbar width
            cursorborder: 'none', // Rempving the scrollbar border
        });

        $('#sidebarCollapse').on('click', function () {
            // open or close navbar
            $('#sidebar').removeClass('active');
            // close dropdowns
            $('.collapse.in').toggleClass('in');
            $('.overlay').fadeIn();
            // and also adjust aria-expanded attributes we use for the open/closed arrows
            // in our CSS
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });

        $('.overlay').on('click', function () {
           $('#sidebar').addClass('active');
           $('.overlay').fadeOut();
        });
      });
    </script>
  </div>
<!-- ///////////////////////////////////////////////////////////////// -->

<!-- =============================== jumbotron ==================================== -->
<?php show_jumbotron(); ?>
<!-- ////////////////////////////////////////////////////////////////////////////// -->



<!-- ===============================TABLE START============================ -->
<?php
$rowcount = 0;
$loopNo = 0;
$offset = 12*(((int)$_SESSION['curppage'])-1);
if(isset($_GET['keyword'])){
  $keyword=$_GET['keyword'];
  $qrs = "SELECT * FROM product WHERE product_name like '%$keyword%' ORDER BY product_name ASC LIMIT 12 OFFSET ".$offset;
  // echo 'Search result of "'.$keyword.'"';?>
  <div id="search" class="text-left panel-heading" style="vertical-align:middle;">
    <h2 style="vertical-align:middle;color:black;display:inline-block;"><?='Search for "'.$keyword.'"'?></h2>
  </div>
  <?php
}
elseif (isset($_GET['keywordtype'])) {
  $keyword=$_GET['keywordtype'];
  $qrs = "SELECT * FROM product WHERE product_tag like '%$keyword%' ORDER BY product_name ASC LIMIT 12 OFFSET ".$offset;
  // echo $keyword.' games';?>
  <div id="search" class="text-left panel-heading" style="vertical-align:middle;">
    <h2 style="vertical-align:middle;color:black;display:inline-block;"><?= $keyword.' books'?></h2>
  </div>
  <?php
}
else{
  $qrs = "SELECT * FROM product ORDER BY product_name ASC LIMIT 12 OFFSET ".$offset;
  // echo 'All games';
}
// $qrs = "SELECT * FROM product ORDER BY product_name ASC LIMIT 12 OFFSET ".$offset;
$resulto = $mysqli->query($qrs);
?>

<div class="container-fluid text-center" style="padding-left:4%;padding-right:4%;margin-bottom:30px;">
  <!-- <div class="row content" style="padding-left:30px;"> -->
<!-- <br><br><br> -->
  <div id=<?=$rowcount?> class="container-fluid text-center">
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
                  </a>
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
                            <form action="product.php
                            <?php
                            if(isset($_GET['keyword'])){
                              echo "?keyword=".$_GET['keyword'];
                              if(isset($_GET['page'])){echo '&page='.$_GET['page'];}
                            }else if(isset($_GET['keywordtype'])){
                              echo "?keywordtype=".$_GET['keywordtype'];
                              if(isset($_GET['page'])){echo '&page='.$_GET['page'];}
                            }else if(isset($_GET['page'])){echo '?page='.$_GET['page'];}
                            echo '#'.$rowcount; ?>"
                            method="POST" style="display:inline-block;">
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
                            </form>
                          <?php } ?>
                        <!-- //////////////////////////////////////////////////////////////////////////////// -->

                  </div>
                  <div class="panel-footer center-block" style="border-top-right-radius:13px;padding-top:15px;">
                    <!-- ============= Cross out the not-yet discount price ================= -->
                    <form id="detail_form<?=$row['product_id']?>" style="display:inline-block;" target="_blank" action="product_details.php" method="get">
                      <input type="hidden" name="pid" value="<?= $row['product_id']?>">
                    </form>
                    <a href="javascript:{}" onclick="document.getElementById('detail_form<?=$row['product_id']?>').submit(); return false;"><?= $row['product_name']?></a>
                    <br><?php
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
                  <!-- <div class="panel-footer center-block" style="width:80%;border-width:0px;margin-top:-13px;">
                  <button class="btn btn-outline-success btn-sm" style="display:inline-block;" type="button" name="addToCart" value="<?= $row['product_id']?>">
                    <span style="font-family:sans-serif;font-size:10px;">Add to wishlist</span></button>
                  </div> -->

                  <?php
                  if($row['quantity']<=0){
                  ?>
                  <div class="panel-footer center-block" style="border-width:0px;margin-top:-13px;">
                    <span style="color:red;">Out of stock</span>
                  </div>
                  <?php }
                  else{
                  ?>
                  <form action="product.php
                      <?php
                      if(isset($_GET['keyword'])){
                        echo "?keyword=".$_GET['keyword'].'#'.$rowcount;
                      }else if(isset($_GET['keywordtype'])){
                        echo "?keywordtype=".$_GET['keywordtype'].'#'.$rowcount;
                      }else{echo '#'.$rowcount;}?>" method="POST">
                      <input type="hidden" name="checkcart" value="first">
                        <!-- //- send check variable to show items in cart -// -->
                      <div class="panel-footer center-block" style="border-width:0px;margin-top:-13px;padding-bottom:15px;">
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
      <!-- ========================================================== Pagination ================================================================= -->
      <?php
      if(isset($_GET['keyword'])){
        $keyword=$_GET['keyword'];
        $qrs = "SELECT * FROM product WHERE product_name like '%$keyword%'";
      }
      elseif (isset($_GET['keywordtype'])) {
        $keyword=$_GET['keywordtype'];
        $qrs = "SELECT * FROM product WHERE product_tag like '%$keyword%'";
      }
      else{
        $qrs = "SELECT * FROM product";
      }
      // $qs = 'SELECT * FROM product;';
      $run = $mysqli->query($qrs);
      $amount = $run->num_rows;
      $count = ceil(($amount+1)/12);
      $_SESSION['ppagelast'] = strval($count);
      if($count>1){?>
      <nav aria-label="page navigation">
        <ul class="pagination">
          <?php


          if($_SESSION['curppage']!='1'){ //================= prev button ======================= ?>
            <li>
              <form id="prev" action="product.php" method="GET" style="display:inline-block;">
                  <input type="hidden" name="page" value="<?= ((int)$_SESSION['curppage'])-1 ?>">
                  <?php
                  if(isset($_GET['keyword'])){
                    $keyword=$_GET['keyword']; ?>
                    <input type="hidden" name="keyword" value="<?= $keyword ?>">
                    <?php
                  }
                  elseif (isset($_GET['keywordtype'])) {
                    $keyword=$_GET['keywordtype']; ?>
                    <input type="hidden" name="keywordtype" value="<?= $keyword ?>">
                    <?php
                  }
                  ?>
              </form>
              <a href="javascript:{}" onclick="document.getElementById('prev').submit(); return false;" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <?php
          }
          for($i = 1; $i <= $count ; $i++){ //======================== number button ================= ?>
            <form id="page<?= $i ?>" action="product.php" method="GET" style="display:inline-block;">
                <input type="hidden" name="page" value="<?= $i ?>">
                <?php
                if(isset($_GET['keyword'])){
                  $keyword=$_GET['keyword']; ?>
                  <input type="hidden" name="keyword" value="<?= $keyword ?>">
                  <?php
                }
                elseif (isset($_GET['keywordtype'])) {
                  $keyword=$_GET['keywordtype']; ?>
                  <input type="hidden" name="keywordtype" value="<?= $keyword ?>">
                  <?php
                }
                ?>
            </form>
                <li <?php if($_SESSION['curppage']==strval($i)){echo "class='active'";} ?>>
                    <a <?php if($_SESSION['curppage']!=strval($i)){echo 'href="javascript:{}" onclick="document.getElementById(\'page'.$i.'\').submit(); return false;"';} ?>>
                        <?= $i ?>
                    </a>
                </li>
            <?php
          }
          if($_SESSION['curppage']!=$_SESSION['ppagelast']){ //=================== Next button ============= ?>
            <li>
              <form id="next" action="product.php" method="GET" style="display:inline-block;">
                  <input type="hidden" name="page" value="<?= ((int)$_SESSION['curppage'])+1 ?>">
                  <?php
                  if(isset($_GET['keyword'])){
                    $keyword=$_GET['keyword']; ?>
                    <input type="hidden" name="keyword" value="<?= $keyword ?>">
                    <?php
                  }
                  elseif (isset($_GET['keywordtype'])) {
                    $keyword=$_GET['keywordtype']; ?>
                    <input type="hidden" name="keywordtype" value="<?= $keyword ?>">
                    <?php
                  }
                  ?>
              </form>
              <a href="javascript:{}" onclick="document.getElementById('next').submit(); return false;" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
            <?php
          }
          ?>
        </ul>
      </nav>
<?php }?>
      <!-- //////////////////////////////////////////////////// END pagination //////////////////////////////////////////////////////////////////// -->
    </div>
 </div>
<!-- ////////////////////////////////////////////////////////////////////// -->
<br><br>
</body>
</html>
