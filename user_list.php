<!DOCTYPE html>
<?php session_start(); ?>
<?php
    // $_SESSION['lastpage']='account';
    require_once('connect.php');
    require_once("navbar.php");
    $_SESSION['lastpage']='user_list.php';
    $_SESSION['currentpage']='account';

  ?>
<html lang="en">
<head>
  <title>BG Store - User List</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css">
  <link rel="stylesheet" href="modal.css" type="text/css">
  <link rel="stylesheet" href="btnoutline.css" type="text/css">
  <link rel="stylesheet" href="alert.css" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default rounded borders and increase the bottom margin */
    .navbar {
      margin-bottom: 0px;
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
      margin-top:15px;
    }

    .panel{
      border-color:#6B6A6A ;
      border-width:1.5px;
    }

    .panel-footer{
      background-color: #D7D7D7;
    }

/*---------------- CSS for alert tab -----------------*/
    /*.alert {
    padding: 20px;
    margin-left:20px;
    margin-right:20px;
    background-color: #f44336;
    font-size:15px;
    opacity:1;
    transition: opacity 0.6s;
    color: white;
    }

    .alert.success {background-color: #4CAF50;}
    .alert.info {background-color: #2196F3;}
    .alert.warning {background-color: #ff9800;}

    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }*/
/*----------------------------------------------------------*/
  </style>
</head>
<body>

  <!-- =============================== jumbotron ==================================== -->
  <!-- <?php show_jumbotron(); ?> -->
  <!-- ////////////////////////////////////////////////////////////////////////////// -->

<!-- =============================== navbar ======================================= -->
<nav class="navbar navbar-inverse navbar-fixed-top">
  <?php show_navbar(); ?>
</nav>
<br><br><br>
  <!-- /////////////////////////////////////////////////////////////////////////// -->

<!-- =================== USERNAME duplicated alert or pwd unmatched ======================= -->
<?php
    // $_SESSION['dupusername'] = '1';
    // $_SESSION['wrongpwd'] = '1';
    if(isset($_SESSION['dupusername'])){
        unset($_SESSION['dupusername']);?>
        <div class="alert warning">
            <span class="closebtn">&times;</span>
            <strong>This username is already existed !</strong>
        </div>
        <?php
    }
    if(isset($_SESSION['wrongpwd'])){
        unset($_SESSION['wrongpwd']);?>
        <div class="alert">
            <span class="closebtn">&times;</span>
            <strong>Password not matched</strong>
        </div>
        <?php
    }?>
    <script src="alert.js"></script>
<!-- /////////////////////// END alert ////////////////////////////////////// -->


<!-- ============================== add user =============================== -->

    <div class="text-center">
        <h1>Add User</h1>
        <p style="color:#656565;">(Type 1 = Admin / Type 2 = Member)</p>
    </div>
    <form id="add" action="user_edit.php" method="POST">
          <table align="center" class="table table-hover center row-add" style="width:95%;">
            <tr class="info">
              <th class="text-center" >Username</th>
              <th class="text-center" >Password</th>
              <th class="text-center" >Confirm Password</th>
              <th class="text-center" >First Name</th>
              <th class="text-center" >Last Name</th>
              <th class="text-center" >Type</th>
              <th class="text-center" >Email</th>
            </tr>
            <tr>
                <td class="text-left" style="width:14%;"><input type="text" maxlength="20" class="form-control" name="username" value="" style="width:100%;"></td>
                <td class="text-left" style="width:10%;"><input type="password" maxlength="20" class="form-control"  name="password" value="" style="width:100%;"></td>
                <td class="text-left" style="width:10%;"><input type="password" maxlength="20" class="form-control"  name="cpassword" value="" style="width:100%;"></td>
                <td class="text-left" style="width:21%;"><input type="text" maxlength="40" class="form-control"  name="fname" value="" style="width:100%;"></td>
                <td class="text-left" style="width:21%;"><input type="text" maxlength="40" class="form-control"  name="lname" value="" style="width:100%;"></td>
                <td class="text-center" style="width:4%;"><input type="text" maxlength="1" class="form-control text-center"  name="type" value="" style="width:100%;"></td>
                <td class="text-left" style="width:23%;"><input type="email" maxlength="50" class="form-control"  name="email" value="" style="width:100%;"></td>
            </tr>

          </table>
          <div class="text-center">
              <!-- <a href="#" class="add-row"><button class="btn-default btn" style="margin-bottom:5px;" type="button" name="add_row" value="Add more rows">Add more rows</button></a><br> -->
              <input class="btn-primary btn" style="margin-right:10px;display:inline-block;" type="submit" name="add_user" value="Add User" id="register" disabled="disabled">
              <input class="btn-default btn" style="margin-right:10px;display:inline-block;" type="submit" name="cancel" value="Cancel" formaction="user_list.php">
          </div>
    </form>

    <!-- ======================== Add user disabled until all fields are filled ==================== -->
    <script>
        function myFunction() {
            alert("Username is already used !");
        }
        (function() {
            $('#add input').keyup(function() {
                var empty = false;
                $('#add input').each(function() {
                    if ($(this).val() == '') {
                        empty = true;
                    }
                });

                if (empty) {
                    $('#register').attr('disabled', 'disabled'); // updated according to http://stackoverflow.com/questions/7637790/how-to-remove-disabled-attribute-with-jquery-ie
                } else {
                    $('#register').removeAttr('disabled'); // updated according to http://stackoverflow.com/questions/7637790/how-to-remove-disabled-attribute-with-jquery-ie
                }
            });
        })()
    </script>
    <!-- //////////////////////////////////// END script for disabled button ////////////////////////// -->
<!-- //////////////////////////////// END add user /////////////////////////////// -->

  <!-- ========================================= user list ================================== -->
  <?php
      $q = 'SELECT * FROM user JOIN usertype WHERE TYPE_ID = USER_TYPE ORDER BY USER_ID ASC';
      $result = $mysqli->query($q);
      $loopno = 1;
      if($result){
  ?>
          <br>
          <div id="edit" class="text-center">
              <h1>Edit Users</h1><br>
          </div>
          <form id="myform" action="user_edit.php" method="POST">
              <table align="center" class="table table-hover center" style="width:90%;">
                  <tr class="info">
                      <th class="text-center" >ID</th>
                      <th class="text-center" >Profile Picture</th>
                      <th class="text-center" >Username</th>
                      <th class="text-center" >Password</th>
                      <th class="text-center" >First Name</th>
                      <th class="text-center" >Last Name</th>
                      <th class="text-center" >Type</th>
                      <th class="text-center" >Email</th>
                      <th class="text-center" >Register Date</th>
                      <th></th>
                      <th class="text-center" >Detail</th>
                      <th class="text-center" >Status</th>
                      <!-- <th></th> -->
                  </tr>
                  <?php
                  while($row=$result->fetch_array()){ ?> <!-- ================= START while ================ -->
                      <tr style="color:
                          <?php
                              if($row['disable']){echo 'red;background:rgba(255, 213, 213,.4);';}
                              else{echo 'black;';}
                          ?>
                      ">
                        <?php
                        // ====================== ENTER if when request edit ==============================
                        if(isset($_POST['edit']) && $_POST['edit']== $row['USER_ID']){?>
                          <!-- =================== id =================== -->
                                    <td class="text-center" style="vertical-align:middle;width:5%;">
                                        <input type="hidden" name="id" value="<?=$row['USER_ID']?>">
                                        <?= $row['USER_ID']; ?>
                                    </td>
                                    <!-- =================== img =================== -->
                                    <td class="text-center" style="vertical-align:middle;">
                                        <img src="profile/<?=$row['propic']?>" style="height:60px;width:60;border-radius:50%;">
                                    </td>
                                    <!-- =================== username =================== -->
                                    <td class="text-left" style="vertical-align:middle;width:10%;;">
                                        <input type="text" class="form-control"  name="username" value="<?=$row['USER_NAME']?>" style="width:100%;">
                                    </td>
                                    <!-- =================== password =================== -->
                                    <td class="text-left" style="vertical-align:middle;width:10%;;">
                                          <input type="text" class="form-control"  name="password" value="<?=$row['USER_PASSWORD']?>" style="width:100%;">
                                    </td>
                                    <!-- =================== fname =================== -->
                                    <td class="text-left" style="vertical-align:middle;width:15%;">
                                        <input type="text" class="form-control"  name="fname" value="<?=$row['USER_FNAME']?>" style="width:95%;display:inline-block;">
                                    </td>
                                    <!-- =================== lname =================== -->
                                    <td class="text-left" style="vertical-align:middle;width:15%;">
                                        <input type="text" class="form-control"  name="lname" value="<?=$row['USER_LNAME']?>" style="width:95%;display:inline-block;">
                                    </td>
                                    <!-- =================== type =================== -->
                                    <td class="text-center" style="vertical-align:middle;">
                                        <?=$row['TYPE_NAME']?>
                                    </td>
                                    <!-- =================== email =================== -->
                                    <td class="text-center" style="vertical-align:middle;width:15%;">
                                        <input type="text" class="form-control"  name="email" value="<?=$row['USER_EMAIL']?>" style="width:90%;">
                                        </td>
                                    <!-- =================== register date =================== -->
                                    <td class="text-center" style="vertical-align:middle;width:10%;">
                                        <?=$row['register_date']?>
                                    </td>
                                    <!-- =================== save =================== -->
                                    <td id="<?=$row['USER_ID']?>" class="text-center" style="vertical-align:middle;width:5%;">
                                        <button class="btn btn-info btn-sm" type="submit" form="myform" name="update" value="Update Changes">Save</button>
                                        <input class="btn-default btn btn-sm" style="display:inline-block;margin-top:6px;color:#858585;" type="submit" name="cancel" value="Cancel" formaction="user_list.php#<?=$_POST['edit']?>">
                                    </td>
                                    <!-- =================== detail =================== -->
                                    <td id="<?=$row['USER_ID']?>" class="text-center" style="vertical-align:middle;width:4%;">
                                        <form id="detail_form" action="user_list_detail.php" method="POST">
                                          <button class="btn btn-outline-primary btn-sm" type="submit" form="detail_form" name="detail" value="<?=$row['USER_ID']?>">Detail</button>
                                        </form>
                                    </td>
                                    <!-- =================== disable button =================== -->
                                    <td class="text-center" style="vertical-align:middle;width:40px;">
                                      <form id="disable_form" action="user_edit.php" method="POST">
                                        <button
                                          <?php
                                              if(!$row['disable']){echo 'class="btn btn-outline-success" onclick="return confirm(\'Do you want to DISABLE this user?\')"';}
                                              else{echo 'class="btn btn-outline-danger" onclick="return confirm(\'Do you want to ENABLE this user?\')"';}
                                          ?>
                                        form="disable_form" type="submit" name="disable" value="<?= $row['USER_ID']?>">
                                          <?php
                                              if(!$row['disable']){echo "Enabled";}
                                              else{echo "Disabled";}
                                          ?>
                                        </button>
                                      </form>
                                    </td>
                                </tr>
                              <?php
                        }else{?> <!-- =================================START else=========================== -->
                                    <!-- =================== id =================== -->
                                    <td class="text-center" style="vertical-align:middle;width:5%;">
                                      <?= $row['USER_ID']; ?>
                                    </td>
                                    <!-- =================== img =================== -->
                                    <td class="text-center" style="vertical-align:middle;width:9%;">
                                        <img src="profile/<?=$row['propic']?>" style="height:60px;width:60;border-radius:50%;">
                                    </td>
                                    <!-- =================== username =================== -->
                                    <td class="text-left" style="vertical-align:middle;width:10%;;">
                                        <?=$row['USER_NAME']?>
                                    </td>
                                    <td class="text-left" style="vertical-align:middle;width:10%;;">
                                      PRIVATE INFO
                                    </td>
                                    <!-- =================== fname =================== -->
                                    <td class="text-left" style="vertical-align:middle;width:12%;">
                                        <?=$row['USER_FNAME']?>
                                    </td>
                                    <!-- =================== lname =================== -->
                                    <td class="text-left" style="vertical-align:middle;width:12%;">
                                        <?=$row['USER_LNAME']?>
                                    </td>
                                    <!-- =================== type =================== -->
                                    <td class="text-center" style="vertical-align:middle;">
                                        <?=$row['TYPE_NAME']?>
                                    </td>
                                    <!-- =================== email =================== -->
                                    <td class="text-left" style="vertical-align:middle;width:15%;">
                                        <span style="padding-left:6%"><?=$row['USER_EMAIL']?></span>
                                    </td>
                                    <!-- =================== register date =================== -->
                                    <td class="text-center" style="vertical-align:middle;width:10%;">
                                        <?=$row['register_date']?>
                                    </td>
                                    <!-- =================== edit =================== -->
                                    <td id="<?=$row['USER_ID']?>" class="text-center" style="vertical-align:middle;width:5%;">
                                        <form id="edit_form" action="user_list.php#edit" method="POST">
                                          <button class="btn btn-outline-info btn-sm" type="submit" form="edit_form" name="edit" value="<?=$row['USER_ID']?>">Edit</button>
                                        </form>
                                    </td>
                                    <!-- =================== detail =================== -->
                                    <td id="<?=$row['USER_ID']?>" class="text-center" style="vertical-align:middle;width:4%;">
                                        <form id="detail_form" action="user_list_detail.php" method="POST">
                                          <button class="btn btn-outline-primary btn-sm" type="submit" form="detail_form" name="detail" value="<?=$row['USER_ID']?>">Detail</button>
                                        </form>
                                    </td>
                                    <!-- =================== disable button =================== -->
                                    <td class="text-center" style="vertical-align:middle;width:40px;">
                                        <!-- ========= Trigger/Open The Modal ================ -->
                                        <form id="disable_form" action="user_edit.php" method="POST">
                                          <button
                                            <?php
                                                if(!$row['disable']){echo 'class="btn btn-outline-success" onclick="return confirm(\'Do you want to DISABLE this user?\')"';}
                                                else{echo 'class="btn btn-outline-danger" onclick="return confirm(\'Do you want to ENABLE this user?\')"';}
                                            ?>
                                          form="disable_form" type="submit" name="disable" value="<?= $row['USER_ID']?>">
                                            <?php
                                                if(!$row['disable']){echo "Enabled";}
                                                else{echo "Disabled";}
                                            ?>
                                          </button>
                                        </form>
                                    </td>
                                </tr>
                              <?php
                            }  ////////////////////////////////////////////////// END else //////////////////////
                          }  ////////////////////////////////////////////////// END while //////////////////////
                          ?>
                        </table>
              <?php
              if(isset($_POST['edit'])){ //=========== show button only when click edit
                  ?>
                  <div class="text-center">
                    <!-- <input class="btn-default btn" style="display:inline-block;" type="submit" name="cancel" value="Cancel" formaction="user_list.php#<?=$_POST['edit']?>"> -->
                  </div>
                  <?php
              } ?>
          </form>
          <br><br><br>
          <?php
      }?>
   <!-- ////////////////////////////////// END show user ////////////////////////////////////// -->


</body>
</html>
