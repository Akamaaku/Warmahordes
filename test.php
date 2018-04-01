<?php

		include_once $_SERVER['DOCUMENT_ROOT'].'/wd2/WarmaHordes/securimage/securimage.php';

		$securimage = new Securimage();
		
		$temp = $securimage->check($_POST['captcha_code']);

		if(!($temp))
		{
			$valid = false;
			$message = "The captcha answer was incorrect. Please try again.";
			echo "<script type='text/javascript'>alert('$temp'.'$message'); </script>";
		}
?>

<pre><?php print_r($_POST);?></pre>