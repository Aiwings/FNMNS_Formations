<?php 
function inscription()
{
	if( isset($_POST['id']))
	{
		global $wpdb;

		$reponse_inscrire = $wpdb->update( 
					'preinscrits', 
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
			$result=array(
				"success"=> "true"
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
		echo json_encode($result);
	}
	die();
}	
?>