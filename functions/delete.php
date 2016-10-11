<?php function form_delete()
{
if(isset($_POST["id"]))
{
global $wpdb;
$wpdb->show_errors();
$result = array();
try
{
if(delfile($_POST["id"],0) == true)
{
$resultat = $wpdb->delete("{$wpdb->prefix}formation", array( 'id' => $_POST["id"] ) );
if($resultat ==1 )
{
$result = array(
"success" => "true"
);
}
else
{
$result = array(
"success" => "false",
"status" => ""
);
}
}
else
{
$result = array(
"success" => "false",
"status" => "Impossible de supprimer le fichier"
);
}

}
catch( Exception $e) {
$result = array(
"success" => "false",
"status" =>"$e->getMessage()");
}
wp_send_json($result);
}
else
{
	die();
}
?>
