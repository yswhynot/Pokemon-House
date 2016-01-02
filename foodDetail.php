<html>
<head>
	<?php
		$FoodID = $_GET['FoodID'];
		session_start();
		$UserID = $_SESSION['userid'];
	?>
	<link href="./css/style.css" rel="stylesheet" type="text/css" />
	<link href="./css/form.css" rel="stylesheet" type="text/css" />
	<title>Food Data</title>
	<script type="text/javascript">
		function showValue(newValue) {
			document.getElementById("showRange").innerHTML = newValue;
		}
	</script>
</head>
<body>
	<?php
		$connectionstring =mysql_connect("localhost","root");
		if ($connectionstring == 0) die("cannot connect to the db");
		$db = mysql_select_db("4432project", $connectionstring) or die("cannot open the selected db");
		$query = "SELECT FoodID, Name, Price, HungryPlus FROM FOOD WHERE FOODID=" .$FoodID;
		$result = mysql_query($query, $connectionstring) or die("No information");
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$name = $row['Name'];
		$fPrice = $row['Price'];
		print("<div class=\"header-top\"><div class=\"wrap\">");
		print("<div class=\"sky-form\"><h4>" . $name . "</h4></div>");
		print("<div class=\"css3\"><img src=\"./Image/Food/" . $name . ".png\" alt=\"\"/></div>");
		print("<div class=\"toogle\">");
     	print("<h3 class=\"m_3\">Food Information</h3>");
     	print("<p class=\"m_text\">Price: " .$fPrice. "<br />");
     	print("Hungry level decrease: " . $row['HungryPlus'] . "<br />");
     	print("</p>");
     	$query = "SELECT MONEY FROM USER WHERE USERID=" .$UserID;
		$result = mysql_query($query, $connectionstring) or die("No information");
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$foodNum = $row['MONEY']/$fPrice;
     	print('<div class="btn_form" align="center"><form method="POST" action="foodPayment.php?FoodID=' .$FoodID. '" ><p class="m_text">');
		print(" Choose how many you want to buy:<br />");
		print('<input type="range" name="range" id="range" min="0" max="'.$foodNum.'" value="0" step="1" 
					onchange="showValue(this.value)" />');
		print('<span name="showRange" id="showRange">0</span><br />');
		print("<input type=\"submit\" value=\"Confirm\" />");
     	print("</div><br />");
		print("</div></div><div class=\"clear\"></div>");
		mysql_free_result($result);
		mysql_close($connectionstring);
	?>
</body>
</html>