<?php
	$css;

	if(file_exists("../styles/bootstrap.css"))
		$css = "../styles/bootstrap.css";

	if(file_exists("styles/bootstrap.css"))
		$css= "styles/bootstrap.css";

	if(file_exists("../../styles/bootstrap.css"))
		$css= "../../styles/bootstrap.css"
?>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?=$css?>" />
		<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Shojumaru" rel="stylesheet">
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
