<?php function carte_centres()
{
global $wpdb;
$centres = array();
$sql_select = "SELECT * FROM `{$wpdb->prefix}centre_formation` ;";
$reponse_select = $wpdb->get_results($sql_select);
if (sizeof($reponse_select) >= 1)
{
foreach ($reponse_select as $row)
{
$centres[] = $row;
}
wp_send_json($centres);
}
else{
	die();
}

}
?>
