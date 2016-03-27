<?php
require_once __DIR__ . '/db_config.php';
$conn = new mysqli(SERVER_NAME,USER_NAME,PASSWORD,DB_NAME);
session_start();
if(isset($_SESSION["selection"]))
	if($_SESSION["selection"]=="student")
		header("Location:student_display.php");
	else if($_SESSION["selection"]=="teacher")
		header("Location:teacher_display.php");		


if($conn->connect_error)
{
	die("Connection failed :".$conn->connect_error);
}

if((isset($_COOKIE["email"])) and (isset($_COOKIE["pass"])))
{
	
	$email=$_COOKIE["email"];
	$pass=$_COOKIE["pass"];

	if($_COOKIE["selection"]=="student")
	{
		$res=$conn->query("SELECT *FROM student WHERE email='$email' ");

		if ($res->num_rows >0) 
		{
			

			$res = $res->fetch_assoc();
			$result=$res["passwrd"];
			
			if(md5($result)==$pass)
			{
				session_start();
				$_SESSION["name"]=$res["name"];
				$_SESSION["email"]=$res["email"];
				$_SESSION["class"]=$res["class"];
				$_SESSION["selection"]="student";

				header("Location:student_display.php");
			}
		}
	}
	else
	{
		$res=$conn->query("SELECT *FROM Teacher WHERE email='$email' ");

		if ($res->num_rows >0) 
		{
			

			$res = $res->fetch_assoc();
			$result=$res["passwrd"];
			
			if(md5($result)==$pass)
			{
				session_start();
				$_SESSION["name"]=$res["name"];
				$_SESSION["email"]=$res["email"];
				$_SESSION["position"]=$res["position"];
				$_SESSION["selection"]="teacher";

				header("Location:teacher_display.php");
			}
		}

	}
}
$error="";
$email="";
if($_SERVER["REQUEST_METHOD"]=="POST")
{
	if(!((empty($_POST["email"])) or (empty($_POST["passwrd"]))))
	{
		
		if($_POST["selection"]=="student")
		{
			$email=$_POST["email"];
			$passwrd=$_POST["passwrd"];
			$result = $conn->query("SELECT *FROM student WHERE email='$email' AND passwrd='$passwrd'");
			
			if($result->num_rows ==1)
			{

				if(isset($_POST["rememberme"]))
				{

					setcookie("email",$email,time()+60*60*24);
					setcookie("pass",md5($passwrd),time()+60*60*24);
					setcookie("selection","student",time()+60*60*24);
				}

				$result = $result->fetch_assoc();
				$name = $result["name"];
				$class = $result["class"];
				
				$groupid = $result["groupid"];
				session_start();
				$_SESSION["name"]=$name;
				$_SESSION["email"]=$email;
				$_SESSION["class"]=$class;
				$_SESSION["selection"]="student";
				header("Location:student_display.php");
				
				
			}
			else
			{
				$result=$conn->query("SELECT *FROM student WHERE email='$email'");
				if($result->num_rows==1)
				{
						$error="Wrong password";
				}
				else
				{
					$error="User does not exist";
					$email="";
				}
						
					
			}
		}
		else
		{
			$email=$_POST["email"];
			$passwrd=$_POST["passwrd"];
			$result = $conn->query("SELECT *FROM Teacher WHERE email='$email' AND passwrd='$passwrd'");
			
			if($result->num_rows ==1)
			{

				if(isset($_POST["rememberme"]))
				{

					setcookie("email",$email,time()+60*60*24);
					setcookie("pass",md5($passwrd),time()+60*60*24);
					setcookie("selection","teacher",time()+60*60*24);
				}

				$result = $result->fetch_assoc();
				$name = $result["name"];
				$position = $result["position"];
				
				
				session_start();
				$_SESSION["name"]=$name;
				$_SESSION["email"]=$email;
				$_SESSION["position"]=$position;
				$_SESSION["selection"]="teacher";
				header("Location:teacher_display.php");
				
				
			}
			else
			{
				$result=$conn->query("SELECT *FROM Teacher WHERE email='$email'");
				if($result->num_rows==1)
				{
						$error="Wrong password";
				}
				else
				{
					$error="User does not exist";
					$email="";
				}
						
					
			}
		}
	}
	else
	{
		$error="A field is missing";
	}
}
$conn->close();
?>
<html>
<head>
	<title>Project Manager</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	 <link rel="stylesheet" href="css/bootstrap.min.css">
<script src="jquery/jquery-1.12.2.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script >
  	$(document).ready(function(){
  		var x= "<?php echo $error ?>";
  		if(x=="")
  			$("#demo").hide();
  		else
  			$("#demo").text(x);

	});

  </script>
</head>
<body>
	<div class="container">
		<br><br>
		<h3><center><i>Login Page</i></center></h3>
		<form action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"  method="post" role="form">
		<div class="form-group">
			<label for="email" >Email</label>
			
				<input type="text" class="form-control " name="email" id="email" value="<?php echo $email ?>"  placeholder="Enter email" required>
		</div>
			
		<div class="form-group">
			<label for="email" >Password</label>
			
				<input type="password" class="form-control " name="passwrd" id="passwrd"  placeholder="Enter password"  required>
		</div>
		
		<div class="checkbox">
			
			<label><input type ="checkbox" name="rememberme">Remember me</label>
		</div>
		<label for="student">Student</label>
		<input type="radio" name="selection"  id="student"value="student" required>
		<label for="teacher">  Teacher</label>
	 	<input type="radio" name="selection" id="teacher" value="teacher" required><br>
		<button type="submit" class="btn btn-primary">Submit</button>
		</form>
		
			<div class="alert alert-danger" id="demo" style="margin-top: 20px"></div>
	
	<a href="register_student.php">Registration Page Student</a><br>
	<a href="register_teacher.php">Registration Page Teacher</a>
	</div>

</body>
</html>