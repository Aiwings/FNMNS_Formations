<?php function sendmail($nom,$formation)
{
$body = "<h1> Pré-inscription pour la formation ". $formation ."</h1>";
$body .= "<p>L'utilisateur ". $nom." a fournit les pièces requises  pour l'inscription</p>";

$to = "jmartin34@orange.fr";

$subject = 'FNMNS | '. "Inscription";
$headers = array(
'Content-Type: text/html; charset=UTF-8',
'BCC: Laurent Tixier <l.tixier@proximitywebpro.fr>;',
'CC: <riabisoufien@gmail.com>,<fnmns66@gmail.com>;',
'Reply-To:'.get_bloginfo('name').' <contact@'.$_SERVER['HTTP_HOST'].'>;'
);

return wp_mail($to, $subject, $body, $headers);


}
?>