<?phpfunction form_delete()
{
	if(isset($_POST["id"]))
	{
		global $wpdb;

		try
		{
			if(delfile($_POST["id"],0) == true)
			{
				$resultat = $wpdb->delete("{$wpdb->prefix}formation", array( 'id' => $_POST["id"] ) );


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
			}
			else
			{
				$result = array(
							"success" => "false",
							"status" => "Impossible de supprimer le fichier"
							);

			}
			die( json_encode($result));
		}
		catch( Exception $e) {


			$result = array(
				"success" => "false",
				"status" =>"$e->getMessage()");

				die( json_encode($result));
		}

	}

}
?>
