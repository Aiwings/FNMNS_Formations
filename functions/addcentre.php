<?php

function ajout_centre()
{

	if(isset($_POST['nom_centre']) && isset($_POST['adresse_centre']) && isset($_POST['ville_centre'])  && isset($_POST['email_centre'])  && isset($_POST['tel_centre'])&& isset($_POST['gerant_centre'])  )
	{
		$centre = htmlspecialchars($_POST['nom_centre']);
		$adresse = htmlspecialchars($_POST['adresse_centre']);
		$ville = htmlspecialchars($_POST['ville_centre']);
		$email = htmlspecialchars($_POST['email_centre']);
		$tel = htmlspecialchars($_POST['tel_centre']);
		$gerant = htmlspecialchars($_POST['gerant_centre']);


		if(isset($_POST['site_centre']))
		{
			$site = htmlspecialchars($_POST['site_centre']);
		}
		else
		{
			$site ="";
		}


		if(isset($_POST['cp_centre']))
		{
			$cp = htmlspecialchars($_POST['cp_centre']);
		}
		else
		{
			$cp ="";
		}

		if(isset($_POST['autre_centre']))
		{
			$autre = htmlspecialchars($_POST['autre_centre']);
		}
		else
		{
			$autre ="";
		}

		global $wpdb;
		$wpdb->show_errors();
		$insert	= array
				(
					'centre' => $centre,
					'adresse' =>$adresse,
					'code_postal' =>$cp,
					'ville' =>$ville,
					'e_mail' =>$email,
					'site' =>$site,
					'telephone' =>$tel,
					'gerant' =>$gerant,
					'autre' =>$autre,
				);

		if($_FILES['image_centre']["name"]!="")
		{
			$image = new Fichier($_FILES['image_centre'],"image");
			$imageResult = $image->fileUpload("centres",'_'.$centre,"");
			$imagename=$image->getName();

			if($imageResult["success"] == "true")
			{
				$insert['image'] = $imageResult["name"];
			}
			else
			{
				echo json_encode($image->getResult());
				exit;
			}
		}



		$resultat = $wpdb->insert("{$wpdb->prefix}centre_formation", $insert);


		if($resultat == 1)
			{
				$result = array(
				"success" => "true");
			}
			else
			{
				$result = array(
					"success" => "false",
					"status" =>$wpdb->print_error()
					);
			}

			echo json_encode($result) ;

		}
	die();
}
?>
