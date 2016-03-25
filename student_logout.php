<?php
session_start();
setcookie("email",null,-1);
setcookie("pass",null,-1);
setcookie("selection",null,-1);
session_destroy();
header("Location:login_student.php");
?>