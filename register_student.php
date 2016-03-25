<?php
$error="";
if($_SERVER["REQUEST_METHOD"]=="POST")
{


	require_once  __DIR__.'/db_config.php';
	$conn = new mysqli(SERVER_NAME,USER_NAME,PASSWORD,DB_NAME);
	if (!(empty($_POST["name"]) or empty($_POST["email"]) or empty($_POST["passwrd"]) or empty($_POST["class"]) or empty($_POST["groupid"])))
	{
		$name = $_POST["name"];
		$email= $_POST["email"];
		$passwrd= $_POST["passwrd"];
		$class = $_POST["class"];
		
		$groupid= $_POST["groupid"];
		$result =$conn->query("SELECT * FROM student where email='$email'");
		if($result->num_rows>0)
			$error="User  already present";
		else
		{
			$result=$conn->query("INSERT INTO student(name,email,passwrd,class,groupid) VALUES('$name','$email','$passwrd','$class','$groupid')");
			if($result==TRUE)
			{
				session_start();
				$_SESSION["name"]=$name;
				$_SESSION["email"]=$email;
				$_SESSION["class"]=$class;
				$_SESSION["selection"]="teacher";
				header("Location:student_display.php");

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
	Class<input type="text" name="class" required><br>
	
	Group name<input type="text" name="groupid" required><br>
	<input type="submit">
	<?php  
	echo $error;
		?>
	</form>
</body>
</html>