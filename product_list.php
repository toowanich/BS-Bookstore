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
    <h1>Add Book</h1><br>
<form action="product_edit.php" method="POST" id="add" enctype="multipart/form-data">
      <table align="center" class="table table-hover center row-add" style="width:98%;">
        <tr class="info">
            <th class="text-center" >Author</th>
            <th class="text-center" >Publisher</th>
            <th class="text-center" >Product</th>
            <th class="text-center" >Price</th>
            <th class="text-center" >%Discount</th>
            <th class="text-center" >Quantity</th>
            <th class="text-center" >Category</th>
            <th class="text-center" >Description</th>
            <th class="text-center" >Image File</th>
        </tr>
        <tr>
            <td class="text-center" style="width:13%;">
                <?php
                  $q = 'SELECT * FROM author';
                  $result = $mysqli->query($q);
                ?>
                <select class="form-control" from="add" name="author">
                  <?php
                  while($row = $result->fetch_array()){ ?>
                      <option value="<?=$row['id']?>"><?=$row['name']?></option>
                      <?php
                  } ?>
                </select>
            </td>
            <td class="text-center" style="width:13%;">
                <?php
                  $q = 'SELECT * FROM publisher';
                  $result = $mysqli->query($q);
                ?>
                <select class="form-control" from="add" name="pub">
                  <?php
                  while($row = $result->fetch_array()){ ?>
                      <option value="<?=$row['id']?>"><?=$row['name']?></option>
                      <?php
                  } ?>
                </select>
            </td>
            <td class="text-center" style="width:18%;"><input id="in" type="text" maxlength="50" class="text-left form-control" name="name" style="width:100%;"></td>
            <td class="text-center" style="width:6%;"><input id="in" type="text" class="form-control" name="price" value="" style="width:100%;"></td>
            <td class="text-center" style="width:5%;"><input id="in" type="text" class="form-control" name="discount" style="width:100%;"></td>
            <td class="text-center" style="width:5%;"><input id="in" type="text" name="quantity" class="form-control" style="width:100%;"></td>
            <td class="text-center" style="width:10%;">
                <?php
                  $q = 'SELECT * FROM product_tag';
                  $result = $mysqli->query($q);
                ?>
                <select class="form-control" from="add" name="tag">
                  <?php
                  while($row = $result->fetch_array()){ ?>
                      <option value="<?=$row['tag_name']?>"><?=$row['tag_name']?></option>
                      <?php
                  } ?>
                </select>
            </td>
            <!-- <td class="text-center" ><input id="in" type="text" class="form-control" name="tag" style="width:100%;"></td> -->
            <td class="text-left" style="width:12%;"><textarea form="add" maxlength="3500" class="form-control" name="desc" style="width:100%;resize:vertical;"></textarea></td>
            <td class="text-center" style="vertical-align:top;"><input type="file" name="image" style="width:100%;"></td>
        </tr>

      </table>
      <div class="text-center">
          <input class="btn-primary btn" style="margin-right:10px;display:inline-block;" type="submit" name="add_product" form="add" value="Add Product" id="register" disabled="disabled">
          <input class="btn-default btn" style="margin-right:10px;display:inline-block;" type="submit" name="cancel" value="Cancel" formaction="product_list.php">
      </div>

      <!-- ======================== Add product disabled until all fields are filled ==================== -->
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
    <!-- //////////////////////////////////// END script for disabled button ////////////////////////// -->
</form>
</div>
<br>
<!-- //////////////////////////////// END add product /////////////////////////////// -->

<!-- ============================== add category =============================== -->
<div class="text-center col-sm-4" style="display:inline-block">
    <h1>Add Category</h1><br>

<form action="product_edit.php" method="POST" id="addtag" enctype="multipart/form-data">
      <table align="center" class="table table-hover center row-add" style="width:80%;">
        <tr class="info">
            <th class="text-center" >Category</th>
        </tr>
        <tr>
          <td class="text-center" ><input id="cat" type="text" maxlength="20" class="form-control" name="tag" style="width:100%;"></td>
        </tr>

      </table>
      <div class="text-center">
          <input class="btn-primary btn" style="margin-right:10px;display:inline-block;" type="submit" name="add_tag" form="addtag" value="Add Category" id="registert" disabled="disabled">
          <input class="btn-default btn" style="margin-right:10px;display:inline-block;" type="submit" name="cancel" value="Cancel" formaction="product_list.php">
      </div>

      <!-- ======================== Add category disabled until all fields are filled ==================== -->
      <script>
      (function() {
        $('#addtag #cat').keyup(function() {
          var empty = false;
          $('#addtag #cat').each(function() {
            if ($(this).val() == '') {
              empty = true;
            }
          });

          if (empty) {
            $('#registert').attr('disabled', 'disabled'); // updated according to http://stackoverflow.com/questions/7637790/how-to-remove-disabled-attribute-with-jquery-ie
          } else {
            $('#registert').removeAttr('disabled'); // updated according to http://stackoverflow.com/questions/7637790/how-to-remove-disabled-attribute-with-jquery-ie
          }
        });
      })()
    </script>
    <!-- //////////////////////////////////// END script for disabled button ////////////////////////// -->
</form>
</div>
<!-- //////////////////////////////// END add category /////////////////////////////// -->

<!-- ============================== add author =============================== -->
<div class="text-center col-sm-4" style="display:inline-block">
    <h1>Add Author</h1><br>

<form action="product_edit.php" method="POST" id="addau" enctype="multipart/form-data">
      <table align="center" class="table table-hover center row-add" style="width:80%;">
        <tr class="info">
            <th class="text-center" >Author Name</th>
        </tr>
        <tr>
          <td class="text-center" ><input id="au" type="text" maxlength="100" class="form-control" name="authorname" style="width:100%;"></td>
        </tr>

      </table>
      <div class="text-center">
          <input class="btn-primary btn" style="margin-right:10px;display:inline-block;" type="submit" name="add_author" form="addau" value="Add Author" id="registera" disabled="disabled">
          <input class="btn-default btn" style="margin-right:10px;display:inline-block;" type="submit" name="cancel" value="Cancel" formaction="product_list.php">
      </div>

      <!-- ======================== Add author disabled until all fields are filled ==================== -->
      <script>
      (function() {
        $('#addau #au').keyup(function() {
          var empty = false;
          $('#addau #au').each(function() {
            if ($(this).val() == '') {
              empty = true;
            }
          });

          if (empty) {
            $('#registera').attr('disabled', 'disabled'); // updated according to http://stackoverflow.com/questions/7637790/how-to-remove-disabled-attribute-with-jquery-ie
          } else {
            $('#registera').removeAttr('disabled'); // updated according to http://stackoverflow.com/questions/7637790/how-to-remove-disabled-attribute-with-jquery-ie
          }
        });
      })()
    </script>
    <!-- //////////////////////////////////// END script for disabled button ////////////////////////// -->
</form>
</div>
<!-- //////////////////////////////// END add publisher /////////////////////////////// -->

<div class="text-center col-sm-4" style="display:inline-block">
    <h1>Add Publisher</h1><br>

<form action="product_edit.php" method="POST" id="addpu" enctype="multipart/form-data">
      <table align="center" class="table table-hover center row-add" style="width:80%;">
        <tr class="info">
            <th class="text-center" >Publisher Name</th>
        </tr>
        <tr>
          <td class="text-center" ><input id="pu" type="text" maxlength="30" class="form-control" name="pubname" style="width:100%;"></td>
        </tr>

      </table>
      <div class="text-center">
          <input class="btn-primary btn" style="margin-right:10px;display:inline-block;" type="submit" name="add_pub" form="addpu" value="Add Publisher" id="registerp" disabled="disabled">
          <input class="btn-default btn" style="margin-right:10px;display:inline-block;" type="submit" name="cancel" value="Cancel" formaction="product_list.php">
      </div>

      <!-- ======================== Add publisher disabled until all fields are filled ==================== -->
      <script>
      (function() {
        $('#addpu #pu').keyup(function() {
          var empty = false;
          $('#addpu #pu').each(function() {
            if ($(this).val() == '') {
              empty = true;
            }
          });

          if (empty) {
            $('#registerp').attr('disabled', 'disabled'); // updated according to http://stackoverflow.com/questions/7637790/how-to-remove-disabled-attribute-with-jquery-ie
          } else {
            $('#registerp').removeAttr('disabled'); // updated according to http://stackoverflow.com/questions/7637790/how-to-remove-disabled-attribute-with-jquery-ie
          }
        });
      })()
    </script>
    <!-- //////////////////////////////////// END script for disabled button ////////////////////////// -->
</form>
<br><br>
</div>
<!-- //////////////////////////////// END add publisher /////////////////////////////// -->


<!-- ========================================= product list ================================== -->
<?php
    $q = 'SELECT p.product_id,p.product_name,p.product_price,p.product_tag,quantity,p.product_pic,p.product_discount,add_date,description,author_id,publisher_id,a.name as aname,pu.name as puname
          FROM product p JOIN author a, publisher pu
          WHERE p.author_id = a.id AND p.publisher_id = pu.id ORDER BY product_id ASC';
    $result = $mysqli->query($q);
    $qc = 'SELECT * FROM product_delete ORDER BY delete_date ASC';
    $results = $mysqli->query($q);?>
    <div id="edit"  class="text-center">
        <h1>Edit Books</h1>
    </div><?php
    if($results){
?>
        <br>
        <form id="myform" action="product_edit.php" method="POST">
            <table align="center" class="table table-hover center" style="width:98%;">
                <tr class="info">
                    <th class="text-center" >ID</th>
                    <th class="text-center" >Author</th>
                    <th class="text-center" >Publisher</th>
                    <th class="text-center" colspan="2">Product</th>
                    <th class="text-center" >Price</th>
                    <th class="text-center" >%Discount</th>
                    <th class="text-center" >Date added</th>
                    <th class="text-center" >Quantity</th>
                    <th class="text-center" >Category</th>
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
                            <!-- =================== author =================== -->
                            <td class="text-center" style="width:11%;vertical-align:middle;">
                                <?php
                                  $qr = 'SELECT * FROM author';
                                  $resultss = $mysqli->query($qr);
                                ?>
                                <select class="form-control" from="myform" name="author">
                                  <?php
                                  while($roww = $resultss->fetch_array()){ ?>
                                      <option value="<?=$roww['id']?>"
                                          <?php if($row['aname'] == $roww['name']){echo "selected";} ?>
                                      ><?=$roww['name']?></option>
                                      <?php
                                  } ?>
                                </select>
                            </td>
                            <!-- =================== publisher =================== -->
                            <td class="text-center" style="width:9%;vertical-align:middle;">
                                <?php
                                  $qr = 'SELECT * FROM publisher';
                                  $resultss = $mysqli->query($qr);
                                ?>
                                <select class="form-control" from="myform" name="pub">
                                  <?php
                                  while($roww = $resultss->fetch_array()){ ?>
                                      <option value="<?=$roww['id']?>"
                                          <?php if($row['puname'] == $roww['name']){echo "selected";} ?>
                                      ><?=$roww['name']?></option>
                                      <?php
                                  } ?>
                                </select>
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
                            <td class="text-center" style="vertical-align:middle;width:4%;">
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
                            <td class="text-center" style="width:9%;vertical-align:middle;">
                                <?php
                                  $qr = 'SELECT * FROM product_tag';
                                  $resultss = $mysqli->query($qr);
                                ?>
                                <select class="form-control" from="myform" name="tag">
                                  <?php
                                  while($roww = $resultss->fetch_array()){ ?>
                                      <option value="<?=$roww['tag_name']?>"
                                          <?php if($row['product_tag'] == $roww['tag_name']){echo "selected";} ?>
                                      ><?=$roww['tag_name']?></option>
                                      <?php
                                  } ?>
                                </select>
                            </td>
                            <!-- =================== description =================== -->
                            <td class="text-left" style="vertical-align:middle;width:13%;">
                                <textarea class="text-left form-control" type="text" form="myform" style="width:100%;resize:vertical;" name="desc"><?= $row['description']?></textarea>
                            </td>
                            <!-- =================== pic file name =================== -->
                            <td class="text-left" style="vertical-align:middle;width:8%;">
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
                      <!-- =================== author =================== -->
                      <td class="text-center" style="vertical-align:middle;width:9%;">
                          <?=$row['aname']?>
                      </td>
                      <!-- =================== publisher =================== -->
                      <td class="text-center" style="vertical-align:middle;width:9%;">
                          <?=$row['puname']?>
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
                      <td class="text-center" style="vertical-align:middle;width:4%;">
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
                      <td class="text-left" style="vertical-align:middle;width:8%;">
                          <?= $row['product_tag']?>
                      </td>
                      <!-- =================== description =================== -->
                      <td class="text-left" style="vertical-align:middle;width:13%;">
                          <textarea readonly class="text-left form-control" type="text" style="width:100%;resize:vertical;" name="des" ><?= $row['description']?></textarea>
                      </td>
                      <!-- =================== pic file name =================== -->
                      <td class="text-left" style="vertical-align:middle;width:8%;">
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
    $q = 'SELECT p.id,p.product_id,p.product_name,p.product_price,p.product_tag,quantity,p.product_pic,p.product_discount,delete_date,description,author_id,publisher_id,a.name as aname,pu.name as puname
          FROM product_delete p JOIN author a, publisher pu
          WHERE p.author_id = a.id AND p.publisher_id = pu.id ORDER BY delete_date DESC';
    $resulto = $mysqli->query($q);?>
    <div id="edit"  class="text-center">
        <h1>Deleted Books</h1>
    </div><?php
    if($resulto->num_rows > 0){
?>
        <br>
        <form id="myform" action="product_edit.php" method="POST">
            <table id="deleted" align="center" class="table table-hover center" style="width:98%;">
                <tr class="info">
                    <th class="text-center" >ID</th>
                    <th class="text-center" >Date deleted</th>
                    <th class="text-center" >Product ID</th>
                    <th class="text-center" >Author</th>
                    <th class="text-center" >Publisher</th>
                    <th class="text-center" colspan="2">Product</th>
                    <th class="text-center" >Price</th>
                    <th class="text-center" >Description</th>
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
                      <td class="text-center" style="vertical-align:middle;width:8%;">
                          <?=$row['delete_date']?>
                      </td>
                      <!-- =================== product id =================== -->
                      <td class="text-center" style="vertical-align:middle;">
                          <?=$row['product_id']?>
                      </td>
                      <!-- =================== author =================== -->
                      <td class="text-center" style="vertical-align:middle;width:9%;">
                          <?=$row['aname']?>
                      </td>
                      <!-- =================== publisher =================== -->
                      <td class="text-center" style="vertical-align:middle;width:9%;">
                          <?=$row['puname']?>
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
                      <td class="text-center" style="vertical-align:middle;width:4%;">
                          <?= number_format($row['product_price'])?>
                      </td>
                      <!-- =================== description =================== -->
                      <td class="text-left" style="vertical-align:middle;width:15%;">
                          <textarea readonly class="text-left form-control" type="text" style="width:100%;resize:vertical;" name="des" ><?= $row['description']?></textarea>
                      </td>
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
                      <td class="text-left" style="vertical-align:middle;width:10%;">
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
