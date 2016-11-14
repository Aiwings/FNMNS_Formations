<?php function inscription_form()
{
if(isset($_GET['userID']) && isset($_GET['formationID']))
{
$userID = $_GET['userID'];
$formationID = $_GET['formationID'];
$formation =select("formationID");
$user = select("userID");
?>
<form method="post" enctype="multipart/form-data" name="poursuite"  id="poursuite">
<input type="hidden" name="nom" id="nom" value="<?php echo $user->nom; ?>" />
<input type="hidden" name="prenom" id="prenom" value="<?php echo $user->prenom; ?>" />
<input type="hidden" name="formation" id="formation" value="<?php echo $formation->discipline."_".$formation->date_debut; ?>" />
<input type="hidden" name="userID" id="userID" value="<?php echo $user->id; ?>" />
<div class="header">
<h1>
Formulaire d'inscription <br />
<small><?php echo $user->nom ." ". $user->prenom ; ?><br />
pour la formation du<?php echo strftime("%d/%m/%y",strtotime($formation->date_debut)) ." au ". strftime("%d/%m/%y",strtotime($formation->date_fin)) ; ?>
</small>
</h1>
<br />
<p>
<span style="color:#B40404;">Important</span>
Les Fichiers à transmettre doivent impérativement être au format pdf et avoir une taille inférieure à 3Mo
</p>
<br />
</div>
<div class="row">
<fieldset class="form-group ">
<label for="date_naissance">Date de Naissance *</label>
<input type="date"  name="date_naissance" id="date_naissance" class="form-control" required />
<input type="hidden" name="age" id="age" />
</fieldset>
<fieldset class="form-group ">
<label for="lieu_naissance">Lieu de Naissance *</label>
<input type="text"  name="lieu_naissance" id="lieu_naissance" class="form-control" required />
</fieldset>
<fieldset class="form-group ">
<label for="paiement">Moyen de Paiement *</label>
<select name="paiement" id="paiement" required style="margin:0;height: auto;">
<option selected value=""></option>
<option value="Individuel">Individuel</option>
<option value="Pris en charge">Pris en charge</option>
</select>
</fieldset>
</div>
<div class="row">
<h2>Diplôme éventuels</h2><br />
<div class="col-md-3" style="overflow:hidden">
<fieldset class="form-group  ">
<label for="diplome">Diplôme </label>
<input type="text"  name="diplome" id="diplome" class="form-control"  />
</fieldset>
</div>
<div class="col-md-3" style="overflow:hidden">
<fieldset class="form-group ">
<label for="no_diplome">N° de Diplôme </label>
<input type="text"  name="no_diplome" id="no_diplome" class="form-control"  />
</fieldset>
</div>
<div class="col-md-3" style="overflow:hidden">
<fieldset class="form-group ">
<label for="date_diplome">Date de diplome </label>
<input type="date"  name="date_diplome" id="date_diplome" class="form-control" />
</fieldset>
</div>
<div class="col-md-3" style="overflow:hidden">
<fieldset class="form-group ">
<label for="dr_delivrance">DR de délivrance</label>
<input type="text"  name="dr_delivrance" id="dr_delivrance" class="form-control"  />
</fieldset>
</div>
</div>
<div class="row">
<h2>Documents administratifs obligatoires</h2><br />
<div class="col-md-3" style="overflow:hidden">
<fieldset class="form-group obligatoire ">
<p style="line-height:25px;">Carte d'identité (recto verso) ou passeport *</p>
<div class="input">
<input type="file" name="carte" id="carte" required />
</div>
</fieldset>
</div>
<div class="col-md-3" style="overflow:hidden">
<fieldset class="form-group obligatoire ">
<p>Certificat Médical *</p>
<div class="input">
<input type="file" name="certif" id="certif" required />
</div>
</fieldset>
</div>
<div class="col-md-3" style="overflow:hidden">
<fieldset class="form-group obligatoire">
<p style="line-height:25px;" >Justificatif d'assurance maladie *</p>
<div class="input">
<input type="file" name="assurance" id="assurance" required />
</div>
</fieldset>
</div>
<div class="col-md-3" style="overflow:hidden">
<fieldset class="form-group obligatoire">
<p>Attestation de recensement *</p>
<div class="input">
<input type="file" name="defense" id="defense" required />
</div>
</fieldset>
</div>
</div>
<h2>Documents complémentaires</h2><br />
<div class="row">
<div class="col-md-3" style="overflow:hidden">
<fieldset class="form-group options ">
<p>document 1</p>
<div class="input">
<input type="file" name="doc1" id="doc1"  />
</div>
</fieldset>
</div>
<div class="col-md-3" style="overflow:hidden">
<fieldset class="form-group options ">
<p>document 2</p>
<div class="input">
<input type="file" name="doc2" id="doc2"  />
</div>
</fieldset>
</div>
<div class="col-md-3" style="overflow:hidden">
<fieldset class="form-group options">
<p>document 3</p>
<div class="input">
<input type="file" name="doc3" id="doc3"  />
</div>
</fieldset>
</div>
<div class="col-md-3" style="overflow:hidden">
<fieldset class="form-group options">
<p>document 4</p>
<div class="input">
<input type="file" name="doc4" id="doc4"  />
</div>
</fieldset>
</div>
</div>
<div class="row">
<div class="col-md-4" style="overflow:hidden">
<fieldset class="form-group options">
<p>document 5</p>
<div class="input">
<input type="file" name="doc5" id="doc5"  />
</div>
</fieldset>
</div>
<div class="col-md-4" style="overflow:hidden">
<fieldset class="form-group options">
<p>document 6</p>
<div class="input">
<input type="file" name="doc6" id="doc6"  />
</div>
</fieldset>
</div>
<div class="col-md-4" style="overflow:hidden">
<fieldset class="form-group options">
<p>document 7</p>
<div class="input">
<input type="file" name="doc7" id="doc7"  />
</div>
</fieldset>
</div>
</div>
<p id="result"></p>
<input type="submit" name="inscrire" id="inscrire" value="Transmettre" />
</form>
<?php
}
}
function select($item)
{
$table="";
$col="";
global $wpdb;
$wpdb->show_errors();
$sql_select ="";
switch($item)
{
case "userID" :
$sql_select ="SELECT * FROM {$wpdb->prefix}preinscrits WHERE id = ".$_GET['userID'].";";
break;
case "formationID" :
$sql_select = "SELECT {$wpdb->prefix}formation.*, {$wpdb->prefix}centre_formation.centre, {$wpdb->prefix}discipline.discipline FROM `{$wpdb->prefix}formation` ";
$sql_select.= "LEFT JOIN {$wpdb->prefix}discipline ON {$wpdb->prefix}formation.idDiscipline =  {$wpdb->prefix}discipline.id ";
$sql_select.= "LEFT JOIN {$wpdb->prefix}centre_formation ON {$wpdb->prefix}formation.idCentre =  {$wpdb->prefix}centre_formation.id"." ";
$sql_select.="WHERE {$wpdb->prefix}formation.id = ".$_GET['formationID'].";";
break ;
}
try{
$reponse =  $wpdb->get_results($sql_select );
if(sizeof($reponse)==1)
{
foreach($reponse as $resultat)
{
return $resultat;
}
}
else
{
throw new Exception("L'element ".$item." est introuvable");
}
}
catch (Exception $e)
{
echo 'Exception reçue : ',  $e->getMessage(), "\n";
exit(1);
}
}
?>
