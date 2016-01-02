<html>
<head>
	<title>Confirmation</title>
	<link href="./css/style.css" rel="stylesheet" type="text/css" />
	<link href="./css/form.css" rel="stylesheet" type="text/css" />
</head>
 <body>
<div class="wrap">
<div class="toggle">
	<p class="m_text" align="middle">
<?php
	$connectionstring = mysql_connect("localhost","root");
	if ($connectionstring == 0) die("cannot connect to the db");
	$db = mysql_select_db("4432project", $connectionstring) or die("cannot open the selected db");
	$confirm = $_GET['confirm'];
	$SENDPOK = $_GET['SENDPOK'];
	$RECEIVEPOK = $_GET['RECEIVEPOK'];
	$query = "SELECT SENDUSER FROM MESSAGE WHERE SENDPOK=" .$SENDPOK. " AND RECEIVEPOK=".$RECEIVEPOK;
	$result = mysql_query($query, $connectionstring) or die("No information");
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$SENDUSER = $row['SENDUSER'];
	session_start();
	$UserID = $_SESSION['userid'];
	if($confirm === 'Y') {			//if confirm
		// insert new message inform the sender marriage confirmed
		$query = "INSERT INTO MESSAGE VALUES (" .$UserID. "," .$SENDUSER. "," .$RECEIVEPOK. "," .$SENDPOK. ",'agree')";
		mysql_query($query, $connectionstring) or die("No information");
		//update two pid in pokemon
		$query = "UPDATE POKEMON SET MARRIAGE=" .$SENDPOK. " WHERE PID=" .$RECEIVEPOK;
		mysql_query($query, $connectionstring) or die("No information");
		$query = "UPDATE POKEMON SET MARRIAGE=" .$RECEIVEPOK. " WHERE PID=" .$SENDPOK;
		mysql_query($query, $connectionstring) or die("No information");
		//if two of different gender
		$query = "SELECT GENDER, CATEGORY, NAME FROM POKEMON JOIN POKEMONDATA ON POKEMON.PDATAID=POKEMONDATA.PDATAID 
			WHERE POKEMON.PID=" .$SENDPOK;
		$result = mysql_query($query, $connectionstring) or die("No information");
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$SENDPOKGender = $row['GENDER'];
		$SENDPOKCat = $row['CATEGORY'];
		$SENDPOKName = $row['NAME'];
		$query = "SELECT GENDER, CATEGORY, NAME FROM POKEMON JOIN POKEMONDATA ON POKEMON.PDATAID=POKEMONDATA.PDATAID 
			WHERE POKEMON.PID=" .$RECEIVEPOK;
		$result = mysql_query($query, $connectionstring) or die("No information");
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$RECEIVEPOKGender = $row['GENDER'];
		$RECEIVEPOKCat = $row['CATEGORY'];
		$RECEIVEPOKName = $row['NAME'];
		print("<br />You have successfully get your pokemon married XD<br /><br />");
		if($SENDPOKGender !== $RECEIVEPOKGender) {	// if the pokemon of the different gender
			// generate random number to determine gender of baby and type of baby
			$rand = rand(0, 100);
			if($rand < 50)
				$newPokCat = $SENDPOKCat;
			else
				$newPokCat = $RECEIVEPOKCat;
			$query = "SELECT GENDERPROB FROM POKEMONDATA WHERE PDATAID=
				(SELECT MIN(PDATAID) FROM POKEMONDATA WHERE CATEGORY=" .$newPokCat. ")";
			$result = mysql_query($query, $connectionstring) or die("No information");
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$GENDERPROB = intval($row['GENDERPROB']);
			if($rand < $GENDERPROB)
				$newPokGender = 'M';
			else
				$newPokGender = 'F';
			// update pokemon insert two new pid
			$query = "SELECT MAX(PID) AS MAX FROM POKEMON";
			$result = mysql_query($query, $connectionstring) or die("No information");
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$newPokID = intval($row['MAX']) +1;
			$query = "INSERT INTO POKEMON VALUES (" .$newPokID. ", (SELECT MIN(PDATAID) FROM POKEMONDATA WHERE CATEGORY="
				.$newPokCat. "), " .$UserID. ", 0, '" .$newPokGender. "', '" .$SENDPOKName. " and " .$RECEIVEPOKName. "', 0, 0, 0)";
			mysql_query($query, $connectionstring) or die("No information");
			$newPokID++;
			$query = "INSERT INTO POKEMON VALUES (" .$newPokID. ", (SELECT MIN(PDATAID) FROM POKEMONDATA WHERE CATEGORY="
				.$newPokCat. "), " .$SENDUSER. ", 0, '" .$newPokGender. "', '" .$SENDPOKName. " and " .$RECEIVEPOKName. "', 0, 0, 0)";
			mysql_query($query, $connectionstring) or die("No information");
			//delate current message
			$query = "DELETE FROM MESSAGE WHERE SENDPOK=" .$SENDPOK. " AND RECEIVEPOK=".$RECEIVEPOK;
			mysql_query($query, $connectionstring) or die("No information");
			print("You've got a new born baby as well!! Go and check it out!<br /><br />");
		} else {
			print("The pokemon of the same gender cannot give birth to new baby :( <br /><br />");
		}
	} else if($confirm === 'N') {	//if refused
		//insert new message inform refuse
		$query = "INSERT INTO MESSAGE VALUES ()";
		//delete current message
		$query = "";
	}
	print("<div class=\"btn_form\" align=\"middle\"><form>");
	print("<input type=\"button\" align=\"middle\" value=\"Yeah!!\" onclick=\"window.open('', '_self', ''); window.close();\" />");
	print("</form></div>");

?>
	</p>
</div>
</div>
<?php
	mysql_free_result($result);
	mysql_close($connectionstring);
?>
</body>
</html>