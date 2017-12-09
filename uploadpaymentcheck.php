<?php
session_start();
require_once('connect.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(move_uploaded_file($_FILES["payUpload"]["tmp_name"],"payment/".$_SESSION['orderid'].$_FILES["payUpload"]["name"]))
  {
  echo "Upload Complete<br>";
  //*** Insert Record ***//
  $strSQL = "UPDATE orderheader SET payment='".$_SESSION['orderid'].$_FILES['payUpload']['name']."' WHERE order_id=".$_SESSION['orderid'];
  $objQuery = $mysqli->query($strSQL);
  $updateStatus = "UPDATE orderheader SET order_status='PENDING' WHERE order_id=".$_SESSION['orderid'];
  $res = $mysqli->query($updateStatus);
  }
  header("Location:orderdetail.php");
}
?>
