<?php function searchdisciplines()
{
global $wpdb;
$sql_disciplines ="SELECT * FROM `{$wpdb->prefix}discipline`";
$disciplines ="";
$disciplines.= '<select id="discipline" required name="discipline" style="width:100%">';
$disciplines.= '<option value="" selected>Formation</option>';
$disciplines.= '<option value="add">Ajouter... </option>';
$results = $wpdb->get_results($sql_disciplines);
if (sizeof($results) >= 1)
{
foreach($results as $row)
{
$disciplines.= '<option value="'.$row->id.'">'. $row->discipline.'</option>';
}
$disciplines.= '</select>';
}
return $disciplines;
}
?>
