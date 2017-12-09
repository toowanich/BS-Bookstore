<?php
  session_start();
  require_once('connect.php');
    if(isset($_POST['orderid'])){
      $orderid=$_POST['orderid'];
    }
    else{
    $orderid=$_SESSION['orderid'];
    }
    $q="UPDATE orderheader SET order_status='CANCELED',confirm_date=NOW() WHERE order_id='$orderid'";
    $res=$mysqli->query($q);
    $ploop="SELECT * FROM orderdetail WHERE order_id='$orderid'";
    $runloop=$mysqli->query($ploop);
    while ($orderdrow=$runloop->fetch_array()) {
      $orderdquantity=$orderdrow['quantity'];
      $pid=$orderdrow['product_id'];
      $restock="UPDATE product SET product.quantity=product.quantity+'$orderdquantity' WHERE product_id='$pid'";
      $result=$mysqli->query($restock);
    }
  if(isset($_POST['lastpage'])){
    $lastpage=$_POST['lastpage'];
    header("Location:$lastpage");
  }
 ?>
