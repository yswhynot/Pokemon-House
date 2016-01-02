<html>

<head> <title> Login </title> 

<script text="css/javascript">

    var xmlHttp;

    function check(str)  {

	try{
		xmlHttp = new XMLHttpRequest();
	} catch (e){
		try{
			xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				alert("Error!");
				return ;
			}
		}
	}

	var url = "home.php?username=" + str;

	xmlHttp.onreadystatechange=function()  {
	   if (xmlHttp.readyState == 4 && xmlHttp.status == 200)  {
		document.getElementById("disInfo").innerHTML = xmlHttp.responseText;
	   }
	}
	xmlHttp.open("GET", url, true);
	xmlHttp.send(null);

      }

</script>
</head>

<body>

	<h1> Welcome back to Pokemon world!</h1>

   <form id="myForm" method="post" onsubmit="check(this.username.value)">
   	<h2>
      <label> Username </label> <input type="text" name="username" /> <br />

      <label> Password </label> <input type="text" name="password" /> <br/> <br />

      <input type="submit" value="Login" name="Login" />
  	</h2>
  	<p name="disInfo"> </p>
   </form>

</body>
</html>