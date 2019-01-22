<?php

	$category_id=$_POST['category_id'];
	$category_id = mysqli_escape_string($conn, $category_id);
	echo $category_id;
	include("dbinfo.php");
	$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
	//more mysqli escape strings
	if (!($conn)) {
	  die ("Connection failed: " . mysqli_connect_error());
	} 
	
	$TableName = "categories";
	$TableName = mysqli_escape_string($conn, $TableName);
	$QueryString = "SELECT * FROM $TableName WHERE category='$category_id'";
	$QueryResult = mysqli_query($conn, $QueryString) or trigger_error( 
						mysqli_error(), E_USER_ERROR);

	
	
	$query = "DELETE FROM $TableName WHERE category = '$category_id'";
	$result = mysqli_query($conn, $query) or trigger_error( 
						mysqli_error(), E_USER_ERROR);
	
	mysqli_close($conn);
    //header("Location:./view_categories.php");
    echo $category_id;
    
?>