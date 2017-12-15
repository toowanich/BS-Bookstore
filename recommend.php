<?php
  if(isset($_GET['id'])){
    $id = $_GET['id'];
  }else{
    $id = 1;
  }
  require_once('connect.php');
  //Heirarchy depending on number of matching tags
  $q = 'SELECT * FROM product WHERE product_id = '.$id;
  $result = $mysqli->query($q);
  ?>
  <html>
  <body>
    <h2>Chosen Product</h2>
  <table align="center" class="table table-hover center" style="width:94%;">
      <tr>
        <td>ID</td>
        <td>Name</td>
        <td>tags</td>

      </tr>

      <?php
      while($row=$result->fetch_array()){
        echo '<tr>';
        echo '<td>';
        echo $row['product_id'];
        echo '</td>';
        echo '<td>';
        echo $row['product_name'];
        echo '</td>';
        echo '<td>';
        echo $row['product_tag'];
        echo '</td>';
        echo '</tr>';
        $tag = $row['product_tag'];

      }
              ?>

      </table>

      <hr>
      All Tags
      <br>

        <?php
        $tags = explode(', ', $tag);
        $count = 0;
        foreach($tags as $t){
          if($count == 0){
            $q = 'SELECT DISTINCT * FROM product
            WHERE product_ID in (SELECT product_id FROM product WHERE product_id != '.$id.') AND (product_tag LIKE "%'.$t.'%"';
          }else{
            $q = $q.' OR product_tag LIKE "%'.$t.'%"';
          }

          $count = $count +1;
        }
                  $q = $q.')';
        echo $q;
        $result = $mysqli->query($q);

         ?>
         <table align="center" class="table table-hover center" style="width:94%;">
             <tr>
               <td>ID</td>
               <td>Name</td>
               <td>tags</td>

             </tr>

             <?php
             while($row=$result->fetch_array()){
               echo '<tr>';
               echo '<td>';
               echo $row['product_id'];
               echo '</td>';
               echo '<td>';
               echo $row['product_name'];
               echo '</td>';
               echo '<td>';
               echo $row['product_tag'];
               echo '</td>';
               echo '</tr>';
               $tag = $row['product_tag'];

             }
                     ?>

             </table>
</body>
</html>
