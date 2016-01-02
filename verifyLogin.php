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
				$query = "SELECT USERID FROM USER WHERE USERNAME='" .$username. "'";
				$result = mysql_query($query, $connectionstring);
				$row = mysql_fetch_array($result, MYSQL_ASSOC);
				//header("Location: http://localhost:8080/home.php");
				session_start();
				$_SESSION['userid'] = $row['USERID'];
				echo "<a href=\"home.php\">Home</a><br>";
			}

		}

	}

	mysql_close($connectionstring);
?>