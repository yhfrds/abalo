"use strict";
let removeCartItemButtons = document.getElementsByClassName('cart-item-remove');
if (removeCartItemButtons.length != 0) {
    for (var i = 0; i < removeCartItemButton; i++) {
        var button = removeCartItemButtons[i];
        /*button.addEventListener('click', removeItem(button));*/
        /*button.addEventListener('click', api_RemoveItemClicked(button));*/
    }
}

var addToCartButtons = document.getElementsByClassName('shop-item-button');
for (var i = 0; i < addToCartButtons.length; i++) {
    debugger;
    let button = addToCartButtons[i];
    button.addEventListener('click', addToCartClicked);
    button.addEventListener('click', api_AddToCartClicked);
}
//===========================================================================================================
//Aufgabe 10 b)
function api_AddToCartClicked(event) {
    debugger;
    event.preventDefault();
    var button = event.target;
    var shopItem = button.parentElement.parentElement;

    //Infos vom gewählten Item
    let itemId = shopItem.getElementsByClassName('artikelId')[0].innerText;
    let itemName = shopItem.getElementsByClassName('artikelName')[0].innerText;
    let itemCreatorId = shopItem.getElementsByClassName('artikelCreatorId')[0].innerText;

    //Infos vom Warenkorb owner
    let shoppingcartCreatorId = getCookie('user_cookie_consent');

    api_Add_Shoppingcart_and_item(itemId, shoppingcartCreatorId);
    console.log(itemName, itemId, itemCreatorId, "shoppingcartCreatorId : " + shoppingcartCreatorId);
}

function api_Add_Shoppingcart_and_item(itemId, shoppingcartCreatorId) {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                console.log(xhr.responseText);
            }
            if (xhr.status == 404) {
                console.log('File or resource not found');
            }
        }
    }
    let toSend = {
        ab_creator_id: shoppingcartCreatorId,
        ab_createdate: new Date().toUTCString(),
        ab_article_id: itemId
    }
    const jsonString = JSON.stringify(toSend);
    xhr.open('post', '/api/shoppingcart', true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(jsonString);
}

//==========================================================================================================
//Aufgabe 10c)
function api_RemoveItemClicked(button) {
    //Infos von zu löschendem Item
    let articleId = button.parentElement.getAttribute('articleId');

    //Infos vom Warenkorb owner
    let shoppingcartCreatorId = getCookie('user_cookie_consent');
    let shoppingcartID = getCookie('shoppingcart_id');
    api_delete_item_in_shoppingcart(articleId, shoppingcartCreatorId, shoppingcartID);
    removeItem(button);
}

function api_delete_item_in_shoppingcart(articleId, shoppingcartCreatorId, shoppingcartID) {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                console.log(xhr.responseText);
            }
            if (xhr.status == 404) {
                console.log('File or resource not found');
            }
        }
    }

    let toSend = {
        ab_creator_id: shoppingcartCreatorId,
        ab_article_id: articleId
    }
    const jsonString = JSON.stringify(toSend);
    xhr.open('delete', '/api/shoppingcart/'+shoppingcartID+'/articles/'+articleId, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(jsonString);
}

//==========================================================================================================
function addToCartClicked(event) {
    event.preventDefault();
    var button = event.target;
    var shopItem = button.parentElement.parentElement;
    var articleId = shopItem.getElementsByClassName('artikelId')[0].innerText;
    var check = shopItem.getElementsByClassName('artikelName')[0];
    var name = check.innerText;
    var price = shopItem.getElementsByClassName('artikelPrice')[0].innerText;
    var creatorId = shopItem.getElementsByClassName('artikelCreatorId')[0].innerText;
    var description = shopItem.getElementsByClassName('artikelDescription')[0].innerText;
    var imageSrc = shopItem.getElementsByClassName('artikelImg')[0].src;
    console.log(articleId, name, price, imageSrc);

    //Ajax send data
    /* let shoppingcartOwner = getCookie('user_cookie_consent');
     sendData(shoppingcartOwner);*/
    addItemToCart(name, price, imageSrc, articleId);
}

function addItemToCart(name, price, imageSrc, articleId) {
    document.getElementById('shopping-cart').classList.remove('hidden');
    var cartRow = document.createElement('div');
    cartRow.classList.add('cart-row');
    var cartItems = document.getElementsByClassName('cart-items')[0];


    var cartItemsNames = cartItems.getElementsByClassName('cart-item-name');
    for (var i = 0; i < cartItemsNames.length; i++) {
        if (cartItemsNames[i].innerHTML == name) {
            alert('der Artikel ist bereits in den Warenkorb hinzugefügt');
            return; /*das Hinzufügen wird geskippt*/
        }
    }

    var cartRowContents = `
            <input type="hidden" value="${articleId}"> <!--add hidden article id here, so that we know which article should be deleted-->
            <h3 class="cart-item-name">${name}</h3>
            <img class="cart-item-image" src="${imageSrc}" width="75px" height="50px"><br>
            <span class="cart-item-price">${price} €</span><br>
            <button class="cart-item-remove" type="button" onclick="api_RemoveItemClicked(this)">-</button>
    `;

    cartRow.innerHTML = cartRowContents;
    cartRow.setAttribute('articleId', articleId); //this attribute for deleting the article later
    cartItems.append(cartRow);
    document.getElementsByClassName('navigation')[0].append(cartItems);
}

function removeItem(button) {
    button.parentElement.remove();
}


