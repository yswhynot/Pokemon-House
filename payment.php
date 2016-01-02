<html>
<head>
<?php
	$PDATAID = $_GET['PDATAID'];
	session_start();
	$UserID = $_SESSION['userid'];
	$connectionstring =mysql_connect("localhost","root");
	if ($connectionstring == 0) die("cannot connect to the db");
	$db = mysql_select_db("4432project", $connectionstring) or die("cannot open the selected db");
?>
	<link href="./css/style.css" rel="stylesheet" type="text/css" />
	<link href="./css/form.css" rel="stylesheet" type="text/css" />
	<title>Confirm Payment</title>
</head>
<body>
<div class="wrap">
<div class="toggle">
	<p class="m_text" align="middle">
<?php
	// generate random number to determine gender of baby
	$rand = rand(0, 100);
	$query = "SELECT GENDERPROB, PRICE FROM POKEMONDATA WHERE PDATAID=". $PDATAID;
	$result = mysql_query($query, $connectionstring) or die("No information");
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$GENDERPROB = intval($row['GENDERPROB']);
	$PRICE = $row['PRICE'];
	if($rand < $GENDERPROB)
		$newPokGender = 'M';
	else
		$newPokGender = 'F';

	// update pokemon insert new pid
	$query = "SELECT MAX(PID) AS MAX FROM POKEMON";
	$result = mysql_query($query, $connectionstring) or die("No information");
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$newPokID = intval($row['MAX']) +1;
	$query = "INSERT INTO POKEMON VALUES (" .$newPokID. ", " .$PDATAID. ", " .$UserID. ", 0, '" 
		.$newPokGender. "', 'N/A', 0, 0, 0)";
	mysql_query($query, $connectionstring) or die("No information");

	// decrease money from the user
	$query = "UPDATE USER SET MONEY=MONEY-" .$PRICE. " WHERE USERID= ".$UserID;
	mysql_query($query, $connectionstring) or die("No information");
	print("<br />You have successfully buy the pokemon XD<br /><br />");
	print("<div class=\"btn_form\" align=\"middle\"><form>");
	print("<input type=\"button\" align=\"middle\" value=\"Yeah!!\" onclick=\"window.open('', '_self', ''); window.close();\" />");
	print("</form></div>");
	mysql_free_result($result);
	mysql_close($connectionstring);
?>
	</p>
</div>
</div>
</body>
</html>
