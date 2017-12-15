<?php
    require_once('connect.php');
    session_start();

    if($_SESSION['usertype']==1 && isset($_POST['add_user'])){ //------------------- For add
        $username = $_POST['username'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $type = $_POST['type'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];

        $q = 'SELECT USER_NAME from user';
        unset($_SESSION['dupusername']);
        unset($_SESSION['wrongpwd']);
        $result = $mysqli->query($q);
        while($name = $result->fetch_array()){
            if($username == $name['USER_NAME']){
                $_SESSION['dupusername'] = '1';
                break;
            }
        }
        if(isset($_SESSION['dupusername'])){
            header("Location:user_list.php");
        }else if($cpassword != $password){
            $_SESSION['wrongpwd'] = '1';
            header("Location:user_list.php");
        }else{
            $q = 'INSERT INTO user(USER_NAME,USER_PASSWORD,USER_TYPE,USER_FNAME,USER_LNAME,USER_EMAIL,register_date)
                  VALUES("'.$username.'","'.$password.'","'.$type.'","'.$fname.'","'.$lname.'","'.$email.'",NOW())';
            $result = $mysqli->query($q);
            header("Location:user_list.php");
        }
    }
    else if($_SESSION['usertype']==1 && isset($_POST['update'])){ //------------------- For update
        $qr = "UPDATE user SET USER_NAME = '".$_POST['username']."' WHERE USER_ID =".$_POST['id'].";";
        $update = $mysqli->query($qr);
        $qr = "UPDATE user SET USER_PASSWORD = '".$_POST['password']."' WHERE USER_ID =".$_POST['id'].";";
        $update = $mysqli->query($qr);
        $qr = "UPDATE user SET USER_FNAME = '".$_POST['fname']."' WHERE USER_ID =".$_POST['id'].";";
        $update = $mysqli->query($qr);
        $qr = "UPDATE user SET USER_LNAME = '".$_POST['lname']."' WHERE USER_ID =".$_POST['id'].";";
        $update = $mysqli->query($qr);
        $qr = "UPDATE user SET USER_EMAIL = '".$_POST['email']."' WHERE USER_ID =".$_POST['id'].";";
        $update = $mysqli->query($qr);

        header("Location:user_list.php#edit");
    }
    else if($_SESSION['usertype']==1 && isset($_POST['disable'])){//------------------- For delete
        // echo $_POST['delete'];
        $qr = "SELECT * FROM user";
        $result = $mysqli->query($qr);
        while($user = $result->fetch_array()){
            if($user['USER_ID']==$_POST['disable']){
                if($user['disable']){
                    $q = "UPDATE user SET disable = 0  WHERE USER_ID = ".$_POST['disable'].";";
                    $update=$mysqli->query($q);
                }
                else{
                    $q = "UPDATE user SET disable = 1  WHERE USER_ID = ".$_POST['disable'].";";
                    $update=$mysqli->query($q);
                }
            }
        }
        header("Location:user_list.php#edit");
    }else{
        header("Location:index.php");
    }

?>
