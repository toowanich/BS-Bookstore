<?php
$mysqli = new mysqli('localhost','root','','bg_store');
   if($mysqli->connect_errno){
      echo $mysqli->connect_errno.": ".$mysqli->connect_error;
   }
 ?>
