<?php
require_once __DIR__ . '/db_config.php';
$conn = new mysqli(SERVER_NAME,USER_NAME,PASSWORD,DB_NAME);
session_start();
if(!(isset($_SESSION["name"])))
	{
		header("Location:login_student.php");
	}
$email=$_SESSION["email"];

$result=$conn->query("SELECT * FROM student WHERE email='$email'");
if($result->num_rows==1)
{
	$res=$result->fetch_assoc();
	$uploads=$res["uploads"];

}

 ?>
 <<!DOCTYPE html>
 <html>
 <head>
 	<title>Uploads</title>
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="jquery/jquery-1.12.2.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script>

	</script>

 </head>
 <body>

 <img src= "<?php echo $uploads ;?>" class="img-rounded"  width="150" height="150" >
 </body>
 </html>

