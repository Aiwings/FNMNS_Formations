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
	map = new google.maps.Map(mapDiv, {
	center: {lat: 48.7765707, lng: 6.1474792},
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
		console.log("Geocode was not successful for the following reason: " + status);
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















