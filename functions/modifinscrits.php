<?php
function modif_inscrits()
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
				$result= array(
					"success"=>"true"
				);
			}
			else
			{
				$wpdb->show_errors();
				$result=array(
					"success"=> "false",
					"status" => $wpdb->print_error()
				);
			}
		}
		catch( Exception $e) {

				$result= array(
					"success"=>"false",
					"status"=>$e->getMessage()
				);



			die('Erreur : ' . $e->getMessage());
		}

	}
	else
	{
			$result= array(
					"success"=>"false",
					"status"=>"Pas de id"
				);
	}
	echo json_encode($result);
	die();
}
?>
