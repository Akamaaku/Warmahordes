<?php

	$validLogin = false;
	$message = "Username and/or Password incorrect.\\nTry again.";

	if(isset($_POST['register']))
	{
		header("Location: register.php");
	}

	if(isset($_POST['login']))
	{
		if(isset($_POST['email']) && isset($_POST['password']))
		{
			$valid = true;
			$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
			//Check email query
			$emailQuery = "SELECT email FROM users WHERE email = :email";
			$emailStatement = $db->prepare($emailQuery);
			$emailStatement->bindValue(':email', $email);
			$emailStatement->execute();

			if($emailStatement->rowCount() < 1)
			{
				$valid = false;
			}
			
			if($emailStatement->rowCount() == 1)
			{
				$password = $_POST['password'];

				//Check password query
				$verifyQuery = "SELECT userid, accesslevel, pswrd, nickname FROM users WHERE email = :email LIMIT 1";
				$verifyStatement = $db->prepare($verifyQuery);
				$verifyStatement->bindValue(':email', $email);
				$verifyStatement->execute();
				$result = $verifyStatement->fetch();
				$passwordHash = $result['pswrd'];

				if(password_verify($password, $passwordHash))
				{
					$_SESSION['userid'] = $result['userid'];
					$_SESSION['displayName'] = $result['nickname'];
					$_SESSION['accessLevel'] = $result['accesslevel'];
					$_SESSION['validLogin'] = 1;
					$validLogin = $valid;
					$message = "Login successful!";
				}
			}

  			
  			echo "<script type='text/javascript'>alert('$message'); </script>";
  			
  			if($validLogin)
  			{
  				echo "<script type='text/javascript'>location.reload(true);</script>";
  			}
  			

		}
	}
?>
<!-- <?php if ($_SESSION['validLogin'] != 1): ?> -->
	<form class="bg-dark text-right mb-0" method="post" action="index.php">
	<div class="form-group">
		<label class="bg-dark text-success pl-2 pr-2" for="email">Email: </label>
		<input class="bg-dark text-success" type="email" name="email" />
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
<!-- <?php else: ?>
	<h4>Welcome <?=$_SESSION['displayName']?></h4>
<?php endif?> -->



