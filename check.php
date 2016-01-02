<?php
	session_start();
	$UserID = $_SESSION['userid'];
	$connectionstring =mysql_connect("localhost","root");
	if ($connectionstring == 0) die("cannot connect to the db");
	$db = mysql_select_db("4432project", $connectionstring) or die("cannot open the selected db");
	$query = "SELECT COUNT(*) AS NUM FROM MESSAGE WHERE RECEIVEUSER=" . $UserID;
	$result = mysql_query($query, $connectionstring) or die("No information");
	$row = mysql_fetch_array($result, MYSQL_ASSOC);

	// Inform the user of new message
	if(intval($row['NUM']) == 0) {
		echo '<li value="message" id="message" ><a onclick="javascript:void window.open(\'message.php\',
								\'Message\',\'width=400,height=400,scrollbars=1,resizable=1\');return false;">My Message</a></li>';
	} else {
		echo '<li value="message" id="message"><a onclick="javascript:void window.open(\'message.php\',
								\'Message\',\'width=400,height=400,scrollbars=1,resizable=1\');return false;">New Message</a></li>';
	}

	// Update the time and pokemon age
	date_default_timezone_set("Asia/Hong_Kong"); 
	$newTime = time();
	$oldTime = $_SESSION['oldTime'];
	if(($newTime - $oldTime) >= 60*30) {
		$i = 0;
		// Increase the age and hungry level when hungry level is less than 100
		for($i=0; $i<(($newTime - $oldTime)/(60*30)); $i++) {
			$query = "SELECT PID, HUNGRYLEVEL FROM POKEMON WHERE USERID=" .$UserID. "
				GROUP BY PID, HUNGRYLEVEL HAVING HUNGRYLEVEL<=95";
			$result = mysql_query($query, $connectionstring) or die("No information");
			while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$PID = $row['PID'];
				$query = "UPDATE POKEMON SET AGE=AGE+1, HUNGRYLEVEL=HUNGRYLEVEL+5 WHERE USERID=".$UserID. " AND PID=" .$PID;
				mysql_query($query, $connectionstring) or die("No information");
			}
		}
		$oldTime += 60*30*$i;
		$_SESSION['oldTime'] = $oldTime;
	}

	// Upgrade the pokemon if it reaches the certain age
	$query = "SELECT PID, AGE FROM POKEMON WHERE USERID=".$UserID;
	$result = mysql_query($query, $connectionstring) or die("No information");
	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$PID = $row['PID'];
		$Age = intval($row['AGE']);
		$query = "SELECT PDATAID, NAME, MINLEVEL FROM POKEMONDATA WHERE CATEGORY=(SELECT CATEGORY
							FROM POKEMON JOIN POKEMONDATA ON POKEMON.PDATAID=POKEMONDATA.PDATAID
							WHERE PID=" .$PID. ") AND PDATAID=(SELECT PDATAID+1 FROM POKEMON WHERE PID=" .$PID. ")";
		$result2 = mysql_query($query, $connectionstring) or die("No information");
		$minLevel = 0;
		while($row2 = mysql_fetch_array($result2, MYSQL_ASSOC)) {
			$minLevel = intval($row2['MINLEVEL']);
		}
		if(($Age >= $minLevel) && ($minLevel != 0)){
			$query = "UPDATE POKEMON SET PDATAID=PDATAID+1 WHERE PID=" .$PID;
			mysql_query($query, $connectionstring) or die("No information");
		}
	}	//end while
	mysql_free_result($result);
	if(isset($result2))
		mysql_free_result($result2);
	mysql_close($connectionstring);
?>