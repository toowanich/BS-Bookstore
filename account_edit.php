<!DOCTYPE html>
<?php session_start();
$_SESSION['currentpage']='account';
require_once("navbar.php");
require_once('connect.php');
?>

<html lang="en">
<head>
  <title>BS Bookstore - Account</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css">
  <link rel="stylesheet" href="alert.css" type="text/css">
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
    .container {
  position: relative;
  width: 50%;
}

.image {
  display: block;
  width: 100%;
  height: auto;
}

.overlay {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  height: 100%;
  width: 100%;
  opacity: 0;
  transition: .5s ease;
  background-color: #008CBA;

}

.container:hover .overlay {
  opacity: 1;
}

.text {
  color: white;
  font-size: 20px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
}
  </style>
</head>
<body>



  <!-- =============================== navbar ======================================= -->
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <?php show_navbar(); ?>
  </nav>
    <!-- /////////////////////////////////////////////////////////////////////////// -->



<!-- ========================================================= profile ========================================================= -->

  <div class="container-fluid text-center">
      <div class="row content">
        <br><br><br>
          <?php
          // $_SESSION['currentpwdcheck']='1';
          if(isset($_SESSION['currentpwdcheck']) && $_SESSION['currentpwdcheck']=='1' ){
            $_SESSION['currentpwdcheck']='0';?>
            <div class="alert text-center">
              <span class="closebtn">&times;</span>
              <strong>Incorrect Current Password</strong>
            </div>
            <script src="alert.js"></script>
            <?php
          }
          ?>
          <h2>My Account</h2>
          <?php
          $id=$_SESSION['id'];
          $q="SELECT propic from user where USER_ID='$id';";
          $res=$mysqli->query($q);
          $row=$res->fetch_array()
          ?>
          <img src="profile/<?=$row['propic'] ?>" alt="<?=$row['propic'] ?>" style="width:150px;height:150px;border-radius: 50%;">

          <?php
          $q='SELECT * FROM user WHERE user.USER_ID='.$_SESSION['id'];
          $res=$mysqli->query($q);
          $row=$res->fetch_array();
          ?>
          <br><br>
          <div>
              <form action="account.php" method="POST" enctype="multipart/form-data">
                  Upload new profile picture: <input type="file" name="filUpload" style="display: inline-block;"><br><br>
                  <table align="center">
                      <tr>
                        <td class="text-right">First name <span style="color:red;">*</span>:&nbsp;</td>
                        <td><input class="form-control" id="inputsm" type="text" name="user_fname" value="<?= $row['USER_FNAME'] ?>"required></td>
                      </tr>
                      <tr><td>&nbsp;</td></tr>
                      <tr>
                        <td class="text-right">Last name <span style="color:red;">*</span>:&nbsp;</td>
                        <td><input class="form-control" id="inputsm" type="text" name="user_lname" value="<?= $row['USER_LNAME'] ?>"required></td>
                      </tr>
                      <tr><td>&nbsp;</td></tr>
                      <tr>
                        <td class="text-right">E-mail <span style="color:red;">*</span>:&nbsp;</td>
                        <td><input class="form-control" type="email" name="user_email" value="<?= $row['USER_EMAIL'] ?>"required></td>
                      </tr>
                      <tr><td>&nbsp;</td></tr>
                      <tr>
                        <td class="text-right">New password:&nbsp; </td>
                        <td><input id="password" maxlength="20" class="form-control" type="password" name="user_newpassword"></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td></tr>
                      <tr>
                        <td class="text-right">Confirm new password:&nbsp;</td>
                        <td><input id="confirm_password" maxlength="20" class="form-control" type="password" name="user_confirmpassword"></td>
                      </tr>
                      <tr><td>&nbsp;</td></tr>
                      <tr>
                        <td class="text-right">Current password <span style="color:red;">*</span>:&nbsp; </td>
                        <td><input class="form-control" type="password" name="user_currentpassword" required></td>
                      </tr>
                  </table>
                  <br>
                  <input class="btn btn-success" type="submit" name="account_update" value="Update">
                  <a href="account.php" class="btn btn-default">Cancel</a>
              </form>
          </div>
      </div>
      <br>
      <script>
          var password = document.getElementById("password")
          , confirm_password = document.getElementById("confirm_password");

          function validatePassword(){
            if(password.value != confirm_password.value) {
              confirm_password.setCustomValidity("Passwords Don't Match");
            } else {
              confirm_password.setCustomValidity('');
            }
          }

          password.onchange = validatePassword;
          confirm_password.onkeyup = validatePassword;
      </script>
  </div>
  <!-- ////////////////////////////////////////////// END profile //////////////////////////////////////////////////////////////////// -->

</body>


</html>
