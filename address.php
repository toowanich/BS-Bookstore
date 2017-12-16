<!DOCTYPE html>
<?php session_start();
$_SESSION['currentpage']='account';
$_SESSION['lp']='account.php';
require_once("navbar.php");
require_once('connect.php');




/////////////////////////////////////////// END edit account ///////////////////////////////////////

// ========================================= Edit account ===============================
if(isset($_POST['address_update'])){
    $id=$_SESSION['id'];
    $addressDetails = array($_POST['address0'],$_POST['address1'],$_POST['address2']);
    $addressIDArrayUp = array($_POST['addressIDArray0'],$_POST['addressIDArray1'],$_POST['addressIDArray2']);
    for ($i=0; $i <3 ; $i++) {
      $addr=$addressDetails[$i];
      $addrid=$addressIDArrayUp[$i];
      if($addrid==0){
        $q="INSERT INTO address (address_details, user_id) VALUES ('$addr','$id')";
      }
      else{
        $q="UPDATE address SET address_details='$addr' WHERE address_id='$addrid'";
      }
      $res=$mysqli->query($q);
    }
    header("Location:account.php");
}
/////////////////////////////////////// END edit address //////////////////////////////

?>

<html lang="en">
<head>
  <title>BS Bookstore - Address</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css">
  <link rel="stylesheet" href="btnoutline.css" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default rounded borders and increase the bottom margin */
    .navbar {
      margin-bottom: 0;
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


  <!-- =============================== navbar ======================================= -->
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <?php show_navbar(); ?>
  </nav>
  <div class="container-fluid text-center">
      <div class="row content"><br><br><br>
        <?php
        $id=$_SESSION['id'];
        $addressArray = array("","","");
        $addressIDArray = array(0,0,0);
        // $defaultArray = array(0,0,0);
        $i=0;
        $q="SELECT * from address where user_id='$id'";
        $res=$mysqli->query($q);
        if($res){
        while($row=$res->fetch_array()){
          $addressArray[$i]=$row['address_details'];
          $addressIDArray[$i]=$row['address_id'];
          // $defaultArray[$i]=$row['default_address'];
          $i=$i+1;
        }
      }
      ?>
        <form id="address_edit" action="address.php" method="post">
          <div align="center">
          <h1>Manage your addresses</h1><br>
          Address 1:&nbsp;
          <textarea rows="3" cols="50" style="width: auto;display:inline-block;vertical-align:middle;resize:vertical;" class="form-control" name="address0" form="address_edit" placeholder="Please insert your address here..."><?php echo $addressArray[0]; ?></textarea><br>
          <br>Address 2:&nbsp;
          <textarea rows="3" cols="50" style="width: auto;display:inline-block;vertical-align:middle;resize:vertical;" class="form-control" name="address1" form="address_edit" placeholder="Please insert your address here..."><?php echo $addressArray[1]; ?></textarea><br>
          <br>Address 3:&nbsp;
          <textarea rows="3" cols="50" style="width: auto;display:inline-block;vertical-align:middle;resize:vertical;" class="form-control" name="address2" form="address_edit" placeholder="Please insert your address here..."><?php echo $addressArray[2]; ?></textarea>
        </div><br>
        <input type="hidden" name="addressIDArray0" value="<?=$addressIDArray[0]?>">
        <input type="hidden" name="addressIDArray1" value="<?=$addressIDArray[1]?>">
        <input type="hidden" name="addressIDArray2" value="<?=$addressIDArray[2]?>">
          <input class="btn btn-success" type="submit" name="address_update" value="Update">
          <a href="account.php" class="btn btn-default">Go back</a>
        </form>
      </div>
  </div>

</body>
</html>
