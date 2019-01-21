<?php

	$item_id=$_POST['item_id'];
	$item_id = mysqli_escape_string($conn, $item_id);
	
	include("dbinfo.php");
	$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
	//more mysqli escape strings
	if (!($conn)) {
	  die ("Connection failed: " . mysqli_connect_error());
	} 
	
	$TableName = "items";
	$TableName = mysqli_escape_string($conn, $TableName);
	$QueryString = "SELECT * FROM $TableName WHERE item_id='$item_id'";
	$QueryResult = mysqli_query($conn, $QueryString) or trigger_error( 
						mysqli_error(), E_USER_ERROR);
	while ($Row = mysqli_fetch_assoc($QueryResult)) {
		$image = $Row["picture"];
	}	
	if ($image!="") unlink("../images/$image");
	
	$query = "DELETE FROM $TableName WHERE item_id = '$item_id'";
	$result = mysqli_query($conn, $query) or trigger_error( 
						mysqli_error(), E_USER_ERROR);
	
	mysqli_close($conn);
	header("Location:./view_items.php");
    
?>
