<html>
	<head>
	<?php
		$PDATAID = $_GET['PDATAID'];
		session_start();
		$UserID = $_SESSION['userid'];
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
		$query = "SELECT PDataID, POKEMONDATA.Name AS PNAME, Type, GenderProb, FOOD.NAME AS FNAME, POKEMONDATA.Price AS PPRICE 
				FROM POKEMONDATA JOIN FOOD ON POKEMONDATA.FOODID=FOOD.FOODID WHERE PDATAID=" .$PDATAID;
		$result = mysql_query($query, $connectionstring) or die("No information");
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$name = $row['PNAME'];
		print("<div class=\"header-top\"><div class=\"wrap\">");
		print("<div class=\"sky-form\"><h4>" . $name . "</h4></div>");
		print("<div class=\"css3\"><img src=\"./Image/Pokemon/" . $name . ".png\" alt=\"\"/></div>");
		print("<div class=\"toogle\">");
     	print("<h3 class=\"m_3\">Baby Pokemon Information</h3>");
     	print("<p class=\"m_text\">Age: 0<br />");
     	print("Gender: " . $row['GenderProb'] . "% of being Male<br />");
     	print("Parent: N/A<br />");
     	print("Hungry level: 0<br />");
     	print("Type: " .$row['Type']. "<br />");
     	print("Food required: " .$row['FNAME']. "<br />");
     	print("Price: " .$row['PPRICE']. "<br />");
     	print("</p></div><br />");
     	$query = "SELECT MONEY FROM USER WHERE USERID=" .$UserID;
		$result = mysql_query($query, $connectionstring) or die("No information");
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
     	print("<h4 class=\"m_9\" align=\"center\">You have " .$row['MONEY']. " money. Confirm payment?</h4>");
     	print("<div class=\"btn_form\"><form>");
     	print("<input type=\"button\" align=\"middle\" value=\"Yes!!\" onclick=\"javascript:void window.open
     						('payment.php?PDATAID=$PDATAID','Feed Pokemon','width=450,height=150,scrollbars=1,resizable=1');return false;\"><br/><br />");
     	print("<input type=\"button\" value=\"Not now :(\" onclick=\"window.open('', '_self', ''); window.close();\">");
		print("</div></div><div class=\"clear\"></div>");
		mysql_free_result($result);
		mysql_close($connectionstring);
	?>
	</body>
</html>