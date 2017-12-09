<link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css">
<?php
if(!isset($_SESSION['currentpage']))
  session_start();
function show_navbar(){

  if(!isset($_SESSION['logstat'])){
    $_SESSION['indexnavbartologin'] = '1';
    require_once('checklogin.php');
  }

?>
  <style>
      .numberCircle {
          border-radius: 50%;
          width: 22px;
          font-size: 14px;
          text-align:center;
          border: 2px solid #980606;
          background-color:#980606;
          display:inline-block;
      }
      .numberCircle span {
          text-align: center;
          line-height: 20px;
          display: block;
          display:inline-block;
      }
      .numberCircle a:hover {
          background-color: :red;
      }

      .unselectable {
          -webkit-touch-callout: none;
          -webkit-user-select: none;
          -khtml-user-select: none;
          -moz-user-select: none;
          -ms-user-select: none;
          user-select: none;
      }

  </style>
  <link rel="stylesheet" type="text/css" href="dropdown.css">
  <div class="container-fluid">
    <!-- <div class="navbar-header "> -->
      <!-- <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button> -->

    <div class="collapse navbar-collapse navbar-fixed-top" id="myNavbar">
      <ul class="nav navbar-nav ">
        <li>
          <span class="navbar-brand unselectable">
            &nbsp;&nbsp;BG Store</a>
          </span>
        </li>
        <li <?php  if($_SESSION['currentpage']=='main') {echo "class='active'";} ?>
          ><a href="main.php">Home</a></li>
        <li <?php if($_SESSION['currentpage']=='product') {echo "class='active'";} ?>
          ><a href="product.php">Products</a></li>
        <li <?php if($_SESSION['currentpage']=='contact') {echo "class='active'";} ?>
          ><a href="contact.php">Contact & Payment method</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">

        <li>
          <form id="serach_form" action="product.php" method="GET">
            <input type="text" style="height:30px;margin-top:5%;" class="form-control" name="keyword" placeholder="Search" >
          </form>
        </li>
        <li>&nbsp;&nbsp;<button form="serach_form" class="btn btn-sm btn-default glyphicon glyphicon-search" style="margin-top:19.5%;" type="submit" name="submit"></button>&nbsp;&nbsp;</li>
        <?php
          if($_SESSION['logstat']=="Log Out"){?>
            <li class="dropdown <?php if($_SESSION['currentpage']=='account') {echo 'active';} ?>">

                <a class="dropbtn" href="javascript:void(0)">
                  <!-- **************************** add this ****************************** -->
                  <img src="profile/<?=$_SESSION['propic'] ?>" alt="<?=$_SESSION['propic'] ?>" style="width:22px;height:22px;border-radius:50%;">
                  &nbsp;<?= $_SESSION['username'] ?>
                  <span class="glyphicon glyphicon-menu-hamburger"></span>
              </a>
                <div class="dropdown-content">
                  <?php
                  if($_SESSION['usertype']==1){?>
                      <a href="product_list.php">Manage Product</a>
                      <a href="user_list.php">Manage User</a>
                      <a href="order_list.php">Manage Order</a>
                  <?php
                  }else if($_SESSION['usertype']==2){?>
                      <a href="account.php">Profile</a>
                      <a href="orderhistory.php">Order</a>
                      <a href="address.php">Address</a>
                      <a href="account_wishlist.php">Wishlist</a>
                      <?php
                  } ?>
                </div>
            </li>
            <?php
          } ?>
        <li <?php if($_SESSION['currentpage']=='login') {echo "class='active'";} ?>
          ><a href="login.php"><span class="glyphicon glyphicon-off"></span> <?php echo $_SESSION['logstat'];?></a></li>
        <li <?php if($_SESSION['currentpage']=='cart') {echo "class='active'";} ?>
          ><a href="cart.php">
            <span class="glyphicon glyphicon-shopping-cart" style="display:inline-block;"></span>
            Cart<?php
            if(isset($_SESSION['cartquantity']) && $_SESSION['cartquantity']!=0){?>
              <!-- <div class="numberCircle" style="font-weight:bold;"> -->
                <span class="badge"><?= $_SESSION['cartquantity'] ?></span>
              <!-- </div> -->
              <?php
           } ?>
          </a>
        </li>
        <li><a></a></li>
      </ul>
    </div>
  </div>
<?php } ?>

<?php
function show_jumbotron(){
?>
  <div class="jumbotron" style="box-shadow:8px 0px 15px #9B9B9B">
    <div class="container text-center">
      <h1>BG Store</h1>
      <p>Board Games for You</p>
    </div>
  </div>
<?php } ?>
