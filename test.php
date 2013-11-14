<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
hello world<br />
<?php 
	$dw = date( "w", $timestamp);
	echo $dw;
?>
</body>
</html>
<!-- 
CREATE TABLE recipes_new LIKE production.recipes;
INSERT recipes_new SELECT * FROM production.recipes; -->
