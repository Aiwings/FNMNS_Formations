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

if(confirminscription($_POST['id']) == true)
{
    wp_send_json_success();
}
else
{
    wp_send_json_success("mail non envoyé");
}

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


function confirminscription($id)
{

$idformation ="";


$sql_user= $wpdb->prepare( "SELECT * FROM `{$wpdb->prefix}preinscrits` WHERE `id`=%d ;",$id);
$rep_user =  $wpdb->get_results($sql_user );

foreach($rep_user as $user)
{

    $idformation = $user->idformation;


    
    $sql_formations = "SELECT {$wpdb->prefix}formation.*, {$wpdb->prefix}centre_formation.centre, {$wpdb->prefix}discipline.discipline FROM `{$wpdb->prefix}formation` ";
    $sql_formations.= "LEFT JOIN {$wpdb->prefix}discipline ON {$wpdb->prefix}formation.idDiscipline =  {$wpdb->prefix}discipline.id ";
    $sql_formations.= "LEFT JOIN {$wpdb->prefix}centre_formation ON {$wpdb->prefix}formation.idCentre =  {$wpdb->prefix}centre_formation.id"." ";
    $sql_formations.="WHERE {$wpdb->prefix}formation.id = ".$idformation.";";
    $rep_formations=  $wpdb->get_results($sql_formations );

    foreach($rep_formations as $formation)
    {

        $body = "<h1>Inscription à la formation ". $formation ."</h1>";
        $body .= "<p>Vous avez bien été inscrits à la formation ".$formation->discipline." du ".$formation->date_debut." au ".$formation->date_fin." à ".$formation->lieu ."<br /></p>";
        $body.="<p>A bientôt sur ". $_SERVER['HTTP_HOST']."</p>";
        $to = $user->email;

        $subject = 'FNMNS | '. "Inscription";
        $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'BCC: Laurent Tixier <l.tixier@proximitywebpro.fr>;',
        'CC: <riabisoufien@gmail.com>,<fnmns66@gmail.com>;',
        'Reply-To:'.get_bloginfo('name').' <contact@'.$_SERVER['HTTP_HOST'].'>;'
        );

        return wp_mail($to, $subject, $body, $headers);
     }
    }
}
?>
