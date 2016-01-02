<html>
	<head>
	<script type="text/javascript">
		function showValue(newValue) {
			document.getElementById("showRange").innerHTML = newValue;
		}
	</script>
	<?php
		include 'activityClass.php';
		$PID = $_GET['PID'];
		$choice = $_GET['choice'];
		$thisPok = new Pokemon($PID);
		print('<link href="./css/style.css" rel="stylesheet" type="text/css" />');
		print('<link href="./css/form.css" rel="stylesheet" type="text/css" />');
		switch ($choice) {
			case 'feed':
				print("<title>Feed Pokemon</title>");
				break;
			case 'marry':
				print("<title>Get Married</title>");
				break;
			case 'work':
				print("<title>Choose to Work</title>");
				break;
			default:
				print("Error");
				break;
		}
	?>
	</head>
	<body>
	<div class="wrap">
	<div class="toogle">
		<?php
			$connectionstring = mysql_connect("localhost","root");
			if ($connectionstring == 0) die("cannot connect to the db");
			$db = mysql_select_db("4432project", $connectionstring) or die("cannot open the selected db");
			$foodName = $thisPok->getFoodName();
			$foodNum = $thisPok->getFoodNum();
			switch ($choice) {
				case 'feed':
					print('<div class=\"btn_form\" align="center"><form method="POST" action="confirm.php?PID='.$PID.'&choice=feed" ><p class="m_text">');
					print("You have $foodNum $foodName. Choose how many you want to feed:<br />");
					print('<input type="range" name="range" id="range" min="0" max="'.$foodNum.'" value="0" step="1" 
							onchange="showValue(this.value)" />');
					print('<span name="showRange" id="showRange">0</span><br />');
					print("<input type=\"submit\" value=\"Confirm\" />");
					break;
				case 'marry':
					$UserID = $_SESSION['userid'];
					print('<div class="btn_form" align="center"><form method="POST" action="confirm.php?PID='.$PID.'&choice=marry" ><p class="m_text">');
					print("Choose the one you want your pokemon to marry: <br />");
					print('<div><select id="mary" name="marry">');
					print('<option value="null">Select a marriage</option>');
					$query = "SELECT PID, NAME, GENDER, USERNAME
							FROM ((SELECT PID, NAME, GENDER, USERID
									FROM POKEMON JOIN POKEMONDATA ON POKEMON.PDATAID=POKEMONDATA.PDATAID
									WHERE PID IN (SELECT PID FROM POKEMON WHERE USERID IN 
										(SELECT UID2 FROM FRIENDLIST WHERE UID1=" .$UserID. ") 
									OR USERID IN (SELECT UID1 FROM FRIENDLIST WHERE UID2=" .$UserID. "))
									AND MARRIAGE=0) T) JOIN USER ON T.USERID=USER.USERID";
					$result = mysql_query($query, $connectionstring) or die("No information");
					while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
						print('<option value="' .$row['PID']. '">' .$row['USERNAME']. '\'s '
							.$row['NAME']. ', Gender: ' .$row['GENDER']. '</option>');
					}
					print('</select></div><br />');
					print("<input type=\"submit\" value=\"Confirm\" />");
					break;
				case 'work':
					unset($_SESSION['WorkStart']);
					print('<div class="btn_form" align="center"><form method="POST" action="confirm.php?PID='.$PID.'&choice=work" ><p class="m_text">');
					print("Choose the work you want your pokemon to do: <br />");
					print('<div><select id="work" name="work">');
					print('<option value="null">Select a job</option>');
					$query = "SELECT * FROM WORK WHERE WORKID<>1";
					$result = mysql_query($query, $connectionstring) or die("No information");
					while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
						print('<option value="' .$row['WorkID']. '">' .$row['WorkID']. ' ' .$row['Type']. ' Salary: '
							.$row['Salary']. ' Time needed: ' .$row['minTime']. '</option>');
					}
					print('</select></div>');
					print("<input type=\"submit\" value=\"Confirm\" />");
					break;
				default:
					print("Error");
					break;
			}
			print("</p></form></div>");
			if(isset($result))
				mysql_free_result($result);
			mysql_close($connectionstring);
		?>
		<!-- <h4 class="m_9" align="left">Choose what you want to do</h4> -->
	</div>
	</div>
	</body>
</html>