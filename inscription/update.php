<?php function update()
{
try
{
$nom =   htmlspecialchars ( $_POST["nom"] );
$prenom = substr ($_POST["prenom"],0,1);
$nom = $nom .$prenom ;
$formation = htmlspecialchars ($_POST["formation"]);
$date_naissance =  htmlspecialchars ( $_POST["date_naissance"] );
$lieu_naissance =  htmlspecialchars (  $_POST["lieu_naissance"] );
$paiement =  htmlspecialchars (  $_POST["paiement"] );
$diplome = "";
$no_diplome ="";
$date_diplome ="";
$dr_delivrance="";
if(isset($_POST["diplome"]))
{
$diplome =  htmlspecialchars ( $_POST["diplome"]);
}
if(isset($_POST["no_diplome"]))
{
$no_diplome =  htmlspecialchars ( $_POST["no_diplome"]);
}
if(isset($_POST["date_diplome"]))
{
$date_diplome =  htmlspecialchars ( $_POST["date_diplome"]);
}
if(isset($_POST["dr_delivrance"]))
{
$dr_delivrance =  htmlspecialchars ( $_POST["dr_delivrance"]);
}
}
catch (Exception $e)
{
die( 'Exception reçue : '.  $e->getMessage(). "\n");
}
$carte = new Fichier($_FILES["carte"],"pdf");
$carteOk = $carte->fileUpload("inscriptions","",$formation."_".$nom."_CI_");
if($carteOk["success"] !="true") {errors($carte);}
$certif = new Fichier($_FILES["certif"],"pdf");
$certifOk = $certif->fileUpload("inscriptions","",$formation."_".$nom."_certif_");
if($certifOk["success"] !="true") {errors($certif);  }
$assurance = new Fichier($_FILES["assurance"],"pdf");
$assuranceOk = $assurance->fileUpload("inscriptions","",$formation."_".$nom."_assurance_");
if($assuranceOk["success"] !="true") {errors($assurance); }
$defense = new Fichier($_FILES["defense"],"pdf");
$defenseOk = $defense->fileUpload("inscriptions","",$formation."_".$nom."_defense_");
if($defenseOk["success"] !="true") {errors($defense);  }
$hasdocs = false ;
for ($i=1;$i<=7;$i++)
{
$document = $_FILES["doc".$i];
if( $document["name"]!="")
{
$hasdocs = true ;
$doc = new Fichier($document,"pdf");
$docOk = $doc->fileUpload("inscriptions","",$formation."_".$nom."_doc".$i."_");
if($docOk["success"] !="true") {errors($doc); exit(1); }
}
}


$update =array(
'date_naissance' => $date_naissance,
'lieu_naissance' => $lieu_naissance,
'paiement' => $paiement,
'diplome' => $diplome,
'no_diplome' => $no_diplome,
'date_diplome' => $date_diplome,
'dr_delivrance' => $dr_delivrance,
'carte' => $carte->getName(),
'assurance' => $assurance->getName(),
'defense' => $defense->getName(),
'certif' => $certif->getName(),
);

global $wpdb;
$wpdb->show_errors();
$reponse_modif =  $wpdb->update(
"{$wpdb->prefix}preinscrits",$update
,
array( 'id' => $_POST['userID'] ),
array(
'%s',	// value1
'%s',
'%s',
'%s',	// value2
'%s',
'%s',
'%s',
'%s',
'%s',
'%s',
'%s'
),
array( '%d' )
);
if($reponse_modif == 1)// will die() true if succefull else it will die() false
{
    if(sendmail($nom,$formation))
    {
        wp_send_json_success();
    }
    else{
        wp_send_json_error("Echec de l'envoi du mail");
    }

}
else
{
$result= array(
"status"=>$wpdb->print_error()
);
}
wp_send_json_error($result);
}
function errors($file)
{
$result = array (
"status" =>$file->getResult(),
"file" => $file->getName()
);
wp_send_json_error($result);
}
?>
