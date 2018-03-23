<?php

	$provinces = ['AB'=> 'Alberta', 'BC' => 'British Columbia', 'MB' => 'Manitoba', 'NB' =>'New Brunswick', 
				 'NF'=> 'Newfoundland and Labrador', 'NS' => 'Nova Scotia', 'ON' => 'Ontario', 'PE' => 'Prince Edward Island', 
				 'QC' => 'Quebec', 'SK' => 'Saskatchewan', 'NT' => 'Northwest Territories', 'NU' => 'Nunavut', 'YK' => 'Yukon'];

	$handle = fopen('states.csv','r');
 	$states = [];

 	while (($data = fgetcsv($handle)) !== FALSE) 
 	{
 		$state = [ 'state' => $data[0], 'abv' => $data[1] ];
 		array_push($states, $state);
	}

?>