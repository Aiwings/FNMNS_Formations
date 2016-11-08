window.onload = function(){
var form = document.getElementById("centre");
jQuery("select option:selected").val("");
if(form){
form.onsubmit = function (e){
e.preventDefault();
if( document.getElementById('select') )
{
if(document.getElementById('select').checked)
{
sendChanges(false);
}
else
{
sendChanges(true);
}
}
else
{
sendChanges(true);
}
var editor = tinymce.get( 'autre-centre' );
}
jQuery("#image-centre").val("");
var centre = document.getElementById('centre-formation');
jQuery("#title").css("color","red");
centre.onchange = onChangeCentres;
jQuery('input[name=select]').change(function(){
var choix =  jQuery('input[name=select]:checked').val();
if(choix == "select")
{
if(jQuery("select option:selected").val() != "")
{
jQuery("#title").html("Modification du centre");
jQuery("#title").css("color","blue");
}
else
{
jQuery("#title").html("Veuillez Selectionner un Centre");
jQuery("#title").css("color","red");
}
}
else
{
jQuery("#title").html("Création d'un nouveau centre");
jQuery("#title").css("color","blue");
}
});
}
function onChangeCentres(){
if (jQuery("#nom-centre") )
{
if(jQuery("select option:selected").val() != "")
{
var id =jQuery("select option:selected").val()
html = ' <input type="hidden" value="'+id+'" name="id" />';
jQuery("#centre span").html(html)
jQuery("#title").html("Modification du centre");
jQuery("#title").css("color","green");
var data = {
action : "select_centres",
id : jQuery("select option:selected").val()
};
var ajaxRequest = jQuery.ajax( {
url : ajaxurl,
method : 'POST',
data : data ,
datatype:"json"
}).done(FillInputs)
.fail(onCreationFail);
}
}
}
function FillInputs(object)
{
try{
jQuery("#nom-centre").val(object.centre);
jQuery("#adresse-centre").val(object.adresse);
jQuery("#cp-centre").val(object.cp);
jQuery("#ville-centre").val(object.ville);
jQuery("#site-centre").val(object.site);
jQuery("#email-centre").val(object.email);
jQuery("#tel-centre").val(object.tel);
jQuery("#gerant-centre").val(object.gerant);
jQuery("#image-centre").val("");
//jQuery("#tinymce p").text(object.autre);
var content=object.autre;
if( typeof tinymce != "undefined" ) {
var editor = tinymce.get( 'autre-centre' );
if( editor && editor instanceof tinymce.Editor ) {
editor.setContent( content, {format : 'html'} );
}
}
}
catch(e){
console.log(e.message);
console.log(object);
}
}
function sendChanges(add)
{
if(jQuery("#nom-centre").val() && jQuery("#adresse-centre").val() && jQuery("#ville-centre").val() && jQuery("#email-centre").val())
{
var form = document.getElementById("centre");
console.log(form);
var formData = new FormData(form);
if (add)
{
formData.append('action', 'ajout_centre');
}
else if (jQuery("select option:selected").val() != "")
{
formData.append('action', 'modif_centre');
}
var ajaxRequest = jQuery.ajax( {
url :ajaxurl,
method :"POST",
data : formData,
processData: false,
contentType: false,
}).done(onCreationSuccess)
.fail(onCreationFail);
}
}
function onCreationSuccess(objet)
{
try
{
if(objet.success == true)
{
jQuery("#title").html("Changements pris en compte ");
jQuery("#title").css("color","green");
alert("Changements pris en compte");
location.reload();
}
}
catch(err)
{
console.log(objet);
alert(err.message);
}
}
function onCreationFail(jqXHR, textStatus){
alert( "Request failed: " + textStatus );
}
}
