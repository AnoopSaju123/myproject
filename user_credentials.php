<?php
require_once __DIR__ . '/db_config.php';
$conn = new mysqli(SERVER_NAME,USER_NAME,PASSWORD,DB_NAME);
session_start();
if(!(isset($_SESSION["name"])))
	{
		header("Location:login_student.php");
	}
$error="";
if($_SESSION["selection"]=="student")
	$check="student";
else
	$check="Teacher";

if($_SERVER["REQUEST_METHOD"]=="POST")
{
	if($_SESSION["selection"]=="student")
	{
		$email=$_SESSION["email"];
		$pwd=$_POST["opswrd"];
		$npswd=$_POST["npswrd"];

		if(!empty($_POST["opswrd"]))
		{
			$result=$conn->query("SELECT * FROM student WHERE email='$email' and passwrd='$pwd'");
			if($result->num_rows>0)
			{
				$res=$conn->query("UPDATE student SET passwrd='$npswd' WHERE email='$email'");
			}
			else
				$error="Incorrect password";
		}


		if(!empty($_POST["email"]))
		{
		
			$nemail=$_POST["email"];

			$result=$conn->query("UPDATE student set email='$nemail' WHERE email='$email'");
			$_SESSION["email"]=$nemail;
			$email=$nemail;
		}
		if(!empty($_POST["groupid"]))
		{

			$groupid=$_POST["groupid"];
			

			$result=$conn->query("UPDATE student set groupid= '$groupid' WHERE email='$email'");
		}
		



		
		
	}
	else
	{
		
		$email=$_SESSION["email"];
		$pwd=$_POST["opswrd"];
		$npswd=$_POST["npswrd"];
		
		if(!empty($_POST["opswrd"]))
		{
			$result=$conn->query("SELECT * FROM Teacher WHERE email='$email' and passwrd='$pwd'");
			if($result->num_rows>0)
			{
				$res=$conn->query("UPDATE Teacher SET passwrd='$npswd' WHERE email='$email'");
			}
			else
				$error="Incorrect password";
		}
		if(!empty($_POST["email"]))
		{
			$nemail=$_POST["email"];

			$result=$conn->query("UPDATE Teacher set email='$nemail' WHERE email='$email'");
			$_SESSION["email"]=$nemail;
			$email=$nemail;
		}




	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Settings</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="jquery/jquery-1.12.2.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script>
	$(document).ready(function(){
		var x = "<?php echo $error ?>";
		var check="<?php echo $check ?>";
		if(x=="")
			$("#demo").hide();
		else
			$("#demo").text(x);
		if(check=="Teacher")
			$("#group").hide();

	});

	function validateForm()
	{
		var x = document.forms["myForm"]["opswrd"].value;
		var y = document.forms["myForm"]["npswrd"].value;
		var z = document.forms["myForm"]["cpswrd"].value;
		if((x=="")&&(y!=""))
		{	
			$("#demo").text("Enter your old password");	
			$("#demo").show();
			return false;
		}
		else if ((y=="")&&(x!=""))
		{

			$("#demo").text("Enter your new password");	
			$("#demo").show();
			return false;

		}
		else if(y!=z)
		{
			$("#demo").text("Passwords and confirm passwords don't match");	
			$("#demo").show();
			return false;
		}
		
	}

	</script>

</head>
<body>
<br><br>
<div class="container">
	<form name="myForm" onsubmit="return validateForm()" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])  ?>"  role="form">

		<div class="form-group">
		<label>Enter your old password</label>
		<input type="password" name="opswrd"  class="form-control ">
		</div>
		<div class="form-group">
		<label>Enter your new password</label>
		<input type="password" name="npswrd" class="form-control ">
		</div>
		<div class="form-group">
		<label>Confirm password</label>
		<input type="password" name="cpswrd" class="form-control " >
		</div>
		<div class="form-group">
		<label>Change email address</label>
		<input type="text" name="email" class="form-control ">
		</div>
		<div class="form-group" id="group" >
		<label>Chenge group id</label>
		<input type="text" name="groupid" class="form-control " >
		</div>
		<div class="form-group">
		<button type="submit" class="btn btn-primary" >Submit</button>
		</div>	
		<div class="alert alert-danger" id="demo" style="margin-top: 20px"></div>
		
	</form>
</div>

</body>
</html>