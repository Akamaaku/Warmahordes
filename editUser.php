<?php
	require('connect.php');
	session_start();

	$userQuery = "SELECT * FROM users ORDER BY accessLevel";
	$userStatement = $db->prepare($userQuery);
	$userStatement->execute();
	$allUsers = $userStatement ->fetchAll();

	if ($_SESSION['accessLevel'] != 1) {
		exit("index.php");
	}

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
					<th>Access Level</th>
					<th>Reset Password</th>
					<th>Edit</th>
					<th>Delete</th>
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
					<td><?=$user['accessLevel']?></td>
					<td><a class="btn btn-dark text-success" href="DB-PHP/resetPassword.php?id=<?=$user['userid']?>">RESET</a></td>
					<td><a class="btn btn-dark text-success" href="DB-PHP/updateUser.php?id=<?=$user['userid']?>">EDIT</a></td>
					<td>
						<button type="button" class="btn btn-dark text-success" data-toggle="modal"  data-target="#delete<?=$user['userid']?>">DELETE</button>

						<div class="modal fade" id="delete<?=$user['userid']?>">
						  <div class="modal-dialog">
						    <div class="modal-content">


						      <div class="modal-header bg-dark text-center text-success border-bottom-0">
						        <h4 class="modal-title text-center">Confirmation:</h4>
						        <button type="button" class="close" data-dismiss="modal">&times;</button>
						      </div>


						      <div class="modal-body bg-dark text-success">
						      	<p>Are you sure you want to delete <?=$user['nickname']?>?</p>
						        <a class="btn btn-dark text-success" href="DB-PHP/deleteUser.php?id=<?=$user['userid']?>">DELETE</a>
						      </div>

						      <div class="modal-footer bg-dark text-center border-top-0">
						      	<button class="btn btn-dark btn-center text-success" data-dismiss="modal">CANCEL</button>
						      </div>

						    </div>
						  </div>
						</div>
						</td>
				</tr>
			<?php endforeach ?>
			</tbody>
		</table>
		<?php else: ?>
			<h2>You do not have the proper access level to view this page.</h2>
		<?php endif ?>
	</div>
</body>
</html>