"use strict";

let divArticleForm = document.createElement("div");
divArticleForm.setAttribute("id", "divArticleForm");
divArticleForm.setAttribute("class", "article__div");
document.getElementById("article").appendChild(divArticleForm);

//Form
let articleForm = document.createElement("form");
articleForm.setAttribute("action", "articles");
articleForm.setAttribute("method", "post");
articleForm.setAttribute("id", "articleForm");
articleForm.setAttribute("class", "article__form");
document.getElementById("divArticleForm").appendChild(articleForm);

//Messages
let msgElement = document.createElement('div');
msgElement.setAttribute('id', "msgForm");
msgElement.setAttribute('class', "success__div--active msg");
document.getElementById('divArticleForm').appendChild(msgElement);

let msgUl = document.createElement('div');
msgElement.setAttribute('id', "UlMsgForm");
msgElement.setAttribute('class', "success__div--active msg");
document.getElementById('divArticleForm').appendChild(msgUl);

//Titel
let title = document.createElement("div");
title.setAttribute("id", "title");
document.getElementById("articleForm").appendChild(title);

let h2Titel = document.createElement("h2");
h2Titel.setAttribute("id", "h2Titel");
h2Titel.innerHTML = "Artikel Einfügen";
document.getElementById("title").appendChild(h2Titel);

//Article Name
let setArticle = document.createElement("div");
setArticle.setAttribute("id", "setArticle");
setArticle.setAttribute("class", "input-edit");
document.getElementById("articleForm").appendChild(setArticle);

let pArticle = document.createElement("p");
pArticle.setAttribute("id", "pArticle");
pArticle.innerHTML = "Artikel:";
document.getElementById("setArticle").appendChild(pArticle);

let inputArticle = document.createElement("input");
inputArticle.setAttribute("id", "name");
inputArticle.setAttribute("type", "text");
inputArticle.setAttribute("name", "name");
inputArticle.setAttribute("placeholder", "Bitte geben Sie die Artikel name ein.");
document.getElementById("setArticle").appendChild(inputArticle);

let divErrorMsgArticle = document.createElement("div");
divErrorMsgArticle.setAttribute("id", "divErrorMsgArticle");
divErrorMsgArticle.setAttribute("class", "error__div");
document.getElementById("setArticle").appendChild(divErrorMsgArticle);

let spanArticle = document.createElement("span");
spanArticle.setAttribute("id", "name-error error-text");
spanArticle.setAttribute("class", "error__div__span--active");
document.getElementById("divErrorMsgArticle").appendChild(spanArticle);

//Article Price
let setPrice = document.createElement("div");
setPrice.setAttribute("id", "setPrice");
setPrice.setAttribute("class", "input-edit");
document.getElementById("articleForm").appendChild(setPrice);

let pPrice = document.createElement("p");
pPrice.setAttribute("id", "pPrice");
pPrice.innerHTML = "Preis:";
document.getElementById("setPrice").appendChild(pPrice);

let inputPrice = document.createElement("input");
inputPrice.setAttribute("id", "price");
inputPrice.setAttribute("type", "text");
inputPrice.setAttribute("name", "price");
inputPrice.setAttribute("placeholder", "Bitte geben Sie die Preis ein.");
document.getElementById("setPrice").appendChild(inputPrice);

let divErrorMsg = document.createElement("div");
divErrorMsg.setAttribute("id", "divErrorMsg");
divErrorMsg.setAttribute("class", "error__div");
document.getElementById("setPrice").appendChild(divErrorMsg);

let spanPrice = document.createElement("span");
spanPrice.setAttribute("id", "price-error error-text");
spanPrice.setAttribute("class", "error__div__span--active");
document.getElementById("divErrorMsg").appendChild(spanPrice);

//Article Description
let setDescription = document.createElement("div");
setDescription.setAttribute("id", "setDescription");
setDescription.setAttribute("class", "input-edit");
document.getElementById("articleForm").appendChild(setDescription);

let pDescription = document.createElement("p");
pDescription.setAttribute("id", "pPrice");
pDescription.innerHTML = "Beschreibung:";
document.getElementById("setDescription").appendChild(pDescription);

let inputDescription = document.createElement("input");
inputDescription.setAttribute("id", "description");
inputDescription.setAttribute("type", "text");
inputDescription.setAttribute("name", "description");
inputDescription.setAttribute("placeholder", "Beschreiben Sie Ihr Wunschartikeln.");
document.getElementById("setDescription").appendChild(inputDescription);

let divErrorMsgDescription = document.createElement("div");
divErrorMsgDescription.setAttribute("id", "divErrorMsgDescription");
divErrorMsgDescription.setAttribute("class", "error__div");
document.getElementById("setDescription").appendChild(divErrorMsgDescription);

let spanDescription = document.createElement("span");
spanDescription.setAttribute("id", "description-error error-text");
spanDescription.setAttribute("class", "error__div__span--active");
document.getElementById("divErrorMsgDescription").appendChild(spanDescription);

//CSRF VerifyCsrfToken.php. $except = [/articles/create]

//Article Submit
let setSubmit = document.createElement("div");
setSubmit.setAttribute("id", "setSubmit");
setSubmit.setAttribute("class", "input-edit");
document.getElementById("articleForm").appendChild(setSubmit);

let inputSubmit = document.createElement("input");
inputSubmit.setAttribute("id", "submit");
inputSubmit.setAttribute("class", "submit__btn");
inputSubmit.setAttribute("type", "submit");
inputSubmit.setAttribute("name", "submit");
inputSubmit.setAttribute("value", "Speichern");
document.getElementById("setSubmit").appendChild(inputSubmit);

/*
Article Form Send Data
 */
const formArticle = document.getElementById("articleForm");
const messages = document.getElementById("UlMsgForm");

formArticle.addEventListener("submit", e => {
    e.preventDefault();

    const request = new XMLHttpRequest();
    const formData = new FormData(formArticle);

    request.onload = () => {
        let responseObject = null;

        try {
            responseObject = JSON.parse(request.responseText); // convert server response into js
        } catch (e) {
            console.error('Could not parse!');
        }

        if(responseObject) {
            handleResponse(responseObject);
        }
    }

    request.open("POST", formArticle.action);
    request.send(formData);
});

function handleResponse(responseObject) {
    if(responseObject.status === 0) {
        /*const object2 = Object.fromEntries(
            Object.entries(responseObject)
                .map(([ key, val ]) => [key, val])
        );*/

        for(let key in responseObject) {
            for (let subKey in responseObject[key]) {
                document.getElementById(subKey+"-error error-text").innerHTML = responseObject[key][subKey][0];
            }
        }
    }

    else {
        const li = document.createElement('h2');
        li.textContent = "Saved successfully";
        messages.appendChild(li);
        formArticle.reset();
    }
}
