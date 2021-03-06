<?php function preinscrire()
{
if (isset($_POST['idformation']))
{
try
{
global $wpdb;
$wpdb->show_errors();
$titre = htmlspecialchars($_POST['titre']);
$nom = htmlspecialchars($_POST['nom']);
$prenom = htmlspecialchars($_POST['prenom']);
$email = htmlspecialchars($_POST['email']);
$tel = htmlspecialchars($_POST['tel']);
$adresse1 = htmlspecialchars($_POST['adresse1']);
$adresse2 = htmlspecialchars($_POST['adresse2']);
$cp = htmlspecialchars($_POST['cp']);
$ville = htmlspecialchars($_POST['ville']);
$formationid =trim ( $_POST['idformation']);
$resultat = $wpdb->insert(
"{$wpdb->prefix}preinscrits",
array(
'titre' => $titre,
'nom' => $nom,
'prenom' => $prenom,
'adresse1' => $adresse1,
'adresse2' => $adresse2,
'cp' => $cp,
'ville' => $ville,
'telephone' => $tel,
'email' => $email,
'idformation' => $formationid,
)
);
if($resultat != false )
{
$sql_formations = "SELECT {$wpdb->prefix}formation.*, {$wpdb->prefix}centre_formation.centre, {$wpdb->prefix}discipline.discipline FROM `{$wpdb->prefix}formation` ";
$sql_formations.= "LEFT JOIN {$wpdb->prefix}discipline ON {$wpdb->prefix}formation.idDiscipline =  {$wpdb->prefix}discipline.id ";
$sql_formations.= "LEFT JOIN {$wpdb->prefix}centre_formation ON {$wpdb->prefix}formation.idCentre =  {$wpdb->prefix}centre_formation.id"." ";
$sql_formations.="WHERE {$wpdb->prefix}formation.id = ".$formationid.";";
$reponse =  $wpdb->get_results($sql_formations );
foreach ($reponse as $formation)
{
$sql_user= $wpdb->prepare( "SELECT * FROM `{$wpdb->prefix}preinscrits` WHERE `nom`=%s AND `prenom`=%s AND `idformation` = %d;",$nom,$prenom,$_POST['idformation']);
$rep_user =  $wpdb->get_results($sql_user );
foreach ($rep_user as $user)
{
if(send($formation,$user))
{
$fichier =  str_replace('\\', '', $formation->fichier);
$url =  "http://".$_SERVER['HTTP_HOST'];
$urlfichier = $url."/export/".$formation->discipline.'/'.$fichier;


$data = array(
"status" =>"Message Envoyé",
"url"=> $urlfichier
);
wp_send_json_success( $data);
}
else
{
throw new Exception('Message Non Envoyé');
}
}
}
}
else
{
throw new Exception('Pas de résultat. $sql_formation');
}
}
catch( Exception $e) {
wp_send_json_error(array("status"=>'Exception reçue : '.  $e->getMessage(). "\n") );
}
}
}
function send($formation,$user)
{
$fichier =  str_replace('\\', '', $formation->fichier);
//require_once( ABSPATH . 'wp-content/plugins/phpmailer/class.phpmailer.php');
date_default_timezone_set('Europe/Paris');
// echo "//Rentre dans la fonction";
$page = get_page_by_title( 'Inscription' );
$dir = ABSPATH;
$url =  "http://".$_SERVER['HTTP_HOST'];
$urlfichier = $url."/export/".$formation->discipline.'/'.$fichier;
$urlupload = $url.'/?page_id='.$page->ID.'&userID='.$user->id.'&formationID='.$formation->id;
$textMessage = "Nous vous remercions pour votre pré-inscription pour la formation ".$formation->discipline." du ".$formation->date_debut." au ".$formation->date_fin." à ".$formation->lieu ."<br />";
$textMessage .= "Vous trouverez ici le lien vers le dossier de préinscription";
$textMessage .= $dir."/export/".$formation->discipline.'/'.$fichier;
$textMessage .=" Vous pouvez nous transmettre les pièces requises à l'adresse";
$textMessage .= $urlupload;
$textMessage .= "A bientôt sur ".$url;
$body = '<h1> Pré-inscription pour la formation '.$formation->discipline.'</h1>';
$body .= '<p>Nous vous remercions pour votre pré-inscription pour la formation <br /> <strong> '.$formation->discipline.' du '.$formation->date_debut.' au '.$formation->date_fin.' à '.$formation->lieu.'</strong><br /></p>';
$body .= '<p>Vous trouverez ici le lien vers le dossier de préinscription <br /><br /></p>';
$body .= '<p>Merci de bien vouloir nous transmettre les pièces requises en cliquant ';
$body .= '<a href="'.$urlupload.'">sur ce lien </a></p><br />';
$body .= '<a href="'.$urlfichier.'">';
$body .= $urlfichier.'</a>' ;
$body .= "<p>A bientôt sur ". $_SERVER['HTTP_HOST']."</p>";
//$mail = new PHPMailer();
//$mail->CharSet = "utf-8";
//$mail->Debugoutput = 'html';
//$mail->AddAddress($_POST["email"]);
$to = $_POST["email"];
//$mail->AddReplyTo("contact@".$_SERVER['HTTP_HOST'],get_bloginfo('name'));
//$mail->SetFrom( 'preinscription@'.$_SERVER['HTTP_HOST'],get_bloginfo('name'));
//$mail->AddBCC('guilhemrr@hotmail.com');
//$mail->Subject = 'FNMNS | '. "Préinscription";
$subject = 'FNMNS | '. "Préinscription";

if(strrpos($_SERVER['HTTP_HOST'],"maitre-nageur-sauveteur" ) != false)
{
    $headers = array(
    'Content-Type: text/html; charset=UTF-8',
    'BCC: Laurent Tixier <l.tixier@proximitywebpro.fr>;',
    'CC: <riabisoufien@gmail.com>,<jmartin34@orange.fr>,<fnmns66@gmail.com>;',
    'Reply-To:'.get_bloginfo('name').' <contact@'.$_SERVER['HTTP_HOST'].'>;'
    );
}
else
{
      $headers = array(
    'Content-Type: text/html; charset=UTF-8',
    'BCC: Laurent Tixier <l.tixier@proximitywebpro.fr>;',
    'CC: <crf.fnmns@gmail.com>;',
    'Reply-To:'.get_bloginfo('name').' <contact@'.$_SERVER['HTTP_HOST'].'>;'
    );
}

//$mail->msgHTML($body);
$attachments = array(ABSPATH."/export/".$formation->discipline."/".$formation->fichier);
//$mail->AddAttachment(ABSPATH."/export/".$formation->discipline."/".$formation->fichier);
//$mail->AltBody  =  $textMessage;
// If email has been process for sending, display a success message
return wp_mail($to, $subject, $body, $headers,$attachments);
}
?>