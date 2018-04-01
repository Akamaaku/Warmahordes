<?php
	if(isset($_SESSION['validLogin']))
	{
		$validLogin = $_SESSION['validLogin'];
	}
?>
<nav class="bg-dark text-success navbar navbar-expand-lg">
	<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navSmallScreen" aria-expanded="false">
    <span class="navbar-toggler-icon text-success">¦¦¦¦</span>
  	</button>
	  <div class="navbar-collapse collapse" id="navSmallScreen" style="">
		<ul class="navbar-nav">
			<li class="nav-item"><a class="nav-link text-success" href="index.php">Home</a></li>
			<?php if ($_SESSION['accessLevel'] <= 4): ?>
<!-- 				<li class="nav-item"><a  class="nav-link text-success" href="forum.php">Forum</a></li> time constraint-->
				<li class="nav-item"><a class="nav-link text-success" href="notReady.php">Profile</a></li>
<!-- 				<li class="nav-item"><a class="nav-link text-success" href="armybuilder.php">Command Center</a></li>  not yet implmented-->
			<?php endif ?>
			<li class="nav-item"><a class="nav-link text-success" href="notReady.php">Events</a></li>
			<li class="nav-item"><a class="nav-link text-success" href="notReady.php">Army Builder</a></li>
			<?php if ($_SESSION['accessLevel'] == 1): ?>
			    <li class="nav-item dropdown">
      			<a class="nav-link dropdown-toggle text-success bg-dark" href="#" id="navbardrop" data-toggle="dropdown">
			        ADMIN
			      </a>
			      <div class="dropdown-menu bg-dark">
			        <a class="dropdown-item bg-dark text-success" href="editNews.php">Edit Announcements</a>
<!-- 			        <a class="dropdown-item bg-dark text-success" href="#">Edit Forums</a> time constraint-->
			        <a class="dropdown-item bg-dark text-success" href="editUser.php">Edit Users</a>
			        <a class="dropdown-item bg-dark text-success" href="notReady.php">Edit Events</a>
			        <a class="dropdown-item bg-dark text-success" href="notReady.php">Edit Army Builder</a>
			      </div>
			    </li>
			<?php endif ?>
		</ul>
	</div>

	<?php if ($validLogin === 0): ?>
	<button type="button" class="btn btn-dark text-success" data-toggle="modal"  data-target="#login">LOGIN</button>

	<div class="modal fade" id="login">
	  <div class="modal-dialog">
	    <div class="modal-content">


	      <div class="modal-header bg-dark text-center">
	        <h4 class="modal-title">Enter Credentials:</h4>
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	      </div>


	      <div class="modal-body bg-dark text-success">
	        <?php include('login.php');?>
	      </div>

	    </div>
	  </div>
	</div>
	<?php endif ?>

	<?php if ($validLogin === 1): ?>
		<button type="button" class="btn btn-dark text-success" data-toggle="modal"  data-target="#logout"><?=$_SESSION['displayName']?></button>

		<div class="modal fade" id="logout">
		  <div class="modal-dialog">
		    <div class="modal-content">


		      <div class="modal-header bg-dark text-center">
		        <h4 class="modal-title">Are you sure you want to leave?</h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		      </div>


		      <div class="modal-body bg-dark text-success">
		        <?php include('logout.php');?>
		      </div>
	<?php endif ?>
</nav>