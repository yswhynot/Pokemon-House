<!DOCTYPE html>
<html>
<head>
<?php
	include 'activityClass.php';
	$PID = $_GET['PID'];
	$choice = $_GET['choice'];
	$thisPok = new Pokemon($PID);
	date_default_timezone_set("Asia/Hong_Kong"); 
?>
	<link href="./css/style.css" rel="stylesheet" type="text/css" />
	<link href="./css/form.css" rel="stylesheet" type="text/css" />
	<title>Confirmation</title>
	<?php print('<meta http-equiv="refresh" content="60;URL="confirm.php?PID='.$PID. '&choice=' .$choice.'">'); ?>
</head>
<body>
<div class="wrap">
<div class="toggle">
	<p class="m_text" align="middle">
<?php
	switch ($choice) {
		case 'feed':
			$amount = $_POST['range'];
			if($amount <= $thisPok->getFoodNum()) {
				$thisPok->setFood($amount);
			}
			print("<br />You have successfully fed the pokemon XD<br /><br />");
			print("<div class=\"btn_form\" align=\"middle\"><form>");
			print("<input type=\"button\" align=\"middle\" value=\"Yeah!!\" onclick=\"window.open('', '_self', ''); window.close();\" />");
			print("</form></div>");
			break;
		case 'marry':
			$MarriageID = $_POST['marry'];
			$thisPok->marry($MarriageID);
			print("<br />You have successfully send out the engagement XD<br /><br />");
			print("<div class=\"btn_form\" align=\"middle\"><form>");
			print("<input type=\"button\" align=\"middle\" value=\"Yeah!!\" onclick=\"window.open('', '_self', ''); window.close();\" />");
			print("</form></div>");
			break;
		case 'work':
			if(!isset($_SESSION['WorkStart'])) {
					$WorkID = $_POST['work'];
					$thisPok->setWork($WorkID);
					$timeSpentWork = 0;
			} else {
				$timeSpentWork = time() - $_SESSION['WorkStart'];
			}
			print("<br />You have successfully send the pokemon to work XD<br />");
			print("Do not close the window while your pokemon is working. <br /> Working progress:");
			if(isset($_SESSION['minTime'])){
				if($timeSpentWork >= $_SESSION['minTime']) 
					$thisPok->stopWork();
				print('<progress align="middle" value="' .($timeSpentWork/$_SESSION['minTime']). '" max="' .$_SESSION['minTime']. '"></progress>');
			} else {
				print('<progress align="middle" value="0" max="1"></progress>');
			}
			break;
		default:
			print("Error");
			break;
	}
?>
	</p>
</div>
</div>
</body>
</html>