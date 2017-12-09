<!DOCTYPE html>
<?php session_start(); ?>
<?php
    // session_destroy();
    $_SESSION['currentpage']='contact';
    $_SESSION['cartquantity']=0;
    require_once("navbar.php");
  ?>
<html lang="en">
<head>
  <title>BG Store - Contact</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css">
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
      position: absolute;
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
  </style>
</head>
<body>

  <!-- =============================== jumbotron ==================================== -->
  <?php show_jumbotron(); ?>
  <!-- ////////////////////////////////////////////////////////////////////////////// -->

<!-- =============================== navbar ======================================= -->
<nav class="navbar navbar-inverse navbar-fixed-top">
  <?php show_navbar(); ?>
</nav>
  <!-- /////////////////////////////////////////////////////////////////////////// -->
  <!-- <h3>BG Store</h3>
  <p><b>Tel:</b> 081-2345678<br><b>Facebook Page:</b> BG Store<br><b>Line ID:</b> BGStore</p> -->

  <div class="container">
    <div class="row">
      <div class="col-sm-3 text-left">
        <h3>Contact us</h3>
        <p><b><img src="img/2013-08-26_09-38-25__Phone_iOS7_App_Icon_Rounded.png" style="width:25px;"></b> 081-2345678</p>
          <p><b><img src="img/facebook.png" style="width:25px;"></b> BG Store</p>
          <p><b><img src="img/LINE_Icon.png" style="width:25px;"></b> BGStore</p>
      </div>
      <div class="col-sm-3 text-left">
        <h3>Payment method</h3>
        <img src="img/kasikornlogo.png" alt="kasikorn" style="width:50px;float:left;">
        <p>&nbsp;&nbsp;Account name: Pawat Treepoca<br>&nbsp;&nbsp;Account no.: KKKKKKKKKK</p><br>
        <img src="img/ouwyyvdzoS7lL7050LN-o.png" alt="ktb" style="width:50px;float:left;">
        <p>&nbsp;&nbsp;Account name: Pawat Treepoca<br>&nbsp;&nbsp;Account no.: XXXXXXXXXX</p>
      </div>
    </div>
  </div>
<footer class="container-fluid text-center">
  <p>BG Store</p>
</footer>

</body>
</html>
