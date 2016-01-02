<html>
	<header>
		<title>Index</title>
	</header>
	<body>
		<p>Redirecting...</p>
		<?php
			if(isset($_COOKIE['count'])) {
				setcookie("count", "notFirst", time()+60, '/');
				print("<p>Not first visit</p>");
				header("Location: http://localhost/new/login.php");
			} else {
				setcookie("count", "first", time()+60);
				print("<p>First visit</p>");
				header("Location: http://localhost/new/firstvisithome.php");
			}
		?>
	</body>
</html>
