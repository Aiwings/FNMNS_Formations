function modif(el)
{
parent = el.parentNode.parentNode;
var className = jQuery(el).attr('class');

var html ="";
var id= parent.id;
switch(className)
{
case "date_fin":
{
html += "<h2>Modification de la date de fin</h2><br />"
html+= '<p style="width:100%;text-align:center;">';
html += '<input  id="champ"required name="'+className+'" type="date" /><br />';
html += '<input  id="idchamp" name="id"  type="hidden" value="'+id+'"/>';
html += '</p>';
}
break;
case "date_debut":
{
html += "<h2>Modification de la date de d&eacute;but</h2><br />"
html += '<p style="width:100%;text-align:center;">';
html += '<input  id="champ" required name="'+className+'" type="date" /><br />';
html += '<input  id="idchamp" name="id"  type="hidden" value="'+id+'"/>';
html += '</p>';
}
break;
case "fichier":
{	var discipline = jQuery("#discipline_"+id).text().trim();
var debut = jQuery("#date_debut_"+id).text().trim();
var tab = debut.split('/');
debut = tab[0]+'-'+tab[1]+'-'+tab[2];

html += "<h2>Modification du fichier</h2><br/>";
html+= '<p style="width:100%;text-align:center;">';
html += '<input id="champ" required id="field" name="newFile" type="file" /><br />';
html += '<input id="idchamp" name="id"  type="hidden" value="'+id+'"/>';
html += '<input  name="dis" id="dis"  type="hidden" value="'+discipline+'"/>';
html += '<input  name="debut" id="debut"  type="hidden" value="'+debut+'"/>';
html += '</p>';
}
break;
case "infos":
{	var discipline = jQuery("#discipline_"+id).text().trim();
var debut = jQuery("#date_debut_"+id).text().trim();
var tab = debut.split('/');
debut = tab[0]+'-'+tab[1]+'-'+tab[2];

html += "<h2>Modification du fichier</h2><br/>";
html+= '<p style="width:100%;text-align:center;">';
html += '<input id="champ" required id="field" name="newInfos" type="file" /><br />';
html += '<input id="idchamp" name="id"  type="hidden" value="'+id+'"/>';
html += '<input  name="dis" id="dis"  type="hidden" value="'+discipline+'"/>';
html += '<input  name="debut" id="debut"  type="hidden" value="'+debut+'"/>';
html += '</p>';
}
break;
default:
{
html += "<h2>Modification "+className+"</h2><br/>";
html+= '<p style="width:100%;text-align:center;">';
html += '<input id="champ" required name="'+className+'" type="text" placeholder="'+className+'"/><br />';
html += '<input  name="id" id="idchamp"  type="hidden" value="'+id+'"/>';
html += '</p>';
}
break;
}
html+= '<p style="width:100%;text-align:center;">';
html += '</p>';
html += '</form>';
jQuery("#modif").removeClass("hidden");
jQuery("#modif form span").html(html);
var form_modif = document.getElementById("form_modif");
form_modif.onsubmit = modifSubmit;
}
var modifSubmit = function (e)
{
e.preventDefault();
var name = jQuery("#champ").attr("name");
var val = jQuery("#champ").val();
var id = jQuery("#idchamp").val();
if(name == "date_debut" || name == "date_fin")
{
if(!prepareTest(name,id,val))
{
hide("modif");
return;
}
}
var formData = new FormData(this);
formData.append('action', 'modif_formation');
var ajaxRequest = jQuery.ajax( {
url :ajaxurl,
method :"POST",
data : formData,
processData: false,
contentType: false,
}).success(modifSuccess)
.fail(addFail);
}
function modifSuccess(objet){
    console.log(objet);
try
{

if(objet.success == true)
{
var html=' <span style="color :green; font-style:bold;"> ';
html+="Modifications prises en compte";
html+='</span>';
jQuery('#response').html(html);
hide("modif");
alert("Modifications prises en compte")
location.reload();
}
else
{
var html= objet.data.status;
jQuery('#response').html(html);
hide("modif");
}
}
catch(err)
{
console.log(objet);
document.getElementById("response").innerHTML = objet;
}
}
function prepareTest(name,id,val){
if(name == "date_debut")
{	var el = "#date_fin_"+id;
var valeur = jQuery(el).text();
var date_fin = new Date(valeur);
var date_debut = new Date(val);
}
else
{
var el = "#date_debut_"+id;
var valeur = jQuery(el).text();
var date_debut = new Date(valeur);
var date_fin = new Date(val);
}

if(testDate(date_debut,date_fin))
{
return true;
}
else
{
return false;
}
}
function hide(el)
{
if(el == "modif")
{
jQuery("#modif").addClass("hidden");
jQuery("#modif form span").html("");
}
else if (el == 'preinscription')
{
jQuery("#preinscription").addClass("hidden");
jQuery('.related-posts').removeClass("preventClick");
}
else if (el == 'preinscrits') {
jQuery("#preinscrits").addClass("hidden");
jQuery('.related-posts').removeClass("preventClick");
}
}
