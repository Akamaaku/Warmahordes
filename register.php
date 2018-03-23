<?php
	session_start();
	include('data/provstate.php');

	$currentYear = date('Y');

	$months = [ 1 => "January", 2 => "February", 3 => "March", 4 => "April", 
				5 => "May", 6 => "June", 7 => "July", 8 => "August", 
				9 => "September", 10 => "October", 11 => "November", 12 => "December"];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Register an Account</title>
	<?php include('styles.php');?>
	<script src="js/registerFormValidation.js"></script>
<!-- 	Planning to use AJAX & Javascript to make the province and state to be dynamic to country chosen.
<script type="text/javascript">
		function determineProvState(str)
		{
			if(str == 'CAN')
			{

			}

			if(str == 'USA')
			{
				$(document).ready(function(){
					$.ajax({
						

					})
				});
			}
		}
	</script> -->
</head>
<body class="bg-dark">
	<div class="container bg-success text-dark text-center">
		<?php include('header.php');?>
		<?php include('nav.php');?>
		<h2 class="display-3">Register Your Account</h2>
		<form class="container bg-dark text-success text-left col-lg-8" method="post" action="addUser.php">
			<h3>Enter your information here:</h3>
			<div class="form-group ">
				<label class="col-lg-4 pl-2 pr-2" for="fname">First Name</label>
				<input class="col-lg-4" type="text" name="fname" autofocus=""  id="fname"/>
				<p id="fnameError" class="text-danger">Please provide your first name.</p>
				<label class="col-lg-4 pl-2 pr-2" for="lname">Last Name</label>
				<input class="col-lg-4" type="text" name="lname"  id="lname"/>
				<p id="lnameError" class="text-danger">Please provide your last name.</p>
			</div>
			<div class="form-group">
				<label class="col-lg-4 pl-2 pr-2" for="country">Country:</label>
				<select class="bg-dark text-success pr-2 pl-2 col-lg-4" id="country" name="country" >
					<option id="canada" value="CAN">Canada</option>
					<option id="usa" value="USA">United States</option>
				</select>
				<label class="col-lg-4 pl-2 pr-2" for="provstate">Province/State:</label>
				<select class="bg-dark text-success col-lg-5 pr-2 pl-2" id="provstate" name="provstate">
						<option class="text-primary" id="can" value="can">PROVINCE</option>
						<?php foreach ($provinces as $pv => $province): ?>
							<option id="<?=$pv?>" value="<?=$pv?>"><?= $province?></option>						
						<?php endforeach ?>
						<option class="text-primary" id="us" value="us">STATES</option>
						<?php foreach ($states as $key => $state): ?>
							<option id="<?=$state['abv']?>" value="<?=$state['abv']?>"><?=$state['state']?></option>
						<?php endforeach ?>
				</select>
				<label class="col-lg-4 pl-2 pr-2" for="city">City</label>
				<input id="city" class="col-lg-4" type="text" name="city" autofocus=""  />
				<p id="cityError" class="text-danger">Please provide your city.</p>
			</div>
			<div class="form-group form-inline">
				<h5 class="col-lg-4 pl-2">Date of Birth:</h5>
				<label for="year" class=" pl-2 pr-2">Year</label>
				<select class="bg-dark text-success" name="year" id="year">
					<?php for ($i=$currentYear; $i > 1940; $i--):?>
						<option value="<?=$i?>"><?=$i?></option>
					<?php endfor?>
				</select>
				<label for="month" class=" pl-2 pr-2">Month</label>
				<select class="bg-dark text-success" name="month" id="month">
				<?php foreach ($months as $number => $month): ?>
					<option value="<?=$number?>"><?=$month?></option>
				<?php endforeach ?>
				</select>
				<label for="days" class="pl-2 pr-2">Day</label>
				<select class="bg-dark text-success" name="days" id="days">
					<?php for ($i=1;$i <= 31;$i++): ?>
						<option value="<?=$i?>"><?=$i?></option>
					<?php endfor ?>
				</select>
				<p id="dobError" class="text-danger">To join the community minimum age of 12 is required.</p>
			</div>
			<div class="form-group">
				<label class="col-lg-4 pl-2 pr-2 justify-left" for="dname">Display Name</label>
				<input class="col-lg-4" type="text" name="dname" id="dname" />
				<button type="button" class="btn btn-success text-dark ml-2" name="check">Check</button>
				<p id="dnameError" class="text-danger">Please provide name to be displayed on the website.</p>
			</div>
			<div class="form-group">
				<label class="col-lg-4 pl-2 pr-2" for="email">Email</label>
				<input class="col-lg-4" type="text" name="email" id="email" />
				<p id="emailError" class="text-danger">Please provide a valid email address.</p>
				<label class="col-lg-4 pl-2 pr-2" for="pswrd">Enter New Password:</label>
				<input class="col-lg-4" type="password" name="pswrd" id="pswrd" >
				<p id="pswrdError" class="text-danger">Please enter a password.</p>
				<label class="col-lg-4 pl-2 pr-2" for="cnfrm">Confirm Password:</label>
				<input class="col-lg-4" type="password" name="cnfrm" id="cnfrm" >
				<p id="cnfrmError" class="text-danger">Please confirm the password.</p>
				<p id="matchError" class="text-danger">Passwords did not match. Please check the passwords you have typed in.</p>
			</div>
			<div class="form-group">
				<div class="form-inline mb-3 ml-2">
					<label class="form-check-label pl-4 pr-2 col-md-10">
						<input id="eventUser" class="form-check-input" type="checkbox" name="eventCheck">Event Organizer?</label>
					</label>
				</div>
				<label class="col-lg-4 pl-2 pr-2" for="company">Company Name:</label>
				<input class="col-lg-4" name="company" id="company" type="text" placeholder="(optional)" />
				<p id="companyError" class="text-danger">Please provide your company name.</p>
				<label class="col-lg-4 pl-2 pr-2" for="phone">Business Number:</label>
				<input class="col-lg-4 " type="tel" name="phone" id="phone" placeholder="(optional)" />
				<p id="phoneError" class="text-danger">Please provide 10-digit company phone number.</p>
			</div>
			<div class="text-center">
				<button id="submit" class="btn btn-success text-dark col-sm-4 mr-2 mb-2" type="submit" name="submit">Register</button>
				<button id="reset" class="btn btn-success text-dark col-sm-4 mb-2" type="reset" name="reset">Reset</button>
			</div>
			<br>
		</form>
		<br>
	</div>
</body>
</html>