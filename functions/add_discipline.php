<?php function ajout_discipline()
{
	if ( isset($_POST["discipline"]))
	{

		global $wpdb;
		$wpdb->show_errors();

		$sql_select = "SELECT * FROM `{$wpdb->prefix}discipline` WHERE `discipline` = '".$_POST["discipline"]."';";

		$reponse_select = $wpdb->get_results($sql_select );

		 if (sizeof($reponse_select) != 1)
		{


			$results_add = $wpdb->insert("{$wpdb->prefix}discipline",array(

					"discipline"=>$_POST["discipline"]
				));

			if($results_add ==1)
			{
				$sql_select = "SELECT * FROM `{$wpdb->prefix}discipline` WHERE `discipline` = '".$_POST["discipline"]."';";


				$reponse_select = $wpdb->get_results($sql_select );


				 if (sizeof($reponse_select)== 1)
					{
						foreach ($reponse_select as $row)
						{
								$result = array(
									"success" => "true",
									"id" => $row->id,
									"discipline" => $_POST["discipline"]
									);

						}

					}
			}
			else
			{
				$result = array(
				"success" => "false",
				"sql" =>$wpdb->print_error()
				);

			}

		}
		else
		{
			$result = array(
				"success" => "alreadyexists",
				"sql" =>$wpdb->print_error()
				);

		}
			echo json_encode($result) ;


	}
		die();
}
?>
