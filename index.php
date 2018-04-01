<?php
	require('connect.php');
	require('DB-PHP/loadNews.php');
	session_start();
	
	if(!isset($_SESSION['validLogin']))
	{
		$_SESSION['validLogin'] = 0;
	}
	
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
		<div class="container">
			<h2>Welcome to the Hordes and War Pub!</h2>
			<p>We want to give access to the community of players to discuss strategies, gameplay, and all-around debates regarding Warmachine and/or Hordes. Also to be able to use this website to record their active army builds, challenge other users in exhibition matches, share their artistic views of the models they put together, and allow local companies or groups to post their event so users can participate in them.</p>
		</div>
		<div class="contianer">
			<h3>Announcements</h3>
			<iframe id="news" style="height:400px;" class="col-lg-8 p-0 m-0" src="listNews.php" scrolling="true"></iframe>
		</div>
		<br>
	</div>
</body>
</html>