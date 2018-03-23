<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<?php include('styles.php');?>
</head>
<body class="bg-dark">
	<div class="container bg-success text-dark text-center">
		<?php include('header.php');?>
		<?php include('nav.php');?>
		<form class="bg-dark text-center form" method="post" action="#">
		<div class="form-group">
			<label class="bg-dark text-success pl-2 pr-2" for="email">Email: </label>
			<input class="bg-dark text-success" type="text" name="email" />
		</div>
		<div class="form-group">
			<label class="bg-dark text-success pl-2 pr-2" for="password">Password: </label>
			<input class="bg-dark text-success" type="password" name="password"/>
		</div>
		<div class="form-group pl-2">
			<button class="btn btn-success text-dark" type="submit" name="login">Login</button>
		</div>
		<div class="form-group">
			<button class="btn btn-dark text-success" type="submit" name="forgot">Forgot Password?</button>
			<button class="btn btn-dark text-success" type="submit" name="register">Register</button>
		</div>
		</form>
	</div>
</body>
</html>