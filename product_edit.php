<?php
    require_once('connect.php');
    session_start();

    if($_SESSION['usertype']==1 && isset($_POST['add_product'])){
        $pname = $_POST['name'];
        $pprice = $_POST['price'];
        $pqty = $_POST['quantity'];
        $ptag = $_POST['tag'];
        // $ppic = $_POST['img'];
        $pdiscount = $_POST['discount'];
        $desc = $_POST['desc'];
        $authorid=$_POST['author'];
        $pubid=$_POST['pub'];
        echo '1<br>';

        $q = 'SELECT product_name from product';
        unset($_SESSION['dupproduct']);
        $result = $mysqli->query($q);
        while($name = $result->fetch_array()){
            if($pname == $name['product_name']){
                $_SESSION['dupproduct'] = '1';
                break;
            }
        }
        if(isset($_SESSION['dupproduct'])){
            header("Location:product_list.php");
        }else{
          echo '2<br>';
            $q = 'INSERT INTO product(product_name,product_price,product_tag,quantity,product_discount,add_date,description,author_id,publisher_id)
                  VALUES("'.$pname.'","'.$pprice.'","'.$ptag.'","'.$pqty.'","'.$pdiscount.'",NOW(),"'.$desc.'","'.$authorid.'","'.$pubid.'")';
            // $q = "INSERT INTO product(product_name,product_price,product_tag,quantity,product_discount,add_date,description,author_id,publisher_id)
            //       VALUES($pname, $pprice, $ptag, $pqty, $pdiscount, NOW(), $desc, authorid
            $result = $mysqli->query($q);
            $addtag = explode(', ',$ptag);
            for($i = 0; $i < count($addtag); $i++){
                $qr = 'INSERT INTO product_tag(tag_name) VALUES("'.$addtag[$i].'")';
                $add = $mysqli->query($qr);
                // echo gettype($addtag[$i]).'<br>';
            }
            echo '3<br>';
            // echo $_POST['image'];
            echo '<br>'.$_FILES["image"]["name"].'<br>';

            // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(move_uploaded_file($_FILES["image"]["tmp_name"],"img/".$_POST['name'].$_FILES["image"]["name"]))
            {
            echo "Copy/Upload Complete<br>";
            echo $pname."<br>";
            //*** Insert Record ***//
            $q = 'SELECT product_id FROM product WHERE product_name="'.$pname.'"';
            $newname = $mysqli->query($q);
            $row = $newname->fetch_array();
            echo $row['product_id'].'<br>';
            $strSQL = "UPDATE product SET product_pic='".$pname.$_FILES['image']['name']."' WHERE product_id=".$row['product_id'];
            $objQuery = $mysqli->query($strSQL);
            echo "12Copy/Upload Complete<br>";
          }
        // }

            header("Location:product_list.php");
        }

    }
    else if($_SESSION['usertype']==1 && isset($_POST['update'])){
        $qr = "UPDATE product SET product_name = '".$_POST['name']."' WHERE product_id =".$_POST['id'].";";
        $update = $mysqli->query($qr);
        $qr = "UPDATE product SET product_price = '".$_POST['price']."' WHERE product_id =".$_POST['id'].";";
        $update = $mysqli->query($qr);
        $qr = "UPDATE product SET product_discount = '".$_POST['discount']."' WHERE product_id =".$_POST['id'].";";
        $update = $mysqli->query($qr);
        $qr = "UPDATE product SET quantity = '".$_POST['quantity']."' WHERE product_id =".$_POST['id'].";";
        $update = $mysqli->query($qr);
        $qr = "UPDATE product SET product_tag = '".$_POST['tag']."' WHERE product_id =".$_POST['id'].";";
        $update = $mysqli->query($qr);
        $qr = "UPDATE product SET product_pic = '".$_POST['pic']."' WHERE product_id =".$_POST['id'].";";
        $update = $mysqli->query($qr);
        $qr = "UPDATE product SET description = '".$_POST['desc']."' WHERE product_id =".$_POST['id'].";";
        $update = $mysqli->query($qr);
        header("Location:product_list.php#edit");
    }
    else if($_SESSION['usertype']==1 && isset($_POST['delete'])){
        // echo $_POST['delete'];
        $q = "DELETE FROM product WHERE product_id = ".$_POST['delete'].";";
        $result=$mysqli->query($q);
        header("Location:product_list.php");
    }else if($_SESSION['usertype']==1 && isset($_POST['del_delete'])){
        // echo $_POST['delete'];
        $q = "DELETE FROM product_delete WHERE id = ".$_POST['del_delete'].";";
        $result=$mysqli->query($q);
        header("Location:product_list.php");
    }else if($_SESSION['usertype']==1 && isset($_POST['retreive'])){
        // echo $_POST['delete'];
        $qr = 'SELECT * FROM product_delete';
        $result = $mysqli->query($qr);
        while($row=$result->fetch_array()){
            if($row['id']==$_POST['retreive']){
                $pname = $mysqli->real_escape_string($row['product_name']);
                $desc = $mysqli->real_escape_string($row['description']);
                $q = 'INSERT INTO product(product_name,product_price,product_tag,quantity,product_pic,product_discount,add_date,author_id,publisher_id,description)
                      VALUES("'.$pname.'"
                      ,"'.$row['product_price'].'"
                      ,"'.$row['product_tag'].'"
                      ,"'.$row['quantity'].'"
                      ,"'.$row['product_pic'].'"
                      ,"0"
                      ,NOW()
                      ,"'.$row['author_id'].'"
                      ,"'.$row['publisher_id'].'"
                      ,"'.$desc.'"
                      );';
                $result=$mysqli->query($q);
                $q = "DELETE FROM product_delete WHERE id = ".$_POST['retreive'].";";
                $result=$mysqli->query($q);
                break;
            }
        }
        header("Location:product_list.php#deleted");
    }else{
        header("Location:index.php");
    }

?>
