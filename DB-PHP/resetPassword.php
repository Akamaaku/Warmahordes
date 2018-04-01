<?php
	require('../connect.php');
	session_start();
	
	if(isset($_GET['id']))
	{
		if(is_numeric($_GET['id']))
		{
			$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
			$_SESSION['resetID'] = $id;
		}
	}

	if(isset($_POST['cancel']))
	{
		header("Location: ../editUser.php");
	}

	$valid = true;

	if(isset($_POST['password']))
	{
		if(isset($_POST['pswrd']) && isset($_POST['cnfrm']))
		{
			if($_POST['pswrd'] == $_POST['cnfrm'])
			{
				$resetid = $_SESSION['resetID'];
				$password = password_hash($_POST['pswrd'], PASSWORD_DEFAULT);
				$pQuery = "UPDATE users SET pswrd = :pswrd WHERE userid = :resetid";
				$pStatement = $db->prepare($pQuery);
				$pStatement->bindValue(':pswrd', $password);
				$pStatement->bindValue(':resetid',$resetid);
				
				if($pStatement->execute())
				{
					header("Location: ../editUser.php");
				}
				else
				{
					$valid = false;
				}
			}
			else
			{
				$valid = false;
			}
		}
		
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Reset Password</title>
	<?php include('../styles.php');?>
	<link rel="stylesheet" type="text/css" href="../../styles/bootstrap.css">
</head>
<body class="bg-dark">
	<div class="container bg-success text-dark">
		<?php include('../header.php');?>
		<br>
	<?php if ($_SESSION['accessLevel'] == 1): ?>
	<form class="form bg-dark text-success text-center pb-2" method="post" action="resetPassword.php" onsubmit="confirm('Are you sure you wnat to proceed?')";>
	<div class="form-group">
		<label class="col-lg-4 pl-2 pr-2" for="pswrd">Enter New Password:</label>
		<input class="col-lg-4" type="password" name="pswrd" id="pswrd" >
		<label class="col-lg-4 pl-2 pr-2" for="cnfrm">Confirm Password:</label>
		<input class="col-lg-4" type="password" name="cnfrm" id="cnfrm" >
		<?php if (!$valid): ?>
			<p id="matchError" class="text-danger">Passwords did not match.</p>
		<?php endif ?>
	</div>
	<button class="btn btn-success text-dark" type="submit" name="password">Reset Password</button>	
	<button class="btn btn-success text-dark" type="submit" name="cancel">Cancel</button>
	</form>
	<?php else: ?>
		<h2>You do not have permission to view this page.</h2>
	<?php endif ?>
	<br>
	</div>
</body>
</html>

