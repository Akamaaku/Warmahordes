<?php
	require('connect.php');
	session_start();
	include('DB-PHP/loadNews.php');
	
	if(isset($_POST['submit']))
	{
		$message = "Announcement failed to be posted.";

		if(isset($_POST['title']) && isset($_POST['content']))
		{
			$valid = true;
			$title = filter_var($_POST['title'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$content = filter_var($_POST['content'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$date = date("Y-m-d h-i-s");
			echo $userid = $_SESSION['userid'];

			if(strlen(trim($title)) < 1)
			{
				$vavlid = false;
			}

			if(strlen(trim($content)) < 1)
			{
				$valid = false;
			}

			if($valid)
			{
				$newsQuery = "INSERT INTO announcements (title, content, createdon, userid)
				VALUES (:title, :content, :createdon, :userid)";
				$newStatement = $db->prepare($newsQuery);
				$newStatement->bindValue(':title',$title,PDO::PARAM_STR);
				$newStatement->bindValue(':content',$content,PDO::PARAM_STR);
				$newStatement->bindValue(':createdon',$date);
				$newStatement->bindValue(':userid',$userid,PDO::PARAM_INT);

				if($newStatement->execute())
				{
					$message = "Announcment added succesfully.";
				}
				else
				{
					$valid = false;
				}
			}
		}

		echo "<script type='text/javascript'>alert('$message'); </script>";
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin: Edit Announcements</title>
	<?php include('styles.php');?>
</head>
<body class="bg-dark">
	<?php if ($_SESSION['accessLevel'] == 1): ?>
	<div class="container bg-success">
		<?php include('header.php');?>
		<?php include('nav.php');?>
		<br>
		<h3>Annoucement Display:</h3>
		<iframe style="height:400px" class="col-lg-12 p-0 m-0" src="listNews.php" scrolling="true"></iframe>
		<div class="container-fluid bg-dark text-success pb-2">
			<h3>New Announcement</h3>
			<form method="post" action="editNews.php">
				<br>
				<div class="form-group">
					<label for="title">Title:</label>
					<input class="pl-1" type="text" name="title" id="title" required="" autofocus="" />
				</div>
				<div class="form-group">
					<label for="content">Announcment:</label>
					<textarea class="form-control" rows="7" name="content" id="content"></textarea>
				</div>
				<div class="form-group form-inline form-group mb-2 form-right">
					<button class="btn btn-success text-dark " name="submit" id="submit" type="submit">POST</button>
				</div>
			</form>
		</div>
		<br>
	</div>
	<?php else: ?>
		<h3 class="text-success">You are not authorized to view this page.</h3>
	<?php endif ?>
</body>
</html>