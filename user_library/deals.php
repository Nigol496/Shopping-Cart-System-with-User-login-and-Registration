<?php

require 'db.php';
// Check if user is logged in using the session variable
    $deals_id = $rand(1, $total_rows);
    $result = $mysqli->query("SELECT * FROM product WHERE prod_id = '$deals_id'' LIMIT 10");
    $user = $result->fetch_assoc();
    $total_rows = $result->num_rows;
        echo "deals". $total_rows;
        $prod_deals_image = $user['prod_image'];
        $prod_deals_title = substr($user['prod_title'], 0, 32) . "...";
        $prod_deals_descr = substr($user['prod_descr'], 0, 64) . "...";
        $prod_deals_price = $user['prod_price'];
        $prod_deals_prod_id = $user['prod_id'];
        $discount = 0.09;

?>

<table> 
                            <tr><td colspan = '2'>
                            <?php  /*require 'deals.php'*/ ?>
                            <img src = '<?php echo $prod_image; ?>' width = '200px' alt = 'test image' class ='center'>
                            </td></tr>
                            <tr><td colspan = '2'>
                                <?php echo "<h4 class ='text_center'><a href = '#'>".$prod_title. "</h4></a>" ?>
                                </td></tr>    
                               <?php  
        echo "<tr><td>
        <strike><p class = 'price text_center'><sup>$</sup>".$prod_price."</p></strike>";
                            echo '</td><td>';
        $prod_price = round($prod_price - ($prod_price*$discount),2);
          echo "<p class = 'price text_center' style = 'color:crimson;'><sup>$</sup>".$prod_price ."</p>" ?>
                                </td></tr>
                                <tr><td colspan = '2'>
                                 <?php echo $prod_descr ?>
                                </tr></td>
                                <tr><td colspan = '2'>
                                <?php echo "<a href = 'purchase.php? prodId=".$prod_id."'>
                                <button type = 'button' class = 'button button_deals'>Select</button></a>";
                                ?>
                                </tr></td>
</table>