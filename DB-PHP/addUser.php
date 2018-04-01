<?php 
	require('../connect.php');
	session_start();

	if($_POST)
	{
		if(isset($_POST['submit']))
		{
			$errorCheck=false;

			$formTexts = ['fname', 'lname', 'dname', 'city'];

			foreach ($formTexts as $check)
			{
				if(!isset($_POST[$check]))
				{
					$errorCheck=true;
					break;
				}
				else if(sanitizeText($_POST[$check]) != $_POST[$check])
				{
					$errorCheck=true;
					break;
				}
			}

			if(!validEmail())
			{
				$errorCheck = true;
			}

			if(!isset($_POST['pswrd']))
			{
				$errorCheck = true;
			}
			else if(!isset($_POST['cnfrm']))
			{
				$errorCheck = true;
			}
			else if(!($_POST['cnfrm'] == $_POST['cnfrm']))
			{
				$errorCheck = true;
			}

			$validAdd = uploadRegisterInformation($errorCheck);
		}
	}

	function uploadRegisterInformation($error)
	{
		if(!$error)
		{
			$validAdd=true;
			$firstName = filter_var($_POST['fname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$lastName = filter_var($_POST['lname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$displayName = filter_var($_POST['dname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$year = filter_var($_POST['year'], FILTER_SANITIZE_NUMBER_INT);
			$month = filter_var($_POST['month'], FILTER_SANITIZE_NUMBER_INT);
			$day = filter_var($_POST['days'], FILTER_SANITIZE_NUMBER_INT);
			$date = strtotime($year."-".$month."-".$day);
			$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
			$password = password_hash($_POST['pswrd'], PASSWORD_DEFAULT);
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
			
			global $db;

			$addQuery = "INSERT INTO users (accessLevel, firstname, lastname, dob, city, provstate, country, nickname, email, pswrd, phonenumber, companyname)
			VALUES (:accessLevel, :firstname, :lastname, :dob, :city, :provstate, :country, :nickname, :email, :password, :phonenumber, :company)";

			$addStatement = $db->prepare($addQuery);

			$addStatement->bindValue(':accessLevel',$accessLevel,PDO::PARAM_INT);
			$addStatement->bindValue(':firstname', $firstName, PDO::PARAM_STR);
			$addStatement->bindValue(':lastname', $lastName, PDO::PARAM_STR);
			$addStatement->bindValue(':dob', $dateOfBirth);
			$addStatement->bindValue(':city', $city, PDO::PARAM_STR);
			$addStatement->bindValue(':provstate', $provstate, PDO::PARAM_STR);
			$addStatement->bindValue(':country', $country, PDO::PARAM_STR);
			$addStatement->bindValue(':nickname', $displayName, PDO::PARAM_STR);
			$addStatement->bindValue(':email', $email, PDO::PARAM_STR);
			$addStatement->bindValue(':password', $password);
			$addStatement->bindValue(':phonenumber', $phonenumber, PDO::PARAM_INT);
			$addStatement->bindvalue(':company', $company, PDO::PARAM_STR);
			
			if(!$addStatement->execute())
			{
				$validAdd = false;
			};

			return $validAdd;
		}
	}

	function sanitizeText($text)
	{	
		$sanitizedText = filter_var($text, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		return $sanitizedText;
	}

	function validEmail ()
	{
		global $db;
		$valid = true;
		if(!isset($_POST['email']))
		{
			$valid = false;
		}

		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$valid = false;
		}

		$emailQuery = "SELECT email FROM users";
		$emailStatement = $db->prepare($emailQuery);
		$emailStatement->execute();

		if($emailStatement->rowCount() != 0)
		{
			while($row = $emailStatement->fetch())
			{
				if($email == $row['email'])
				{
					$valid = false;
					break;
				}
			}
		}
		

		return $valid;
	}

	function validDateOfBirth($month, $year, $day)
	{
		$validDate = true;
		$validDay;
		$currentYear = date('Y');
		$months = array( 'options' => array ('min_range' => 1, 'max_range' => 12));
		$years = array( 'options' => array ('min_range' => 1940, 'max_range' => $currentYear));

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

	function calculateAge($birthYear, $birthMonth, $birthDay) 
	{
	    $currentYear = date('Y');
	    $currentMonth = date('m');
	    $currentDay = date('d');
	    $calculatedAge = $currentYear - $birthYear;

	    if ($currentMonth < $birthMonth - 1) {
	        $calculatedAge--;
	    }
	    if ($birthMonth - 1 == $currentMonth && $currentDay < $birthDay) {
	        $calculatedAge--;
	    }
	    return $calculatedAge;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Registered</title>
	<?php include('../styles.php');?>
</head>
<body class="bg-dark">
	<div class="container bg-success text-dark text-center">
		<?php include('../header.php');?>
		<div class="container bg-dark text-success">
			<?php if ($errorCheck): ?>
				<h3>Could not register User</h3>
			<?php endif ?>
			<?php if ($validAdd): ?>
				<h3>Congratulations! You have been registered. You are now able to login. </h3>
				<p>Please click this link <a href="../index.php">here</a> to get to the home page.
			<?php endif ?>
			<br>
		</div>
		<br>
	</div>
</body>
</html>