<!DOCTYPE html>
<?php session_start(); ?>
<?php
    // $_SESSION['lastpage']='account';
    require_once('connect.php');
    require_once("navbar.php");
    $_SESSION['lastpage']='user_list.php';
    $_SESSION['currentpage']='account';

    // ============================= UPDATE status ========================= -->
    if(isset($_POST['paidid'])){
      $qs = "UPDATE orderheader SET confirm_date=NOW(),order_status ='".$_POST['paid']."' WHERE order_id=".$_POST['paidid'];
      $update = $mysqli->query($qs);
      header("Location:".$_SESSION['lp']);
    }

    ////////////////////////////////////////////////////////////////// -->
    $_SESSION['lp']='order_list.php';
  ?>
<html lang="en">
<head>
  <title>BG Store - Order List</title>
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


  <!-- ========================================= unpaid/pending order list ================================== -->
  <?php
      $qr = 'SELECT * FROM orderheader WHERE order_status="PENDING" OR order_status="UNPAID" OR order_status="INVALID" ORDER BY CASE
      WHEN order_status="PENDING" THEN 1
      WHEN order_status="INVALID" THEN 2
      ELSE 3 END, order_status,order_date DESC,order_time DESC';
      $results = $mysqli->query($qr);
      $numrow = $results->num_rows;
      $q = 'SELECT * FROM orderheader WHERE order_status="PENDING" OR order_status="UNPAID" OR order_status="INVALID" ORDER BY  CASE
      WHEN order_status="PENDING" THEN 1
      WHEN order_status="INVALID" THEN 2
      ELSE 3 END, order_status ASC,order_date DESC,order_time DESC LIMIT 5';
      $result = $mysqli->query($q);
      if($result){
  ?>

          <div id="edit" class="text-center">
              <h1>Unpaid Orders</h1><br>
          </div>

              <table align="center" class="table table-hover center" style="width:70%;">
                  <tr class="info">
                      <th class="text-center">Order No.</th>
                      <th class="text-center">Order Date</th>
                      <th class="text-center">Username</th>
                      <th class="text-center">Quantity</th>
                      <th class="text-center">Total amount</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Detais</th>
                  </tr>
                  <!-- ================= START while ================ -->
                  <?php
                  while($row=$result->fetch_array()){?>
                        <tr>
                            <td style="vertical-align:middle;" class="text-center"><?= $row['order_id'] ?></td>
                            <td style="vertical-align:middle;" class="text-center">
                              <?php
                              $date=date_create($row['order_date']);
                              echo date_format($date,"Y/m/d").', '.$row['order_time'];
                              ?>
                            </td>
                            <?php
                            $qry = 'SELECT * from user JOIN orderheader
                                 WHERE orderheader.user_id = user.USER_ID
                                 AND orderheader.user_id='.$row['user_id'];
                            $fetch = $mysqli->query($qry);
                            $uname = $fetch->fetch_array();
                            ?>
                            <td style="vertical-align:middle;" class="text-center"><?= $uname['USER_NAME'] ?></td>
                            <td style="vertical-align:middle;" class="text-center"><?= $row['quantity'] ?></td>
                            <td style="vertical-align:middle;" class="text-center"><?= number_format($row['total_amount']) ?></td>
                            <td style="vertical-align:middle;
                              <?php if($row['order_status']=='PENDING'){echo "color:#0073E1";}
                                    else{echo "color:red;";}?>"
                                    class="text-center">
                              <?= $row['order_status'] ?>
                            </td>
                            <td class="text-center">
                            <form action="order_list_detail.php" method="POST">
                               <input type="hidden" name="orderid" value="<?=$row['order_id']?>">
                               <input class="btn btn-outline-info" type="submit" name="view" value="view">
                            </form>
                          </td>
                        </tr>

                        <?php
                    }  ////////////////////////////////////////////////// END while //////////////////////
                          ?>
                      <?php
                          if($numrow>5){ ?>
                          <tr>
                            <td colspan="7" class="text-center">
                              <?php
                              // $_SESSION['orderadmin']='unpaid'; ?>
                              <a href="order_list_history.php?orderadmin=unpaid">view all</a>
                            </td>
                          </tr>
                        <?php } ?>
                        </table><br>
          <?php
      }?>
   <!-- ////////////////////////////////// END unpaid/pending order ////////////////////////////////////// -->


   <!-- ========================================= SHIPPED order list ================================== -->
   <?php
       $qr = 'SELECT * FROM orderheader WHERE order_status="PAID" OR order_status="SHIPPED" ORDER BY order_status ASC,order_date DESC,order_time DESC';
       $results = $mysqli->query($qr);
       $numrow = $results->num_rows;
       $q = 'SELECT * FROM orderheader WHERE order_status="PAID" OR order_status="SHIPPED" ORDER BY order_status ASC,order_date DESC,order_time DESC LIMIT 5';
       $result = $mysqli->query($q);
       if($result){
   ?>
           <div id="edit" class="text-center">
               <h1>Paid Orders</h1><br>
           </div>
               <table align="center" class="table table-hover center" style="width:70%;">
                   <tr class="info">
                       <th class="text-center">Order No.</th>
                       <th class="text-center">Order Date</th>
                       <th class="text-center">Confirmed Date</th>
                       <th class="text-center">Username</th>
                       <th class="text-center">Quantity</th>
                       <th class="text-center">Total amount</th>
                       <th class="text-center">Status</th>
                       <th class="text-center">Details</th>
                   </tr>
                   <!-- ================= START while ================ -->
                   <?php
                   while($row=$result->fetch_array()){?>
                         <tr>
                             <td style="vertical-align:middle;" class="text-center"><?= $row['order_id'] ?></td>
                             <td style="vertical-align:middle;" class="text-center">
                               <?php
                               $date=date_create($row['order_date']);
                               echo date_format($date,"Y/m/d").', '.$row['order_time'];
                               ?>
                             </td>
                             <td style="vertical-align:middle;" class="text-center">
                               <?php $date=date_create($row['confirm_date']);
                               echo date_format($date,"Y/m/d, H:i:s"); ?>
                             </td>
                             <?php
                             $qry = 'SELECT * from user JOIN orderheader
                                  WHERE orderheader.user_id = user.USER_ID
                                  AND orderheader.user_id='.$row['user_id'];
                             $fetch = $mysqli->query($qry);
                             $uname = $fetch->fetch_array();
                             ?>
                             <td style="vertical-align:middle;" class="text-center"><?= $uname['USER_NAME'] ?></td>
                             <td style="vertical-align:middle;" class="text-center"><?= $row['quantity'] ?></td>
                             <td style="vertical-align:middle;" class="text-center"><?= number_format($row['total_amount']) ?></td>
                             <td style="vertical-align:middle;
                               <?php if($row['order_status']=='PAID'){echo "color:#20CA00;";}
                                     else if($row['order_status']=='SHIPPED'){echo "color:#7A00BF";}
                                     else{echo "color:red;";}?>"
                                     class="text-center">
                               <?= $row['order_status'] ?>
                             </td>
                             <td style="vertical-align:middle;" align="center">
                                <form action="order_list_detail.php" method="POST">
                                   <input type="hidden" name="orderid" value="<?=$row['order_id']?>">
                                   <input class="btn btn-outline-info" type="submit" name="view" value="view">
                                </form>
                             </td>
                         </tr>
                         <?php
                     }  ////////////////////////////////////////////////// END while //////////////////////
                           ?>
                           <?php
                           if($numrow>5){ ?>
                             <tr>
                               <td colspan="8" class="text-center">
                                 <?php
                                 // $_SESSION['orderadmin']='paid'; ?>
                                 <a href="order_list_history.php?orderadmin=paid">view all</a>
                               </td>
                             </tr>
                           <?php } ?>
                  </table><br>
           <?php
       }?>
    <!-- ////////////////////////////////// END canceled order ////////////////////////////////////// -->

    <!-- ========================================= canceled order list ================================== -->
    <?php
    $qr = 'SELECT * FROM orderheader WHERE order_status="CANCELED" ORDER BY order_date DESC,order_time DESC';
    $results = $mysqli->query($qr);
    $numrow = $results->num_rows;
    $q = 'SELECT * FROM orderheader WHERE order_status="CANCELED" ORDER BY order_date DESC,order_time DESC LIMIT 5';
    $result = $mysqli->query($q);
        if($result){
    ?>
            <div id="edit" class="text-center">
                <h1>Canceled Orders</h1><br>
            </div>
                <table align="center" class="table table-hover center" style="width:70%;">
                    <tr class="info">
                        <th class="text-center">Order No.</th>
                        <th class="text-center">Order Date</th>
                        <th class="text-center">Canceled Date</th>
                        <th class="text-center">Username</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Total amount</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Details</th>
                    </tr>
                    <!-- ================= START while ================ -->
                    <?php
                    while($row=$result->fetch_array()){?>
                          <tr>
                              <td style="vertical-align:middle;" class="text-center"><?= $row['order_id'] ?></td>
                              <td style="vertical-align:middle;" class="text-center">
                                <?php
                                $date=date_create($row['order_date']);
                                echo date_format($date,"Y/m/d").', '.$row['order_time'];
                                ?>
                              </td>
                              <td style="vertical-align:middle;" class="text-center">
                                <?php $date=date_create($row['confirm_date']);
                                echo date_format($date,"Y/m/d, H:i:s"); ?>
                              </td>
                              <?php
                              $qry = 'SELECT * from user JOIN orderheader
                                   WHERE orderheader.user_id = user.USER_ID
                                   AND orderheader.user_id='.$row['user_id'];
                              $fetch = $mysqli->query($qry);
                              $uname = $fetch->fetch_array();
                              ?>
                              <td style="vertical-align:middle;" class="text-center"><?= $uname['USER_NAME'] ?></td>
                              <td style="vertical-align:middle;" class="text-center"><?= $row['quantity'] ?></td>
                              <td style="vertical-align:middle;" class="text-center"><?= number_format($row['total_amount']) ?></td>
                              <td style="vertical-align:middle;color:#8B8B8B;"
                                      class="text-center">
                                <?= $row['order_status'] ?>
                              </td>
                              <td style="vertical-align:middle;" align="center">
                                 <form action="order_list_detail.php" method="POST">
                                    <input type="hidden" name="orderid" value="<?=$row['order_id']?>">
                                    <input class="btn btn-outline-info" type="submit" name="view" value="view">
                                 </form>
                              </td>
                          </tr>
                          <?php
                      }  ////////////////////////////////////////////////// END while //////////////////////
                            ?>
                            <?php
                            if($numrow>5){ ?>
                              <tr>
                                <td colspan="8" class="text-center">
                                  <?php
                                  // $_SESSION['orderadmin']='cancel'; ?>
                                  <a href="order_list_history.php?orderadmin=cancel">view all</a>
                                </td>
                              </tr>
                            <?php } ?>
                   </table>
            <br><br><br>
            <?php
        }?>
     <!-- ////////////////////////////////// END canceled order ////////////////////////////////////// -->

</body>
</html>
