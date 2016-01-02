<html>
	<head>
	<?php
		$PID = $_GET['PID'];
	?>
		<link href="./css/style.css" rel="stylesheet" type="text/css" />
		<link href="./css/form.css" rel="stylesheet" type="text/css" />
		<title>Pokemon Data</title>
	</head>
	<body>
	<?php
		$connectionstring =mysql_connect("localhost","root");
		if ($connectionstring == 0) die("cannot connect to the db");
		$db = mysql_select_db("4432project", $connectionstring) or die("cannot open the selected db");
		$query = "SELECT PID, POKEMON.PDataID, UserID, Age, Gender, Parent, HungryLevel, Marriage, WorkStatusID, Name, Type
					FROM POKEMON JOIN POKEMONDATA ON POKEMON.PDATAID=POKEMONDATA.PDATAID
					WHERE POKEMON.PID=" . $PID;
		$result = mysql_query($query, $connectionstring) or die("No information");
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$name = $row['Name'];
		print("<div class=\"header-top\"><div class=\"wrap\">");
		print("<div class=\"sky-form\"><h4>" . $name . "</h4></div>");
		print("<div class=\"css3\"><img src=\"./Image/Pokemon/" . $name . ".png\" alt=\"\"/></div>");
		print("<div class=\"toogle\">");
		print("<h3 class=\"m_3\">General Pokemon Information</h3>");
     	print("<p class=\"m_text\">Type: " . $row['Type'] . "</p>");
     	print("<h3 class=\"m_3\">Pokemon Personal Information</h3>");
     	print("<p class=\"m_text\">Age: " . $row['Age'] . "<br />");
     	print("Gender: " . $row['Gender'] . "<br />");
     	print("Parent: " . $row['Parent'] . "<br />");
     	print("Hungry level: " . $row['HungryLevel'] . "<br />");
     	$Marriage = $row['Marriage'];
     	if ($Marriage == 0) {
     		print("Marriage: Not married <br />");
     	} else {
     		$query = "SELECT T.USERID, USERNAME, PID, NAME FROM ((SELECT USER.USERID, USERNAME, PID, PDATAID
								FROM POKEMON JOIN USER ON USER.USERID = POKEMON.USERID
								WHERE PID=" . $Marriage . ") T) JOIN POKEMONDATA ON T.PDATAID=POKEMONDATA.PDATAID";
			$result = mysql_query($query, $connectionstring) or die("No information");
			$row2 = mysql_fetch_array($result, MYSQL_ASSOC);
			print("Marriage: Married with " . $row2['USERNAME'] . "'s " . $row2['NAME'] . "<br />");
     	}
     	$WorkStatusID = $row['WorkStatusID'];
     	if ($WorkStatusID == 0) {
     		print("Work Status: Currently free <br />");
     	} else {
     		$query = "SELECT WorkStatusID, Type, Time
						FROM WORKSTATUS JOIN WORK ON WORKSTATUS.WorkID=WORK.WorkID
						WHERE WorkStatusID=" . $WorkStatusID;
			$result = mysql_query($query, $connectionstring) or die("No information");
			$row3 = mysql_fetch_array($result, MYSQL_ASSOC);
			$workTime = $row3['Time'];
			date_default_timezone_set("Asia/Hong_Kong"); 
			print("Work Status: Have been " . $row3['Type'] . " since " . date('Y-m-d, H:i:s', $workTime) . "<br />");
     	}
     	print("</p></div><br />");
     	print("<h4 class=\"m_9\">Choose what you want to do</h4>");
     	print("<div class=\"btn_form\"><form>");
     	print("<input type=\"button\" value=\"Feed\" onclick=\"javascript:void window.open
     						('activity.php?PID=$PID&choice=feed','Feed Pokemon','width=450,height=150,scrollbars=1,resizable=1');return false;\"><br /><br />");
     	if ($Marriage == 0) 
     		print("<input type=\"button\" value=\"Getting marriaged\" onclick=\"javascript:void window.open
     						('activity.php?PID=$PID&choice=marry','Feed Pokemon','width=450,height=150,scrollbars=1,resizable=1');return false;\"><br /><br />");
     	if($WorkStatusID == 0)
     		print("<input type=\"button\" value=\"Send to work\" onclick=\"javascript:void window.open
     						('activity.php?PID=$PID&choice=work','Feed Pokemon','width=450,height=150,scrollbars=1,resizable=1');return false;\"></form></div>");
		print("</div></div><div class=\"clear\"></div>");
		mysql_free_result($result);
		mysql_close($connectionstring);
	?>
	</body>
</html>