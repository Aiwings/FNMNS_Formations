<?php function delfile($id,$mode)
	{
		$target_dir="";
		$target_file="";

		global $wpdb;

		$sql_formations = "SELECT {$wpdb->prefix}formation.*, {$wpdb->prefix}centre_formation.centre, {$wpdb->prefix}discipline.discipline FROM `{$wpdb->prefix}formation` ";
		$sql_formations.= "LEFT JOIN {$wpdb->prefix}discipline ON {$wpdb->prefix}formation.idDiscipline =  {$wpdb->prefix}discipline.id ";
		$sql_formations.= "LEFT JOIN {$wpdb->prefix}centre_formation ON {$wpdb->prefix}formation.idCentre =  {$wpdb->prefix}centre_formation.id"." ";
		$sql_formations.="WHERE {$wpdb->prefix}formation.id = '".$id."';";

		$reponse = $wpdb->get_results($sql_formations );

		foreach ($reponse as $row)
		{
			$target_dir = ABSPATH ."/export/".$row->discipline ."/" ;

			if($mode==0)
			{
				$target_file =  $target_dir . $row->fichier;
			}
			else
			{
				if($row->infos!==""){
					$target_file =  $target_dir . $row->infos;
				}
				else
				{
					return true;
				}
			}

		}

		return unlink($target_file);

	}
?>
