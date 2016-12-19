var geocoder;
var map;
var mapurl = '../../../../wp-content/plugins/carte/';
jQuery(document).ready(function(jQuery) {
initMap() ;
});
/******************************/	
/* Initialisation de la carte */
/******************************/	
function initMap() 
{
geocoder = new google.maps.Geocoder();
var mapDiv = document.getElementById('map');
var mapcenter= {};
console.log(ajaxurl);

if(ajaxurl.indexOf("maitre-nageur-sauveteur") != -1)
{
	mapcenter ={lat: 43.3200548, lng: 3.6380331};
}
else
{
	mapcenter ={lat: 48.3058726, lng: 4.9833027};
}

map = new google.maps.Map(mapDiv, {
center: mapcenter,
zoom: 7,
minZoom : 7
});
getRegions();
getPoints();
}
/*****************************************/
/* Geocoding : adresse vers coordonnées  */
/*****************************************/
function codeAddress(adresse,data,then) 
{
	geocoder.geocode( { 'address': adresse}, function(results, status) {
	if (status == google.maps.GeocoderStatus.OK) 
	{
	then(results[0].geometry.location,data);
	} else 
	{
	setTimeout(function(){
		codeAddress(adresse,data,then);
	},10000);
	}
	});
}
/**************************************/
/* Récupération des tracé des régions */
/**************************************/
function getRegions()
{
var ajaxRequest = jQuery.ajax( {
url:ajaxurl,
data:{
action:'poly'
},
dataType:"json"
})
.done(onSuccess)
.fail(onFail);
}
/********************/
/* Success Callback */
/********************/
function onSuccess (data)
{
	
jQuery.each( data, function( index, obj ) 
{	
setPoly(obj);
});
}
/********************/
/* Failure Callback */
/********************/
function onFail(jqXHR, textStatus){
alert( "Request failed: " + textStatus );
	console.log(jqXHR);
}
/********************************************/
/* Mise en Forme en chemin de Polygone Gmap */
/********************************************/
function setPoly(chemin)
{
var poly = [];
jQuery.each( chemin, function( index, point ) 
{
	
var latLng = new google.maps.LatLng(point["lat"], point["lon"]);
poly.push(latLng);
});
tracePoly(poly);
}
/*********************************/
/* Tracé du Polygone Google Maps */
/*********************************/
function tracePoly(poly)
{
	
var polygone = new google.maps.Polygon({
paths: poly,
strokeColor: '#FF0000',
strokeOpacity: 0.5,
strokeWeight: 1,
fillColor: '#FF0000',
fillOpacity: 0.2
});
polygone.setMap(map);
}
