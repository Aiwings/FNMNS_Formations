<?php function externe()
{
	global $wpdb;
	$wpdb->show_errors(); 
	$date = date("Y-m-d", time());
	if( isset ($_POST["departement"]))
	{
		$cp = sanitize_text_field( $_POST["departement"]);
		$formations= $wpdb->get_results( $wpdb->prepare( 
		 "SELECT {$wpdb->prefix}formation.*, {$wpdb->prefix}centre_formation.centre, {$wpdb->prefix}discipline.discipline FROM `{$wpdb->prefix}formation`"." ".
		 "LEFT JOIN {$wpdb->prefix}discipline ON {$wpdb->prefix}formation.idDiscipline =  {$wpdb->prefix}discipline.id"." ".
		 "LEFT JOIN {$wpdb->prefix}centre_formation ON {$wpdb->prefix}formation.idCentre =  {$wpdb->prefix}centre_formation.id"." ".
		 "WHERE `date_fin` > %s "." ".
		 "AND `departement` = %d ORDER BY `date_debut`",
		 $date,
		 $cp
		 ),ARRAY_A);

		wp_send_json_success($formations);


	}



	die();

}
?>