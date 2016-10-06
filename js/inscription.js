function preinscription(id)
{
var loadRequest = jQuery('#md_body').load(
ajaxurl,
{
action :'form_inscription'
}
,function(){
var idformation = document.getElementById("idformation");
idformation.value = id;
var date_debut = jQuery("#date_debut_"+id).text();
var date_fin = jQuery("#date_fin_"+id).text();
var discipline = jQuery("#discipline_"+id).text();
var html = "Preinscription a la formation"+discipline+"du "+date_debut +" au "+ date_fin;
jQuery("#preinscription_form h2").html(html);
});
jQuery('.related-posts').addClass("preventClick");
jQuery("#preinscription").removeClass("hidden");
var preinscription = document.getElementById("preinscription");
preinscription.onsubmit = preinscrire;
}
var preinscrire = function(e){
e.preventDefault();
var form = document.getElementById("preinscription_form");
var formData = new FormData(form);
formData.append('action', 'preinscrire');
var ajaxRequest = jQuery.ajax( {
url :ajaxurl,
method :"POST",
data : formData,
processData: false,
contentType: false,
}).done(onPreinscription)
.fail(addFail);
};
function onPreinscription(data)
{
try
{
var object = JSON.parse(data);
if(object.success == "true")
{
var html = '<span style="color:green;">'
html+= 'Merci , Votre pré-inscription a bien été prise en compte <br />';
html+= 'Vous pouvez accèder au dossier de préinscription en cliquant ';
html+= '<a  href="'+object.url+'" target="_blank" title="dossier de préinscription ">ici</a>';
html+='</span>';
}
else
{
var html = '<span style="color:red;">'
html+= 'Désolé , il y a eu une erreur dans la procédure de préinscription <br />' + object.status;
html+='</span>';
}
jQuery("#response").html(html);
hide("preinscription");
}
catch(err)
{
console.log(data);
console.log(err.message);
hide("preinscription");
document.getElementById("response").innerHTML = data;
}
}
function inscrits(id){
var loadRequest = jQuery('#md_body').load(
ajaxurl,
{
action : 'inscrits',
idformation:id,
inscrit:1,
}
,function(){
var modif_pre = document.getElementsByName('modif_pre');
for (var i= 0; i < modif_pre.length; i++)
{
modif_pre[i].onsubmit = modifPre;
}
});
jQuery('.related-posts').addClass("preventClick");
jQuery("#preinscrits").removeClass("hidden");
}
function preinscrits(id){
var loadRequest = jQuery('#md_body').load(
ajaxurl,
{
action: 'inscrits',
inscrit:0,
idformation:id
}
,function(){
var modif_pre = document.getElementsByName('modif_pre');
for (var i= 0; i < modif_pre.length; i++)
{
modif_pre[i].onsubmit = modifPre;
}
});
jQuery('.related-posts').addClass("preventClick");
jQuery("#preinscrits").removeClass("hidden");
}
var modifPre = function(e)
{
e.preventDefault();
var formData = new FormData(this);
formData.append('action', 'modif_inscrits');
var ajaxRequest = jQuery.ajax( {
url:ajaxurl,
method :"POST",
data : formData,
processData: false,
contentType: false,
}).done(onModifPre)
.fail(onModifPreFail);
};
function onModifPre(data){
try
{
var object = JSON.parse(data);
if(object.success == "true")
{
location.reload();
}
}
catch(err)
{
console.log(data);
console.log(err.message);
hide("preinscription");
document.getElementById("response").innerHTML = data;
}
}
function inscrire(id)
{
var data = {
id:id,
action:'inscription'
};
var ajaxRequest = jQuery.ajax( {
url :ajaxurl,
dataType : "JSON",
method :"POST",
data : data
}).done(onInscription)
.fail(onInscriptionFail);
}
function onModifPreFail(jqXHR, textStatus){
alert( "Request failed: " + textStatus );
}
function onInscriptionFail(jqXHR, textStatus){
alert( "Request failed: " + textStatus );
}
function onInscription(data)
{
try
{
//	var object = JSON.parse(data);
if(data.success == "true")
{
location.reload();
}
}
catch(err)
{
console.log(err.message);
hide("preinscription");
document.getElementById("response").innerHTML = data;
}
}
function exporter(idformation, estinscrit)
{
var data = {
idformation:idformation,
inscrit:estinscrit,
action:'export'
};
var ajaxRequest = jQuery.ajax( {
url :ajaxurl,
method :"POST",
data : data
}).done(onExport)
.fail(onExportFail);
}
function pieces(idformation,estinscrit)
{
var data = {
idformation:idformation,
inscrit:estinscrit,
action:'pieces'
};
var ajaxRequest = jQuery.ajax( {
url :ajaxurl,
method :"POST",
dataType : "html",
data : data
}).done(onPieces)
.fail(onPiecesFail);
}
function onPieces(data){
jQuery('#results').html(data);
var id = jQuery('#idformation').html();
jQuery('#suite').text("retour");
jQuery('#suite').attr( 'title', 'Retour aux champs' );
jQuery('#suite').attr( "onclick",'preinscrits('+id+')' );
}
function onPiecesFail(jqXHR, textStatus){
alert( "Request failed: " + textStatus );
}
function onExport(data){
var url = data;
location.href=url;
}
function onExportFail(jqXHR, textStatus){
alert( "Request failed: " + textStatus );
}
