<!DOCTYPE html>
<?php session_start(); ?>
<?php
    $_SESSION['lastpage']='product_list.php';
    $_SESSION['currentpage']='account';
    require_once('connect.php');
    require_once("navbar.php");
  ?>
<html lang="en">
<head>
  <title>BG Store - Product List</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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

  <!-- =================== product already in the list ======================= -->
  <?php
      // $_SESSION['dupproduct']='1';
      if(isset($_SESSION['dupproduct'])){
          unset($_SESSION['dupproduct']);?>
          <div class="alert warning">
              <span class="closebtn">&times;</span>
              <strong>This product is already in the list !</strong>
          </div>
          <?php
      }?>
      <script src="alert.js"></script>

    <!-- /////////////////////////////////////////////////////////////////////////// -->

<!-- ============================== add product =============================== -->
<div class="text-center">
    <h1>Add Product</h1><br>
</div>
<form action="product_edit.php" method="POST" id="add" enctype="multipart/form-data">
      <table align="center" class="table table-hover center row-add" style="width:94%;">
        <tr class="info">
            <th class="text-center" >Product</th>
            <th class="text-center" >Price</th>
            <th class="text-center" >%Discount</th>
            <th class="text-center" >Quantity</th>
            <th class="text-center" >Tag</th>
            <th class="text-center" >Description</th>
            <th class="text-center" >Image File</th>
        </tr>
        <tr>
            <td class="text-center" style="width:20%;"><input id="in" type="text" class="text-left form-control" name="name" style="width:100%;"></td>
            <td class="text-center" style="width:8%;"><input id="in" type="text" class="form-control" name="price" value="" style="width:100%;"></td>
            <td class="text-center" style="width:8%;"><input id="in" type="text" class="form-control" name="discount" style="width:100%;"></td>
            <td class="text-center" style="width:8%;"><input id="in" type="text" name="quantity" class="form-control" style="width:100%;"></td>
            <td class="text-center" ><input id="in" type="text" class="form-control" name="tag" style="width:100%;"></td>
            <td class="text-left" style="width:28%;"><textarea form="add" class="form-control" name="desc" style="width:100%;resize:vertical;"></textarea></td>
            <td class="text-center" style="vertical-align:top;"><input type="file" name="image" style="width:100%;"></td>
        </tr>

      </table>
      <div class="text-center">
          <input class="btn-primary btn" style="margin-right:10px;display:inline-block;" type="submit" name="add_product" form="add" value="Add Product" id="register" disabled="disabled">
          <input class="btn-default btn" style="margin-right:10px;display:inline-block;" type="submit" name="cancel" value="Cancel" formaction="product_list.php">
      </div>

      <script>
      (function() {
        $('#add #in').keyup(function() {
          var empty = false;
          $('#add #in').each(function() {
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
</form>
<!-- ======================== Add product disabled until all fields are filled ==================== -->
<br>
<!-- //////////////////////////////////// END script for disabled button ////////////////////////// -->
<!-- //////////////////////////////// END add product /////////////////////////////// -->


<!-- ========================================= product list ================================== -->
<?php
    $q = 'SELECT * FROM product ORDER BY product_id ASC';
    $result = $mysqli->query($q);
    $qc = 'SELECT * FROM product_delete ORDER BY delete_date ASC';
    $results = $mysqli->query($q);?>
    <div id="edit"  class="text-center">
        <h1>Edit Products</h1>
    </div><?php
    if($check=$results->fetch_array()){
?>
        <br>
        <form id="myform" action="product_edit.php" method="POST">
            <table align="center" class="table table-hover center" style="width:94%;">
                <tr class="info">
                    <th class="text-center" >ID</th>
                    <th class="text-center" colspan="2">Product</th>
                    <th class="text-center" >Price</th>
                    <th class="text-center" >%Discount</th>
                    <th class="text-center" >Date added</th>
                    <th class="text-center" >Quantity</th>
                    <th class="text-center" >Tag</th>
                    <th class="text-center" >Description</th>
                    <th class="text-center" >Image File</th>
                    <th></th>
                    <th class="text-center" >Delete</th>
                </tr>
                <?php
                while($row=$result->fetch_array()){?>
                  <tr style="background:
                      <?php
                          if($row['quantity']==0){echo 'rgba(255, 213, 213,.3);';}
                          // else{echo 'transparent;';}
                      ?>
                  ">
                  <?php // ====================== ENTER if when request edit ==============================
                  if(isset($_POST['edit']) && $_POST['edit']== $row['product_id']){
                  ?>
                            <!-- =================== id =================== -->
                            <td class="text-center" style="vertical-align:middle;">
                                <?=$row['product_id']?>
                                <input type="hidden" name="id" value="<?=$row['product_id']?>">
                            </td>
                            <!-- =================== img =================== -->
                            <td class="text-center" style="vertical-align:middle;">
                                <img src="img/<?=$row['product_pic']?>" style="height:40px;">
                            </td>
                            <!-- =================== name =================== -->
                            <td class="text-left" style="vertical-align:middle;width:15%;">
                                <input class="text-left form-control" type="text" style="width:100%;" name="name" value="<?= $row['product_name']?>">
                            </td>
                            <!-- =================== price =================== -->
                            <td class="text-center" style="vertical-align:middle;width:6%;">
                                <input class="text-center form-control" type="text" style="width:100%;" name="price" value="<?= floatval($row['product_price'])?>">
                            </td>
                            <!-- =================== discount =================== -->
                            <td class="text-center" style="vertical-align:middle;width:4%;">
                                <input class="text-center form-control" type="text" style="width:100%;" name="discount" value="<?=$row['product_discount'] ?>">
                            </td>
                            <!-- =================== add date =================== -->
                            <td class="text-center" style="vertical-align:middle;">
                                <?=$row['add_date']?>
                            </td>
                            <!-- =================== quantity =================== -->
                            <td class="text-center" style="vertical-align:middle;width:5%;">
                                <input class="text-center form-control" type="text" style="width:100%;" name="quantity" value="<?= $row['quantity']?>">
                            </td>
                            <!-- =================== tag =================== -->
                            <td class="text-left" style="vertical-align:middle;">
                                <input class="text-left form-control" type="text" style="width:100%;" name="tag" value="<?= $row['product_tag']?>">
                            </td>
                            <!-- =================== description =================== -->
                            <td class="text-left" style="vertical-align:middle;width:17%;">
                                <textarea class="text-left form-control" type="text" form="myform" style="width:100%;resize:vertical;" name="desc"><?= $row['description']?></textarea>
                            </td>
                            <!-- =================== pic file name =================== -->
                            <td class="text-left" style="vertical-align:middle;">
                                <input class="text-left form-control" type="text" style="width:100%;" name="pic" value="<?=$row['product_pic']?>">
                            </td>
                            <!-- =================== save =================== -->
                            <td id="<?=$row['product_id']?>" class="text-center" style="vertical-align:middle;width:5%;">
                                <button class="btn btn-info btn-sm" type="submit" form="myform" name="update" value="Update Changes">Save</button>
                                <input class="btn-default btn-sm btn" style="display:inline-block;margin-top:6px;color:#858585;" type="submit" name="cancel" value="Cancel" formaction="product_list.php#edit">
                            </td>
                            <!-- =================== delete button =================== -->
                            <td class="text-center" style="vertical-align:middle;">
                                <!-- ========= Trigger/Open The Confirmation ================ -->
                                <button form="myform" onclick="return confirm('Do you want to delete this item?')" type="submit" style="background-color:transparent;border:none;" name="delete" value="<?= $row['product_id']?>"><img src="img/close_red.png" style="height:20px;"></button>
                            </td>
                        </tr>
                  <?php
                }else{?>
                      <!-- =================== id =================== -->
                      <td class="text-center" style="vertical-align:middle;">
                          <?=$row['product_id']?>
                      </td>
                      <!-- =================== img =================== -->
                      <td class="text-center" style="vertical-align:middle;">
                          <img src="img/<?=$row['product_pic']?>" style="height:40px;">
                      </td>
                      <!-- =================== name =================== -->
                      <td class="text-left" style="vertical-align:middle;width:15%;">
                          <?= $row['product_name']?>
                      </td>
                      <!-- =================== price =================== -->
                      <td class="text-center" style="vertical-align:middle;width:6%;">
                          <?= number_format($row['product_price'])?>
                      </td>
                      <!-- =================== discount =================== -->
                      <td class="text-center" style="vertical-align:middle;width:4%;">
                          <?php if($row['product_discount']!=0){echo "<span style='font-weight:bold;background-color:#B4D8B6;'>&nbsp;".$row['product_discount']."&nbsp;</span>";}
                          else{echo $row['product_discount'];} ?>
                      </td>
                      <!-- =================== add date =================== -->
                      <td class="text-center" style="vertical-align:middle;">
                          <?=$row['add_date']?>
                      </td>
                      <!-- =================== quantity =================== -->
                      <td class="text-center" style="vertical-align:middle;width:5%;">
                        <?php if($row['quantity']==0){echo "<span style='font-weight:bold;background-color:#F0CACA;'>&nbsp;".$row['quantity']."&nbsp;</span>";}
                        else{echo $row['quantity'];} ?>
                      </td>
                      <!-- =================== tag =================== -->
                      <td class="text-left" style="vertical-align:middle;">
                          <?= $row['product_tag']?>
                      </td>
                      <!-- =================== description =================== -->
                      <td class="text-left" style="vertical-align:middle;width:17%;">
                          <textarea readonly class="text-left form-control" type="text" style="width:100%;resize:vertical;" name="des" ><?= $row['description']?></textarea>
                      </td>
                      <!-- =================== pic file name =================== -->
                      <td class="text-left" style="vertical-align:middle;">
                          <?=$row['product_pic']?>
                      </td>
                      <!-- =================== edit =================== -->
                      <td id="<?=$row['product_id']?>" class="text-center" style="vertical-align:middle;width:5%;">
                        <form id="edit_form" action="product_list.php#edit" method="POST">
                          <button class="btn btn-outline-info btn-sm" type="submit" form="edit_form" name="edit" value="<?=$row['product_id']?>">Edit</button>
                        </form>
                      </td>
                      <!-- =================== delete button =================== -->
                      <td class="text-center" style="vertical-align:middle;">

                          <!-- ========= Trigger/Open The Confirmation ================ -->
                          <button onclick="return confirm('Do you want to delete this item?')" type="submit" style="background-color:transparent;border:none;" name="delete" value="<?= $row['product_id']?>"><img src="img/close_red.png" style="height:20px;"></button>

                      </td>
                  </tr>
                    <?php
                }
              } ?>
            </table>
            <div class="text-center">
              <?php
              if(isset($_POST['edit'])){
              ?>
              <!-- <input class="btn-default btn" style="display:inline-block;" type="submit" name="cancel" value="Cancel" formaction="product_list.php#edit"> -->
                  <?php
              } ?>
            </div>
        </form>

        <?php
    }else{?>
      <div class="text-center">
          <h1>No products available</h1>
      </div>

      <?php
    } ?>
<!-- ////////////////////////////////// END show product ////////////////////////////////////// -->

<!-- ================================== SHOW deleted products ============================ -->
<?php
    $q = 'SELECT * FROM product_delete ORDER BY delete_date ASC';
    $resulto = $mysqli->query($q);
    $qc = 'SELECT * FROM product_delete ORDER BY delete_date ASC';
    $results = $mysqli->query($q);?>
    <div id="edit"  class="text-center">
        <h1>Deleted Products</h1>
    </div><?php
    if($check=$results->fetch_array()){
?>
        <br>
        <form id="myform" action="product_edit.php" method="POST">
            <table id="deleted" align="center" class="table table-hover center" style="width:94%;">
                <tr class="info">
                    <th class="text-center" >ID</th>
                    <th class="text-center" >Date deleted</th>
                    <th class="text-center" >Product ID</th>
                    <th class="text-center" colspan="2">Product</th>
                    <th class="text-center" >Price</th>
                    <!-- <th class="text-center" >%Discount</th> -->
                    <th class="text-center" >Quantity</th>
                    <th class="text-center" >Tag</th>
                    <th class="text-center" >Image File</th>
                    <th></th>
                    <th class="text-center" >Delete</th>
                </tr>
                <?php
                while($row=$resulto->fetch_array()){?>
                  <tr>
                      <!-- =================== id =================== -->
                      <td class="text-center" style="vertical-align:middle;">
                          <?=$row['id']?>
                      </td>
                      <!-- =================== delete date =================== -->
                      <td class="text-center" style="vertical-align:middle;">
                          <?=$row['delete_date']?>
                      </td>
                      <!-- =================== product id =================== -->
                      <td class="text-center" style="vertical-align:middle;">
                          <?=$row['product_id']?>
                      </td>
                      <!-- =================== img =================== -->
                      <td class="text-center" style="vertical-align:middle;">
                          <img src="img/<?=$row['product_pic']?>" style="height:40px;">
                      </td>
                      <!-- =================== name =================== -->
                      <td class="text-left" style="vertical-align:middle;width:28%;">
                          <?= $row['product_name']?>
                      </td>
                      <!-- =================== price =================== -->
                      <td class="text-center" style="vertical-align:middle;">
                          <?= number_format($row['product_price'])?>
                      </td>
                      <!-- =================== discount =================== -->
                      <!-- <td class="text-center" style="vertical-align:middle;">
                          <?php if($row['product_discount']!=0){echo "<span style='font-weight:bold;background-color:#B4D8B6;'>&nbsp;".$row['product_discount']."&nbsp;</span>";}
                          else{echo $row['product_discount'];} ?>
                      </td> -->
                      <!-- =================== quantity =================== -->
                      <td class="text-center" style="vertical-align:middle;">
                        <?php if($row['quantity']==0){echo "<span style='font-weight:bold;background-color:#F0CACA;'>&nbsp;".$row['quantity']."&nbsp;</span>";}
                        else{echo $row['quantity'];} ?>
                      </td>
                      <!-- =================== tag =================== -->
                      <td class="text-left" style="vertical-align:middle;">
                          <?= $row['product_tag']?>
                      </td>
                      <!-- =================== pic file name =================== -->
                      <td class="text-left" style="vertical-align:middle;">
                          <?=$row['product_pic']?>
                      </td>
                      <!-- =================== retreive =================== -->
                      <td class="text-center" style="vertical-align:middle;width:5%;"><form id="edit_form" action="product_list.php#edit" method="POST">
                          <button onclick="return confirm('Do you want to retreive this item?')" class="btn btn-outline-info btn-sm" type="submit" name="retreive" value="<?=$row['id']?>">Retreive</button>
                        </td>
                      <!-- =================== delete button =================== -->
                      <td class="text-center" style="vertical-align:middle;">

                          <!-- ========= Trigger/Open The Confirmation ================ -->
                          <button onclick="return confirm('Do you want to delete this history?')" type="submit" style="background-color:transparent;border:none;" name="del_delete" value="<?= $row['id']?>"><img src="img/close_red.png" style="height:20px;"></button>
                      </td>
                  </tr>
                    <?php
              } ?>
            </table>
            <div class="text-center">
              <?php
              if(isset($_POST['edit']) && $_POST['edit']== $row['product_id']){
              ?>
              <!-- <input class="btn-primary btn" style="margin-right:10px;display:inline-block;" type="submit" name="update" value="Update Changes"> -->
                  <input class="btn-default btn" style="display:inline-block;" type="submit" name="cancel" value="Cancel" formaction="product_list.php#edit">
                  <?php
              } ?>
            </div>
        </form>

        <?php
    }else{?>
      <div class="text-center">
          <p>No product deleted</p>
      </div>

      <?php
    } ?>


<!-- //////////////////////////// END show deleted products /////////////////////////////// -->


<br><br><br>
</body>
</html>
