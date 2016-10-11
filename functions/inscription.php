<?php function inscription()
{
if( isset($_POST['id']))
{
global $wpdb;
$wpdb->show_errors();
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
$result=array(
"success"=> "true"
);
}
else
{

$result=array(
"success"=> "false",
"status" => $wpdb->print_error()
);
}
wp_send_json($result);
}
else{
	die();
}

}
?>
