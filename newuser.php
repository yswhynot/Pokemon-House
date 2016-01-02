<?php
	$username = $_POST['username'];
	$password = $_POST['password'];
	print($username." and ".$password);
	$connectionstring =mysql_connect("localhost","root");
	if ($connectionstring == 0) die("cannot connect to the db");
	$db = mysql_select_db("4432project", $connectionstring) or die("cannot open the selected db");
	if (($username === "") || ($password === "")) {
		print("Username/password can not be left blank.");	
	} else if ($_COOKIE['count'] === 'first') {
		$check="Select UserName from User where username=" .$username;
		$result=mysql_query($check,$connectionstring);
		if($result) print("Username already exists. Please choose another username");
		else {
			$sql="Insert into User ()";
			print("Your account has been successfully created.");
			//email reg needs further developed
			session_start();
		}
	}
?>