<?php
require_once __DIR__ . '/db_config.php';
$conn = new mysqli(SERVER_NAME,USER_NAME,PASSWORD,DB_NAME);
session_start();
if(!(isset($_SESSION["name"])))
	{
		header("Location:login_student.php");
	}

$check =0;
if($_SERVER["REQUEST_METHOD"]=="POST")
{
	$check=1;
	$file=$_FILES["upload"]["name"];
	$folder='uploads/';
	$err=$_FILES["upload"]["error"];
	$target=$folder.$file;
	
	$temp=$_FILES["upload"]["tmp_name"];
	
	move_uploaded_file($temp, $target);
	$email=$_SESSION["email"];

	$res=$conn->query("UPDATE student  SET  uploads='$target' where email='$email'");



}
?>	
<html>
<head>
	<title>Welcome</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="jquery/jquery-1.12.2.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#upload").change(function(){
					$("#myform").submit();
			});
			$("#browse").click(function(){
			$("#upload").click();
			});

		})
		
	</script>

	
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

 	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" id="myform" enctype="multipart/form-data">
 		<input type="file" name="upload" id="upload" style="display:none">
 		<button class="btn btn-primary" type="button" id="browse">Upload</button>
 	</form>
 	<a href="showuploads.php" class="btn btn-primary">Show uploads</a>
	
</div>
</body>
</html>
