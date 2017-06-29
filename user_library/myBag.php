<?php
session_start();
/* Displays user information and some useful messages */
// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "You must log in before viewing your profile page!";
  header("location: /error.php");    
}else {
    require '../db.php';
    $email = $_SESSION['email'];
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
	<meta name="viewport" content = "width=device-width, initial-scale =1.0">
</head>

<body class="body">

	<header class = "mainHeader">
		<nav><ul>
		<li><a href = "home.php"> Home </a></li>
		<li><a href = "about.html"> About </a></li>
		<li><a href = "blog.html"> Blog </a></li>
		<li><a href = "contact.html"> Contact </a></li>
        <li><a href = "confirm.php"> My Cart(<?php echo $total_items+1; ?>) </a></li>
        <li id ="right"><form action = 'home.php' method = "POST"><input type = "text" name = "search" placeholder = "Search.." class = "search_bar"> <input type = "submit" class = "button"></form></li> 
        <li id =><a href = "../logout.php" > Logout </a></li>   
		 </ul></nav>
		 </header>

<div class ="mainContent">
<div class = "content">           
<article class= "topContent"> 
    <?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $prod_id = $_POST['prod_id'];
                $prod_price = $_POST['prod_price'];
                $prod_qty = $_POST['prod_qty'];
        
                    $sql = "INSERT INTO sales (prod_id, email, sales_amount, sales_quantity) VALUES ('$prod_id','$email','$prod_price',$prod_qty)";
        
            if ($mysqli->query($sql)){
                echo "<h1>Product Added </h1>";
            }else {
                echo "Failed to add product <br>";
            }
        }
    
        $result = $mysqli->query("SELECT * FROM product WHERE prod_id = $prod_id");
        if ($_SERVER['REQUEST_METHOD'] == 'POST' AND !empty($_POST['search'])) {
            $result = $mysqli->query("SELECT * FROM product WHERE prod_title LIKE '%". $_POST['search']."%' LIMIT 10"); 
            unset($_POST['search']);
        }
    
        if ( $result->num_rows == 0 ){ // Product doesn't exist
            echo "<h2> No Products Found </h2>";  
        } else { 
        // User exists
            $user = $result->fetch_assoc();
    ?>
    
    <table cellpadding = '10' width = '100%'>
            <tr> 
                <td class = 'prod_info_left'>
                    <header>
                        <a href = '#' title = 'prod_title'>
                            <h4><?php echo $user['prod_title']; ?>
                                <div class ='prod_qty'> (x <?php echo $prod_qty ?> ) </div>
                        </a></h4>
                    </header>

                    <footer>
                                <p class = 'prod_seller' title = 'prod_seller'> by <?php echo $user['prod_seller'] ?> </p> 
                    </footer>

                    <content>
                        <p class = 'price'><sup>$</sup><?php echo $prod_price; ?> </p>
                        <p><?php echo $user['prod_descr']; ?></p>
                    </content>
                </td>
                <td>
                    <img src = '<?php echo $user['prod_image']; ?>' width = '300px' alt = 'test image' alt = 'test image' style = 'float:right;'>
                </td> 
            </tr>
        <?php            
            }
        ?>
   
            <tr>
                <td colspan="2">
                    <hr style = 'height:1px; border:none; color:#cccccc; background-color:#cccccc;'>
                    <a href = 'home.php'><button type = 'button' class = 'button' style = 'float:left;'> Continue Shopping </button></a>
                    <form action = 'confirm.php' method = 'POST'>
                        <input type = 'hidden' name = 'prod_id' value = <?php echo $user['prod_id']; ?>>
                        <input type = 'hidden' name = 'email' value = <?php echo $email ?>>
                        <input type = 'submit' class = 'button' value = 'Checkout' style = 'float:right;'>
                    </form>
                </td>
            </tr>
        </table>
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
					</p>
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

