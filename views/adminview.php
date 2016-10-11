<?php class AdminView
{
private $date;
public function __construct()
{
setlocale (LC_ALL,"fr_FR");
$this->date = date("Y-m-d", time());
$this->getRows();
$this->addForm();
$this->popup();
}
private function tabHeaders()
{
?>
<h2>Liste des formations</h2>
<div class="table">
<table id="admin" class="formations">
<tr>
<th width="100px;" >
Contact
</th>
<th width="100px;" >
Formation
</th>
<th width="100px;" >
Infos
</th>
<th style=" width:150px;">
Date de début
</th>
<th style=" width:150px;">
Date de fin
</th>
<th width="200px" >
Lieu
</th>
<th>
<img alt="En Attente" title="En Attente" src="<?php echo FORMATION_URL;?>img/feu_jaune.png" style="width:32px"/>
</th>
<th>
<img alt="Inscrits" title="Inscrits" src="<?php echo FORMATION_URL;?>img/feu_vert.png" style="width:32px"/>
</th>
<th width="100px">
Dept
</th>
<th width="100px">
Fichier
</th>
<th >
X
</th>
</tr>
<?php
}
private function getRows()
{
global $wpdb;
$sql_formations = "SELECT {$wpdb->prefix}formation.*, {$wpdb->prefix}centre_formation.centre, {$wpdb->prefix}discipline.discipline FROM `{$wpdb->prefix}formation` ";
$sql_formations.= "LEFT JOIN {$wpdb->prefix}discipline ON {$wpdb->prefix}formation.idDiscipline =  {$wpdb->prefix}discipline.id ";
$sql_formations.= "LEFT JOIN {$wpdb->prefix}centre_formation ON {$wpdb->prefix}formation.idCentre =  {$wpdb->prefix}centre_formation.id"." ";
$sql_formations.= 'WHERE `date_fin` > "'.$this->date.'" ORDER BY `date_debut`;';
$reponse_formations = $wpdb->get_results($sql_formations );
try
{
if (sizeof($reponse_formations)>= 1)
{
$this->tabHeaders();
$this->displayRows($reponse_formations);
$this->tabEnd();
}
else
{
?>
<h3 style="color:red">Ajouter une Formation</h3>
<?php
}
}
catch( Exception $e)
{
die('Erreur : ' . $e->getMessage());
}
}
private function displayRows($reponse_formations)
{
foreach ($reponse_formations as $row_formations)
{

	$fichier =  str_replace('\\', '', $reponse_formations->fichier);
	$infos =  str_replace('\\', '', $reponse_formations->infos);

?>
<tr id="<?php echo $row_formations->id;?>">
<td  class="centre" id="centre_<?php echo $row_formations->id;?>">
<a onclick="displaywindow(<?php echo $row_formations->idCentre ;?>)">
<?php echo $row_formations->centre; ?>
</a>
</td>
<td >
<p  class="discipline" id="discipline_<?php echo $row_formations->id;?>" onclick="modif(this)">
<?php echo $row_formations->discipline;?>
</p>
</td>
<td style="overflow:hidden;width:100px;">
<p title="<?php echo $infos; ?>" onclick="modif(this)" style="width:120px;height:50px;overflow:hidden;" class="infos" id="infos_<?php echo $row_formations->id;?>">
<?php echo $infos; ?>
</p>
</td>
<td >
<p onclick="modif(this)" class="date_debut" id="date_debut_<?php echo $row_formations->id;?>">
<?php echo strftime("%d/%m/%y",strtotime($row_formations->date_debut)); ?>
</p>
</td>
<td>
<p  onclick="modif(this)" class="date_fin" id="date_fin<?php echo $row_formations->id;?>">
<?php echo strftime("%d/%m/%y",strtotime($row_formations->date_fin)); ?>
</p>
</td>
<td >
<p onclick="modif(this)"  class="lieu" id="lieu_<?php echo $row_formations->id;?>">
<?php echo $row_formations->lieu; ?>
</p>
</td>
<td>
<?php echo searchinscrits($row_formations->id,0) ?>
</td>
<td>
<?php echo searchinscrits($row_formations->id,1) ?>
</td>
<td >
<p onclick="modif(this)" class="departement"  id="departement_<?php echo $row_formations->id;?>" >
<?php echo $row_formations->departement; ?>
</p>
</td>
<td style="overflow:hidden;width:100px;">
<p title="<?php echo $fichier; ?>" onclick="modif(this)" style="width:120px;height:50px;overflow:hidden;" class="fichier" id="fichier_<?php echo $row_formations->id;?>">
<?php echo $fichier; ?>
</p>
</td>
<td>
<a style="cursor:pointer;"onclick="formDelete(<?php echo $row_formations->id; ?>)">X</a>
</td>
<tr>
<?php
}
}
private function tabEnd()
{
?>
</table>
</div>
<?php
}
private function addForm()
{
?>
<h2>Ajouter une formation</h2>
<form name="ajoutForm"enctype="multipart/form-data" method="POST" id="ajoutForm" class="row">
<div class="col-md-3">
<div class="col-md-6" style="overflow:hidden">
<?php echo 	searchcentres(); ?>
</div>
<div class="col-md-6" style="overflow:hidden">
<?php echo 	searchdisciplines(); ?>
</div>
</div>
<div class="col-md-1">
<div class="input-file-container"
<input class="input-file" id="fileInfo"   name="fileInfo" type="file" value="this.value">
<label for="fileInfo" class="input-file-trigger" tabindex="0">Infos...</label>
</div>
<p class="file-return"></p>
</div>
<div class="col-md-2">
<input type="date" required name="date_debut" id="date_debut" style="width:100%" />
</div>
<div class="col-md-2">
<input type="date" required name="date_fin" id="date_fin" style="width:100%"  />
</div>
<div class="col-md-4">
<div class="col-md-5">
<input type="text" required name="lieu"  id="lieu" placeholder="lieu" />
</div>
<div class="col-md-3">
<input type="text" required name="departement" id="departement" placeholder="00" pattern="[0-9]{2}" />
</div>
<div class="col-md-3">
<div class="input-file-container" >
<input class="input-file" id="fichier"  required name="fichier" type="file" value="this.value">
<label for="fichier" class="input-file-trigger" tabindex="0">Fichier...</label>
</div>
<p class="file-return"></p>
</div>
<div class="col-md-1">
<input type="submit" name="add_submit" value="+" />
</div>
</div>
</form>
<p id="response"></p>
<?php
}
private function popup()
{
?>
<div id="modif" class="popup hidden">
<div class="popup-content">
<span class="close" onclick ="hide('modif');">x</span>
<form id="form_modif">
<span></span>
<p style="width:100%;text-align:center;">
<input name="submit" type="submit" value="Valider" />
</p>
</form>
</div>
</div>
<div id="preinscrits" class="popup hidden">
<div class="popup-content">
<span class="close" onclick ="hide('preinscrits');">x</span>
<div id="md_body">
</div>
</div>
</div>
<?php
}
}
?>
