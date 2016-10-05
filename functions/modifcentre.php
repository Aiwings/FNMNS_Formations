<?php function modif_centre()
{


	if ( isset($_POST['id']))
	{

		if(isset($_POST['nom_centre']) && isset($_POST['adresse_centre']) && isset($_POST['ville_centre'])  && isset($_POST['email_centre']) && isset($_POST['site_centre']) && isset($_POST['cp_centre']) && isset($_POST['tel_centre'])  && isset($_POST['gerant_centre']) && isset($_POST['autre_centre']))
		{
			$centre = htmlspecialchars($_POST['nom_centre']);
			$adresse = htmlspecialchars($_POST['adresse_centre']);
			$ville = htmlspecialchars($_POST['ville_centre']);
			$email = htmlspecialchars($_POST['email_centre']);
			$site = htmlspecialchars($_POST['site_centre']);
			$cp = htmlspecialchars($_POST['cp_centre']);
			$tel =  htmlspecialchars($_POST['tel_centre']);
			$gerant =  htmlspecialchars($_POST['gerant_centre']);
			$autre =  htmlspecialchars($_POST['autre_centre']);

			global $wpdb;

			if($_FILES['image_centre']["name"] == "")
			{

				$sql_update = 'UPDATE `{$wpdb->prefix}centre_formation` SET ';
				$sql_update.= '`centre`="'.$centre.'",';
				$sql_update.= '`adresse`="'.$adresse.'",';
				$sql_update.= '`code_postal`="'.$cp.'",';
				$sql_update.= '`ville`="'.$ville.'",';
				$sql_update.= '`e_mail`="'.$email.'",';
				$sql_update.= '`telephone`="'.$tel.'",';
				$sql_update.= '`site`="'.$site.'",';
				$sql_update.= '`gerant`="'.$gerant.'",';
				$sql_update.= '`autre`="'.$autre.'"';
				$sql_update.= ' WHERE `id`="'.$_POST['id'].'";';
			}
			else
			{

			$image = new Fichier($_FILES['image_centre'],"image");
			$imageResult = $image->fileUpload("centres",'_'.$centre,"");
			$imagename=$image->getName();

				if($imageResult["success"] == "true")
				{
					$sql_update = 'UPDATE `{$wpdb->prefix}centre_formation` SET ';
					$sql_update.= '`centre`="'.$centre.'",';
					$sql_update.= '`adresse`="'.$adresse.'",';
					$sql_update.= '`code_postal`="'.$cp.'",';
					$sql_update.= '`ville`="'.$ville.'",';
					$sql_update.= '`e_mail`="'.$email.'",';
					$sql_update.= '`telephone`="'.$tel.'",';
					$sql_update.= '`image`="'.$imageResult["name"].'",';
					$sql_update.= '`gerant`="'.$gerant.'",';
					$sql_update.= '`autre`="'.$autre.'",';
					$sql_update.= '`site`="'.$site.'"';
					$sql_update.= ' WHERE `id`="'.$_POST['id'].'";';
				}
				else
				{
					echo json_encode($image->getResult());
					exit;
				}
			}
			$resultat = $wpdb->query($sql_update);

			if($resultat ==1 )
			{
				$result = array(
				"success" => "true");
			}
			else
			{
					$result = array(
				"success" => "false",
				"sql" =>$sql_update);
			}

			die( json_encode($result));
		}
	}
	die();
}
?>
