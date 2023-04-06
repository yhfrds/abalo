"use strict";
function setCookie(cname, cvalue, exsekunde){
    const d = new Date();
    d.setTime(d.getTime() + (exsekunde * 1000 )); // seconds * milliseconds
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    console.log("Cookie is set : ");
}

function getCookie(cname) {
    const cookies = document.cookie
        .split(';') //trenne jede cookie
        .map(cookie => cookie.split('=')) //trenne den Wert und den Key von jeder cookie
        .reduce((acc, [key, value]) => ({...acc, [key.trim()]: value}), {}); //erzeuge eine neue Array

    //gesuchte cookie nicht gefunden,gibt leerzeichen züruck
    if(cookies[cname] == undefined){
        return "";
    }
    else
        return cookies[cname];
}

function acceptcookie(cname){
    //setze den Name von dem Cookie und ihr Ablaufzeit. Hier für 15 sekunde
    setCookie(cname, 1, 120);
    //verstecke das Pop up
    document.getElementById("consent_pop_up").style.display = "none";
}

//unset value and set time to past time
function denycookie(cname){
    const d = new Date();
    document.cookie = cname + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
    //hier wird das Cookie verstecken, das kommt aber nach Neuladen wieder
    document.getElementById("consent_pop_up").style.display = "none";
}
//hier set the username of the cookies
window.onload = () =>{
    var the_user = 'user_cookie_consent';
    let consent = getCookie(the_user);

    if(consent != "" && consent != undefined){
        document.getElementById("consent_pop_up").style.display = 'none'; //keine Consent->cookie wird angezeigt
    }else {
        setTimeout(function (){
            document.getElementById("consent_pop_up").style.display = "block";
            console.log("Cookies consent pop up is shown");
        },1000);
    }

    document.getElementById('acceptcookie').addEventListener("click",function () {
        acceptcookie(the_user);
        console.log(the_user + " accept the cookie");
    });

    document.getElementById('denycookie').addEventListener("click", function () {
        denycookie(the_user);
        console.log(the_user + " deny the cookie");
    });
}


//documentation:
// once the cookies accepted it will be saved for amount of time and won't be shown until the expiry date expires
//in this code. to test: delete browser history, neu laden, akzeptiere cookies, wird nicht mehr angezeigt für 10 sekunde
//nach Ablauf der Expirationzeit, nämlich 10 Sekunde wird es noch mal angezeigt.

