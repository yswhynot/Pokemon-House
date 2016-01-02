<html>

<head> <title> Log in </title> 

<script text="css/javascript">

    var xmlHttp;

    function checksignup()  {

	try{
			xmlHttp = new XMLHttpRequest();
		} catch (e){
			try{
				xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try{
					xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
					catch (e) {
					alert("Error!");
					return ;
				}
			}
		}

		var url = "newuser.php";
		var username = document.getElementById("username").value;
		var password = document.getElementById("password").value;
		var vars = "username=" + username + "&password=" + password;
		xmlHttp.open("POST", url, true);
		xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlHttp.onreadystatechange=function()  {
			console.log(xmlHttp);
	   		if (xmlHttp.readyState == 4 && xmlHttp.status == 200)  {
				document.getElementById("disInfo").innerHTML = xmlHttp.responseText;
	   		}
		}
		xmlHttp.send(vars);
		document.getElementById("disInfo").innerHTML = "Processing...";

      }

       function checklogin()  {

		try{
			xmlHttp = new XMLHttpRequest();
		} catch (e){
			try{
				xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try{
					xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
					catch (e) {
					alert("Error!");
					return ;
				}
			}
		}

		var url = "verifyLogin.php";
		var username = document.getElementById("username").value;
		var password = document.getElementById("password").value;
		var vars = "username=" + username + "&password=" + password;
		xmlHttp.open("POST", url, true);
		xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlHttp.onreadystatechange=function()  {
			console.log(xmlHttp);
	   		if (xmlHttp.readyState == 4 && xmlHttp.status == 200)  {
				document.getElementById("disInfo").innerHTML = xmlHttp.responseText;
	   		}
		}
		xmlHttp.send(vars);
		document.getElementById("disInfo").innerHTML = "Processing...";
	}

</script>
</head>

<body>

	<h1> Welcome back to Pokemon world!</h1>

   <form id="myForm" method="post"> <fieldset>
   	<h2>
      
	<lable for="username">Username: </lable><input id="username" name="username" type="text" /><br/>
	<lable for="password">Password: </lable><input id="password" name="password" type ="password" /><br />

      <input type="button" value="Log in" name="Login" onclick="checklogin();" />
      <input type="button" value="Sign up" name="Sign up" onclick="checksignup();" />
  	</h2>
  	<div id="disInfo"> </div>
		<h2> Rules: </h2>
		<p> Our Pokemon has several features: 
			<ul> <li> life level (1-10) </li></ul>
			<ul> <li> gender </li></ul>
			<ul> <li> age </li></ul>
			<ul> <li> hungry level (0-100)</li></ul>
		</p>
		<p>  At the very begining the followings come with a level-1Pokemon 
			<ul><li> $50 money </li></ul> 
			<ul><li> 10 units of food </li></ul> 
		</p>
		<p> <ul> <li> Feed you Pokemon for them to grow! </li></ul>
			<ul> <li> one unit of food reduce hungry level by 10</li></ul>
			<ul> <li> No more feeding if his/her hungry level reaches 0.</li></ul>
			<ul> <li> Age depends on the cumulative time duration of sessions you've been logged in.</li></ul>
			<ul> <li> Your Pokemon evolves to a higher life level at certain ages! </li></ul>
			<ul> <li> Send your Pokemon to work for money! Salary depends on his/her 
			<ul> <li>  working time </li></ul> 
			<ul> <li> level </li></ul> 
			</li></ul>
		</p>
   </fieldset></form>

</body>
</html>