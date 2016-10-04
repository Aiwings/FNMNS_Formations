
<?php

function searchdisciplines()
{
$sql_disciplines ='SELECT * FROM `discipline`';
$disciplines ="";


$disciplines.= '<select id="discipline" required name="discipline" class="col-md-2">';
$disciplines.= '<option value="" selected>Formation</option>';
$disciplines.= '<option value="add">Ajouter... </option>';

global $wpdb;
$results = $wpdb->get_results($sql_disciplines);

	 if (sizeof($results) >= 1) 
	{
		foreach($results as $row)
		{ 
			$disciplines.= '<option value="'.$row->id.'">'. $row->discipline.'</option>';
	
		}
		$disciplines.= '</select>';
	}	

return $disciplines;
}
?>

