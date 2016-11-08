<?php function inscription()
{
if( isset($_POST['id']))
{
global $wpdb;
$reponse_inscrire = $wpdb->update(
"{$wpdb->prefix}preinscrits",
array(
'estinscrit' => '1',	// string
),
array( 'id' => $_POST['id'] ),
array(
'%d'
),
array( '%d' )
);
if($reponse_inscrire ==1 )// will return true if succefull else it will return false
{
wp_send_json_success();
}
else
{
wp_send_json_error( array( "status"=> $wpdb->print_error()));
}
}
else{
die();
}
}
?>
