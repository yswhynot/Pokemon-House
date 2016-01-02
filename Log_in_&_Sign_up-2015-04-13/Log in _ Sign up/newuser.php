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
		$check="SELECT COUNT(*) AS Num from User where Username='".$username."'";
		echo "$check";
		$result=mysql_query($check,$connectionstring) or die("No information");
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$umNum = $row['Num'];
		echo "$umNum";
		if($umNum!=0) {
			print("Username already exists. Please choose another username");
			mysql_free_result($result);
		}
		else {
			$queryP = "SELECT COUNT(*) AS NUM FROM User";
			$resultP = mysql_query($queryP, $connectionstring) or die("No information");
			$rowP = mysql_fetch_array($resultP, MYSQL_ASSOC);
			$wsNum = $rowP['NUM'];

			
			$sql="INSERT into User (UserID,UserName,Password)
				  VALUES ('".$wsNum."','$username','$password')";
			//echo "$sql";
			$result=mysql_query($sql,$connectionstring) or die("No information");
			print("Your account has been successfully created.");
			echo "<a href=http://localhost:8080/home.php?>Home</a><br>";
			
			//header("Location: http://localhost:8080/home.php");

			session_start();
		}
	}


	mysql_close($connectionstring);
?>