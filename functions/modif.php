<?php function modif_formation()
{
if (  isset( $_POST["id"]) )
{
global $wpdb;
$wpdb->show_errors();
$result ="";
$result_update="";
$tab = array();

if(isset($_POST["date_debut"]))
{
	$result_update = $wpdb->update( "{$wpdb->prefix}formation",
	array(
	'date_debut' => $_POST["date_debut"]
	),
	array( 'id' => $_POST["id"] )
	);
}
if(isset($_POST["date_fin"]))
{
	$result_update = $wpdb->update( "{$wpdb->prefix}formation",
	array(
	'date_fin' => $_POST["date_fin"]
	),
	array( 'id' => $_POST["id"] )
	);
}
if(isset($_POST["lieu"]))
{
	$result_update = $wpdb->update( "{$wpdb->prefix}formation",
	array(
	'lieu' => $_POST["lieu"]
	),
	array( 'id' => $_POST["id"] )
	);
}
if(isset($_POST["departement"]))
{
	$result_update= $wpdb->update( "{$wpdb->prefix}formation",
	array(
	'departement' => $_POST["departement"]
	),
	array( 'id' => $_POST["id"] )
	);
}
if(isset($_FILES["newFile"]) && isset ($_POST["dis"]) && isset ($_POST["debut"]))
{
	try
	{
		$delete = 	delfile( $_POST["id"],0);
		if($delete)
		{
			$newFile = new Fichier($_FILES["newFile"],"pdf");
			$fileresult = $newFile->fileUpload($_POST["dis"],'_'.$_POST["debut"],"");
			if ( $fileresult["success"] == "true")
			{
				$result_update= $wpdb->update( "{$wpdb->prefix}formation",
				array(
				'fichier' => $newFile->getName()
				),
				array( 'id' => $_POST["id"] )
				);
			}
			else
			{
				$result.= $newFile->getResult() ;
			}
		}
		else
		{
			$result = "Impossible de supprimer le fichier" ;
		}
	}
	catch( Exception $e) {
		$result = $e->getMessage();
	}
}

if(isset($_FILES["newInfos"]) && isset ($_POST["dis"]) && isset ($_POST["debut"]))
{
	try
	{
		$delete = 	delfile( $_POST["id"],1);
		$fileresult = fileupload($_FILES["newInfos"],$_POST["dis"],$suf);
		if($delete)
		{
			$suf = $_POST["debut"].'_infos';
			$newInfos = new Fichier($_FILES["newInfos"],"pdf");
			$fileresult = $newInfos->fileUpload($_POST["dis"],'_'.$suf,"");
			if ( $fileresult["success"] == "true" )
			{
				$result_update= $wpdb->update( "{$wpdb->prefix}formation",
				array(
				'infos' => $newInfos->getName()
				),
				array( 'id' => $_POST["id"] )
				);
			}
			else
			{
			$result.= $newInfos->getResult() ;
			}
		}
		else
		{
			$result = "Impossible de supprimer le fichier" ;
		}
	}
	catch( Exception $e) {
		$result = $e->getMessage();
	}
}
if(isset($_POST["discipline"]))
{
	$sql_select = "SELECT * FROM `{$wpdb->prefix}discipline` WHERE `discipline` = '".$_POST["discipline"]."';";
	$reponse_select = $wpdb->get_results($sql_select );
	if ( sizeof($reponse_select) != 1)
	{
		$results_disc = $wpdb->insert(
		"{$wpdb->prefix}discipline",
		array("discipline"=>$_POST["discipline"])
		);

		if($results_disc == 1)
		{
			$sql_discipline = "SELECT id FROM `{$wpdb->prefix}discipline` WHERE `discipline` = '".$_POST["discipline"]."' ;";
			$idDiscipline = $wpdb->get_var($sql_discipline);
			$result_update= $wpdb->update( "{$wpdb->prefix}formation",
				array(
				'idDiscipline' => $idDiscipline
				),
				array( 'id' => $_POST["id"] )
				);
		}
		else
		{
			$result = "Erreur lors de l'ajout d'ajout de discipline";
		}
	}
	else
	{
		foreach ($reponse_select as $row)
		{
			$idDiscipline = $row->id;
			$result_update= $wpdb->update( "{$wpdb->prefix}formation",
				array(
					'idDiscipline' => $idDiscipline
				),
				array( 'id' => $_POST["id"] )
			);
		}
	}
}
if($result=="")
{
if($result_update!= false)
{
$tab = array(
"success" => "true",
"status"=>"ok"
);
}
else
{
$tab = array(
"success" => "false",
"status"=> $wpdb->print_error()
);
}
}else{
$tab = array(
"success" => "false",
"status"=>$result
);
}
wp_send_json($tab);
}
else
{
	die("Pas de champ id");
}

}
?>
