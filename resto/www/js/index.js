"use strict";


//
 //requireFields.each(function () {
//     if($(this).val().trim().length ==0)
//     {
//         $(this.sibling.val().trim())
//     }
//
// })

function removeAJAX()
{
    let platData = { id : $(this).data('id')} ;
    $.getJSON($(this).data('action'), platData, onRemoveSucces.bind(this));

}

function onRemoveSucces()
{
    $(this).parents(".plat-container").fadeOut("slow");
}

function displayEntree()
{
    $(".entree").show();
    $(".dessert").hide();
    $(".plat").hide();
}
function displayPlat()
{

    $(".plat").show();
    $(".dessert").hide();
    $(".entree").hide();
}
function displayDessert()
{
    $(".dessert").show();

    $(".entree").hide();
    $(".plat").hide();
}



$(function()
{
    $('#datetimepicker6').datetimepicker({
        format: 'YYYY.MM.DD',
        locale:'fr',

        // disabledDates: [
        //     moment("12/25/2013"),
        //     new Date(2013, 11 - 1, 21),
        //     "11/22/2013 "
        // ]
    });

    $(".remove-button").on("click",removeAJAX);
    $(".btnEntree").on("click",displayEntree);
    $(".btnplat").on("click",displayPlat);
    $(".btnDessert").on("click",displayDessert);

    // $(".flashbag").fadeOut(10000);



}) ;