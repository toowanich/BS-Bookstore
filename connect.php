<?php
$mysqli = new mysqli('localhost','root','','bs_bookstore');
   if($mysqli->connect_errno){
      echo $mysqli->connect_errno.": ".$mysqli->connect_error;
   }
 ?>
