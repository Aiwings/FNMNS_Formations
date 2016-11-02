<?php
//Envoi des coordonnées du Tracé des Régions
function poly()
{
$polys = array();
foreach (glob(__DIR__.'/poly/'."*.poly") as $filename)
{
$handle = fopen($filename, 'r');
if($handle)
{
$poly = array();
while (!feof($handle))
{
$ligne = fgets($handle);
if($ligne !=="")
{
if(trim($ligne)!="none" && trim($ligne)!="1" )
{
$point = explode("   ",$ligne);
if(count($point) == 3)
{
$lat = trim($point[2]);
$lon = trim($point[1]);
$poly[] = array(
"lat" =>  $lat,
"lon" =>  $lon
);
}
}
}
}
$polys[] = $poly;
}
}
 wp_send_json($polys);

}
?>
