<?php
	require('connect.php');
	session_start();
	include('DB-PHP/loadNews.php');
	
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
		<?php foreach ($rows as $news): ?>
			<li>
				<h4><?=$news['title']?></h4>
				<?php if ($news['updatedon'] != null): ?>
					Modified on <?=$news['updatedon']?>
				<?php else: ?>
					<p>Original Post: <?=$news['createdon']?> 
				<?php endif ?></p>
				<p><?=substr($news['content'],0,20)?>...<a class="text-success" href="fullPost.php?id=<?=$news['newsid']?>">Read Full Post</a></p>
				<?php if ($_SESSION['accessLevel'] == 1): ?>
					<a class="btn btn-success text-dark" href="DB-PHP/modifyNews.php?id=<?=$news['newsid']?>">Edit</a>
				<?php endif ?>
			</li>	
		<?php endforeach ?>
		</ul>
	</div>
</body>
</html>