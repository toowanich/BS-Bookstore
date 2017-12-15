
<?php session_start(); ?>
<?php
	require_once('connect.php');

    if(isset($_POST['submit'])){
        $q = 'SELECT * FROM user WHERE USER_NAME = "'.$_POST['username'].'" AND USER_EMAIL = "'.$_POST['email'].'";';
        $result = $mysqli->query($q);

        unset($_SESSION['forgotpwd']);
        unset($_SESSION['errorforgot']);

        if($fname = $result->fetch_array()){
						$useremail=$fname['USER_EMAIL'];
            $_SESSION['forgotpwd'] = $fname['USER_FNAME'];
            $qr = 'UPDATE user SET USER_PASSWORD ="'.$fname["USER_FNAME"].'" WHERE USER_ID = '.$fname["USER_ID"].';';
            $pwdchange = $mysqli->query($qr);
						mail($useremail,"Your password has changed","Your password is ".$_SESSION['forgotpwd']);
            echo "bbb<br>";
        }else{
            $_SESSION['errorforgot'] = '1';
            echo "ccc<br>";
        }

        echo "aaa<br>";
        echo $_SESSION['errorforgot'];

        header("Location:forgotpassword.php");
    }else{
        header("Location:index.php");
    }
?>
