jQuery(".postid-95").ready(function(){
var discipline = document.getElementById("discipline");
if(discipline){
discipline.onchange = function(){
if (discipline.value == "add")
{
addPopup();
}
}
}
var ajoutForm = document.getElementById("ajoutForm");
if(ajoutForm) ajoutForm.onsubmit = startAdd;
});
var startAdd = function (e)
{
e.preventDefault();
var formData = new FormData(this);
// Display the values
formData.append('name', 'ajout_formation');
formData.append('action', 'ajout_formation');
var date_debut = new Date(jQuery("#date_debut").val());
var date_fin = new Date(jQuery("#date_fin").val());
if( testDate(date_debut,date_fin))
{
var ajaxRequest = jQuery.ajax(
{
url : ajaxurl,
method :"POST",
data : formData,
processData: false,
contentType: false,
}).done(addSuccess)
.fail(addFail);
}
}
function testDate(date_debut,date_fin)
{
var date = new Date();
if(date_debut.getTime() > date_fin.getTime())
{
var html=' <span style="color :red; font-style:bold;"> ';
html+="Erreur ! La date de d&eacute;but est sup&eacute;rieure &agrave; la date de fin";
html+='</span>';
jQuery('#response').html(html);
return false;
}
//if(date_debut.getTime() == date_fin.getTime())
//{
//var html=' <span style="color :red; font-style:bold;"> ';
//html+="La formation doit &ecirc;tre sur plusieurs jours";
//html+='</span>';
//jQuery('#response').html(html);
//return false;
//}
if(date_debut.getTime() <= date.getTime())
{
var html=' <span style="color :red; font-style:bold;"> ';
html+="Veuillez saisir une date de d&eacute;but sup&eacute;rieure &agrave; la date d'aujourd'huis";
html+='</span>';
jQuery('#response').html(html);
return false;
}
return true;
}
function addSuccess(data){

try {
jQuery('#response').html(data.text);
if(data.success == "true")
{
alert("La formation a bien été ajoutée");
location.reload();
}
}
catch(e){
console.log(data);
jQuery('#response').html(data);
}
}
function addFail(jqXHR, textStatus){
alert( "Request failed: " + textStatus );
}
function addPopup()
{
var newDiscipline = prompt("Saisir la nouvelle discipline", "");
if (newDiscipline) {
addDiscipline(newDiscipline)
}
}
function addDiscipline(discipline)
{
var data = {
action: 'ajout_discipline',
discipline :discipline
};

var ajaxRequest = jQuery.ajax( {
url : ajaxurl,
method :"POST",
data : data,
datatype:"json"
}).done(afterDisCreation)
.fail(onDisFail);
}
function afterDisCreation(data)
{

try
{

if (data.success == "true")
{
var option= '<option selected value="'+data.id+'" > '+objet.discipline+'</option>';
console.log(option);
jQuery("#discipline").html(option);
}
}
catch(e){
console.log(data);
jQuery('#response').html(data);
}
}
function onDisFail(jqXHR, textStatus){
alert( "Request failed: " + textStatus );
}
function formDelete(id)
{
var data ={
action:'form_delete',
id:id
};
var ajaxRequest = jQuery.ajax( {
url :ajaxurl,
method :"POST",
data : data,
datatype:"json"
}).done(onDelete)
.fail(onDisFail);
}
function onDelete(data)
{
try
{


if(data.success == "true")
{
jQuery("#".id).html("");
var html = '<span style="color:green;">';
html+= 'La formation a bien été supprimée';
html+='</span>';
alert("La formation a bien été supprimée");
location.reload();
}
else
{
var html = '<span style="color:red;">';
html+= 'Désolé , il y a eu une erreur lors de la suppression <br />' + data.status;
html+='</span>';
}
jQuery('#response').html(html);
}
catch(err)
{
console.log(data);
document.getElementById("response").innerHTML = data;
}
}
function displaywindow(id)
{
}
