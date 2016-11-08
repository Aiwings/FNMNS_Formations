<?php function ajout_discipline()
{
if ( isset($_POST["discipline"]))
{
try
{
global $wpdb;
$wpdb->show_errors();
$sql_select = "SELECT * FROM `{$wpdb->prefix}discipline` WHERE `discipline` = '".$_POST["discipline"]."';";
$reponse_select = $wpdb->get_results($sql_select );
if (sizeof($reponse_select) != 1)
{
$results_add = $wpdb->insert("{$wpdb->prefix}discipline",array(
"discipline"=>$_POST["discipline"]
));
if($results_add ==1)
{
$sql_select = "SELECT * FROM `{$wpdb->prefix}discipline` WHERE `discipline` = '".$_POST["discipline"]."';";
$reponse_select = $wpdb->get_results($sql_select );
if (sizeof($reponse_select)== 1)
{
foreach ($reponse_select as $row)
{
$data = array(
"id" => $row->id,
"discipline" => $_POST["discipline"]
);
wp_send_json_success($data);
}
}
}
else
{
throw new Exception($wpdb->print_error());
}
}
else
{
throw new Exception($wpdb->print_error());
}
}
catch( Exception $e)
{
wp_send_json_error(array( "status"=>$e->getMessage()));
}
}
else{
die();
}
}
?>
