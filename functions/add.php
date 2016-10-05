<?php function ajout_formation()
{

	$textresult ="";
	$success ="false";
	$html="";
	$fileInfo="";
	$discipline="";
	$sql_insert ="";
	$filename="";
	$infoname="";

	if(  $_FILES["fichier"]["name"] !="" && isset($_POST["discipline"]) && $_POST["discipline"] != "add" )
	{

		global $wpdb;
		$sql_discipline = "SELECT discipline FROM `{$wpdb->prefix}discipline` WHERE `id` = '".$_POST["discipline"]."' ;";

		$discipline = $wpdb->get_var($sql_discipline);



			if(isset($_FILES["fileInfo"]) && $_FILES["fileInfo"]["name"] !="")
			{
				$suf = '_'.$_POST['date_debut'].'_infos';


					$fileInfo = new Fichier($_FILES["fileInfo"],"pdf");
					$inforesult = $fileInfo->fileUpload($discipline,$suf,"");
					$infoname=$fileInfo->getName();
			}



				$file = new Fichier($_FILES["fichier"],"pdf");
				$fileresult = $file->fileUpload($discipline,'_'.$_POST['date_debut'],"");
				$filename=$file->getName();


			if ( $fileresult["success"] =="true" )
			{

				$wpdb->show_errors();
				$results_add = $wpdb->insert("{$wpdb->prefix}formation",array(

					"idDiscipline"=>$_POST["discipline"],
					"date_debut"=>$_POST["date_debut"],
					"date_fin"=>$_POST["date_fin"],
					"idCentre"=>$_POST["centre-formation"],
					"departement"=>$_POST["departement"],
					"fichier"=>$filename,
					"lieu"=>$_POST["lieu"],
					"infos"=>$infoname
				)
				);

				 if($results_add ==1)
				{
						$textresult.= "<span style=\"color:#2CA86A\">Le fichier a bien été mis en ligne <br /> La Formation a bien été ajoutée</span>";
						$success = "true";
				}
				else
				{
					$textresult.= "<span style=\"color:#FF0000\">Erreur dans le traitement de la requête SQL =".$wpdb->print_error()."</span>";
				}
			}
			else
			{
				$textresult.= "erreur transfert de ficher".$fileresult["status"];
			}
	}
	else
	{
		if(isset($_POST['add_submit']))	$textresult.= "<span style=\"color:#FF0000\">Erreur : Paramètres Manquants</span>";

	}


	$tab = array(
		"text"=>$textresult,
		"success"=>$success
	);

	die( json_encode($tab ));
}
?>
