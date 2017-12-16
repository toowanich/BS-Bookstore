<!DOCTYPE html>
<?php session_start();
  require_once('navbar.php');
 ?>
<html lang="en">
<head>
  <title>BS Bookstore - Forgot Password</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css">
  <link rel="stylesheet" href="alert.css" type="text/css">
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
      left:0;
      right:0;
      bottom:0;
    }

    .form label{
      text-align: right;
      width:125px;
    }

    div#div_content{
    	background-color:white;
    	min-height: 400px;
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


<!-- ================================= navbar ================================== -->
<nav class="navbar navbar-inverse navbar-fixed-top">
  <?php show_navbar(); ?>
</nav>
<!-- /////////////////////////////////////////////////////////////////////////// -->
<br><br><br><br>



<!-- ===================== forgot panel ============================= -->
<?php
if(isset($_SESSION['forgotpwd'])){?>
    <div class="text-center">
        <h2>Email Sent</h2>
        <p>A temporarily password has been sent to your email.</p>
    </div>
    <?php
    unset($_SESSION['forgotpwd']);
}else{
    if(isset($_SESSION['errorforgot'])){ ?>
        <div class="alert text-center">
            <span class="closebtn">&times;</span>
            <strong>Username or email incorrect</strong>
        </div>
        <script src="alert.js"></script>
        <?php
    }
    ?>

    <div class="container-fluid text-center">
      <div class="row content">
        <div class="col-sm-2 sidenav">
          <!-- left space -->
        </div>
        <div class="col-sm-2 sidenav">
          <!-- left space -->
        </div>

        <div class="col-sm-4 text-center center">
          <div class="panel panel-primary center-block">
            <div class="panel-body">
            		<form action="checkforgot.php" method="POST">
              		  <h2>Enter your username and email</h2><br>
                		<label style="text-align:right;width:80px;">Username&nbsp;&nbsp;</label><input type="textbox" name="username"><br><br>
                		<label style="text-align:right;width:80px;">Email&nbsp;&nbsp;</label><input type="email" name="email"><br><br>
            		    <input type="submit" class="btn btn-primary" style="margin-right:20px;" name="submit" value="Request Password">
                </form>
            </div>
            <div class="panel-footer"></div>
          </div>
        </div>
      </div>
    </div>
<?php } ?>
<!-- ///////////////////////////// END forgot panel //////////////////////////////////// -->


</body>
</html>
