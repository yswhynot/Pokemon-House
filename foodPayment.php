<html>
<head>
<?php
	$FoodID = $_GET['FoodID'];
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
	$amount = $_POST['range'];
	$query = "SELECT MAX(FOODSTATUSID) AS MAX FROM FOODSTATUS";
	$result = mysql_query($query, $connectionstring) or die("No information");
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$newFSID = intval($row['MAX']) +1;
	// get the price of this food
	$query = "SELECT Price FROM FOOD WHERE FOODID=" .$FoodID;
	$result = mysql_query($query, $connectionstring) or die("No information");
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$Price = $row['Price'];
	// update new foodstatus
	$query = "UPDATE FOODSTATUS SET NUMBER=NUMBER+" .$amount. " WHERE USERID=" .$UserID. " AND FOODID=" .$FoodID;
	mysql_query($query, $connectionstring) or die("No information");
	// update money of user
	$query = "UPDATE USER SET MONEY=MONEY-" .($amount*$Price). " WHERE USERID=" .$UserID;
	mysql_query($query, $connectionstring) or die("No information");
	print("<br />You have successfully buy the food XD<br /><br />");
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
