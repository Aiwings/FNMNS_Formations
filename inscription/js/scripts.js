
jQuery("document").ready(function($){
    
    $(".obligatoire").css("border-color","red");
     $(".obligatoire").css("border-style","solid");
      $(".obligatoire").css("border-width","1px");

  $('input[type="file"]').change(function() {
    var fieldset = this.parentNode.parentNode;
      
      if(this.files[0].name !="") 
        $(fieldset).css("border-color","green");
        $(fieldset).append(this.files[0].name);

    });
    $("#poursuite").submit(onSubmit);

    $('#date_naissance').change(function() 
    {
        var d = new Date(this.value);
        var age = getAge(d);
        $("#age").val(age);
    });



});
function getAge(la_date)
{
    return parseInt(Math.floor( new Date().getTime()-la_date.getTime()) / (365.24*24*3600*1000)) ;
}


function onSubmit()
{
    var formData = new FormData(this);
    formData.append('action','update');

    var ajaxRequest = jQuery.ajax( {
        url :ajaxurl,
        method :"POST",
        data : formData,
        processData: false,
        contentType: false,

            }).done(onInscription)
            .fail(onInscriptionFail); 
 return false;
}
function onInscription(data)
{
    console.log(data);
    try{
        var objet = json.Parse(data);

        if(objet.success == "true")
        {
            alert("Merci , vos informations ont bien été transmises !");
            jQuery("#result").html("Merci , vos informations ont bien été transmises !")
        }
        else {
             jQuery("#result").html(object.status);
        }
    }
    catch(e){
         jQuery("#result").html(data);
    }

}

function onInscriptionFail(jqXHR, textStatus)
{
    alert( "Request failed: " + textStatus );
}