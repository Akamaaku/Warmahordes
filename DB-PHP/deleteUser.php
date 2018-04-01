<?php
	require("../connect.php");
	session_start();

	if(isset($_GET['id']))
	{
		if(is_numeric($_GET['id']))
		{
			$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

			if($_SESSION['accessLevel'] == 1)
			{
				$deleteQuery = "DELETE FROM users WHERE userid = :id LIMIT 1";
				$deleteStatement = $db->prepare($deleteQuery);
				$deleteStatement->bindValue(':id',$id,PDO::PARAM_INT);
				$deleteStatement->execute();

				if($deleteStatement->execute())
				{
					header('Location: ../editUser.php');
				}
			}			
		}
	}
	
?>