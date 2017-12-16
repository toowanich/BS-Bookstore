<!DOCTYPE html>
<?php session_start();
  require_once('navbar.php');
 ?>
<html lang="en">
<head>
  <title>BS Bookstore - Register</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css">
  <link rel="stylesheet" href="alert.css" type="text/css">
  <link rel="stylesheet" href="tooltips.css" type="text/css">
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
<?php //================================== if username duplicated or p&c unmatched =====================
  if(isset($_SESSION['dupname']) && $_SESSION['dupname']){?>
    <div class="alert warning text-center">
        <span class="closebtn">&times;</span>
        <strong>This username is already existed !</strong>
    </div>
    <script src="alert.js"></script>
    <?php
    $_SESSION['dupname'] = false;
    $_SESSION['pcunmatch'] = false;
  }else if(isset($_SESSION['pcunmatch']) && $_SESSION['pcunmatch']){?>
    <div class="alert text-center">
        <span class="closebtn">&times;</span>
        <strong>Password Unmatched</strong>
    </div>
    <script src="alert.js"></script>
    <?php
  }else{}
    ////////////////////////////// END error ////////////////////////////////////////////////////////////////
  ?>
<!-- ===================== register panel ============================= -->
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
        <div id="div_content" class="panel-body form">

      		<form action="checkregister.php" method="POST">
      		  <h2 style="height:13px;">Register Your Account</h2><br>


          <br>
          <label style="display:inline-block">Firstname&nbsp;<span style="color:red;">*</span></label> <input class="form-control" style="width:50%;display:inline-block;" required type="textbox" name="fname"
            <?php
              if(isset($_SESSION['error']) && $_SESSION['error'])
              {echo ' value='.$_SESSION['f'];}
            ?>
          ><br><br>
          <label style="display:inline-block">Lastname&nbsp;<span style="color:red;">*</span></label> <input class="form-control" style="width:50%;display:inline-block;" required type="textbox" name="lname"
            <?php
              if(isset($_SESSION['error']) && $_SESSION['error'])
              {echo ' value='.$_SESSION['l'];}
            ?>
          ><br><br>
          <label style="display:inline-block">Email&nbsp;<span style="color:red;">*</span></label> <input class="form-control" style="width:50%;display:inline-block;" required type="email" name="email"
            <?php
              if(isset($_SESSION['error']) && $_SESSION['error'])
              {echo ' value='.$_SESSION['e'];}
            ?>
          ><br><br>
      		<label style="display:inline-block">Username&nbsp;<span style="color:red;">*</span>
              <span class="tooltips"><span class="glyphicon glyphicon-question-sign"></span>
                  <span class="tooltipstext">Maximum 20 characters</span>
              </span>
          </label>
          <input required class="form-control" style="width:50%;display:inline-block;" type="textbox" name="username" maxlength="20"
            <?php
              if(isset($_SESSION['error']) && $_SESSION['error'])
              {echo ' value='.$_SESSION['u'];}
            ?>
          ><br>
      		<br><label style="display:inline-block"
            <?php
              if(isset($_SESSION['pcunmatch']) && $_SESSION['pcunmatch']){
                echo ' style="color:#E50000;"';
              }
            ?>
          >Password&nbsp;<span style="color:red;">*</span>
              <span class="tooltips"><span class="glyphicon glyphicon-question-sign"></span>
                  <span class="tooltipstext">Maximum 20 characters</span>
              </span>
          </label>
          <input required class="form-control" style="width:50%;display:inline-block;" type="password" name="password" maxlength="20"
            <?php
              if(isset($_SESSION['pcunmatch']) && $_SESSION['pcunmatch'])
              {echo ' style="border-style:solid;border-color:#E50000;"';}
            ?>><br>
            <br>
          <label style="display:inline-block;width:inherit;margin-left:-10px;"
            <?php
              if(isset($_SESSION['pcunmatch']) && $_SESSION['pcunmatch']){
                echo ' style="color:#E50000;"';

              }
            ?>
          >Confirm Password&nbsp;<span style="color:red;">*</span></label> <input class="form-control" style="width:50%;display:inline-block;" required type="password" name="confirm"
            <?php
              if(isset($_SESSION['pcunmatch']) && $_SESSION['pcunmatch']){
                echo ' style="border-style:solid;border-color:#E50000;"';
                $_SESSION['error']=false;
                $_SESSION['pcunmatch'] = false;
              }
            ?>><br><br>
      		<input type="submit" class="btn btn-primary" style="margin-right:20px;" name="submit" value="Register">
          <a href="login.php"><button class="btn btn-default" type="button"><span style="color:black;">Cancel</span></button></a>
          <!-- <input type="submit" style="margin-right:20px;" name="submit" value="Cancel"> -->
      		</form>
		     </div>
         <div class="panel-footer"></div>
      </div>
  </div>
</div>
</div>
<!-- ///////////////////////////// END register panel //////////////////////////////////// -->


</body>
</html>
