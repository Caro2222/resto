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
"use strict";


var totalPriceDisplay ;

function onBasketAdd(e)
{
    e.preventDefault() ;
    var select = $(this).parents(".order-block").find(".quantity") ;

    let data = {
        id : $(this).data('id'),
        q  : select.val(),
    } ;

    $.getJSON($(this).data('action'), data, onBasketChangeSuccess.bind(this)) ;
}

function onBasketChange(e)
{

    e.preventDefault() ;

    let data = {
        id : $(this).data('id'),
        q  : $(this).val(),
    };
    console.log(data)
    $.getJSON($(this).data('action'), data, onBasketChangeSuccess.bind(this)) ;
}

function onBasketRemoveItem(e)
{
    e.preventDefault() ;

    let data = {
        id : $(this).data('id'),
    } ;

    $.getJSON($(this).data('action'), data, onBasketChangeSuccess.bind(this)) ;
}


function onBasketChangeSuccess(data)
{

    console.log("changeS")
    if(data.success)
    {
        if(data.todo)
        {
            if(data.todo == "delete")
            {
                let container = $(this).parents(".removableContainer");
                container.fadeOut("slow", function()
                {
                    container.remove() ;
                }) ;
                let priceToRemove = parseFloat(container.find(".subTotalPrice").text()) ;
                let newTotalPrice = totalPriceDisplay.text() - priceToRemove ;
                totalPriceDisplay.text(newTotalPrice.toFixed(2)) ;

            }


            if(data.todo == "updateQuantity")
            {
                console.log("d")
                let container = $(this).parents(".removableContainer");
                let subTotalDisplay = container.find(".subTotalPrice") ;
                let oldSubtotal = parseFloat(subTotalDisplay.text()) ;
                let priceEach = parseFloat(container.find(".priceEach").text()) ;
                let newSubTotal = parseInt(data.quantity) * priceEach ;
                let newTotalPrice = totalPriceDisplay.text() - oldSubtotal + newSubTotal ;

                container.find(".quantityOrdered").val(data.quantity) ;
                subTotalDisplay.text(newSubTotal.toFixed(2)) ;
                totalPriceDisplay.text(newTotalPrice.toFixed(2)) ;

            }
        }

    }
    else
    {
        if(data.redirect)
        {
            window.location.href = data.redirect ;
        }
    }


    if(data.message)
    {
        alert(data.message) ;
    }
}





$(function()
{


    $(".remove-button").on("click",removeAJAX);
    $(".btnEntree").on("click",displayEntree);
    $(".btnplat").on("click",displayPlat);
    $(".btnDessert").on("click",displayDessert);

    totalPriceDisplay = $("#totalPrice");
    $(".add-to-basket").on("click", onBasketAdd);
    $(".update-basket-line").on("click", onBasketChange);
    $(".delete-basket-item").on("click", onBasketRemoveItem);

    // $(".flashbag").fadeOut(10000);

    $('#datetimepicker6').datetimepicker({
        format: 'YYYY.MM.DD',
        locale:'fr',


    });


}) ;