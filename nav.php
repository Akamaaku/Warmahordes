<nav class="bg-dark text-success navbar navbar-expand-lg">
	<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navSmallScreen" aria-expanded="false">
    <span class="navbar-toggler-icon text-success">¦¦¦¦</span>
  	</button>
	  <div class="navbar-collapse collapse" id="navSmallScreen" style="">
		<ul class="navbar-nav">
			<li class="nav-item"><a class="nav-link text-success" href="index.php">Home</a></li>
			<?php if ($_SESSION['accessLevel'] <= 3): ?>
				<li class="nav-item"><a  class="nav-link text-success" href="forum.php">Forum</a></li>
				<li class="nav-item"><a class="nav-link text-success" href="profile.php">Profile</a></li>
				<li class="nav-item"><a class="nav-link text-success" href="armybuilder.php">Battles</a></li>
			<?php endif ?>
			<li class="nav-item"><a class="nav-link text-success" href="events.php">Events</a></li>
			<li class="nav-item"><a class="nav-link text-success" href="armybuilder.php">Army Builder</a></li>
			<?php if ($_SESSION['accessLevel'] == 1): ?>
			    <li class="nav-item dropdown">
      			<a class="nav-link dropdown-toggle text-success bg-dark" href="#" id="navbardrop" data-toggle="dropdown">
			        ADMIN
			      </a>
			      <div class="dropdown-menu bg-dark">
			        <a class="dropdown-item bg-dark text-success" href="#">Edit Announcements</a>
			        <a class="dropdown-item bg-dark text-success" href="#">Edit Forums</a>
			        <a class="dropdown-item bg-dark text-success" href="editUser.php">Edit Users</a>
			        <a class="dropdown-item bg-dark text-success" href="#">Edit Events</a>
			        <a class="dropdown-item bg-dark text-success" href="#">Edit Army Builder</a>
			      </div>
			    </li>
			<?php endif ?>
		</ul>
	</div>
	<?php if ($_SESSION['validLogin'] == 0): ?>
	<div style="display:inline-block;" class="float-right">
		<button type="button" class="btn btn-dark dropdown-toggle text-success" data-toggle="dropdown">LOGIN</button>
		<div style="width:100%" class="dropdown-menu float-right bg-dark">
			<?php include('login.php');?>
		</div>
	</div>
	<?php endif ?>
	<?php if ($_SESSION['validLogin'] == 1): ?>
	<p class="text-success"><?=$_SESSION['displayName']?></p>
	<button class="btn btn-dark text-success" type="button" name="logout">Log Out</button>
	<?php endif ?>
</nav>