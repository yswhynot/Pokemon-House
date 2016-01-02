<html>
<head>
	<title>My Message</title>
	<link href="./css/style.css" rel="stylesheet" type="text/css" />
	<link href="./css/form.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="wrap">
<div class="toggle">
	<p class="m_text">
<?php
	session_start();
	$connectionstring = mysql_connect("localhost","root");
	if ($connectionstring == 0) die("cannot connect to the db");
	$db = mysql_select_db("4432project", $connectionstring) or die("cannot open the selected db");
	$query = "SELECT SENDUSER, USERNAME, SENDPOK, RECEIVEPOK, MESSAGE FROM MESSAGE JOIN USER ON MESSAGE.SENDUSER=USER.USERID
				WHERE RECEIVEUSER=" .$_SESSION['userid'];
	$result = mysql_query($query, $connectionstring) or die("No information");
	//load the message
	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$USERNAME = $row['USERNAME'];
		$SENDPOKID = $row['SENDPOK'];
		$SENDUSER = $row['SENDUSER'];
		$RECEIVEPOKID = $row['RECEIVEPOK'];
		$MESSAGE = $row['MESSAGE'];
		switch ($MESSAGE) {
			case 'engage':
				$query2 = "SELECT POKEMON.PID AS PID, NAME FROM POKEMONDATA JOIN POKEMON ON POKEMONDATA.PDATAID=POKEMON.PDATAID 
					WHERE PID=" .$SENDPOKID;
				$result2 = mysql_query($query2, $connectionstring) or die("No information");
				$row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
				$SENDPOKID = $row2['PID'];
				$SENDPOKNAME = $row2['NAME'];
				$query2 = "SELECT POKEMON.PID AS PID, NAME FROM POKEMONDATA JOIN POKEMON ON POKEMONDATA.PDATAID=POKEMON.PDATAID 
					WHERE PID=" .$RECEIVEPOKID;
				$result2 = mysql_query($query2, $connectionstring) or die("No information");
				$row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
				$RECEIVEPOKID = $row2['PID'];
				$RECEIVEPOKNAME = $row2['NAME'];
				print("<br />" .$USERNAME. "'s " .$SENDPOKNAME. " wants to get married with your " .$RECEIVEPOKNAME. "!!  ");
				print("<div class=\"btn_form\"><form>");
				print("<input type=\"button\" value=\"Agree\" onclick=\"javascript:void window.open
     						('confirmMarriage.php?confirm=Y&SENDPOK=".$SENDPOKID."&RECEIVEPOK=".$RECEIVEPOKID."',
     							'Confirm','width=450,height=200');return false;\">  ");
				print("<input type=\"button\" value=\"Not now\" onclick=\"javascript:void window.open
     						('confirmMarriage.php?confirm=N', 'Confirm','width=450,height=300');return false;\">  ");
				print("</form><hr /></div>");
				mysql_free_result($result2);
				break;

			case 'agree':
				print($SENDUSER. " has agreed with your engagement!<br />");
				break;

			case 'refuse':
				print($SENDUSER. " has refused your engagement!<br />");
				break;
			
			default:
				print('error');
				break;
		}
		
	}
	mysql_free_result($result);
	mysql_close($connectionstring);
?>
	</p>
</div>
</div>
</body>

</html>