<!DOCTYPE html PUBLIC " - //W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Edit Category</title>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	</head>

	<body>
	<H1>Edit Category</h1>

<?php
	include("dbinfo.php");
	$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
	//more mysqli escape strings
	$category_id=$_POST['category_id'];
	$category_id = mysqli_escape_string($conn, $category_id); 
  
	
	
	if (!($conn)) {
	  die ("Connection failed: " . mysqli_connect_error());
	} 

	$TableName = "categories";
	$TableName = mysqli_escape_string($conn, $TableName);
	$QueryString = "SELECT * FROM $TableName WHERE category_id='$category_id'";
	$QueryResult = mysqli_query($conn, $QueryString) or trigger_error( 
						mysqli_error(), E_USER_ERROR);
	while ($Row = mysqli_fetch_assoc($QueryResult)) {
   		$category_id = $Row["category_id"];
   		$category = $Row["category"];

   		echo "    <FORM action=\"check_category_save.php\" method=\"POST\">";
   		echo "      Category: <input type=\"hidden\" name=\"category_id\" value=\"$category_id\" />";
   		echo "      <input type=\"text\" name=\"category\" value=\"$category\" />";
   		echo "      <input type=\"submit\" name=\"submit\" value=\"Save\" />";
   		echo "    </FORM>";
   
 	}   

	mysqli_close($conn);
 
?>
  
		</table>
	</body>

</html>