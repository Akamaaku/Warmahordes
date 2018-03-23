<?php

	if(isset($_GET['id']))
	{
		if(is_numeric($_GET['id']))
		{
			$id=filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
			
		}
		


	}
?>