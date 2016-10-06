function getPoints()
{

var ajaxRequest = jQuery.ajax( {
url :ajaxurl,
data:{
action :'carte_centres'
},
dataType : "JSON"
}).done(onReceipt)
.fail(onRecepFail);


}

function onReceipt(data)
{	
for(var i =0; i< data.length ;i++)
{

var adresse = data[i].adresse + " "+ data[i].ville;

codeAddress(adresse,data[i],function(result,data)
{
var centre = data.centre;
var id = data.id;

createMarker(centre,result,id);
});
}
}

function onRecepFail()
{

}


/*******************************************/
/********** Création du Marqueur ***********/
/* Récupération du contenu de l'InfoWindow */
/***** Ajout de L'evênementt on click ******/
/*******************************************/
function createMarker(title,place,id)
{
var image = {
url : imageurl +'bleu.png',
size: new google.maps.Size(21, 33)

};
var marker = new google.maps.Marker({
map: map,
position: place,
id:id,
title :title,
icon :image ,
checked :false
});


var ajaxRequest = jQuery.ajax( {
url :ajaxurl,
data : {
action:'infowindow',
id:id
},
method :"POST",
dataType:"html"
})
.done(function(contentString){


var infowindow = new google.maps.InfoWindow({
content: contentString


});

marker.addListener('click', function() 
{


if(!marker.checked)
{
infowindow.open(map, marker);
marker.checked = ! marker.checked;
}
else
{
infowindow.close(map, marker);
marker.checked = ! marker.checked;
}
});

})
.fail(onFail);
}