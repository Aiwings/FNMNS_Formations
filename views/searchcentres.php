
<?php function searchcentres()
{
	global $wpdb;

	$sql_centres ="SELECT * FROM `{$wpdb->prefix}centre_formation`";
	$centres ="";

	$results = $wpdb->get_results($sql_centres);


	 if (sizeof($results) >= 1)
	{
		$centres.= '<select required id="centre-formation" name="centre-formation" style="width:100%">';
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
