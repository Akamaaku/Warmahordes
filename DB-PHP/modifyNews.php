<?php
	require('../connect.php');
	session_start();
	$message = "Attempt to modify announcements failed.";
	if(isset($_GET['id']))
	{
		if(is_numeric($_GET['id']))
		{
			$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
			$_SESSION['newsid'] = $id;
			$uQuery = "SELECT * FROM announcements WHERE newsid = :id LIMIT 1";
			$uStatement = $db->prepare($uQuery);
			$uStatement->bindValue(':id',$id,PDO::PARAM_INT);
			$uStatement->execute();
			$row = $uStatement->fetch();
		}
	}

	if(isset($_POST['delete']))
	{
		if($_SESSION['accessLevel'] == 1)
		{
			$id = $_SESSION['newsid'];
			$deleteQuery = "DELETE FROM announcements WHERE newsid = :id LIMIT 1";
			$deleteStatement = $db->prepare($deleteQuery);
			$deleteStatement->bindValue(':id',$id,PDO::PARAM_INT);
			$deleteStatement->execute();

			if($deleteStatement->execute())
			{
				header('Location: ../listNews.php');
			}
		}
	}

	if(isset($_POST['submit']))
	{
		if($_SESSION['accessLevel'] == 1)
		{
			$id = $_SESSION['newsid'];
			$userid = $_SESSION['userid'];
			$date = date('Y-m-d h-i-s');
			$title = $_POST['title'];
			$content = $_POST['content'];

			$newsQuery = "UPDATE announcements SET 
							title = :title,
							content = :content,
							updatedon = :updatedon,
							userid = :userid
							WHERE newsid = :id";

			$updateStatement = $db->prepare($newsQuery);
			$updateStatement->bindValue(':title',$title,PDO::PARAM_STR);
			$updateStatement->bindValue(':content',$content,PDO::PARAM_STR);
			$updateStatement->bindValue(':updatedon',$date);
			$updateStatement->bindValue(':userid',$userid,PDO::PARAM_INT);
			$updateStatement->bindValue(':id',$id,PDO::PARAM_INT);

			if($updateStatement->execute())
			{
				header('Location: ../listNews.php');
			}

		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Modify Announcment</title>
	<?php include('../styles.php');?>
</head>
<body class="bg-dark">
	<div class="container-fluid bg-dark text-success">
		<form method="post" action="modifyNews.php">
		<br>
		<div class="form-group">
			<label for="title">Title:</label>
			<input class="pl-1" type="text" name="title" id="title" required="" autofocus="" value="<?=$row['title']?>"/>
		</div>
		<div class="form-group">
			<label for="content">Announcment:</label>
			<textarea class="form-control" rows="7" name="content" id="content"><?=$row['content']?></textarea>
		</div>
		<div class="form-group form-inline form-group mb-2 form-right">
			<button class="btn btn-success text-dark mr-2" name="submit" id="submit" type="submit">Edit</button>
			<button type="button" class="btn btn-dark text-success" data-toggle="modal"  data-target="#delete">DELETE</button>

		<div class="modal fade" id="delete">
		  <div class="modal-dialog">
		    <div class="modal-content">


		      <div class="modal-header bg-dark text-center text-success border-bottom-0">
		        <h4 class="modal-title text-center">Confirmation:</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		      </div>

		      <div class="modal-body bg-dark text-success text-center">
		      	<p>Are you sure you want to delete this post?</p>
		        <button class="btn btn-dark text-success" type="submit" name="delete">DELETE</button>
		      </div>

		      <div class="modal-footer bg-dark text-center border-top-0">
		      	<button class="btn btn-dark btn-center text-success" data-dismiss="modal">CANCEL</button>
		      </div>

		</div>
		</form>
	</div>
</body>
</html>