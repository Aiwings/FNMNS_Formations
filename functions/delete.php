<?php 

function form_delete()
{


	if(isset($_POST["id"]))
	{
		global $wpdb;

		try
		{
			if(delfile($_POST["id"],0) == true)
			{
				$resultat = $wpdb->delete( 'formation', array( 'id' => $_POST["id"] ) );
			
		
				if($resultat ==1 )
				{
					$result = array(
							"success" => "true"
							);
				}
				else 
				{	
					$result = array(
							"success" => "false",
							"status" => ""
							);
					
				}
			
				echo json_encode($result);
			}
			else
			{
				$result = array(
							"success" => "false",
							"status" => "Impossible de supprimer le fichier"
							);
			}
		}
		catch( Exception $e) {
		
			
			$result = array(
				"success" => "false",
				"status" =>"$e->getMessage()");
			
				echo json_encode($result);
		}
		
	}
		die();
}
	
	
	
?>