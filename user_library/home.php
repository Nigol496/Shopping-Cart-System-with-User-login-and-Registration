<?php
/* Displays user information and some useful messages */
    session_start();
// Check if user is logged in using the session variable
    if ( $_SESSION['logged_in'] != 1 ) {
        $_SESSION['message'] = "You must log in before viewing your profile page!";
        header("location: /error.php");    
    }else {
        require '../db.php';
        
        //Count Number of items in the Cart
        $email = $_SESSION['email'];
        $query = "SELECT * FROM sales WHERE email = '$email' && invoice_no IS NULL";
        $rows = $mysqli->query($query);
        $total_items = $rows->num_rows;
    
    }
?>

<!Doctype html>
<html lang="en">

<head>
	<title> HTML/CSS3 </title>
	<meta charset = "utf-8" />
	<link rel="stylesheet" href = "style.css" type ="text/css" />
	<meta name="viewport" content = "width=device-width, initial-scale =1.0">
</head>

<body class="body">

	<header class = "mainHeader">
		<nav><ul>
		<li><a href = "home.php"> Home </a></li>
		<li><a href = "about.html"> About </a></li>
		<li><a href = "blog.html"> Blog </a></li>
		<li><a href = "contact.html"> Contact </a></li>
        <li><a href = "confirm.php"> My Cart(<?php echo $total_items ?>) </a></li>
        <li id ="right"><form action = '<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method = "POST"><input type = "text" name = "search" placeholder = "Search.." class = "search_bar"> <input type = "submit" value = "Submit" class = "button"></form></li> 
        <li id =><a href = "../logout.php" > Logout </a></li>   
		 </ul></nav>
		 </header>

<div class ="mainContent">
    <div class = "content">           
        <article class= "topContent">  
  
<?php
    
    //Get the Products and limit 10 items in one page       
    $result = $mysqli->query("SELECT * FROM product LIMIT 10");
    if ($_SERVER['REQUEST_METHOD'] == 'POST' AND !empty($_POST['search'])) {
       $result = $mysqli->query("SELECT * FROM product WHERE prod_title LIKE '%". $_POST['search']."%' LIMIT 10"); 
        unset($_POST['search']);
    }
    
    if ( $result->num_rows == 0 ){ // Product doesn't exist
        echo "<h2> No Products Found </h2>";  
    } else { 
    // User exists
        $count = 1;
        $total_rows =$result->num_rows;
        $discount_per = 0;
        
        while ($user = $result->fetch_assoc()){
        
            if ($user['prod_discount'] > $discount_per) {
                $discount_per = $user['prod_discount'];
            }
?>
            
            <table cellpadding = '10' width='100%'>
            <td>
                <img src = '<?php echo $user['prod_image']; ?>' width = '200px' alt = 'test image'>
            </td> 
          
            <td>
                <header>
                    <a href = '#' title = 'product_title'>
                        <h4>
                            <?php echo $user['prod_title'] ?>
                    </a>

                            <?php  
                                if ($user['prod_quantity'] > 0 ){
                                echo "<a href = 'purchase.php? prodId=".$user['prod_id']."'>";
                            ?>
                                <button type = 'button' class = 'button' style = 'float:right;'>Select</button></a>
         
                            <?php
                                }else {  
                            ?>
                                <button type = 'button' class = 'button empty_button' style = 'float:right;'>Select</button>
                            <?php 
                                }
                            ?>
                    </h4>
            </header>

            <footer>
                <p class = 'prod_seller' title = 'prod_seller'> by <?php echo $user['prod_seller']?> </p> 
            </footer>
            
        <content>
                <?php 
                    if ($user['prod_discount'] > 0.00 && $user['prod_discount'] < 1.00){
                ?>
                  <p class = 'price'><strike style = 'float:left'><sup>$</sup><?php echo $user['prod_price'] ?></strike></p>
                
                <?php $prod_price = round($user['prod_price'] - $user['prod_price']*$user['prod_discount'],2); ?>
                  <p class = 'price' style = 'color:crimson;' ><sup>$</sup><?php echo $prod_price; ?></p>
               <?php 
                }else {
                ?>
                 <p class = 'price'><sup>$</sup><?php echo $user['prod_price']; ?> </p>
                
                <?php 
                } 
                if ($user['prod_quantity'] < 5 && $user['prod_quantity'] != 0) {
                    echo "<p class = 'prod_quantity'>";
                    echo "Only ".$user['prod_quantity']." left in stock";
                }else if ($user['prod_quantity'] == 0) {
                    echo "<p class = prod_quantity>";
                    echo $user['prod_quantity']." left in stock";
                }
                $prod_prev = substr($user['prod_descr'], 0, 128) . "...";
                echo "<p> $prod_prev </p>";
            ?>
        </content>
    </td>
</table>
    
            <?php
                if ($count < $total_rows){
                    echo "<hr style = 'height:1px; border:none; color:#cccccc; background-color:#cccccc;'>";
                }  
                    $count = $count + 1; 
            }  // while loop end bracket
    }  // else end bracket
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
						<h2 class = 'text_center'> Today's Deals </h2>
                            
                        
                            <table> 
                            <tr><td colspan = '2'>
                            <?php  
                                // Deals Section
                                $result = $mysqli->query("SELECT * FROM product WHERE prod_discount = '$discount_per'");
                                $user = $result->fetch_assoc();
                                
                                $prod_image = $user['prod_image'];
                                $prod_title = substr($user['prod_title'], 0, 32) . "...";
                                $prod_descr = substr($user['prod_descr'], 0, 64) . "...";
                                $prod_price = $user['prod_price'];
                                $prod_id = $user['prod_id'];
                                
                                ?>
                            <img src = '<?php echo $prod_image; ?>' width = '200px' alt = 'test image' class ='center'>
                            </td></tr>
                            <tr><td colspan = '2'>
                                <?php echo "<h4 class ='text_center'><a href = '#'>".$prod_title. "</h4></a>" ?>
                                </td></tr>    
                               <?php  
        echo "<tr><td>
        <strike><p class = 'price text_center'><sup>$</sup>".$prod_price."</p></strike>";
                            echo '</td><td>';
        $prod_price = round($prod_price - ($prod_price*$discount_per),2);
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
