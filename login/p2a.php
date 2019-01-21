<?php
  //check login page

  session_start();

  $DBName = "project";
  $DBConnect = mysql_connect("localhost:8889", "root", "root") or die ("unable to connect".mysql_error());
  mysql_select_db($DBName);
  
  //retrieve username and password
  $username=$_POST['username'];
  $password=$_POST['password'];
  $ip=$_SERVER['REMOTE_ADDR']; 

  $current_time = time();  //will give you # seconds since jan 1, 1970
  $last_access = $current_time - 60*10;  //10 mins ago
  $current_date = date("Y-m-d"); //will give you 2012-01-16

  $Query_Result = mysql_query("SELECT * FROM failed_attempts WHERE ip='$ip'
		AND timestamp>$last_access");	
  if (mysql_num_rows($Query_Result)>0) { 
		$Query_Result = mysql_query("INSERT INTO failed_attempts 
			       (ip,timestamp) VALUES ('$ip','$current_time')");	
  } else {

	$user_id=0;
  
	$Query_Result = mysql_query("SELECT * FROM user_info WHERE username='$username'
			AND password='$password' AND Active='1'");	
	while ($Row = mysql_fetch_assoc($Query_Result))
	{
			$user_id = $Row["user_id"];
	}
  
	if ($user_id!=0) {
   
		//SET user_id as session variable
		$_SESSION['user_id'] = $user_id;
		
		//generate unique session Id and set as session variable
		$sessID=session_id();
		$_SESSION['session_id'] = $sessID;
		
				
		//send user_id and session id to DB
		$Query_Result = mysql_query("INSERT INTO current_logins 
			       (user_id, session_id, last_visited, login_date) 
			VALUES ('$user_id','$sessID','$current_time','$current_date'");	
  
	} else {
   
		$Query_Result = mysql_query("INSERT INTO failed_attempts 
			       (ip,timestamp) VALUES ('$ip','$current_time')");	
   
	}
  }
  
  