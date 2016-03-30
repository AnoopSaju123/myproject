<html>
<body>

<?php
$files=$_FILES["upload"]["name"];
$type=$_FILES["upload"]["type"];
$size=$_FILES["upload"]["size"];
$temp=$_FILES["upload"]["tmp_name"];
$err=$_FILES["upload"]["error"];
$ext =pathinfo($files,PATHINFO_EXTENSION);
$targetdir="uploads/";

$targetloc="";

echo "Error",$err;

if (file_exists($targetdir.$files))
	echo "File already present";
else
{

	
	$targloc=$targetdir.basename($files);


	move_uploaded_file($temp, $targloc);
}
echo $ext;
echo $targetloc;
?>



</body>
</html>