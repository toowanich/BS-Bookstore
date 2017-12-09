<?php

	if(!isset($_SESSION['indexnavbartologin'])){
		session_start();
	}
	unset($_SESSION['indexnavbartologin']);

	require_once('connect.php');

// *************************************************************************************************
//------------------------Log in process-------------------------------//
  if(isset($_POST['username'])){
			$_SESSION['cartquantity']=0;
    	$u = $_POST['username'];
    	$p = $_POST['password'];

    	$q = "SELECT * FROM user WHERE USER_NAME = '$u' AND USER_PASSWORD = '$p'";
    	$result = $mysqli->query($q);
    	$row = $result->fetch_array();

  		if($row){
    		echo "Login success";
    		$_SESSION['id'] = $row['USER_ID'];
    		$_SESSION['name'] = $row['USER_FNAME'].' '.$row['USER_LNAME'];
    		$_SESSION['usertype'] = $row['USER_TYPE'];
				$_SESSION['username'] = $row['USER_NAME'];
				$_SESSION['disable'] = '0';
				$_SESSION['propic']=$row['propic'];

				if($row['disable']){
						$_SESSION['disable'] = '1';
						echo "<br>".$_SESSION['disable'];
						echo "<br>".$_SESSION['logout'];
						header("Location:login.php");
				}
				else if($_SESSION['usertype']==1){ $_SESSION['logstat']="Log Out";header("Location:product_list.php"); }
        else {
					$_SESSION['logstat']="Log Out";
          if($_SESSION['lastpage']=="cart.php" || $_SESSION['lastpage']=="account.php" || $_SESSION['lastpage']=='user_list.php'){
            $_SESSION['lastpage']="main.php";
          }
          header("Location:".$_SESSION['lastpage']);
        }
    	}
    	else{
				echo "aaaa";
				$_SESSION['incorrect'] = '1';
				header("Location:login.php");
				// echo "Incorrect username or password";
    		// echo "<br><a href='login.php'>Retry login</a>";
    	}
  }
  else if(isset($_SESSION['logout']) && $_SESSION['logout']==1){
    $_SESSION['id'] = NULL;
    $_SESSION['name'] = NULL;
    $_SESSION['usertype'] = NULL;
    $_SESSION['logstat']= "Log In";
		$_SESSION['cart']=NULL;
		$_SESSION['cartquantity']=0;
    if($_SESSION['lastpage']=="cart.php" || $_SESSION['currentpage']='account'){
      $_SESSION['lastpage']="main.php";
    }
		$_SESSION['logout']=0;
		$_SESSION['disable']='0';
		echo "<br>logout";
    header("Location:login.php");
  }
  else{
    $_SESSION['id'] = NULL;
    $_SESSION['name'] = NULL;
    $_SESSION['usertype'] = NULL;
		$_SESSION['logout']=0;
    $_SESSION['logstat']= "Log In";
		$_SESSION['cartquantity']=0;
  }
?>
