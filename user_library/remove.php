<?php
session_start();
/* Displays user information and some useful messages */
// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "You must log in before viewing your profile page!";
  header("location: /error.php");    
}else {
    require '../db.php';
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
        <li id ="right"><form action = '<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method = "POST"><input type = "text" name = "search" placeholder = "Search.."> <input type = "submit" class = "button"></form></li> 
        <li id =><a href = "../logout.php" > Logout </a></li>   
		 </ul></nav>
		 </header>

<div class ="mainContent">
<div class = "content">           
<article class= "topContent">  
  
    <?php 
    $removeSalesId = $_GET['removeSalesId'];
    $result = $mysqli->query("SELECT * FROM product WHERE prod_id = $prod_id");
  //  $result2 = $mysqli->query("DELETE FROM sales WHERE sales_id = $removeSalesId");
    
    if (!$result2) {
        echo "<h1> Select From invoice failed <br>", mysqli_error($result);
    }else {
        echo "<h1> Product Removed </h1>";
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' AND !empty($_POST['search'])) {
       $result = $mysqli->query("SELECT * FROM product WHERE prod_title LIKE '%". $_POST['search']."%' LIMIT 10"); 
        unset($_POST['search']);
    }
    
    if ( $result->num_rows == 0 ){ // Product doesn't exist
    echo "<h2> No Products Found </h2>";  
 }
else { // User exists
    $user = $result->fetch_assoc();
      echo "<table cellpadding = '10' width = '100%'>
            <tr> 
<td>
        <header>
            <a href = '#' title = 'prod_title'>
                <h4>".$user['prod_title']."
            </h4></a>
        </header>

    <footer>
        <p class = 'prod_seller' title = 'prod_seller'> by ".$user['prod_seller']."</p> 
    </footer>

            <content>
                <p class = 'price'><sup>$</sup>".$user['prod_price']."</p>";
                $descr = $user['prod_descr'];
          echo "<p>".$user['prod_descr']."</P>
            </content>
</td>
 <td> 
        <img src = '#' width = '300px' alt = 'test image' style = 'float:right;'>
</td> 
    </tr>";
    echo "
    <form action = 'myBag.php' method = 'POST'>
                <input type = 'hidden' name = 'prod_id' value = ".$user['prod_id'].">
                <input type = 'hidden' name = 'prod_price' value = ".$user['prod_price'].">
                <input type = 'submit' class = 'button' value = 'Add To Bag' style = 'float:left;'>
            </form> ";
}
?>
    </table>
</article>
			<article class= "bottomContent">
				<header>
				<h2> <a href = "#" title = "Second post"> Second Product </a></h2>
			    </header>

			<footer>
				<p class = "post-info"> This is written by Nigol </p>
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
						<h2> Top Sidebar </h2>
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
							<input type="text" name="firstname" value="Nigol"><br>
							Last name:<br>
							<input type="text" name="lastname" value="Bista"><br><br>
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

