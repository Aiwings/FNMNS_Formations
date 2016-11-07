<?php function pieces()
{
setlocale (LC_TIME, 'fr_FR.utf8','fra');
global $wpdb;
$url =  get_bloginfo('home');
$urldocs = $url."/export/inscriptions/";
$pathdocs = ABSPATH."export/inscriptions/";
$sql_preinscrits ="SELECT * FROM `{$wpdb->prefix}preinscrits` WHERE `idformation` = '".$_POST['idformation']."' AND `estinscrit` = '".$_POST["inscrit"]."';";
$reponse_inscrits  = $wpdb->get_results($sql_preinscrits );
?>
<div class="row">
<div class="col-md-2">
Nom prenom
</div>
<div class="col-md-2">
Carte d'identité
</div>
<div class="col-md-2">
Certificat Médical
</div>
<div class="col-md-2">
Contrat Assurance
</div>
<div class="col-md-2">
Appel à la défense
</div>
<div class="col-md2">
Autres documents
</div>
</div>
<?php
if( sizeof($reponse_inscrits)>=1)
{
foreach($reponse_inscrits as $inscrit)
{
?>
<div class="row">
<div class="col-md-2">
<?php
echo $inscrit->nom .' '.$inscrit->prenom
?>
</div>
<div class="col-md-2">
<?php if(isset($inscrit->carte)) {
echo '<a href="'.$urldocs.$inscrit->carte.'" target="_blank">Carte d\'identité</a>';}
else{
echo 'Carte non présente';
}
?>
</div>
<div class="col-md-2">
<?php if (isset($inscrit->certif)){
echo '<a href="'.$urldocs.$inscrit->certif.'"target="_blank">Certificat médical</a>';}
else{
echo 'Certificat non présent';
}
?>
</div>
<div class="col-md-2">
<?php if (isset($inscrit->assurance)){
echo '<a href="'.$urldocs.$inscrit->assurance.'"target="_blank">Contrat d\'assurance</a>';}
else{
echo 'Assurance non présente';
}
?>
</div>
<div class="col-md-2">
<?php if (isset($inscrit->defense)){
echo '<a href="'.$urldocs.$inscrit->defense.'"target="_blank">Recensement</a>';}
else{
echo 'Recensement non présent';
}
?>
</div>
<div class="col-md-2">
<?php
$docs = array();
$suf = $inscrit->nom . substr ($inscrit->prenom,0,1).'_doc';
foreach (glob($pathdocs."*.pdf") as $filename)
{
if(strrpos($filename,$suf ) != false)
{
$docs[] = $filename;
}
}
$i =1;
if(sizeof($docs) != 0)
{
foreach($docs as $doc)
{
?>
<a href="<?php echo $urldocs.$doc; ?>" target="_blank"> document<?php echo $i;$i++;?></a> ,
<?php
}
}
else
{
echo "Pas de documents additionnels";
}
?>
</div>
</div>
<?php
}
}
die();
}
?>
