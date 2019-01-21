<?php

	include("dbinfo.php");
	$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
	
	if (!($conn)) {
	  die ("Connection failed: " . mysqli_connect_error());
	} 
    //added mysqli escape string
	$catdropdown=$_POST['catdropdown'];
	$catdropdown = mysqli_escape_string($conn, $catdropdown);  
	$title=$_POST['title'];
	$title = mysqli_escape_string($conn, $title);  
	$description=$_POST['description'];
	$description = mysqli_escape_string($conn, $description);
	$price=$_POST['price'];
	$price = mysqli_escape_string($conn, $price);
	$quantity=$_POST['quantity'];
	$quantity = mysqli_escape_string($conn, $quantity);  
	$sku=$_POST['sku'];
	$sku = mysqli_escape_string($conn, $sku);  
  	$image=basename( $_FILES['uploaded']['name']);
  
  	$errors = 0;
  
  	if ($title=="") $errors=1;
  	if ($description=="") $errors=2;
  	if ($price=="") $errors=3;
  	if ($quantity=="") $errors=4;
  	if ($sku=="") $errors=5;
  	if ($image=="") $errors=6;
  
	$TableName = "items";
	$TableName = mysqli_escape_string($conn, $TableName);
	$sql = "SELECT * FROM $TableName WHERE title='$title'";
	$DuplicateCheck = mysqli_query($conn, $sql) or trigger_error( 
						mysqli_error(), E_USER_ERROR);
	if ( mysqli_num_rows($DuplicateCheck) > 0 ) {  $errors=7; $is_duplicate="yes"; }	  

	if ($errors>0) {
?>  
<!DOCTYPE html PUBLIC " - //W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Check Item Add</title>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	</head>

	<body>

		<h2>Enter Item Details Below</h2>
		<FONT color=red><h2>All Fields Are Required</h2></font>
		<FONT color=red><h2>Error with field: <?php echo $errors; ?></h2></font>


   		<FORM action="check_item_add.php" method="POST" enctype="multipart/form-data">
 	
			Category: <select name="catdropdown">
    						<option value = "">Choose a category</option>
<?php
   
	$sql = "SELECT category_id, category FROM categories";
	$result = mysqli_query($conn, $sql) or trigger_error( 
						mysqli_error(), E_USER_ERROR);
	while ($row = mysqli_fetch_assoc($result)) {
			$category_id = $row['category_id'];
			$category = $row['category'];
			echo "<option value=\"$category_id\" ";
			if ($catdropdown==$category_id) echo " SELECTED ";
			echo ">$category\n";
	}
?>	
	 		</select>
			<?php if ($catdropdown=="") echo "<font color=red> *required</font>"; ?>
	 		<br /><br />
      		Title: 		<input type="text" name="title" value="<?php echo "$title"; ?>" />
			<?php if ($title=="") echo "<font color=red> *required</font>"; ?>
			<?php if ($title!="" && $is_duplicate=="yes") echo "<font color=red> *duplicate</font>"; ?>
      		<br /><br />
	  		Description : 	<input type="text" name="description" value="<?php echo "$description"; ?>" />
			<?php if ($description=="") echo "<font color=red> *required</font>"; ?>
	  		<br /><br />
			Price: 		<input type="text" name="price" value="<?php echo "$price"; ?>" />
			<?php if ($price=="") echo "<font color=red> *required</font>"; ?>
			<br /><br />
	  		Quantity:		<input type="text" name="quantity" value="<?php echo "$quantity"; ?>" />
			<?php if ($quantity=="") echo "<font color=red> *required</font>"; ?>
	  		<br /><br />
	  		SKU  : 			<input type="text" name="sku" value="<?php echo "$sku"; ?>" />
			<?php if ($sku=="") echo "<font color=red> *required</font>"; ?>
	  		<br /><br />
	 		Please choose an image: <input name="uploaded" type="file" /><?php echo "<font color=red> *required</font>"; ?>
	 		<br /><br />

      		<input type="submit" name="submit" value="Add" />
   		</FORM>

	</body>

</html>
<?php
		mysqli_close($conn);

  	} else {

		$SQLString = "INSERT INTO $TableName(Category, title, description, price, quantity, sku, picture) 
						VALUES('$catdropdown', '$title', '$description', '$price', '$quantity', '$sku', '$image')";
		$QueryResult = mysqli_query($conn, $SQLString) or trigger_error( 
						mysqli_error(), E_USER_ERROR);

		$target = "../images/"; 
 		$target = $target . basename( $_FILES['uploaded']['name']) ; 
 		move_uploaded_file($_FILES['uploaded']['tmp_name'], $target);

		mysqli_close($conn);
		header("Location:./view_items.php");
	}

?>
  


