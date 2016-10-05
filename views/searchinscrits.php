<?php
function searchinscrits($id,$inscrit)
{

global $wpdb;

if($inscrit == 0)
{
	$sql_preinscrits ="SELECT * FROM `{$wpdb->prefix}preinscrits` WHERE `idformation`= '".$id."' AND estinscrit='0';";
	$results_pre = $wpdb->get_results($sql_preinscrits);

	if (sizeof($results_pre)>= 1)
	{
		$preinscrits= '<a onclick="preinscrits('.$id.');" title="Pr&eacute;-inscrits">';
		$preinscrits.='<img src="'.FORMATION_URL.'img/feu_jaune.png" alt="pr&eacute;-inscrits" style="width:28px;cursor:pointer;" />';
		$preinscrits.= '</a>';
		return $preinscrits;
	}
	else
	{
		return "<img src=\"".FORMATION_URL."img/cross.png\" style=\"width:20px;\" alt=\"pas de pr&eacute;inscrits\" />";
	}
}
else
{
	$sql_inscrits ="SELECT * FROM `{$wpdb->prefix}preinscrits` WHERE `idformation`= '".$id."' AND estinscrit='1';";

	$results_ins = $wpdb->get_results($sql_inscrits);

	if (sizeof($results_ins) >= 1)
	{
		$inscrits= '<a onclick="inscrits('.$id.');" title="inscrits">';
		$inscrits.='<img src="'.FORMATION_URL.'img/feu_vert.png" alt="inscrits" style="width:28px;cursor:pointer;" />';
		$inscrits.= '</a>';
		return $inscrits;
	}
	else
	{
		return "<img src=\"".FORMATION_URL."img/cross.png\" style=\"width:20px;\" alt=\"pas d'inscrits\" />";
	}
}

}
?>
