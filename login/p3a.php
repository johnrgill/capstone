<?php
  //password protected page
  session_start();
  $DBName = "project";
  $DBConnect = mysql_connect("localhost:8889", "root", "root") or die ("unable to connect".mysql_error());
  mysql_select_db($DBName);
  //retrieve username and password
  $user_id = $_SESSION['user_id'];
  $session_id = $_SESSION['session_id'];
  $current_time = time();  //will give you # seconds since jan 1, 1970
  $last_access = $current_time - 60*10;  //10 mins ago
  
  //check just for valid user AND user viewed a page within within the last 10 mins
  $Query_Result = mysql_query("SELECT * FROM current_logins 
		WHERE user_id='$user_id' AND session_id='$session_id' 
		AND last_visited>$last_access");	
  $logged_in="no";
  if (mysql_num_rows($Query_Result)>0) { $logged_in="yes"; }
		
   if ($logged_in=="yes") {
		//RESTRICTED CONTENT  
		$Query_Result = mysql_query("UPDATE current_logins 
			       SET last_visited='$current_time' WHERE user_id='$user_id'");	
   }