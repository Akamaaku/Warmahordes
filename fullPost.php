<?php
	require('connect.php');
	session_start();

	if(isset($_GET['id']))
	{
		if(is_numeric($_GET['id']))
		{
			$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
			$_SESSION['newsid'] = $id;
			$aQuery = "SELECT * FROM announcements WHERE newsid = :newsid LIMIT 1";
			$aStatement = $db->prepare($aQuery);
			$aStatement->bindValue('newsid',$id);
			$aStatement->execute();
			$news = $aStatement->fetch();

			$commentQuery = "SELECT * FROM comments WHERE newsid = :newsid";
			$commentStatement = $db->prepare($commentQuery);
			$commentStatement->bindValue('newsid',$id);
			$commentStatement->execute();
			$commentsCount = $commentStatement->rowCount();
			$comments = $commentStatement->fetchAll();
		}
	}
	
	if(isset($_POST['comment']))
	{
		$valid = true;

		if(strlen(trim($_POST['mycomment'])) < 1)
		{
			$valid = false;
		}
		else
		{
			$comment = filter_var(trim($_POST['mycomment']),FILTER_SANITIZE_SPECIAL_CHARS);
		}

		include_once $_SERVER['DOCUMENT_ROOT'].'/wd2/WarmaHordes/securimage/securimage.php';

		$securimage = new Securimage();

		$temp = $securimage->check($_POST['captcha_code']);

		if(!($temp))
		{
			$valid = false;
			$message = "The captcha answer was incorrect. Please try again.";
			echo "<script type='text/javascript'>alert('$message'); </script>";
		}

		if($valid)
		{
			$newsid = $_SESSION['newsid'];
			$userid = $_SESSION['userid'];
			$displayName = $_SESSION['displayName'];
			$date = date("Y-m-d h-i-s");

			$commentQuery = "INSERT INTO comments (displayname, comment, postdate, newsid, userid)
								VALUES (:displayname, :comment, :postdate, :newsid, :userid)";
			$commentStatement = $db->prepare($commentQuery);
			$commentStatement->bindValue(':displayname',$displayName, PDO::PARAM_STR);
			$commentStatement->bindValue(':comment',$comment, PDO::PARAM_STR);
			$commentStatement->bindValue(':postdate',$date);
			$commentStatement->bindValue(':newsid',$newsid, PDO::PARAM_INT);
			$commentStatement->bindValue(':userid',$userid,PDO::PARAM_INT);

			if($commentStatement->execute())
			{	
				$message = "You have succefully left a comment.";
				echo "<script type='text/javascript'>alert('$message'); </script>";
				header("Location: fullPost.php?id=".$newsid);
			}
			else
			{
				$message = "There was a problem with posting your comment. Please try again.";
				$valid = false;
				echo "<script type='text/javascript'>alert('$message'); </script>";
			}
		}


	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>ListNews</title>
	<?php include('styles.php');?>
</head>
<body class="bg-dark">
	<div class="container bg-dark text-success ">
		<h3>Current News Items</h3>
		<ul class="m-0 list-unstyled">
			<li>
				<h4><?=$news['title']?></h4>
				<p>Original Post:<?=$news['createdon']?> 
				<?php if ($news['updatedon'] != null): ?>
					Modified on <?=$news['updatedon']?>
				<?php endif ?></p>
				<p><?=$news['content']?></p>
				<a class="btn btn-success text-dark" href="listNews.php">Return to all posts.</a>
				<?php if ($_SESSION['accessLevel'] == 1): ?>
					<a class="btn btn-success text-dark" href="DB-PHP/modifyNews.php?id=<?=$news['newsid']?>">Edit</a>
				<?php endif ?>
				<?php if ($_SESSION['accessLevel'] < 5): ?>
					<button type="button" class="btn btn-dark" id="viewComments" onclick="display_comment()">Comments(<?=$commentsCount?>)</button>
					<ul class="m-0 list-unstyled" id="comments">
						<li><button type="button" class="btn btn-dark text-success" id="topHide" onclick="hide_comment()">Hide comments</button></li>
						<?php foreach ($comments as $comment): ?>
						<div class="container bg-dark text-success cols-sm-3">
							<li class="p-2 border border-success rounded">
								<h5 class="m-0 p-0 display-block cols-sm-3"><?=$comment['displayname']?></h5>
								<p><?=$comment['postdate']?></p>
								<p class="m-0"><?=$comment['comment']?></p>
							</li>
						</div>
						<br>
						<?php endforeach ?>
						<li><button type="button" class="btn btn-dark text-success" onclick="hide_comment()" id="bottomHide">Hide comments</button></li>
					</ul>
				<button type="button" class="btn btn-dark text-success" id="post_comment">Post Comment</button>
					<div id="comment_form">
			      	<h4 class="text-left">Post a comment:</h4>
					<form class="form text-left" method="post" action="fullPost.php?id=<?=$id?>">
						<div class="form-group">
							<h5><?=$_SESSION['displayName']?></h5>
							<label for="mycomment">Comment: </label>
							<textarea class="form-control" name="mycomment" id="mycomment" autofocus="" rows="3"><?php if (isset($_POST['mycomment'])): ?><?=$_POST['mycomment']?><?php endif ?></textarea>
						</div>
						<div class="form-group text-left">
							<?php
								require_once "securimage/securimage.php";
								echo "<div id=captcha_container_1>\n";
								echo Securimage::getCaptchaHtml();
								echo "<br>";
								echo "\n</div>\n";
							?>	
						</div>
						<div class="form-group text-center">
							<button class="btn btn-success text-dark btn-right" type="submit" name="comment">Comment</button>
					      	<button class="btn btn-dark btn-center text-success" type="button" name="cancel" id="cancel" onclick="cancel_comment()">Cancel</button>
						</div>
					</form>
					</div>
				<?php endif ?>
			</li>	
		</ul>
	</div>
	<script>
	$("#comment_form").hide();
	$("#comments").hide();

	$("#post_comment").click(function()
	{
		$("#comment_form").show();
	});

	function display_comment()
	{		
		$("#comments").show();
	}

	function hide_comment()
	{		
		$("#comments").hide();
	}

	function cancel_comment()
	{
		$("#comment_form").hide();
	}
</script>
</body>
</html>
