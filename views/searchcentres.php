
<?php

function searchcentres()
{
$sql_centres ='SELECT * FROM `centre_formation`';
$centres ="";

global $wpdb;
$results = $wpdb->get_results($sql_centres);



	 if (sizeof($results) >= 1) 
	{
		$centres.= '<select required id="centre-formation" name="centre-formation" >';
		$centres.= '<option value="" selected>centre</option>';
		foreach($results as $row)
		{ 
			$centres.= '<option value="'.$row->id .'">'. $row->centre.'</option>';
	
		}
		$centres.= '</select>';
	}	
	
return $centres;
}
?>

