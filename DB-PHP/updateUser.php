<!-- Administration user update form -->

<?php
	require('../connect.php');
	session_start();
	include('../data/provstate.php');
	include('../data/months.php');


	if(isset($_GET['id']))
	{
		if(is_numeric($_GET['id']))
		{
			$_SESSION['id'] = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
			$id = $_SESSION['id'];
			$updateQuery = "SELECT * FROM users WHERE userid = :userid";
			$updateStatement= $db->prepare($updateQuery);
			$updateStatement->bindValue(':userid',$id,PDO::PARAM_INT);
			$updateStatement->execute();
			$userInfo = $updateStatement->fetch();
			$dob = date_parse_from_format("Y-m-d", $userInfo['dob']);
		}

	}

	if(isset($_POST['cancel']))
	{
		header("Location: ../editUser.php");
	}

	if(isset($_POST['submit']))
	{
		$valid = true;
		$message = "Update failed";
		$userid = $_SESSION['id'];
		$firstName = filter_var($_POST['fname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$lastName = filter_var($_POST['lname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$displayName = filter_var($_POST['dname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$year = filter_var($_POST['year'], FILTER_SANITIZE_NUMBER_INT);
		$month = filter_var($_POST['month'], FILTER_SANITIZE_NUMBER_INT);
		$day = filter_var($_POST['days'], FILTER_SANITIZE_NUMBER_INT);		
		$date = strtotime($year."-".$month."-".$day);
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		$dateOfBirth = date('Y-m-d', $date);
		$country = filter_var($_POST['country'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$provstate = filter_var($_POST['provstate'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$city = filter_var($_POST['city'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$phonenumber = "";
		$company = "";
		$accessLevel = 4;

		if(isset($_POST['phone']))
		{
			$phonenumber = filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);
		}
		if(isset($_POST['company']))
		{
			$company = filter_var($_POST['company'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}
		if(isset($_POST['accessLevel']))
		{
			$accessLevel = filter_var($_POST['accessLevel'], FILTER_SANITIZE_NUMBER_INT);
		}

		$updateQuery2 = "UPDATE users SET 
							accessLevel = :accessLevel, 
							firstname = :firstname, 
							lastname = :lastname,
							dob = :dob,
							city = :city,
							provstate = :provstate,
							country = :country,
							nickname = :nickname,
							email = :email,
							phonenumber = :phonenumber,
							companyname = :company
							WHERE userid = :userid";

		$updateStatement2 = $db->prepare($updateQuery2);

		$updateStatement2->bindValue(':accessLevel',$accessLevel,PDO::PARAM_INT);
		$updateStatement2->bindValue(':firstname', $firstName, PDO::PARAM_STR);
		$updateStatement2->bindValue(':lastname', $lastName, PDO::PARAM_STR);
		$updateStatement2->bindValue(':dob', $dateOfBirth);
		$updateStatement2->bindValue(':city', $city, PDO::PARAM_STR);
		$updateStatement2->bindValue(':provstate', $provstate, PDO::PARAM_STR);
		$updateStatement2->bindValue(':country', $country, PDO::PARAM_STR);
		$updateStatement2->bindValue(':nickname', $displayName, PDO::PARAM_STR);
		$updateStatement2->bindValue(':email', $email, PDO::PARAM_STR);
		$updateStatement2->bindValue(':phonenumber', $phonenumber, PDO::PARAM_INT);
		$updateStatement2->bindvalue(':company', $company, PDO::PARAM_STR);
		$updateStatement2->bindValue(':userid',$userid,PDO::PARAM_INT);

		if($updateStatement2->execute())
		{
			header("Location: ../editUser.php");
		}

		echo "<script type='text/javascript'>alert('$message'); </script>";
		


	}

	function validDateOfBirth($month, $year, $day)
	{
		$validDate = true;
		$validDay;
		$currentYear = date('Y');
		$months = array( 'options' => array ('min_range' => 1, 'max_range' => 12));
		$years = array( 'options' => array ('min_range' => 1940, 'max_range' => $currentYear));
		$age = 0;

		if($month == 2)
		{
			if(($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0)
			{
				if($day > 29)
				{
					$validDate = false;
					dateError(errorMessage);
				}
				else
				{
					$age = calculateAge($year,$month,$day);
				}
			}
		}
		else if($month == 4 || $month == 6 || $month == 9 || $month == 11)
		{
			if($day > 30)
			{
				$validDate = false;
				dateError(errorMessage);
			}
			else
			{
				$age = calculateAge($year,$month,$day);
			}
		}
		else
		{
			if($day > 31)
			{
				$validDate = false;
				dateError(errorMessage);
			}
			else
			{
				$age = calculateAge($year,$month,$day);
			}
		}

		if($age < 12)
		{
			$validDate = false;
		}

		$validDay = filter_input(INPUT_POST, $day, FILTER_VALIDATE_INT);
		$validMonth = filter_input(INPUT_POST, $month, FILTER_VALIDATE_INT, $months === true);
		$validYear = filter_input(INPUT_POST, $year, FILTER_VALIDATE_INT, $years === true);

		if(!($validDay && $validMonth && $validYear))
		{
			$validDate = false;
		}
		
		return $validDate;
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Edit User</title>
	<?php include('../styles.php');?>
	<script src="../js/registerFormValidation.js"></script>
</head>
<body class="bg-dark">
	<div class="container bg-success text-dark text-center">
		<?php if ($_SESSION['accessLevel'] == 1): ?>
		<?php include('../header.php');?>
		<form class="container-fluid bg-dark text-success text-left col-lg-8" method="post" action="updateUser.php">
			<h3 class="text-center">Update User: <?=$userInfo['nickname']?></h3>
			<br>
			<div class="form-group ">
				<label class="col-lg-4 pl-2 pr-2" for="accessLevel">Access Level:</label>
				<select class="bg-dark text-success pr-2 pl-2 col-lg-4" id="accessLevel" name="accessLevel">
					<option id="user" value="4">Regular</option>
					<option id="event" value="3">Event User</option>
					<option id="moderator" value="2">Forum Moderator</option>
					<option id="admin" value="1">Administrator</option>
				</select>
				<label class="col-lg-4 pl-2 pr-2" for="fname">First Name</label>
				<input class="col-lg-4" type="text" name="fname" autofocus=""  id="fname" value="<?=$userInfo['firstname']?>"/>
				<p id="fnameError" class="text-danger">First name cannot be blank.</p>
				<label class="col-lg-4 pl-2 pr-2" for="lname">Last Name</label>
				<input class="col-lg-4" type="text" name="lname"  id="lname" value="<?=$userInfo['lastname']?>"/>
				<p id="lnameError" class="text-danger">Last name cannot be blank.</p>
			</div>
			<div class="form-group">
				<label class="col-lg-4 pl-2 pr-2" for="country">Country:</label>
				<select class="bg-dark text-success pr-2 pl-2 col-lg-4" id="country" name="country">
					<?php if ($userInfo['country'] == "CAN"): ?>
						<option id="canada" value="CAN">Canada</option>	
						<option id="usa" value="USA">United States</option>
					<?php else: ?>
						<option id="usa" value="USA">United States</option>
						<option id="canada" value="CAN">Canada</option>	
					<?php endif ?>
				</select>
				<label class="col-lg-4 pl-2 pr-2" for="provstate">Province/State:</label>
				<select class="bg-dark text-success col-lg-5 pr-2 pl-2" id="provstate" name="provstate">
						<option class="text-primary" id="<?=$userInfo['provstate']?>" value="<?=$userInfo['provstate']?>"><?=$userInfo['provstate']?></option>
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
				<input id="city" class="col-lg-4" type="text" name="city" autofocus="" value="<?=$userInfo['city']?>"/>
				<p id="cityError" class="text-danger">Set the City.</p>
			</div>
			<div class="form-group form-inline">
				<h5 class="col-lg-4 pl-2">Date of Birth:</h5>
				<label for="year" class=" pl-2 pr-2">Year</label>
				<select class="bg-dark text-success" name="year" id="year">
					<option value="<?=$dob['year']?>"><?=$dob['year']?></option>
					<?php for ($i=$currentYear; $i > 1940; $i--):?>
						<option value="<?=$i?>"><?=$i?></option>
					<?php endfor?>
				</select>
				<label for="month" class=" pl-2 pr-2">Month</label>
				<select class="bg-dark text-success" name="month" id="month">
					<option value="<?=$dob['month']?>"><?=$dob['month']?></option>
				<?php foreach ($months as $number => $month): ?>
					<option value="<?=$number?>"><?=$month?></option>
				<?php endforeach ?>
				</select>
				<label for="days" class="pl-2 pr-2">Day</label>
				<select class="bg-dark text-success" name="days" id="days">
					<option value="<?=$dob['day']?>"><?=$dob['day']?></option>
					<?php for ($i=1;$i <= 31;$i++): ?>
						<option value="<?=$i?>"><?=$i?></option>
					<?php endfor ?>
				</select>
				<p id="dobError" class="text-danger">Age is incorrect. Confirm date of birth.</p>
			</div>
			<div class="form-group">
				<label class="col-lg-4 pl-2 pr-2 justify-left" for="dname">Display Name</label>
				<input class="col-lg-4" type="text" name="dname" id="dname" value="<?=$userInfo['nickname']?>"/>
				<button type="button" class="btn btn-success text-dark ml-2" name="check">Check</button>
				<p id="dnameError" class="text-danger">Assign display name.</p>
			</div>
			<div class="form-group">
				<label class="col-lg-4 pl-2 pr-2" for="email">Email</label>
				<input class="col-lg-4" type="email" name="email" id="email" value="<?=$userInfo['email']?>"/>
				<p id="emailError" class="text-danger">Verify email.</p>
				<label class="col-lg-4 pl-2 pr-2" for="company">Company Name:</label>
				<input class="col-lg-4" name="company" id="company" type="text" placeholder="(optional)" value="<?=$userInfo['companyname']?>" />
				<p id="companyError" class="text-danger">Please provide your company name.</p>
				<label class="col-lg-4 pl-2 pr-2" for="phone">Business Number:</label>
				<input class="col-lg-4 " type="tel" name="phone" id="phone" placeholder="(optional)" value="<?=$userInfo['phonenumber']?>"/>
				<p id="phoneError" class="text-danger">Please provide 10-digit company phone number.</p>
			</div>
			<div class="text-center">
				<button id="submit" class="btn btn-success text-dark col-sm-4 mr-2 mb-2" type="submit" name="submit">Update</button>
				<button id="cancel" class="btn btn-success text-dark col-sm-4 mb-2" type="submit" name="cancel">Cancel</button>
			</div>
			<div class="form-group">
				<div class="invisible form-inline mb-3 ml-2">
					<label class="form-check-label pl-4 pr-2 col-md-10">
						<input id="eventUser" class="form-check-input" type="checkbox" name="eventCheck">Event Organizer?</label>
					</label>
				</div>
				<label class="invisible col-lg-4 pl-2 pr-2" for="pswrd">Enter New Password:</label>
				<input class="invisible col-lg-4" type="password" name="pswrd" id="pswrd" value="default">
				<p id="pswrdError" class="text-danger">Assign password.</p>
				<label class="invisible col-lg-4 pl-2 pr-2" for="cnfrm">Confirm Password:</label>
				<input class="invisible col-lg-4" type="password" name="cnfrm" id="cnfrm" value="default">
				<p id="cnfrmError" class="text-danger">Confirm password.</p>
				<p id="matchError" class="text-danger">Passwords did not match.</p>
			</div>
		</form>
			<br>
		<?php else: ?>
			<h2>You do not have the proper access level to view this page.</h2>
		<?php endif ?>
	</div>
</body>
</html>
