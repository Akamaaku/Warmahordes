<?php
	require('connect.php');
	session_start();
	$userQuery = "SELECT * FROM users";
	$userStatement = $db->prepare($userQuery);
	$userStatement->execute();
	$allUsers = $userStatement ->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Users</title>
	<?php include('styles.php');?>
</head>
<body class="bg-dark">

	<div class="container bg-success text-dark text-center">
		<?php if ($_SESSION['accessLevel'] == 1): ?>
		<?php include('header.php');?>
		<?php include('nav.php');?>
		<table>
			<tbody>
				<tr>
					<th>Display Name</th>
					<th>Email</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Location</th>
					<th>Company</th>
					<th>Phone#</th>
					<th>RESET PASSWORD</th>
					<th>EDIT</th>
					<th>DELETE</th>
				</tr>
			<?php foreach ($allUsers as $user): ?>
				<tr>
					<td><?=$user['nickname']?></td>
					<td><?=$user['email']?></td>
					<td><?=$user['firstname']?></td>
					<td><?=$user['lastname']?></td>
					<td><?=$user['city']?>, <?=$user['provstate']?>, <?=$user['country']?></td>
					<td><?=$user['companyname']?></td>
					<td><?=$user['phonenumber']?></td>
					<td><a href="#?id=<?=$user['userid']?>">RESET</a></td>
					<td><a href="#?id=<?=$user['userid']?>">EDIT</a></td>
					<td><a href="#?id=<?=$user['userid']?>">DELETE</a></td>
				</tr>
			<?php endforeach ?>
			</tbody>
		</table>
		<<?php else: ?>
			<h2>You do not have the proper access level to view this page.</h2>
		<?php endif ?>
	</div>
</body>
</html>