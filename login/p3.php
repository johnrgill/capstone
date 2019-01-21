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

  //check just for valid user
  $Query_Result = mysql_query("SELECT * FROM current_logins 
		WHERE user_id='$user_id' AND session_id='$session_id'");	
  $logged_in="no";
  if (mysql_num_rows($Query_Result)>0) { $logged_in="yes"; }
		
   if ($logged_in=="yes") {
		//RESTRICTED CONTENT  
   }