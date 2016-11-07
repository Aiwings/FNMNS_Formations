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

		$update = array(
					"centre" => $centre,
					"adresse"=>$adresse,
					"$code_postal"=> $cp,
					"ville"=>$ville,
					"e_mail"=>$email,
					"telephone"=>$tel,
					"site"=>$site,
					"gerant"=>$gerant,
					"autre"=>$autre
				);
				
		if(!$_FILES['image_centre']["name"] == "")
		{
			
		$image = new Fichier($_FILES['image_centre'],"image");
		$imageResult = $image->fileUpload("centres",'_'.$centre,"");
		$imagename=$image->getName();
		if($imageResult["success"] == "true")
		{
			$update["image"] = $imageResult["name"];
		}
		else
		{
			wp_send_json_error(array("status"=>$image->getResult()));
		}
		}
			$resultat = $wpdb->update( "{$wpdb->prefix}centre_formation",
			$update,
			array( 'id' => $_POST["id"] )
			);	
		if($resultat ==1 )
		{
			wp_send_json_success();
		}
		else
		{
			wp_send_json_error(array("status"=>$sql_update));
		}
	}
	else{
		die();
	}

}
}
?>
