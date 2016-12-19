<?php function inscrits()
{
setlocale (LC_TIME, 'fr_FR.utf8','fra');
global $wpdb;
try {
$sql_formations = "SELECT {$wpdb->prefix}formation.*, {$wpdb->prefix}centre_formation.centre, {$wpdb->prefix}discipline.discipline FROM `{$wpdb->prefix}formation` ";
$sql_formations.= "LEFT JOIN {$wpdb->prefix}discipline ON {$wpdb->prefix}formation.idDiscipline =  {$wpdb->prefix}discipline.id ";
$sql_formations.= "LEFT JOIN {$wpdb->prefix}centre_formation ON {$wpdb->prefix}formation.idCentre =  {$wpdb->prefix}centre_formation.id"." ";
$sql_formations.= "WHERE {$wpdb->prefix}formation.id = '".$_POST['idformation']."';";
$formation = array();
$reponse_formation = $wpdb->get_results($sql_formations );
foreach ($reponse_formation as $row)
{
$formation = $row;
}
$sql_preinscrits ="SELECT * FROM `{$wpdb->prefix}preinscrits` WHERE `idformation` = '".$_POST['idformation']."' AND `estinscrit` = '".$_POST["inscrit"]."';";
$reponse_inscrits  = $wpdb->get_results($sql_preinscrits );
if( sizeof($reponse_inscrits)>=1)
{
?>
<h2>
<?php
if($_POST["inscrit"] == 1)
{
echo "Inscrits";
}
else
{
echo "Pré-inscrits";
}
echo  " a la formation ".$formation->discipline." ". strftime("du %A %d %B %Y" , strtotime( $formation->date_debut ))." ".strftime("au %A %d %B %Y" , strtotime($formation->date_fin ))."  a ".$formation->lieu." (".$formation->departement .")";
?>
</h2>
<div style="padding-left:5%;padding-bottom:20px;" id ="export" class="row">
<span style="display:none" id="idformation"><?php echo $_POST['idformation'] ?></span>
<a href="#" onclick="exporter(<?php echo $_POST['idformation'] ?>,<?php echo $_POST['inscrit'] ?>);"  title="Exporter au format Excel" >
Exporter au format Excel
</a>
<a href="#" id='suite' onclick="pieces(<?php echo $_POST['idformation'] ?>,<?php echo $_POST['inscrit'] ?>);"  title="Pièces requises" style="padding-left:15px;"  >
Afficher les pièces requises
</a>
</div>
<div id="results">
<div class="row" >
<div class="col-md-<?php echo 1+ $_POST["inscrit"]; ?>">
Nom
</div>
<div class="col-md-1">
Prenom
</div>
<div class="col-md-2">
E-mail
</div>
<div class="col-md-1">
Telephone
</div>
<div class="col-md-2">
Adresse1
</div>
<div class="col-md-1">
Adresse2
</div>
<div class="col-md-1">
CP
</div>
<div class="col-md-1">
Ville
</div>
<div class="col-md-1">
</div>
</div>
<?php
foreach ($reponse_inscrits as $preinscrit)
{
    $warningclass = "";
if(($preinscrit->carte  =="") ||($preinscrit->certif  =="") || ($preinscrit->carte  =="") || ($preinscrit->assurance =="") || ($preinscrit->defense  ==""))
{
    $warningclass = "warning";
}



?>
<div class="row" >
<form name="modif_pre">
<div class="col-md-<?php echo 1+ $_POST["inscrit"]; ?>">
<input type="text"  name="nom" value="<?php echo $preinscrit->nom; ?>"  />
</div>
<div class="col-md-1">
<input type="text" name="prenom" value="<?php echo $preinscrit->prenom; ?>"  />
</div>
<div class="col-md-2">
<input type="email"  name="email" value="<?php echo $preinscrit->email; ?>"  />
</div>
<div class="col-md-1">
<input type="tel"  name="telephone" value="0<?php echo $preinscrit->telephone; ?>"  />
</div>
<div class="col-md-2">
<input type="text"  name="adresse1" value="<?php echo $preinscrit->adresse1; ?>"  />
</div>
<div class="col-md-1">
<input type="text"  name="adresse2" value="<?php echo $preinscrit->adresse2; ?>"  />
</div>
<div class="col-md-1">
<input type="text"  name="cp" value="<?php echo $preinscrit->cp; ?>"  />
</div>
<div class="col-md-1">
<input type="text"  name="ville" value="<?php echo $preinscrit->ville; ?>"  />
</div>
<div class="col-md-1">
<input  type="submit" name="modif" value="Modifier" />
</div>
<?php if($_POST["inscrit"]== 0)
{
?>
<div class="col-md-1">
<img id="inscrire_buttn" style="width:30px;cursor:pointer;" class="<?php echo $warningclass;?>" src="<?php echo FORMATION_URL;?>img/feu_vert.png" alt="inscrire"  onclick ="inscrire(<?php echo $preinscrit->id; ?>);"title="inscrire" />
</div>
<?php
}
?>
<input type="hidden" id="id" name="id" value="<?php echo $preinscrit->id; ?>" />
</form>
</div>
</tr>
<?php	} 		?>
</div>
<?php
}
else
{	?>
<p> il n'y a pas encore d'inscrits &agrave; ce jour</p>
<?php
}
}
catch( Exception $e) {
die('Erreur : ' . $e->getMessage());
}
die();
}
?>
