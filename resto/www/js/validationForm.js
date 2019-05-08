"use strict";


//
//requireFields.each(function () {
//     if($(this).val().trim().length ==0)
//     {
//         $(this.sibling.val().trim())
//     }
//
// })

function resetError()
{
    $('.red').text('');
}

function validationText()
{
    resetError();
    if($(this).val().trim().length < 5) {
        $(this).after("<p class='red'>Ce champ doit contenir 5 caractéres</p>")
    }
}


function validation(event)
{

    resetError();
    var requireFields= $(".inputRequired");
    requireFields.each(function () {
        if (($(this).val().trim().length == 0)) {

            ($(this)).after("<p class='red'>Veuillez remplir ce champ</p>");

            $('.red').fadeOut(10000);
            event.preventDefault();

        }
    })
}
function validationEmail()
{
  resetError();
  if($(this).val().trim().length !== /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/)
  {
      ($(this)).after("<p class='red'>Ceci n'est  pas un email</p>");
  }
}

$(function()
{
    $('input[type="email"]').on("blur",validationEmail);
    $('textarea').on("blur",validationText);
    $("form").on("submit",validation);

});