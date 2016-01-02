<!DOCTYPE HTML>
<html>
	<head>
	<?php
		session_start();
		$UserID = $_SESSION['userid'];
		$connectionstring =mysql_connect("localhost","root");
		if ($connectionstring == 0) die("cannot connect to the db");
		$db = mysql_select_db("4432project", $connectionstring) or die("cannot open the selected db");
	?>
		<title>Pokemon Shop</title>
		<link href="./css/style.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="./js/jquery.min.js"></script>
<!-- start menu -->     
<link href="./css/megamenu.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="./js/megamenu.js"></script>
<script>$(document).ready(function(){$(".megamenu").megamenu();});</script>
<!-- end menu -->
</head>
<body onload="check();">
  <div class="header-top">
  <div class="wrap"> 
  	<?php
  		$query = "SELECT USERNAME FROM USER WHERE USERID=" . $UserID;
  		$result = mysql_query($query, $connectionstring) or die("No information");
  		$row = mysql_fetch_array($result, MYSQL_ASSOC);
  		print('<div align="center">Welcome ' .$row['USERNAME']. ' to our Pokemon Shop!<br /><br />');
  		print('Click on the Pokemon to view detail information.</div>');
  		$query = "SELECT PDataID, POKEMONDATA.Name AS PNAME, Type, GenderProb, FOOD.FoodID, FOOD.NAME AS FNAME, POKEMONDATA.Price AS PPRICE 
				FROM POKEMONDATA JOIN FOOD ON POKEMONDATA.FOODID=FOOD.FOODID WHERE MINLEVEL=0";
		$result = mysql_query($query, $connectionstring) or die("No information");

  	?>
	    <div class="cssmenu">
		   <ul>
			 <li value="message" id="message"><a onclick="javascript:void window.open('message.php',
								'Message','width=400,height=400,scrollbars=1,resizable=1');return false;">My Message</a></li> 
			 <li><a href="login.php">Log Out</a></li> 
		   </ul>
		</div>
		<div class="clear"></div>
 	</div>
   </div>
   <div class="header-bottom">
   		<div class="wrap">
   		<!-- start header menu -->
		<ul class="megamenu skyblue">
		    <li><a class="color1" href="home.php">HOME</a>
		    	<div class="megapanel">
		    		<div class="row">
		    			<div class="col1">
		    				<div class="h_nav">
		    					<h4>In my account</h4>
		    					<ul>
		    						<li><a href="#">Food</a></li>
		    						<li><a href="#">Money</a></li>
		    					</ul>
		    					<h4>My Friend List</h4>
		    					<ul>
		    						<li><a href="#">View My Friend List</a></li>
		    					</ul>
		    				</div>
		    			</div>
		    		</div>
		    	</div>
		    </li>
			<li class="grid"><a class="color2" href="pokemonShop.php">POKEMON SHOP</a></li>
  			<li class="active grid"><a class="color3" href="foodShop.php">FOOD SHOP</a></li>
		</ul>
		<div class="clear"></div>
    	</div>
   </div>
       <div class="index-banner">
             <div class="main">
                <div class="wrap">
				  <div class="content-bottom">
				  <?php
				  	$num_rows = mysql_num_rows($result);
				  	for($i = 0; $i < $num_rows/3; $i++) {
				  		$j = 0;
				  		print("<div class=\"box1\">");
						while(($j < 3) && (($i*3+$j) < $num_rows)) {
							$row = mysql_fetch_array($result, MYSQL_ASSOC);
							print("<div class=\"col_1_of_3 span_1_of_3\">");
							$PDATAID = $row['PDataID'];
							print("<a onclick=\"javascript:void window.open('pokemon.php?PDATAID=$PDATAID',
								'Pokemon Data','width=400,height=600,scrollbars=1,resizable=1');return false;\">");
				     		print("<div class=\"view view-fifth\">");
				  	  		print("<div class=\"top_box\">");
				  	  		$name = $row['PNAME'];
					  		print("<h3 class=\"m_1\">" . $name . "</h3>");
				        	print("<div class=\"grid_img\">");
							print("<div class=\"css3\"><img src=\"./Image/Pokemon/" . $name . ".png\" alt=\"\"/></div>");
	                    	print("</div><div class=\"price\">");
	                    	print("Type: " . $row['Type'] . "<br />");
	                    	print("Male Probability: " . $row['GenderProb'] . "<br />");
	                    	print("Required food: " . $row['FNAME'] . "<br />");
	                    	print("Price: " . $row['PPRICE'] . "<br />");
	                    	print("</div></div></div>");
			    	    	print("<div class=\"clear\"></div></a></div>");
			    	    	$j++;
						}
						print("<div class=\"clear\"></div></div>");
					}
				  ?>
			  	</div>
			 	</div>
        	</div>
        </div>
        <div class="footer">
       	 <div class="copy">
       	   <div class="wrap">
       	   	  <p>Designed by Yisha and Kiki</p>
       	   </div>
       	 </div>
       </div>
        <?php
        	mysql_free_result($result);
			mysql_close($connectionstring);
        ?>
</body>
</html>