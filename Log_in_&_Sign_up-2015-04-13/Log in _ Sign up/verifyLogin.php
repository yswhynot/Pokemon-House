<?php
	$username = $_POST['username'];
	$password = $_POST['password'];
	//print($username." and ".$password);
	$connectionstring =mysql_connect("localhost","root", "");
	if ($connectionstring == 0) die("cannot connect to the db");
	$db = mysql_select_db("4432project", $connectionstring) or die("cannot open the selected db");

	if (($username === "") || ($password === "")) {
		print("Username/password can not be left blank.");	
	} 

	else {
		$check="Select UserName,Password from User where Username='".$username."'";
		//echo "$check";
		$result=mysql_query($check,$connectionstring);
		if (!$result) die("Username doesn't exist.");
		else {
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			if($row["Password"]!== $password)
				echo "Username & password don't match";
			else {
				echo "Successful Logging in!";
				echo "<a href=http://localhost:8080/home.php?>Home</a><br>";
				//header("Location: http://localhost:8080/home.php");
				session_start();
			}

		}

	}

	mysql_close($connectionstring);
?>