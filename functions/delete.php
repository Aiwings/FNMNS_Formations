<?php function form_delete()
{
if(isset($_POST["id"]))
{
global $wpdb;

$result = array();
try
{
if(delfile($_POST["id"],0) == true)
{
$resultat = $wpdb->delete("{$wpdb->prefix}formation", array( 'id' => $_POST["id"] ) );
if($resultat ==1 )
{
wp_send_json_success();
}
else
{
	throw new Exception($wpdb->print_error());
}
}
else
{
	throw new Exception("Impossible de supprimer le fichier");
}

}
catch( Exception $e) {
  	wp_send_json_error( array( "status"=>$e->getMessage()));
}

}
else
{
	die();
}
}
?>
