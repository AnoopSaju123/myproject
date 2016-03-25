<?php
session_start();
if(!(isset($_SESSION["name"])))
	{
		header("Location:login_student.php");
	}

?>

<html>
<head>
	<title>Welcome</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="jquery/jquery-1.12.2.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

	
</head>
<body>
<div class="container">
	<br><br>
	<?php
		echo "Welcome ".$_SESSION["name"];
	?>
	<br>

	<div class="dropdown">
		<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span>
    	<span class="caret"></span></button>
   		 <ul class="dropdown-menu">
     		 <li><a href="student_logout.php">Logout</a></li>
     		 <li><a href="user_credentials.php" target="_blank">My account</a></li>
		</ul>
 	 </div>
 	<br>
	
</div>
</body>
</html>
