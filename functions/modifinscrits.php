<?php function modif_inscrits()
{
global $wpdb;
if (isset($_POST['id'])) {
try{
$reponse_modif = $wpdb->update(
"{$wpdb->prefix}preinscrits",
array(
'prenom' => $_POST['prenom'],	// string
'nom' => $_POST['nom'],
'email' => $_POST['email'],
'telephone' => $_POST['telephone'],
'adresse1' => $_POST['adresse1'],
'adresse2' => $_POST['adresse2'],
'cp' => $_POST['cp'],
'ville' => $_POST['ville'],
),
array( 'id' => $_POST['id'] ),
array(
'%s',
'%s',
'%s',
'%d',
'%s',
'%s',
'%d',
'%s'
),
array( '%d' )
);
if($reponse_modif  ==1 )
{
wp_send_json_success();
}
else
{
throw new Exception( $wpdb->print_error());
}
}
catch( Exception $e) {
wp_send_json_error(array("status"=>'Exception reçue : '.  $e->getMessage(). "\n") );
}
}
else
{
wp_send_json_error(array("status"=>'Pas de id'));
}
}
?>
