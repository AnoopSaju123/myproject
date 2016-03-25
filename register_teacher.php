<?php
$error="";
if($_SERVER["REQUEST_METHOD"]=="POST")
{


	require_once  __DIR__.'/db_config.php';
	$conn = new mysqli(SERVER_NAME,USER_NAME,PASSWORD,DB_NAME);
	if (!(empty($_POST["name"]) or empty($_POST["email"]) or empty($_POST["passwrd"]) or empty($_POST["position"])))
	{
		$name = $_POST["name"];
		$email= $_POST["email"];
		$passwrd= $_POST["passwrd"];
		$position = $_POST["position"];
		
	
		$result =$conn->query("SELECT * FROM Teacher where email='$email'");
		if($result->num_rows>0)
			$error="User  already present";
		else
		{
			$result=$conn->query("INSERT INTO Teacher(name,email,passwrd,position) VALUES('$name','$email','$passwrd','$position')");
			if($result==TRUE)
			{
				session_start();
				$_SESSION["name"]=$name;
				$_SESSION["email"]=$email;
				$_SESSION["position"]=$position;
				$_SESSION["selection"]="teacher";
				header("Location:teacher_display.php");

			}
			else
			{
				echo "User not registered because of insertion error";

			}
		}
	}
	else
	{
		$error="One of the fields are misssing";

	}

}
?>


<html>
<body>
	<form action ="<?php echo $_SERVER["PHP_SELF"]?>" method="post">
	Name<input type="text" name="name" required><br> 
	Password<input type="text" name="passwrd" required><br>
	Email<input type="text" name="email" required><br>
	Designation<input type="text" name="position" required><br>
	
	<input type="submit">
	<?php  
	echo $error;
		?>
	</form>
</body>
</html>