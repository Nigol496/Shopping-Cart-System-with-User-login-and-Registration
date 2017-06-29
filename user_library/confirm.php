<?php
session_start();
/* Displays user information and some useful messages */
// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "You must log in before viewing your profile page!";
      
}else {
    require '../db.php';
	
    if ($_SERVER['REQUEST_METHOD'] = "POST"){
       		$prod_id = $_POST['prod_id'];    
	}  

    if (isset($_POST['prod_price'])) {
		$prod_price = $_POST['prod_price'];
	}
    
    $email = $_SESSION['email'];
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result1 = $mysqli->query($query);
    
    if (!$result1){
        echo "SELECT from users failed.",mysqli_error($mysqli);
        exit();
    }
    
	if (isset($_GET['removeSalesId'])){
    		  $removeSalesId = $_GET['removeSalesId'];
		      $result2 = $mysqli->query("DELETE FROM sales WHERE sales_id = $removeSalesId");
        	   unset($_GET['removeSalesId']);
		}    

    $user_row = $result1->fetch_assoc();
    $query = "SELECT * FROM invoice ORDER BY invoice_no DESC";
    $result4 = $mysqli->query($query);
    if (!$result4) {
        echo "SELECT form invoice failed.", mysql_error($mysqli);
        exit();
    }
    
    $invoicerow = $result4->fetch_assoc();
    if ($invoicerow) {
        $invoiceNo = $invoicerow['invoice_no'] + 1;
    } else {
        $invoiceNo = 1;
    }
    date_default_timezone_set('America/Vancouver');
    
    
    $query = "SELECT * FROM sales WHERE email = '$email' && invoice_no IS NULL";
    $result5 = $mysqli->query($query);
    if (!$result5) {
        echo "SELECT form products failed.", mysqli_error($mysqli);
        exit();
    }
     $total_items =$result5->num_rows;
}

?>



<!Doctype html>
<html lang="en">

<head>
	<title> HTML/CSS3 </title>
	<meta charset = "utf-8" />
	<link rel="stylesheet" href = "style.css" type ="text/css" />
    <!-- link rel = "stylesheet" href = "../css/style.css" type = "text/css" /-->
	<meta name="viewport" content = "width=device-width, initial-scale =1.0">
</head>

<body class="body">

	<header class = "mainHeader">
		<nav><ul>
		<li><a href = "home.php"> Home </a></li>
		<li><a href = "about.html"> About </a></li>
		<li><a href = "blog.html"> Blog </a></li>
		<li><a href = "contact.html"> Contact </a></li>
        <li><a href = "confirm.php"> My Cart(<?php echo $total_items; ?>) </a></li>
        <li id ="right"><form action = 'home.php' method = "POST"><input type = "text" name = "search" placeholder = "Search.." class = "search_bar"> <input type = "submit" class = "button"></form></li> 
        <li id =><a href = "../logout.php" > Logout </a></li>   
		 </ul></nav>
		 </header>

<div class ="mainContent">
<div class = "content">           
<article class= "topContent">
<h1> Your Bagged Items </h1>
    <?php
    $purtot = $taxamt = $invtot = 0;
    $salesrow2 = $result5->fetch_assoc();
    
    $count = 1;
    
    if (!$total_items){
            echo "<h1> No Bagged Item </h1>";
        } else {
        
    do {
        $this_prod = $salesrow2['prod_id'];
        $sale_date = $salesrow2['sales_date'];
        $this_qty = $salesrow2['sales_quantity'];
        $query = "SELECT * FROM product WHERE prod_id = '$this_prod'";
        $result6 = $mysqli->query($query);
        if (!$result6){
        echo "SELECT FROM product failed. ", mysqli_error($mysqli);
        exit();
        }
        $prodrow2 = $result6->fetch_assoc();
        $prod_price = round($prodrow2['prod_price'] - $prodrow2['prod_price']*$prodrow2['prod_discount'],2);
?>
            <table cellpadding = '10'>
                <tr> 
                    <td>
                        <img src = '<?php echo $prodrow2['prod_image']; ?>' width = '200px' alt = 'test image' alt = 'test image' style = 'float:right;'>
                    </td> 
                    <td class = 'prod_info'>
                                <header>
                                    <a href = '#' title = 'product_title'>
                                    <h4><?php echo $prodrow2['prod_title']; ?>
                                    </a>
                                    <a href = 'confirm.php? removeSalesId= <?php echo $salesrow2['sales_id']; ?>'>
                                    <button type = 'button' class = 'button' style = 'float:right;'>Remove</button>
                                    </a></h4>
                                </header>

                            <footer>
                                <p class = 'prod_seller' title = 'prod_seller'> by <?php echo $prodrow2['prod_seller']; ?></p> 
                            </footer>

                        <content>
                            <div class ='prod_qty'> (x <?php echo $this_qty ?>) </div>
                            <p class = 'price'><sup>$</sup> <?php echo $prod_price ?></p>
                            <?php 
                                $prod_desc_prev = substr($prodrow2['prod_descr'], 0, 128) . "...";
                                echo"<p>".$prod_desc_prev."</p>";
                            ?>
                        </content>
                    </td>
 
                </tr>

                <tr>
                    <td colspan='2'>
                        <hr style = 'height:1px; border:none; color:#cccccc; background-color:#cccccc;'>
                    </td>
                </tr>
                
        <?php 
                $purtot = $purtot + $prod_price*$this_qty;
                if ($count == $total_items){ 
                $taxamt = round($purtot * .087,2);
                $invtot = round($purtot + $taxamt,2);
                setlocale(LC_MONETARY, 'en_US');
        ?>
                <tr>
                    <td>
                        <div style = 'float:left; font-size: 20px;'>
                            Bag Subtotal:<br>
                            Tax:<br>
                    </td>
                    <td style = 'float:right; font-size: 20px;'>
                        <sup>$</sup><?php echo money_format('%!n', $purtot) ?> <br>    
                        <sup>$</sup><?php echo money_format('%!n', $taxamt) ?> <br>   
                    </td>
                </tr>
                
                <tr>
                    <td colspan = '2'>
                        <hr style = 'height:1px; border:none; color:#cccccc; background-color:#cccccc;'>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span style = 'font-size: 25px;'> Total: <span><br>
                    </td>
                    <td style = 'float:right;'>
                        <span style = 'font-size: 25px;'>
                            <sup>$</sup><?php echo money_format('%!n ', $invtot) ?> <br>   
                        <span><br>
                    </td>
                </tr>
                <tr>
                    <td colspan = '2'>
                        <hr style = 'height:1px; border:none; color:#cccccc; background-color:#cccccc;'>
                    </td>
                </tr>
                <tr>
                    <td colspan = '2'>
                        <a href = 'checkout.php'>
                        <button type = 'button' class = 'button' style = 'float:right;'>Confirm Checkout</button>
                        </a>
                    </td>
                </tr>
            </table>
        
             <?php 
        }    
            $count++;
    } while ($salesrow2 = $result5->fetch_assoc());
}
    ?>
        
</article>
    <article class= "bottomContent">
				<header>
				<h2> <a href = "#" title = "Second post"> Second Product </a></h2>
			    </header>

			<footer>
				<p class = "post-info"> This is written by XYZ </p>
				</footer>

				<content>
					<p>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent gravida ut ex ut fringilla.
					Vestibulum semper erat a condimentum rutrum. Donec luctus imperdiet magna ac pulvinar.
					Aenean pharetra erat est. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
					Aliquam viverra dui erat, eu imperdiet risus efficitur ac. Morbi et dapibus nisl.
					Aenean malesuada turpis egestas consequat sodales. Integer in turpis varius, sodales eros non, facilisis magna.
					</P>

					<p>
					Sed congue justo ut velit dictum vestibulum. Nullam nec consequat diam. Etiam cursus congue fermentum.
					Vivamus a tincidunt dui, at porttitor erat. Pellentesque ac magna vitae diam dapibus mollis et non nunc.
					Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque sit amet sem nec sapien semper imperdiet.
					Ut quis gravida risus. Curabitur id metus est. Ut sollicitudin fermentum lacus, id cursus diam iaculis nec.
					Morbi tristique tincidunt metus. Fusce pretium vehicula tristique. Integer sed nunc vel dolor lobortis mattis.
					</P>
					</content>
    </article>
					</div>
					</div>

					<aside class = "top-sidebar">
						<article>
						<h2> Today's Deals </h2>
						<p> Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
					</article>
					</aside>

					<aside class = "middle-sidebar">
						<article>
						<h2> Middle sidebar </h2>
						<p> Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
					</article>
					</aside>

					<aside class = "bottom-sidebar">
						<article>
						<h2> Bottom sidebar </h2>
						<p> Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
					</article>
					</aside>

					<aside class = "bottom-inputbar">
						<article>
						<h2> Contact </h2>
						<hr></hr>
						<form action="action_page.php">
							First name:<br>
							<input type="text" name="firstname" value="XYZ"><br>
							Last name:<br>
							<input type="text" name="lastname" value="XYZ"><br><br>
							<input type="submit" value="Submit">
								<hr></hr>
									Sorry.... this is under construction
						</form>
						</article>
						</aside>

					<footer class = "mainFooter">
						<p> Copyright &copy; 2017 <a href = "http://www.codeforglory.com/" title = "1stwebdesigner"> codeforglory.com </p>
						 </footer>
						</body>

