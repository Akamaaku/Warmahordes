<?php
	global $db;

	$aQuery = "SELECT * FROM announcements ORDER BY createdon DESC";
	$aStatement = $db->prepare($aQuery);
	$aStatement->execute();
	$rows = $aStatement->fetchAll();

?>