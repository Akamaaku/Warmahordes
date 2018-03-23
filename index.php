<?php
	require('connect.php');
	session_start();
	$_SESSION['validLogin'] = 0;
	
	if(!isset($_SESSION['accessLevel']))
	{
		$_SESSION['accessLevel'] = 5;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>WarmaHordes</title>
	<?php include('styles.php');?>
</head>
<body class="bg-dark">
	<div class="container bg-success">
		<?php include('header.php');?>
		<?php include('nav.php');?>
		<?=$_SESSION['validLogin']?>
		<?=$_SESSION['accessLevel']?>
		<br>
	</div>
</body>
</html>