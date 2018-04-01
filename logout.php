<?php 
	if(isset($_POST['logout']))
	{
		$_SESSION['validLogin'] = 0;
		$_SESSION['displayName'] ="";
		$_SESSION['accessLevel'] = 5;
		header("Location: index.php");
	}
?>
<form class="bg-dark text-right form-inline" method="post" action="index.php">
	<div class="form-group pl-2">
		<button class="btn btn-success text-dark" type="submit" name="logout">Sign Out</button>
	</div>
</form>