<?php 
function delfile($id,$mode)
	{
		$target_dir="";
		$target_file="";

		global $wpdb;
		
		$sql_formations = "SELECT formation.*, centre_formation.centre, discipline.discipline FROM `formation` ";
		$sql_formations.= 'LEFT JOIN discipline ON formation.idDiscipline =  discipline.id ';
		$sql_formations.= 'LEFT JOIN centre_formation ON formation.idCentre =  centre_formation.id'." ";
		$sql_formations.='WHERE formation.id = "'.$id.'";';
		
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
	