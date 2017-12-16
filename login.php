
<?php session_start();
  $_SESSION['currentpage']='login';
  require_once("navbar.php");
?>

<html lang="en">
<head>
  <title>BS Bookstore - Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css">
  <link rel="stylesheet" href="alert.css" type="text/css">
  <link rel="stylesheet" href="btnoutline.css" type="text/css">
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

<?php
  // if(!$_SESSION['disable']){
    $_SESSION['logout']=0;
  // }
  if($_SESSION['logstat']=="Log Out"){
    $_SESSION['logout']=1;
    header("Location: checklogin.php");
  }

?>

<!-- =============================== navbar ======================================= -->
<nav class="navbar navbar-inverse navbar-fixed-top">
  <?php show_navbar(); ?>
</nav>
  <!-- /////////////////////////////////////////////////////////////////////////// -->


<!-- ===================== Log in panel ============================= -->
<div class="container-fluid text-center">
  <br><br><br><br>
  <?php //======================================= if user is disabled ==========================================
    // $_SESSION['disable']='1';
      if(isset($_SESSION['disable']) && $_SESSION['disable']=='1'){
        $_SESSION['disable']='0';?>
        <div class="alert warning">
            <span class="closebtn">&times;</span>
            <strong>Your account has been disabled. Contact the admin via admin@mail.com</strong>
        </div>
        <script src="alert.js"></script>
        <?php
        unset($_SESSION['disable']);
      } /////////////////////////////////// END disable ////////////////////////////////////
      ?>
      <?php //======================================= if incorrect username or password ==========================================
        // $_SESSION['disable']='1';
          if(isset($_SESSION['incorrect']) && $_SESSION['incorrect']=='1'){
            $_SESSION['incorrect']='0';?>
            <div class="alert">
                <span class="closebtn">&times;</span>
                <strong>Incorrect username or password</strong>
            </div>
            <script src="alert.js"></script>
            <?php
            unset($_SESSION['incorrect']);
          } /////////////////////////////////// END incorrect ////////////////////////////////////
          ?>
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
      		<form action="checklogin.php" method="POST">
          		  <h2 >Log in to your account</h2><br>
            		<label style="display:inline-block;">Username</label>&nbsp;&nbsp;<input type="textbox" class="form-control" name="username" style="width:50%;display:inline-block;"><br><br>
            		<label style="display:inline-block;">Password</label>&nbsp;&nbsp;<input type="password" class="form-control" name="password" style="width:50%;display:inline-block;"><br><br>
        		<input type="submit" class="btn btn-primary" style="margin-right:20px;" name="login" value="Log in">
            <a href="forgotpassword.php">Forgot password?</a>
            <p style="padding-top:10px;">or&nbsp;&nbsp;<a href="register.php">Create a new account</a></p>
          </form>
		     </div>
         <div class="panel-footer"></div>
      </div>
  </div>
</div>
</div>
<!-- ////////////////////// END login panel //////////////////////////////// -->


</body>
</html>
